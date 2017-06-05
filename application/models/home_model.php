<?php

class Home_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function checkUserRegister($username, $email) {
           
        $both_check = $this->db->get_where('users', array('username' => "$username", 'email' => "$email"));

        if ($both_check->num_rows() > 0) {
            $result['message'] = 'Username and Email already exist';
        } else {
            $username_check = $this->db->get_where('users', array('username' => "$username", 'account_type' => "normal"));
            if ($username_check->num_rows() > 0) {
                $result['message'] = 'Username already exists';
            } else {
                $email_check = $this->db->get_where('users', array('email' => "$email", 'account_type' => "normal"));
                if ($email_check->num_rows() > 0) {
                    $result['message'] = 'Email already exists';
                }
            }
        }

        return $result;
    }
    
    function checkRecord($table, $data) {
        $query = $this->db->get_where($table, $data);
        return $query->row();
    }

    function saveRecord($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function updateRecord($table, $where_fields, $data) {
        foreach ($where_fields as $key => $field) {
            $this->db->where($key, $field);
        }
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    function deleteRecord($table, $where_fields) {
        foreach ($where_fields as $key => $field) {
            $this->db->where($key, $field);
        }
        $this->db->delete($table);
        return $this->db->affected_rows();
    }
    
    function getFridgesByRadius($lat, $lng){        
        
        $query = $this->db->query("select items.*, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin( radians( latitude ) ) ) ) as distance
                from items
                where items.condition = 'Active' 
                and is_active = 1
                having distance <= 30
            ");
         
        return $query->result_array();
    }
    
    function getFridgeCountries(){
        
        $this->db->select('country');
        $this->db->group_by('country');
        $query = $this->db->get('items');
        
        return $query->result_array();
    }
    
    function getCitiesByCountry($country){
        
        $this->db->select('area');
        $this->db->where('country', $country);
        $this->db->group_by('area');
        $query = $this->db->get('items');
        
        return $query->result_array();
    }
    
    function getFridges($country, $area){
        
        $this->db->select('*');
//        if(empty($country) && empty($area)){
//            $this->db->where('country', $this->session->userdata('country'));
//        }
        if(!empty($country)){
            $this->db->where('country', $country);
        }
        if(!empty($area)){
            $this->db->where('area', $area);
        }
        $this->db->where('items.condition', 'Active');
        $this->db->where('is_active', 1);
        $query = $this->db->get('items');
        
        return $query->result_array();
    }
    
    function getRecentFridge(){
        
        $this->db->select('services, address, country');
        $this->db->order_by('item_id', 'DESC');
        $this->db->limit('3');
        $query = $this->db->get('items');
        
        return $query->result_array();
    }
    
    function getUserByFridgeId($fridge_id){
        
        $this->db->select('email, latitude, longitude, manager_id');
        $this->db->where('item_id', $fridge_id);
        $this->db->join('users', 'users.user_id = items.user_id', 'inner');
        $query = $this->db->get('items');
        
        return $query->row();
    }
    
    function updateGEom($point, $item_id){
        
        $this->db->query("update items set point = $point where item_id = $item_id");
        
    }

}
