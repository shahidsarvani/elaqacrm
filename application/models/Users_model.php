<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Users_model extends CI_Model {

	 function __construct() {
		parent::__construct();
	}
	
	function trash_user($args2){
		if($args2 >1){
			$this->db->where('id', $args2);
			$this->db->delete('users_tbl');
		} 
		return true;
	}
	
	
	function get_all_filter_users($params = array()){
		$whrs =''; 
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val']; 
			if(strlen($q_val)>0){
				$whrs .=" AND ( name LIKE '%$q_val%' OR email LIKE '%$q_val%' OR phone_no LIKE '%$q_val%' OR mobile_no LIKE '%$q_val%' OR address LIKE '%$q_val%' ) ";
			}
		}
		
		if(array_key_exists("sl_role_id",$params)){
			$sl_role_id = $params['sl_role_id']; 
			if($sl_role_id >0){
				$whrs .=" AND role_id='".$sl_role_id."' ";
			}
		}
		 
		$limits ='';
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
			$tot_limit =   $params['limit'];
			$str_limit =   $params['start']; 			 
			$limits = " LIMIT $str_limit, $tot_limit ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
             $tot_limit =   $params['limit'];
			$limits = " LIMIT $tot_limit ";
		}   
		
		$query = $this->db->query("SELECT * FROM users_tbl WHERE id >'0' $whrs ORDER BY created_on DESC $limits "); 
		return $query->result(); 
	}  
	

	function get_all_users(){
	   $query = $this->db->get('users_tbl');
	   return $query->result();
	} 

	function get_user($email,$password){ 
		$query = $this->db->get_where('users_tbl',array('email'=> $email,'password'=> $password));
		return $query->row();
	}
	
	function get_user_by_email($email){
		$query = $this->db->get_where('users_tbl',array('email'=> $email));
		return $query->row();
	}
	
	function get_user_by_id($args1){ 
		$query = $this->db->get_where('users_tbl',array('id'=> $args1));
		return $query->row();
	}
	
	function insert_user_data($data){ 
		$ress = $this->db->insert('users_tbl', $data);
		return $ress;
	}  
	
	function update_user_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('users_tbl', $data);
	}
	 
	function get_user_custom_data($data_arr){ 
		$query = $this->db->get_where('users_tbl',$data_arr);
		return $query->row();
	}
	
	function get_config_by_id($args1){ 
		$query = $this->db->get_where('config_tbl',array('id'=> $args1));
		return $query->row();
	}
	
	function insert_config_data($data){  
		$ress = $this->db->insert('config_tbl', $data);
		return $ress;
	}  
	
	function update_config_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('config_tbl', $data);
	}
	 
}  ?>