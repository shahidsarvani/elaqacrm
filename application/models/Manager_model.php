<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}   
	
	/* Manager_model function starts */    
	function get_filter_manager_agents_list($params = array()){
		$whrs ='';  
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val']; 
			if(strlen($q_val)>0){
				$whrs .=" AND ( name LIKE '%$q_val%' OR email LIKE '%$q_val%' OR phone_no LIKE '%$q_val%' OR mobile_no LIKE '%$q_val%' OR address LIKE '%$q_val%' ) ";
			}
		}
		
		if(array_key_exists("manager_id_val",$params)){
			$manager_id_val = $params['manager_id_val']; 
			if($manager_id_val >0){
				$whrs .=" AND parent_id='$manager_id_val' ";
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
		 
		$query = $this->db->query("SELECT * FROM users_tbl WHERE role_id='3' $whrs ORDER BY created_on DESC $limits "); 
		return $query->result(); 
	}  
	
	
	function get_filter_agents_meetings_views_list($params = array()){
		$whrs ='';  
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val']; 
			if(strlen($q_val)>0){
				$whrs .=" AND ( u.name LIKE '%$q_val%' OR u.email LIKE '%$q_val%' OR u.phone_no LIKE '%$q_val%' OR u.mobile_no LIKE '%$q_val%' OR u.address LIKE '%$q_val%' OR m.nos_of_meetings LIKE '%$q_val%'  OR m.nos_of_views LIKE '%$q_val%' ) ";  			
			}
		}
		
		if(array_key_exists("manager_id_val",$params)){
			$manager_id_val = $params['manager_id_val']; 
			if($manager_id_val >0){
				$whrs .=" AND u.parent_id='$manager_id_val' ";
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
		 
		$query = $this->db->query("SELECT m.*, u.name AS agent_name FROM meetings_views_tbl m, users_tbl u WHERE m.user_id=u.id $whrs ORDER BY m.added_on DESC $limits "); 
		return $query->result(); 
	} 
	/* Manager_model functions ends */ 
	
}  ?>