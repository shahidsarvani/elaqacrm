<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	} 
  	
	/* dashboard functions starts */
	function get_all_recent_properties_list($params = array()){
		 
		$whrs = '';
		if(array_key_exists("portal_id",$params)){
			$portal_id_val = $params['portal_id']; 
			if($portal_id_val>0){
				$whrs =" AND FIND_IN_SET($portal_id_val, p.show_on_portal_ids) ";
			}
		} 
		
		$limits='';
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
			$tot_limit =   $params['limit'];
			$str_limit =   $params['start'];
			$limits = " LIMIT $str_limit,$tot_limit ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
             $tot_limit =   $params['limit'];
			 $limits = " LIMIT $tot_limit ";
		}
		
		$query = $this->db->query("SELECT p.id, p.ref_no, p.price, p.property_status, p.assigned_to_id, p.is_new, u.name AS crt_usr_name, bd.title AS bed_title, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no FROM properties_tbl p LEFT JOIN users_tbl u ON p.created_by=u.id LEFT JOIN no_of_bedrooms_tbl bd ON p.no_of_beds_id=bd.id LEFT JOIN owners_tbl ow ON p.owner_id=ow.id WHERE p.is_deleted='0' $whrs ORDER BY p.id DESC $limits "); 
		return $query->result(); 	
	}  
	
 	function get_total_sale_properties_nums(){  
		$this->db->where("is_deleted='0'");  
		$this->db->where("property_type='1'"); 
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	} 
	
	function get_total_rent_properties_nums(){  
		$this->db->where("is_deleted='0'"); 
		$this->db->where("property_type='2'");  
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	}   
	
	function get_total_active_properties_nums(){ 
		$this->db->where("is_deleted='0'");  
		$this->db->where("is_archived='0'"); 
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	} 
	
	function get_total_archived_properties_nums(){  
		$this->db->where("is_deleted='0'");  
		$this->db->where("is_archived='1'"); 
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	}
	
	
	/* dashboard functions ends */  
	
}  ?>