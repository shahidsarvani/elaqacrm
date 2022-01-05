<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Owners_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}   
	
	/* owners function starts */   
	
	function get_all_filter_owners($params = array()){
	  
		$temp_agents_ids = $whrs = '';
		$vs_id = $this->session->userdata('us_id');
		$vs_role_id = $this->session->userdata('us_role_id');
		if($vs_role_id==2){
			$temp_agents_ids .= $vs_id.","; 
			$agnt_arrs = $this->get_all_manager_agents_list($vs_id);  
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				} 
			}
			
			$temp_agents_ids = trim($temp_agents_ids,","); 
			
			$whrs .=" AND assigned_to IN (".$temp_agents_ids.") ";
		
		}else if($vs_role_id==3){   
			$whrs .=" AND assigned_to=$vs_id ";
		}  
		
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val']; 
			if(strlen($q_val)>0){
				$whrs .=" AND ( name LIKE '%$q_val%' OR email LIKE '%$q_val%' OR phone_no LIKE '%$q_val%' OR mobile_no LIKE '%$q_val%' OR address LIKE '%$q_val%' ) ";
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
		  
		$query = $this->db->query("SELECT * FROM owners_tbl WHERE id >'0' $whrs ORDER BY created_on DESC $limits "); 
		return $query->result(); 
	} 
	
	
	function get_all_manager_agents_list($mngrs_ids){ 
	   $query = $this->db->get_where('users_tbl',array('parent_id' => $mngrs_ids));
	   return $query->result();
	}  
	
	function trash_owner($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('owners_tbl');
		} 
		return true;
	}
	
	function get_all_owners(){
	   $query = $this->db->get('owners_tbl');
	   return $query->result();
	} 
	
	function get_owner_by_id($args1){ 
		$query = $this->db->get_where('owners_tbl',array('id'=> $args1));
		return $query->row();
	} 
	
	function get_owner_by_name($tmp_nm){ 
		$this->db->where(" name='$tmp_nm' "); 
		$query = $this->db->get('owners_tbl');
		return $query->row(); 
	}
	
	function get_owner_by_mobile_no($tmp_mobile){  
		$this->db->where(" mobile_no='$tmp_mobile' "); 
		$query = $this->db->get('owners_tbl');
		return $query->row(); 
	} 
	 
	function insert_owner_data($data){ 
		return $this->db->insert('owners_tbl', $data);
	}  
	
	function update_owner_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('owners_tbl', $data);
	} 
	/* owners functions ends */ 
	
}  ?>