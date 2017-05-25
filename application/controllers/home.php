<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model('Home_model');
        $this->load->model('Api_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->library('googlemaps');
        $this->load->library('form_validation');
    }

    public function index() {

        if($this->session->userdata('latitude') == FALSE){
//            $ip = $_SERVER['REMOTE_ADDR'];
            $ip = '103.255.4.251';
            $json = json_decode(file_get_contents("http://ip-api.com/json/$ip"));
            
            $this->session->set_userdata('country', $json->country);
            $this->session->set_userdata('latitude', $json->lat);
            $this->session->set_userdata('longitude', $json->lon);
        }
        
        $pins = $this->Home_model->getFridgesByRadius($this->session->userdata('latitude'), $this->session->userdata('longitude'));
        
        $config['center'] = $this->session->userdata('latitude').','.$this->session->userdata('longitude');
        $config['zoom'] = '14';
        $config['scrollwheel'] = FALSE;
        $config['sensor'] = FALSE;
        $this->googlemaps->initialize($config);
        
//        $circle = array();
//        $circle['center'] = $this->session->userdata('latitude').','.$this->session->userdata('longitude');
//        $circle['radius'] = '100';
//        $this->googlemaps->add_circle($circle);  
        
        $marker = array();
        $marker['position'] = $this->session->userdata('latitude').','.$this->session->userdata('longitude');
        $marker['infowindow_content'] = 'Current Location';
        $marker['animation'] = 'DROP';
        $this->googlemaps->add_marker($marker);
        
        foreach ($pins as $pin) {
            $marker = array();
            $marker['position'] = $pin['latitude'] . ',' . $pin['longitude'];
            $marker['infowindow_content'] = '<b><a href="#" class="Direction"><img src="assets/images/sign-direction.png" alt="Direction"/></a>'.$pin['area'].'</b><br>'.ucfirst(str_replace('null', '', $pin['address'])).'<br>'.join(', ', array_map('ucfirst', explode(',', $pin['services']))) . '<br>' . $pin['latitude'] . ', ' . $pin['longitude'];
            $marker['icon'] = 'assets/images/icon-fridge.png';
            $this->googlemaps->add_marker($marker);
        }
        $data['map'] = $this->googlemaps->create_map();

        $data['countries'] = $this->Home_model->getFridgeCountries();
        
        $this->load->view('index', $data);
    }

    function get_cities_by_country($country) {

        $result['cities'] = $this->Home_model->getCitiesByCountry($_POST['country']);
        echo $this->load->view('partial/cities', $result);
    }

    function search() {

        $pins = $this->Home_model->getFridges($_POST['country'], $_POST['city']);
        $data['countries'] = $this->Home_model->getFridgeCountries();

        $config['center'] = $this->session->userdata('latitude') . ',' . $this->session->userdata('longitude');
        $config['zoom'] = 'auto';
        $config['scrollwheel'] = FALSE;
        $config['sensor'] = FALSE;
        $this->googlemaps->initialize($config);

        foreach ($pins as $pin) {
            $marker = array();
            $marker['position'] = $pin['latitude'] . ',' . $pin['longitude'];
            $marker['infowindow_content'] = '<b>'.$pin['area'].'</b><br>'.ucfirst(str_replace('null', '', $pin['address'])).'<br>'.join(', ', array_map('ucfirst', explode(',', $pin['services']))) . '<br>' . $pin['latitude'] . ', ' . $pin['longitude'];
            $marker['icon'] = 'assets/images/icon-fridge.png';
            $this->googlemaps->add_marker($marker);
        }
        $data['map'] = $this->googlemaps->create_map();

        $this->load->view('index', $data);
    }

    function image_download($image) {

        if ($_SERVER['HTTP_HOST'] == 'communityfridge.org') {
            $ext = explode('.', $image);
            $ext = end($ext);

            $this->load->helper('download');
            $data = file_get_contents(base_url() . 'assets/images/' . $image);
            $name = 'image.' . $ext;
            force_download($name, $data);
        }
        redirect('index');
    }

//-------------------- Admin Functions Start --------------------\\


    public function admin_index() {

        if ($this->session->userdata('admin') == TRUE) {
            $this->load->view('admin_header');
            $this->load->view('admin_footer');
        } else {
            $this->load->view('admin_login');
        }
    }

    public function admin_login() {

        if ($this->session->userdata('admin') == TRUE) {
            $this->load->view('admin_header');
            $this->load->view('admin_footer');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('username', 'Password', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin_header');
                $this->load->view('admin_login');
                $this->load->view('admin_footer');
            } else if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin') {
                $this->session->set_userdata('admin', 'Logged In');
                redirect('dashboard');
            } else {
                $this->session->set_userdata('error', 'Invalid Username or Password');
                $this->load->view('admin_login');
            }
        }
    }

    function check_login() {

        if ($this->session->userdata('admin') == FALSE) {
            $this->session->set_userdata('error', 'You are not Logged In');
            redirect('admin');
        }
    }

    function admin_logout() {

        $this->session->unset_userdata('admin');
        session_destroy();
        $this->load->view('admin_login');
    }

    function dashboard() {

        $this->check_login();

        $this->load->view('admin_header');
        $this->load->view('admin_footer');
    }

    function push_form() {

        $this->load->view('admin_header');
        $this->load->view('push_notification');
        $this->load->view('admin_footer');
    }

    public function product_notification() {

        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('msg', 'Message', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin_header');
            $this->load->view('push_notification');
            $this->load->view('admin_footer');
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
            $tokens = $this->Home_model->getiOSTokens($email);
            foreach ($tokens as $tk) {
                $ids[] = $tk['token'];
            }

            $devices = ['include_ios_tokens' => $ids];
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
