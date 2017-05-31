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
            $ipaddress = '';
            if ($_SERVER['HTTP_CLIENT_IP'])
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if($_SERVER['HTTP_X_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if($_SERVER['HTTP_X_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if($_SERVER['HTTP_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if($_SERVER['HTTP_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if($_SERVER['REMOTE_ADDR'])
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            
           $ipaddress = '103.255.4.66';
            
            $json = json_decode(file_get_contents("http://ip-api.com/json/$ipaddress"));
                        
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
               
        $marker = array();
        $marker['position'] = $this->session->userdata('latitude').','.$this->session->userdata('longitude');
        $marker['infowindow_content'] = 'Current Location';
        $marker['animation'] = 'DROP';
        $this->googlemaps->add_marker($marker);
        
        foreach ($pins as $pin) {
            
            $marker = array();
            $marker['position'] = $pin['latitude'] . ',' . $pin['longitude'];

            $marker['infowindow_content'] = '<b><a href="'. base_url().'get_direction?sLat='.$this->session->userdata('latitude').'&sLng='.$this->session->userdata('longitude').'&eLat='.$pin['latitude'].'&eLng='.$pin['longitude'].'" class="Direction" target="_blank"><img src="assets/images/sign-direction.png" alt="Direction"/></a>'.$pin['area'].'</b><br>'.ucfirst(str_replace('null', '', $pin['address'])).'<br>'.join(', ', array_map('ucfirst', explode(',', $pin['services']))) . '<br>' . $pin['latitude'] . ', ' . $pin['longitude'];
            
            $marker['icon'] = 'assets/images/icon-fridge.png';
            $this->googlemaps->add_marker($marker);
        }
        $data['map'] = $this->googlemaps->create_map();

        $data['countries'] = $this->Home_model->getFridgeCountries();
        
        $this->load->view('index', $data);
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
        $data['countries'] = $this->Home_model->getFridgeCountries();

        $config['center'] = $pins[0]['latitude'] . ',' . $pins[0]['longitude'];
        $config['zoom'] = '12';
        $config['scrollwheel'] = FALSE;
        $config['sensor'] = FALSE;
        $this->googlemaps->initialize($config);

        foreach ($pins as $pin) {
            $marker = array();
            $marker['position'] = $pin['latitude'] . ',' . $pin['longitude'];
            $marker['infowindow_content'] = '<b><a href="'. base_url().'get_direction?sLat='.$this->session->userdata('latitude').'&sLng='.$this->session->userdata('longitude').'&eLat='.$pin['latitude'].'&eLng='.$pin['longitude'].'" class="Direction" target="_blank"><img src="assets/images/sign-direction.png" alt="Direction"/></a>'.$pin['area'].'</b><br>'.ucfirst(str_replace('null', '', $pin['address'])).'<br>'.join(', ', array_map('ucfirst', explode(',', $pin['services']))) . '<br>' . $pin['latitude'] . ', ' . $pin['longitude'];
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

}
