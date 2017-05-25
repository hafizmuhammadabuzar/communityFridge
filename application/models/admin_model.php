<?php

class Admin_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function adminLogin($login_data)
    {
        $query = $this->db->get_where('users', $login_data);
        return $query->row();      
    }
    
    function getAllUsers(){
        
        $this->db->where('status', 0);
        $this->db->or_where('status', 1);
        $query = $this->db->get('users');
        return $query->result_array();
    }
            
    function postStatus($ad_id){
        
        $this->db->where('ad_id', $ad_id);
        $this->db->update('user_posts', array('sell_status' => 1, 'activate_date' => date('Y-m-d h:i:s')));
        return $this->db->affected_rows();        
    }
    
    
    function getPendingPosts(){
        $this->db->select('user_posts.*, universities.uni_name, courses.course_code, courses.course_title');
        $this->db->join('users', 'users.user_id = user_posts.user_id', 'INNER');
        $this->db->join('universities', 'universities.uni_id = users.uni_id', 'INNER');
        $this->db->join('courses', 'courses.course_id = user_posts.course_id', 'INNER');
        $this->db->order_by('created_date', 'DESC');
        $query = $this->db->get_where('user_posts', array('sell_status' => '0'));
        return $query->result_array();
    }
    
    function removePost($ad_id){
        
        $this->db->where('ad_id', $ad_id);
        $this->db->delete('user_posts');
        return $this->db->affected_rows();        
    }
    
    function postExpire(){
        
        $this->db->query('update user_posts set sell_status = 2
                        WHERE DATE(`activate_date`) = DATE_SUB(CURDATE(), INTERVAL 14 DAY)
                        AND sell_status = 1
                    ');        
        
        $expired = $this->db->query('SELECT ad_id FROM `user_posts` 
                                INNER JOIN users ON `users`.`user_id` = `user_posts`.`user_id`
                                WHERE DATE(`activate_date`) = DATE_SUB(CURDATE(), INTERVAL 14 DAY)
                                AND sell_status = 2 and token IS NULL
                            ');
        $ads = $expired->result_array();
        
        foreach($ads as $ad){
            $this->db->query('update user_posts set token = "'.uniqid().'" where ad_id = '.$ad['ad_id']);            
        }
        
        $query = $this->db->query('SELECT `token`, `isbn`, `fullname`, `email` FROM `user_posts` 
                                INNER JOIN users ON `users`.`user_id` = `user_posts`.`user_id`
                                WHERE DATE(`activate_date`) = DATE_SUB(CURDATE(), INTERVAL 14 DAY)
                                AND sell_status = 2
                            ');
        
        return $query->result_array();        
    }
    
    function postRenew($token, $date){
        
        $this->db->query("update user_posts set sell_status = 1, activate_date = '$date' WHERE token = '$token'");
        return $this->db->affected_rows();        
    }

    function updateUserUniversity($uni_id, $emails){

        $this->db->query("update users set uni_id = $uni_id where email in ('$emails')");
        return $this->db->affected_rows();
    }

    function getAllUniversities(){

        $this->db->select('universities.uni_id, TRIM(universities.uni_name) as uni_name, country_name');
        $this->db->join('countries', 'countries.country_id = universities.uni_location', 'left');
        $this->db->order_by('universities.uni_name');
        $query = $this->db->get('universities');

        return $query->result_array();
    }

    function getAllCountries(){

        $this->db->select('country_id, country_name');
        $this->db->order_by('country_name');
        $query = $this->db->get('countries');

        return $query->result_array();
    }

    function countRecord($table) {
        return $this->db->count_all_results($table);
    }

    function countFridges(){

        $this->db->select('count(*) as count');
        $this->db->join('users', 'users.user_id = items.user_id', 'inner');
        if($this->session->userdata('manager_id')){
            $this->db->where('manager_id', $this->session->userdata('manager_id'));
        }
        $query = $this->db->get('items');

        return $query->row();
    }

    function getAllFridges($limit = ''){

        $this->db->select('*');
        $this->db->join('users', 'users.user_id = items.user_id', 'inner');
        $this->db->order_by("item_id DESC");
        if($this->session->userdata('manager_id')){
            $this->db->where('manager_id', $this->session->userdata('manager_id'));
        }
        if ($limit != '') {
            $offset = $this->uri->segment(4);
            $query = $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('items');

        return $query->result_array();
    }

    function getAllUsersDetail(){

        $this->db->select('users.first_name, users.last_name, users.email, users.status, universities.uni_name, countries.country_name');
        $this->db->join('universities', 'universities.uni_id = users.uni_id', 'left');
        $this->db->join('countries', 'countries.country_id = universities.uni_location', 'left');
        $this->db->order_by('user_id', 'DESC');
        $query = $this->db->get('users');

        return $query->result_array();
    }

    function getAllManagers(){

        $this->db->select('*');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('managers');

        return $query->result_array();
    }
    
}