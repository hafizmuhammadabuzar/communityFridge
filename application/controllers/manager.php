<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Manager extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model('Admin_model');
        $this->load->model('Api_model');
        $this->load->model('Home_model');
        $this->load->library('session');

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');

        date_default_timezone_set('America/New_York');
    }

    public function index() {

        $this->load->view('manager/header');
        $this->load->view('manager/manager_login');
        $this->load->view('manager/footer');
    }

    public function login_check() {

        if ($this->session->userdata('manager_username') == FALSE) {
            $this->session->set_userdata('error', 'You are not Logged In, Please Login First !');
            redirect('manager/index');
        }
    }

    public function login() {

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('manager/header');
            $this->load->view('manager/manager_login');
            $this->load->view('manager/footer');
        }

        $res = $this->Home_model->checkRecord('managers', ['email' => $_POST['email'], 'password' => $_POST['password'], 'is_area_manager' => 0]);
        if ($res) {
            $this->session->set_userdata('manager_id', $res->manager_id);
            $this->session->set_userdata('manager_username', $res->name);
            redirect('manager/dashboard');
        } else {
            $this->session->set_userdata('error', 'Incorrect Username or Password');
            redirect('manager/index');
        }
    }

    public function logout() {
        $this->session->unset_userdata('manager_username');
        $this->session->sess_destroy();
        redirect('manager/index');
    }

    public function dashboard() {
        $this->login_check();

        $this->load->view('manager/header');
        $this->load->view('manager/dashboard');
        $this->load->view('manager/footer');
    }

    function view_fridges() {
        $this->login_check();
        
        $limit = 20;
        $total_items = $this->Admin_model->getAllFridges();
        $total_row = count($total_items);
        
        $config['base_url'] = base_url() . '/manager/view_fridges/page/';
        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);

        $result['items'] = $this->Admin_model->getAllFridges($limit);
        $result['links'] = $this->pagination->create_links();
        $result['total'] = $total_row;

        $this->load->view('manager/header');
        $this->load->view('manager/view_fridges', $result);
        $this->load->view('manager/footer');
    }

    function edit_fridge($id) {
        $this->login_check();

        $id = pack("H*", $id);

        $result['fridge'] = $this->Home_model->checkRecord('items', ['item_id' => $id]);
        $this->load->view('manager/header');
        $this->load->view('manager/edit_fridge', $result);
        $this->load->view('manager/footer');
    }

    public function update_fridge() {

        $this->form_validation->set_rules('services', 'Services', 'required');
        $this->form_validation->set_rules('lat', 'Latitude', 'required');
        $this->form_validation->set_rules('lng', 'Longitude', 'required');
        $this->form_validation->set_rules('area', 'Area', 'required');
        $this->form_validation->set_rules('streetAddress', 'Street Address', 'required');
        $this->form_validation->set_rules('accessTime', 'Access Time', 'required');
        $this->form_validation->set_rules('preferredFillTime', 'Preferred Fill Time', 'required');

        if ($this->form_validation->run() == FALSE) {

            redirect('manager/edit_fridge/' . $_POST['firdge_id']);
        } else {
            $fridge_id = pack("H*", $_POST['fridge_id']);

            $lat = $this->input->post('lat');
            $lng = $this->input->post('lng');
            $country = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=true"));

            $fridge_data = array(
                'services' => $this->input->post('services'),
                'latitude' => $this->input->post('lat'),
                'longitude' => $this->input->post('lng'),
                'country' => $country->results[count($country->results) - 1]->formatted_address,
                'area' => $this->input->post('area'),
                'address' => $this->input->post('streetAddress'),
                'access_time' => $this->input->post('accessTime'),
                'preferred_filling_time' => $this->input->post('preferredFillTime'),
            );

            $res = $this->Home_model->updateRecord('items', ['item_id' => $fridge_id], $fridge_data);

            if ($res > 0) {
                $this->session->set_userdata('msg', "Successfully updated!");
                redirect('manager/view_fridges');
            } else {
                $this->session->set_userdata('msg', "Could not be updated!");
                redirect('manager/edit_fridge/' . $id);
            }
        }
    }

    function save_fridge_manager() {

        $fridge = $_POST['fridge_id'];
        $manager = $_POST['manager'];
        $updateArray = array();
        for ($i = 0; $i < sizeof($fridge); $i++) {

            if($manager[$i] != ''){
                $updateArray[] = array(
                    'item_id' => pack("H*", $fridge[$i]),
                    'manager_id' => pack("H*", $manager[$i]),
                );
            }
        }
       
        $res = $this->db->update_batch('items', $updateArray, 'item_id');
        
        $this->session->set_userdata('msg', "Successfully Assigned!");
        redirect('manager/view_fridges');
    }

    function delete_fridge($id) {
        $this->login_check();

        $id = pack("H*", $id);
        
        $images = $this->Home_model->checkRecord('item_images', array('item_id' => $id));
        if($images){
            if(file_exists(strstr($images->image, 'assets'))){
                echo $images->image;
                unset($images->image);
            }
        }

        $res = $this->Home_model->deleteRecord('items', array('item_id' => $id));
        if ($res > 0) {
            $this->Home_model->deleteRecord('item_images', array('item_id' => $id));
            $this->session->set_userdata('msg', "Successfully Deleted!");
        } else {
            $this->session->set_userdata('msg', "Could not be Deleted!");
        }
        redirect('manager/view_fridges');
    }

    public function fridge_status() {

        $id = pack("H*", $_POST['id']);
        $status = (trim($_POST['status']) == 'Active') ? 0 : 1;

        $res = $this->Home_model->updateRecord('items', ['item_id' => $id], ['is_active' => $status]);

        if ($res == 1) {
            echo '1';
        } else {
            echo 'Error';
        }
    }

    function send_email($to, $f_name, $subject, $msg, $from = '') {

        $this->load->library('phpmailer');
        $mail = new PHPMailer(true);
        $mail->IsSMTP();

        // local
        $mail->Host = "ssl://smtp.googlemail.com";
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->Username = "bookswap.education@gmail.com";
        $mail->Password = "booksocIAL";
        $mail->AddReplyTo('no-reply@email.com', 'Bookswap');

        // live
//        $mail->Host = "localhost";
//        $mail->SMTPAuth = true;
//        $mail->SMTPSecure = "ssl";
//        $mail->Username = "bookswap.education@gmail.com";
//        $mail->Password = 'booksocIAL';
//        $mail->Port = "465";
//        $mail->AddReplyTo('no-reply@email.com', '');

        $mail->AddAddress($to, $f_name);
        $from_email = (empty($from)) ? 'bookswap.education@gmail.com' : $from;
        $mail->SetFrom($from_email, 'Bookswap');
        $mail->Subject = $subject;
        $body = $msg;

        $mail->MsgHTML($body);
        $mail->Send();
    }
    
    
    // Manager Functions
    public function manager_login() {
        
        $result['manager'] = true;
        
        if(!isset($_POST['submit'])){    
            
            $this->load->view('manager/header');
            $this->load->view('manager/manager_login', $result);
            $this->load->view('manager/footer');
        } 
        else{
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('manager/header');
                $this->load->view('manager/manager_login', $result);
                $this->load->view('manager/footer');
            }else{
                
                $res = $this->Home_model->checkRecord('managers', ['email' => $_POST['email'], 'password' => $_POST['password']]);
                if($res){
                    $this->session->set_userdata('manager_username', $_POST['username']);
                    redirect('manager/');
                }
            }

            if ($_POST['password'] == 'manager') {
                redirect('manager/dashboard');
            } else {
                $this->session->set_userdata('error', 'Incorrect Username or Password');
                redirect('manager/index');
            }
        }
    }
    

}
