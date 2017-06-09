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
    
    function getAdminCounts(){
        
        $query = $this->db->query('SELECT 
                        (SELECT COUNT(*) FROM users) as users,
                        (SELECT COUNT(*) FROM items) as fridges,
                        (SELECT COUNT(*) FROM managers WHERE is_area_manager = 1) as amanagers, 
                        (SELECT COUNT(*) FROM managers WHERE is_area_manager = 0) as zmanagers
                    ');
        
        return $query->row();
    }
    
    function getAreaManagerCounts($polygon){
        
//        $this->db->where('manager_id', $this->session->userdata('manager_id'));
//        }
//        $this->db->where("Intersects(point, GeomFromText('POLYGON(($polygon))'))");
        
        $query = $this->db->query("SELECT 
                        (SELECT COUNT(*) FROM items where Intersects(point, GeomFromText('POLYGON(($polygon))'))) as fridges,
                        (SELECT COUNT(*) FROM managers WHERE is_area_manager = 0) as zmanagers
                    ");
        
        return $query->row();
    }
    
    function getZoneManagerCounts(){
        
        $query = $this->db->query('SELECT 
                        (SELECT COUNT(*) FROM items where manager_id = '.$this->session->userdata('manager_id').') as fridges
                    ');
        
        return $query->row();
    }
        
    
    function getAllUsers($limit = '', $sort = ''){
        
//        $this->db->where('status', 0);
//        $this->db->or_where('status', 1);
        if(!empty($sort)){
            $this->db->order_by("$sort");
        }else{
            $this->db->order_by("created_at DESC");
        }
        if ($limit != '') {
            $offset = $this->uri->segment(4);
            $query = $this->db->limit($limit, $offset);
        }
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
            $this->db->where('manager_id', $this->session->userdata('areamanager_id'));
        }
        $query = $this->db->get('items');

        return $query->row();
    }

    function getPolygon(){
        
        $this->db->select('polygon');
        $this->db->where('manager_id', $this->session->userdata('areamanager_id'));
        $query = $this->db->get('managers');

        return $query->row();
    }
    
    function getFridgesByPolygon($limit = '', $polygon=''){
       
//      SET @bbox = 'POLYGON((0 0, 10 0, 10 10, 0 10, 0 0))';
//      SELECT name, AsText(location) FROM Points WHERE Intersects( location, GeomFromText(@bbox) )
        
        $this->db->select('*, AsText(point)');
        $this->db->join('users', 'users.user_id = items.user_id', 'inner');
        $this->db->order_by("item_id DESC");
        if($this->session->userdata('manager_id') == TRUE){
            $this->db->where('manager_id', $this->session->userdata('manager_id'));
        }
        $this->db->where("Intersects(point, GeomFromText('POLYGON(($polygon))'))");
        if ($limit != '') {
            $offset = $this->uri->segment(4);
            $query = $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('items');

        return $query->result_array();
    }
    
    function getAllFridges($limit = ''){
       
        $this->db->select('*');
        $this->db->join('users', 'users.user_id = items.user_id', 'inner');
        $this->db->order_by("item_id DESC");
        if($this->session->userdata('manager_id') == TRUE){
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

    function getAllManagers($limit = ''){

        $this->db->select('*');
        $this->db->where('is_area_manager', 1);
        $this->db->order_by('name', 'ASC');
        if ($limit != '') {
            $offset = $this->uri->segment(4);
            $query = $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('managers');

        return $query->result_array();
    }

    function getAllManagersBySuperManager($limit = ''){

        $this->db->select('*');
        $this->db->where('super_manager', $this->session->userdata('areamanager_id'));
        $this->db->order_by('name', 'ASC');
        if ($limit != '') {
            $offset = $this->uri->segment(4);
            $query = $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('managers');

        return $query->result_array();
    }

    function getAllSubManagers($limit = ''){

        $this->db->select('m2.manager_id, m2.name, m2.email, m2.mobile, m1.name as created_by, m1.email as am_email');
        $this->db->join('managers as m2', 'm1.manager_id = m2.super_manager', 'inner');
        $this->db->order_by('m1.name', 'ASC');
        if ($limit != '') {
            $offset = $this->uri->segment(4);
            $query = $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('managers as m1');

        return $query->result_array();
    }

    
}