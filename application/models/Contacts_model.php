<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}   
	
	/* contacts function starts */
	function get_all_filter_contacts($params = array()){
		$whrs =''; 
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
		
		$query = $this->db->query("SELECT * FROM contacts_tbl WHERE id >'0' $whrs ORDER BY created_on DESC $limits "); 
		return $query->result(); 
	}  
	
	function trash_contact($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('contacts_tbl');
		} 
		return true;
	}
	
	function get_all_contacts(){
	   $query = $this->db->get('contacts_tbl');
	   return $query->result();
	} 
	
	function get_contact_by_id($args1){ 
		$query = $this->db->get_where('contacts_tbl',array('id'=> $args1));
		return $query->row();
	} 
	
	function get_contact_by_name($tmp_nm){ 
		$this->db->where(" name='$tmp_nm' "); 
		$query = $this->db->get('contacts_tbl');
		return $query->row(); 
	}
	
	function get_contact_by_mobile_no($tmp_mobile){  
		$this->db->where(" mobile_no='$tmp_mobile' "); 
		$query = $this->db->get('contacts_tbl');
		return $query->row(); 
	} 
	 
	function insert_contact_data($data){ 
		return $this->db->insert('contacts_tbl', $data);
	}  
	
	function update_contact_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('contacts_tbl', $data);
	} 
	/* contacts functions ends */ 
	
}  ?>