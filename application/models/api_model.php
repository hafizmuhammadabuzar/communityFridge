<?php

class Api_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getUserItems($user_id = ''){
        
        $this->db->select('items.item_id, condition, services, latitude, longitude, access_time, preferred_filling_time, area, address, status, item_images.item_id as img_item_id, image, is_active');
        $this->db->join('item_images', 'items.item_id = item_images.item_id', 'left');
        if(!empty($user_id)){
            $this->db->where('user_id', $user_id);
        }
        else{
            $this->db->where("items.is_active = 1");
            $this->db->where("items.condition = 'Active'");
        }
        $this->db->where("items.status != 'Deleted'");
        $query = $this->db->get('items');
                
        return $query->result_array();
    }
    
    function getItemsById($item_id){
        
        $this->db->select('items.item_id, condition, services, latitude, longitude, access_time, preferred_filling_time, area, address, status, item_images.item_id as img_item_id, image');
        $this->db->join('item_images', 'items.item_id = item_images.item_id', 'left');
        $this->db->where('items.item_id', $item_id);
        $query = $this->db->get('items');
                
        return $query->result_array();
    }
    
    function deleteItem($item_id, $user_id = ''){
        
        if(!empty($user_id)){
            $this->db->where('item_id', $item_id);
            $this->db->where('user_id', $user_id);
            $this->db->update('items', ['status' => 'Deleted']);
        }
        
        if(empty($user_id)){
            $this->db->where('item_id', $item_id);
            $this->db->delete('item_images');
        }
        
        return $this->db->affected_rows();
        
        /*
        $this->db->select('image');
        $this->db->where('item_id', $item_id);
        $query1 = $this->db->get('item_images');
        
        if($query1->num_rows() > 0){
            $images = $query1->result_array();
            
            foreach($images as $img){
                $filename = explode('/', $img['image']);
                unlink('assets/uploads/'.end($filename));
            }
        }
        
        if(empty($user_id)){
            $this->db->where('item_id', $item_id);
            $this->db->delete('item_images');
        }
        else{
            $this->db->last_query("delete items, item_images from items
                    left join item_images on items.item_id = item_images.item_id
                    where items.item_id = $item_id and user_id = $user_id");
            $this->db->where('item_id', $item_id);
            $this->db->where('user_id', $user_id);
            $this->db->delete('items');
        }
        
        return $this->db->affected_rows();
        */
    }
    
    function getAllActivities($date){
        
        $this->db->select('items.item_id as fridge_id, english_description, french_description, arabic_description, users.user_id, users.username, fridge_refills.updated_at as created_at');
        $this->db->join('items', 'items.item_id = fridge_refills.item_id', 'inner');
        $this->db->join('users', 'users.user_id = items.user_id', 'inner');
        $this->db->where("fridge_refills.updated_at > '$date'");
        $this->db->where("items.status != 'Deleted'");
        $this->db->order_by('fridge_refills.updated_at', 'DESC');
        $query = $this->db->get('fridge_refills');
                        
        return $query->result_array();
    }
    
    function getAllLoggedInUsers(){
        
        $this->db->select('users.username, users.email, tokens.token');
        $this->db->join('tokens', 'tokens.user_email = users.email', 'inner');
        $this->db->group_by('users.email');
        $this->db->order_by('users.username', 'ASC');
        $query = $this->db->get('users');
        
        return $query->result_array();
    }
    
    function getTokens($email = '') {
        $email = (!empty($email)) ? "and user_email = '" . $email  . "'" : '';
        $query = $this->db->query("select token from tokens where device_id is not null $email");
        return $query->result_array();
    }

    function getiOSTokens($email = '') {
        $email = (!empty($email)) ? "and user_email = '" . $email  . "'" : '';
        $query = $this->db->query("select token, player_id from tokens where player_id is not null and date(`updated_date`) > '2016-05-01' $email");
        return $query->result_array();
    }
    

}
