<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model('Admin_model');
        $this->load->model('Api_model');
        $this->load->model('Home_model');
        $this->load->library('session');

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
//        $this->load->library('encrypt');

        date_default_timezone_set('America/New_York');
    }

    public function index() {

        $this->load->view('admin/header');
        $this->load->view('admin/admin_login');
        $this->load->view('admin/footer');
    }

    public function login_check() {

        if ($this->session->userdata('admin_username') == FALSE) {
            $this->session->set_userdata('error', 'You are not Logged In, Please Login First !');
            redirect('admin/index');
        }
    }

    public function login() {

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/header');
            $this->load->view('admin/admin_login');
            $this->load->view('admin/footer');
        }

        if ($_POST['password'] == 'admin') {
            $this->session->set_userdata('admin_username', $_POST['username']);
            redirect('admin/dashboard');
        } else {
            $this->session->set_userdata('error', 'Incorrect Username or Password');
            redirect('admin/index');
        }
    }

    public function logout() {
        $this->session->unset_userdata('admin_username');
        $this->session->sess_destroy();
        redirect('admin/index');
    }

    public function dashboard() {
        $this->login_check();

        $this->load->view('admin/header');
        $this->load->view('admin/dashboard');
        $this->load->view('admin/footer');
    }
    
    function add_manager() {
        $this->login_check();

        $this->load->view('admin/header');
        $this->load->view('admin/add_manager', $result);
        $this->load->view('admin/footer');
    }

    function view_managers() {
        $this->login_check();

        $result['managers'] = $this->Admin_model->getAllManagers();

        $this->load->view('admin/header');
        $this->load->view('admin/view_managers', $result);
        $this->load->view('admin/footer');
    }

    public function save_manager() {

        $this->form_validation->set_rules('username', 'Manager Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('polygon', 'Polygon', 'required');

        if ($this->form_validation->run() == FALSE) {

            redirect('admin/add_manager');
        } 
        else {            
            $polygon_end_point = explode(',', $this->input->post('polygon')); 
            $manager_data = array(
                'name' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'mobile' => $this->input->post('mobile'),
                'polygon' => $this->input->post('polygon').', '.$polygon_end_point[0],
                'is_area_manager' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            );

            $res = $this->Home_model->saveRecord('managers', $manager_data);

            if ($res > 0) {
                $this->session->set_userdata('msg', "Successfully saved!");
                redirect('admin/view_managers');
            } else {
                $this->session->set_userdata('msg', "Could not be saved!");
                redirect('admin/add_manager');
            }
        }
    }

    function edit_manager($id) {
        $this->login_check();

        $id = pack("H*", $id);

        $result['manager'] = $this->Home_model->checkRecord('managers', array('manager_id' => $id));
        $this->load->view('admin/header');
        $this->load->view('admin/add_manager', $result);
        $this->load->view('admin/footer');
    }

    public function update_manager() {

        $this->form_validation->set_rules('username', 'Manager Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('polygon', 'Polygon', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');

        if ($this->form_validation->run() == FALSE) {

            redirect('admin/edit_manager/' . $_POST['manager_id']);
        } else {            
            $polygon_end_point = explode(',', $this->input->post('polygon'));
            $id = pack("H*", $_POST['manager_id']);

            $manager_data = array(
                'name' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'polygon' => $this->input->post('polygon').', '.$polygon_end_point[0],
                'updated_at' => date('Y-m-d H:i:s'),
            );

            if (!empty($_POST['password'])) {
                $password = ['password' => $this->input->post('password')];
                $manager_data = array_merge($password, $manager_data);
            }

            $res = $this->Home_model->updateRecord('managers', ['manager_id' => $id], $manager_data);

            if ($res > 0) {
                $this->session->set_userdata('msg', "Successfully saved!");
                redirect('admin/view_managers');
            } else {
                $this->session->set_userdata('msg', "Could not be saved!");
                redirect('admin/edit_manager/' . $_POST['manager_id']);
            }
        }
    }

    function delete_manager($id) {
        $this->login_check();

        $id = pack("H*", $id);

        $res = $this->Home_model->deleteRecord('managers', array('manager_id' => $id));
        if ($res) {
            $this->session->set_userdata('msg', "Successfully Deleted!");
        } else {
            $this->session->set_userdata('msg', "Could not be Deleted!");
        }
        redirect('admin/view_managers');
    }

    function delete_sub_manager($id) {
        $this->login_check();

        $id = pack("H*", $id);

        $res = $this->Home_model->deleteRecord('managers', array('manager_id' => $id));
        if ($res) {
            $this->session->set_userdata('msg', "Successfully Deleted!");
        } else {
            $this->session->set_userdata('msg', "Could not be Deleted!");
        }
        redirect('admin/view_sub_managers');
    }
    
    function view_sub_managers() {
        $this->login_check();

        $result['managers'] = $this->Admin_model->getAllSubManagers();

        $this->load->view('admin/header');
        $this->load->view('admin/view_sub_managers', $result);
        $this->load->view('admin/footer');
    }

    public function save_sub_manager() {

        $this->form_validation->set_rules('username', 'Manager Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');

        if ($this->form_validation->run() == FALSE) {

            redirect('admin/add_manager');
        } 
        else {            
            $manager_data = array(
                'name' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'mobile' => $this->input->post('mobile'),
                'created_at' => date('Y-m-d H:i:s'),
            );

            $res = $this->Home_model->saveRecord('managers', $manager_data);

            if ($res > 0) {
                $this->session->set_userdata('msg', "Successfully saved!");
            } else {
                $this->session->set_userdata('msg', "Could not be saved!");
            }
            redirect('admin/view_sub_managers');
        }
    }

    function edit_sub_manager($id) {
        $this->login_check();

        $id = pack("H*", $id);

        $result['manager'] = $this->Home_model->checkRecord('managers', array('manager_id' => $id));
        $this->load->view('admin/header');
        $this->load->view('admin/edit_sub_manager', $result);
        $this->load->view('admin/footer');
    }

    public function update_sub_manager() {

        $this->form_validation->set_rules('username', 'Manager Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');

        if ($this->form_validation->run() == FALSE) {

            redirect('admin/edit_sub_manager/' . $_POST['manager_id']);
        } else {            
            $id = pack("H*", $_POST['manager_id']);

            $manager_data = array(
                'name' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            if (!empty($_POST['password'])) {
                $password = ['password' => $this->input->post('password')];
                $manager_data = array_merge($password, $manager_data);
            }

            $res = $this->Home_model->updateRecord('managers', ['manager_id' => $id], $manager_data);

            if ($res > 0) {
                $this->session->set_userdata('msg', "Successfully saved!");
                redirect('admin/view_managers');
            } else {
                $this->session->set_userdata('msg', "Could not be saved!");
                redirect('admin/edit_sub_manager/' . $_POST['manager_id']);
            }
        }
    }
        
    function view_users() {
        $this->login_check();
        
        if(isset($_POST['sort_btn'])){
            if($_POST['sort'] == 'name'){
                $this->session->set_userdata('sort', "username ASC");
                $sort = $this->session->userdata('sort');
            } 
            else if($_POST['sort'] == 'date'){
                $this->session->set_userdata('sort', "created_at DESC");
                $this->session->set_userdata('sorted', $_POST['sort']);
                $sort = $this->session->userdata('sort');
            }
            $this->session->set_userdata('sorted', $_POST['sort']);
        }
        else if($this->session->userdata('sort') == TRUE){
            $sort = $this->session->userdata('sort');
        }

        $limit = 10;
        $result['users'] = $this->Admin_model->getAllUsers($limit, $sort);

        $total_row = $this->Admin_model->countRecord('users');

        $config['base_url'] = base_url() . '/admin/view_users/page/';
        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);

        $result['links'] = $this->pagination->create_links();
        $result['total'] = $total_row;

        $this->load->view('admin/header');
        $this->load->view('admin/view_users', $result);
        $this->load->view('admin/footer');
    }
    

    function view_fridges() {
        $this->login_check();

//        $result['managers'] = $this->Admin_model->getAllManagers();

        $limit = 20;
        $result['items'] = $this->Admin_model->getAllFridges($limit);

        $total_row = $this->Admin_model->countRecord('items');

        $config['base_url'] = base_url() . '/admin/view_fridges/page/';
        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);

        $result['links'] = $this->pagination->create_links();
        $result['total'] = $total_row;

        $this->load->view('admin/header');
        $this->load->view('admin/view_fridges', $result);
        $this->load->view('admin/footer');
    }

    function edit_fridge($id) {
        $this->login_check();

        $id = pack("H*", $id);

        $result['fridge'] = $this->Home_model->checkRecord('items', ['item_id' => $id]);
        $this->load->view('admin/header');
        $this->load->view('admin/edit_fridge', $result);
        $this->load->view('admin/footer');
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

            redirect('admin/edit_fridge/' . $_POST['firdge_id']);
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

//            echo '<pre>'; print_r($fridge_data); die;

            $res = $this->Home_model->updateRecord('items', ['item_id' => $fridge_id], $fridge_data);

            if ($res > 0) {
                $this->session->set_userdata('msg', "Successfully updated!");
                redirect('admin/view_fridges');
            } else {
                $this->session->set_userdata('msg', "Could not be updated!");
                redirect('admin/edit_fridge/' . $id);
            }
        }
    }

    function save_fridge_manager() {

        $fridge = $_POST['fridge_id'];
        $manager = $_POST['manager'];
        
        if(count(array_filter($manager)) > 0){
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
        }
        else{
            $this->session->set_userdata('msg', "No Manager selected!");
        }
        
        redirect('admin/view_fridges');
    }

    function delete_fridge($id) {
        $this->login_check();

        $id = pack("H*", $id);

        $images = $this->Home_model->checkRecord('item_images', array('item_id' => $id));
        if($images){
            if(file_exists(strstr($images->image, 'assets'))){
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
        redirect('admin/view_fridges');
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

    public function user_status() {

        $id = pack("H*", $_POST['id']);
        $status = (trim($_POST['status']) == 'Active') ? 0 : 1;

        $res = $this->Home_model->updateRecord('users', ['user_id' => $id], ['status' => $status]);

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
            
            $this->load->view('admin/header');
            $this->load->view('admin/admin_login', $result);
            $this->load->view('admin/footer');
        } 
        else{
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/header');
                $this->load->view('admin/admin_login', $result);
                $this->load->view('admin/footer');
            }else{
                
                $res = $this->Home_model->checkRecord('managers', ['email' => $_POST['email'], 'password' => $_POST['password']]);
                if($res){
                    $this->session->set_userdata('manager_username', $_POST['username']);
                    redirect('manager/');
                }
            }

            if ($_POST['password'] == 'admin') {
                redirect('admin/dashboard');
            } else {
                $this->session->set_userdata('error', 'Incorrect Username or Password');
                redirect('admin/index');
            }
        }
    }
    
    public function push_form() {

        $this->load->view('admin/header');
        $this->load->view('admin/push_notification');
        $this->load->view('admin/footer');
    }

    public function product_notification() {

        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('msg', 'Message', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/header');
            $this->load->view('admin/push_notification');
            $this->load->view('admin/footer');
        } else {
            $title = $_POST['title'];
            $msg = $_POST['msg'];
            
            if (isset($_POST['send_to_android']) && isset($_POST['send_to_ios'])) {
                $result_android = $this->android_push($title, $msg);
                $result_ios = $this->ios_notification($title, $msg);
            } else if (isset($_POST['send_to_android'])) {
                $result_android = $this->android_push($title, $msg);
            } else if ($_POST['send_to_ios']) {
                $result_ios = $this->ios_notification($title, $msg);
            } else {
                $result_android = $this->android_push($title, $msg);
                $result_ios = $this->ios_notification($title, $msg);
            }

            if (isset($result_ios) || isset($result_android)) {
                $this->session->set_userdata('error', 'Successfully Sent !');
                redirect('push_form');
            }
        }
    }

    public function ind_push_form() {

        $result['users'] = $this->Api_model->getAllLoggedInUsers();

        $this->load->view('admin_header');
        $this->load->view('ind_push_notification', $result);
        $this->load->view('admin_footer');
    }

    public function ind_product_notification() {

        $result_ios = $this->ios_notification($_POST['title'], $_POST['msg'], $_POST['email']);
        $result_android = $this->android_push($_POST['title'], $_POST['msg'], $_POST['email']);

        if (isset($result_ios) || isset($result_android)) {
            $this->session->set_userdata('error', 'Successfully Sent !');

            $result['users'] = $this->Api_model->getAllLoggedInUsers();

            $this->load->view('admin_header');
            $this->load->view('ind_push_notification', $result);
            $this->load->view('admin_footer');
        }
    }

    public function ios_notification($noti_title, $msg, $email = '') {

        if (!empty($email)) {
            $tokens = $this->Api_model->getiOSTokens($email);
            foreach ($tokens as $tk) {
                $player_ids[] = $tk['player_id'];
            }

            $devices = ['include_player_ids' => $player_ids,];
        } else {
            $devices = ['included_segments' => array('All')];
        }

        $title = array(
            "en" => $noti_title
        );
        $content = array(
            "en" => $msg
        );

        $fields = array(
            'app_id' => "3f639b9a-f9cd-4c81-8bc9-80ff744ec0c4",
            'contents' => $content,
            'heading' => $title,
            'data' => ['title' => $noti_title, 'body' => $msg],
            'ios_badgeType' => 'SetTo',
            'ios_badgeCount' => 1
        );
        $fields = array_merge($fields, $devices);

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Authorization: Basic ZThlM2Q3YzYtZjAyYy00YWU0LWE3NWEtMWRlZmU4NTE0ZGIw'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function android_push($title, $body, $email = '') {

        $email = (!empty($email)) ? $email : '';

        $tokens = $this->Api_model->getTokens($email);

        foreach ($tokens as $tk) {
            $ids[] = $tk['token'];
        }
        
        $chunks = array_chunk($ids, 1000);

        foreach ($chunks as $chk) {   
            
            define('API_ACCESS_KEY', 'AIzaSyAq208nQaq4tYa5ODrfbyiINwxfKO0qrwg');
            $registrationIds = $ids;

            $msg['notification'] = array
                (
                'title' => $title,
                'message' => $body
            );

            $fields = array
                (
                'registration_ids' => $registrationIds,
                'data' => $msg
            );

            $headers = array
                (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            
            return $result;
        }
    }
    

}
