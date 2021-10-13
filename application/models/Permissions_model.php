<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}   
	
	/*permission function starts*/  
	function get_all_permission_with_user_modules_roles($params = array()){
		$whrs =''; 
		if(array_key_exists("module_id_val",$params)){
			$sel_module_id = $params['module_id_val']; 
			if($sel_module_id>0){
				$whrs .=" AND p.module_id=$sel_module_id";
			}
		}  
		
		if(array_key_exists("user_type_id_val",$params)){
			$user_type_id_val = $params['user_type_id_val']; 
			if($user_type_id_val>0){
				$whrs .=" AND p.role_id=$user_type_id_val ";
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
		
		$query = $this->db->query("SELECT p.*, m.name AS module_name, r.name AS role_name FROM permissions_tbl p LEFT JOIN modules_tbl m ON p.module_id=m.id LEFT JOIN roles_tbl r ON p.role_id=r.id WHERE p.id >'0' $whrs ORDER BY p.id ASC $limits "); 
		return $query->result(); 
	} 
	 
	
	function get_all_permission_with_user_roles($params = array()){
		$whrs =''; 
		if(array_key_exists("module_id_val",$params)){
			$sel_module_id = $params['module_id_val']; 
			if($sel_module_id>0){
				$whrs .=" AND p.module_id=$sel_module_id";
			}
		}  
		
		if(array_key_exists("user_type_id_val",$params)){
			$user_type_id_val = $params['user_type_id_val']; 
			if($user_type_id_val>0){
				$whrs .=" AND p.role_id=$user_type_id_val ";
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
		
		$query = $this->db->query("SELECT p.*, r.name AS role_name FROM permissions_tbl p LEFT JOIN roles_tbl r ON p.role_id=r.id WHERE p.id >'0' $whrs ORDER BY p.id ASC $limits "); 
		return $query->result(); 
	}  
	
	function trash_permission($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('permissions_tbl');
		} 
		return true;
	}
	
	function get_all_permissions(){
	   $query = $this->db->get('permissions_tbl');
	   return $query->result();
	} 
	
	function get_permission_by_id($args1){ 
		$query = $this->db->get_where('permissions_tbl',array('id'=> $args1));
		return $query->row();
	}
	
	function get_permission_by_id_with_chk($args1){ 
		if($args1 >0){
			$vs_id = $this->session->userdata('us_id'); 
			$query = $this->db->query("SELECT * FROM permissions_tbl WHERE id='$args1' AND added_by='$vs_id' "); 
			return $query->row();  
		} 
	}  
	 
	function insert_permission_data($data){ 
		return $this->db->insert('permissions_tbl', $data);
	}  
	
	function update_permission_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('permissions_tbl', $data);
	} 
	/*permission functions ends*/ 
	
}  ?>