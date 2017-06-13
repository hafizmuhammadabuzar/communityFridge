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
        
	date_default_timezone_set('Asia/Dubai');
    }

    public function index() {
                        
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if ($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if ($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if ($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if ($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=$ipaddress");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        
        $json = json_decode($json);
        
        if($json == false){
            $this->session->set_userdata('latitude', '25.2048');
            $this->session->set_userdata('longitude', '55.2708');
        }
        else{
            $this->session->set_userdata('latitude', $json->geoplugin_latitude);
            $this->session->set_userdata('longitude', $json->geoplugin_longitude);
        }

//            $json = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$ipaddress"));
//            $json = json_decode(file_get_contents("http://freegeoip.net/json"));
//            $json = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));
//            $json = json_decode(file_get_contents("http://ip-api.com/json/$ipaddress"));

        
        if ($this->session->userdata('latitude') == '') {
            $this->session->set_userdata('latitude', '25.2048');
            $this->session->set_userdata('longitude', '55.2708');
        }
        
        $pins = $this->Home_model->getFridgesByRadius($this->session->userdata('latitude'), $this->session->userdata('longitude'));
        
        $config['center'] = $this->session->userdata('latitude') . ',' . $this->session->userdata('longitude');
        $config['zoom'] = '14';
        $config['scrollwheel'] = FALSE;
        $config['sensor'] = FALSE;
        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = $this->session->userdata('latitude') . ',' . $this->session->userdata('longitude');
        $marker['infowindow_content'] = 'Current Location';
        $marker['animation'] = 'DROP';
        $this->googlemaps->add_marker($marker);

        foreach ($pins as $pin) {

            $marker = array();
            $marker['position'] = $pin['latitude'] . ',' . $pin['longitude'];
            $marker['infowindow_content'] = '<b><a href="' . base_url() . 'get_direction?sLat=' . $this->session->userdata('latitude') . '&sLng=' . $this->session->userdata('longitude') . '&eLat=' . $pin['latitude'] . '&eLng=' . $pin['longitude'] . '" class="Direction" target="_blank"><img src="assets/images/sign-direction.png" alt="Direction" title="Get Direction" /></a>' . $pin['area'] . '</b><br>' . preg_replace('!\s+!', ' ', $pin['address']) . '<br>' . join(', ', array_map('ucfirst', explode(',', $pin['services']))) . '<br>' . $pin['latitude'] . ', ' . $pin['longitude'];

            $icon = ($pin['status'] == 'Needs Refill') ? 'nr-icon.png' : 'icon-fridge.png';
            $marker['icon'] = "assets/images/$icon";
            $this->googlemaps->add_marker($marker);
        }
        $data['map'] = $this->googlemaps->create_map();

        $data['countries'] = $this->Home_model->getFridgeCountries();

        $this->load->view('header', $data);
        $this->load->view('index', $data);
        $this->load->view('footer');
    }

    public function get_direction() {

        $this->load->library('googlemaps');
        $config['center'] = $_GET['latLng'];
        $config['zoom'] = 'auto';
        $config['directions'] = TRUE;
        $config['directionsStart'] = 'empire state building';
        $config['directionsEnd'] = 'statue of liberty';
        $config['directionsDivID'] = 'directionsDiv';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();

        $this->load->view('get_direction', $data);
    }

    function get_cities_by_country($country) {

        $result['cities'] = $this->Home_model->getCitiesByCountry($_POST['country']);
        echo $this->load->view('partial/cities', $result);
    }

    function search() {

        $pins = $this->Home_model->getFridges($_POST['country'], $_POST['city']);
        $zoom = (count($pins) > 1) ? 'auto' : '14';
        $data['countries'] = $this->Home_model->getFridgeCountries();

        $config['center'] = $pins[0]['latitude'] . ',' . $pins[0]['longitude'];
        $config['zoom'] = $zoom;
        $config['scrollwheel'] = FALSE;
        $config['sensor'] = FALSE;
        $this->googlemaps->initialize($config);

        foreach ($pins as $pin) {
            $marker = array();
            $marker['position'] = $pin['latitude'] . ',' . $pin['longitude'];
            $marker['infowindow_content'] = '<b><a href="' . base_url() . 'get_direction?sLat=' . $this->session->userdata('latitude') . '&sLng=' . $this->session->userdata('longitude') . '&eLat=' . $pin['latitude'] . '&eLng=' . $pin['longitude'] . '" class="Direction" target="_blank"><img src="assets/images/sign-direction.png" alt="Direction" title="Get Direction" /></a>' . $pin['area'] . '</b><br>' . preg_replace('!\s+!', ' ', $pin['address']) . '<br>' . join(', ', array_map('ucfirst', explode(',', $pin['services']))) . '<br>' . $pin['latitude'] . ', ' . $pin['longitude'];
            $icon = ($pin['status'] == 'Needs Refill') ? 'nr-icon.png' : 'icon-fridge.png';
            $marker['icon'] = "assets/images/$icon";
            $this->googlemaps->add_marker($marker);
        }
        $data['map'] = $this->googlemaps->create_map();

        $this->load->view('header', $data);
        $this->load->view('index', $data);
        $this->load->view('footer');
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

    public function about() {
        $this->load->view('header');
        $this->load->view('about');
        $this->load->view('footer');
    }

    public function resource() {
        $this->load->view('header');
        $this->load->view('resource');
        $this->load->view('footer');
    }

    public function press_release() {
        $this->load->view('header');
        $this->load->view('press_release');
        $this->load->view('footer');
    }
	
	public function host_fridge() {
        $this->load->view('header');
        $this->load->view('host_fridge');
        $this->load->view('footer');
    }

    public function faqs() {
        $this->load->view('header');
        $this->load->view('faqs');
        $this->load->view('footer');
    }
	
	public function news() {
        $this->load->view('header');
        $this->load->view('news');
        $this->load->view('footer');
    }

    public function contact() {
        $this->load->view('header');
        $this->load->view('contact');
        $this->load->view('footer');
    }

    public function privacy_policy() {
        $this->load->view('header');
        $this->load->view('privacy_policy');
        $this->load->view('footer');
    }
    
    function send_email() {

        $headers = 'From: '. $_POST['email'] . "\r\n" .
                'Reply-To: '. $_POST['email']."\r\n" .
                'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        
        $body = '<b>Name: </b>'.$_POST['username'];
        $body .= '<br/><b>Phone: </b>'.$_POST['phone'];
        $body .= '<br/><b>Message: </b>'.wordwrap($_POST['message']);

        if(mail('info@communityfridge.org', 'Communtiy Fridge Contact - '.$_POST['subject'], $body, $headers)){
            die('1');
        }
        else{
            die('Email could not be sent');
        }
    }
    
    function test(){
        
        $ch = curl_init();

        // set URL and other appropriate options
//        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=181.176.98.233");
        curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/$ipaddress");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $res = curl_exec($ch);
        curl_close($ch);
        
        if($res == false){
            echo 'Time out';
            die;
        }
        
        echo json_encode($res);
    }

}
