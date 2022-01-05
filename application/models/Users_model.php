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
				$whrs .=" AND ( u.name LIKE '%$q_val%' OR u.email LIKE '%$q_val%' OR u.phone_no LIKE '%$q_val%' OR u.mobile_no LIKE '%$q_val%' OR u.address LIKE '%$q_val%' ) ";
			}
		}
		  
		$vs_id = $this->session->userdata('us_id');
		$vs_role_id = $this->session->userdata('us_role_id'); 
		$vs_parent_id = $this->session->userdata('us_parent_id');  
		if($vs_role_id==2){ 
			$whrs .=" AND u.parent_id='".$vs_id."' "; 
		}else if($vs_role_id==3){ 
			$whrs .=" AND u.parent_id='".$vs_parent_id."' "; 
		}
		
		if(array_key_exists("sl_role_id",$params)){
			$sl_role_id = $params['sl_role_id']; 
			if($sl_role_id >0){
				$whrs .=" AND u.role_id='".$sl_role_id."' ";
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
		
		$query = $this->db->query("SELECT u.*, r.name as role_name, p.name as package_name FROM users_tbl u 
		LEFT JOIN roles_tbl r ON u.role_id=r.id
		LEFT JOIN packages_tbl p ON u.package_id=p.id
		 WHERE u.id >'0' $whrs ORDER BY u.created_on DESC $limits "); 
		return $query->result(); 
	}  
	

	function get_all_users(){
	   $query = $this->db->get('users_tbl');
	   return $query->result();
	} 

	function get_user($email,$password){ 
		$query = $this->db->get_where('users_tbl',array('email' => $email, 'password' => $password));
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
	
	function get_user_by_role_custom_data($data_arr){ 
		$query = $this->db->get_where('users_tbl',$data_arr);
		return $query->result();
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