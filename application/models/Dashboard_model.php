<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	} 
  	
	/* dashboard functions starts */
	function get_all_recent_properties_list($params = array()){ 
		$temp_agents_ids = '';
		$vs_id = $this->session->userdata('us_id');
		$vs_user_type_id= $this->session->userdata('us_role_id');  
		if($vs_user_type_id==2){
			$agnt_arrs = $this->general_model->get_gen_all_manager_agents_list($vs_id); 
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		} 
		 
		$whrs = ''; 
		if($vs_user_type_id==3){ 
			$whrs .= " AND p.assigned_to_id=$vs_id ";
		}else if($vs_user_type_id==2){   
			if(array_key_exists("assigned_to_id_val",$params)){
				$assigned_to_id_val = $params['assigned_to_id_val'];  
				if(strlen($assigned_to_id_val)>0){ 
					$whrs .= " AND p.assigned_to_id IN ($assigned_to_id_val) ";
				} 
			}else{  
				if($temp_agents_ids != ''){ 
					$whrs .= " AND ( p.assigned_to_id='$vs_id' OR p.assigned_to_id IN ($temp_agents_ids) ) "; 
				}else{ 
					$whrs .= " AND p.assigned_to_id='$vs_id'  ";
				}	 
			}
		} 
		
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
		$temp_agents_ids = ''; 
		$vs_id = $this->session->userdata('us_id');  
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
		
		if($vs_user_type_id==2){ 
			$agnt_arrs = $this->general_model->get_gen_all_manager_agents_list($vs_id);
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		} 
		  
		if($vs_user_type_id==3){  
			$this->db->where("assigned_to_id=$vs_id");
		}else if($vs_user_type_id==2){ 
			
			if($temp_agents_ids != ''){ 
				$this->db->where("(assigned_to_id='$vs_id' OR assigned_to_id IN ($temp_agents_ids))"); 
			}else{  
				$this->db->where("assigned_to_id='$vs_id' ");
			}  
		} 
		$this->db->where("is_deleted='0'");  
		$this->db->where("property_type='1'"); 
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	} 
	
	function get_total_rent_properties_nums(){ 
		$temp_agents_ids = ''; 
		$vs_id = $this->session->userdata('us_id');  
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
		
		if($vs_user_type_id==2){ 
			$agnt_arrs = $this->general_model->get_gen_all_manager_agents_list($vs_id);
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		} 
		  
		if($vs_user_type_id==3){  
			$this->db->where("assigned_to_id=$vs_id");
		}else if($vs_user_type_id==2){
			if($temp_agents_ids != ''){ 
				$this->db->where("(assigned_to_id='$vs_id' OR assigned_to_id IN ($temp_agents_ids))"); 
			}else{  
				$this->db->where("assigned_to_id='$vs_id' ");
			} 
		}
		
		$this->db->where("is_deleted='0'"); 
		$this->db->where("property_type='2'");  
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	}   
	
	function get_total_active_properties_nums(){ 
		$temp_agents_ids = ''; 
		$vs_id = $this->session->userdata('us_id');  
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
		
		if($vs_user_type_id==2){ 
			$agnt_arrs = $this->general_model->get_gen_all_manager_agents_list($vs_id);
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		} 
		  
		if($vs_user_type_id==3){  
			$this->db->where("assigned_to_id=$vs_id");
		}else if($vs_user_type_id==2){
			if($temp_agents_ids != ''){ 
				$this->db->where("(assigned_to_id='$vs_id' OR assigned_to_id IN ($temp_agents_ids))"); 
			}else{  
				$this->db->where("assigned_to_id='$vs_id' ");
			} 
		}
			 
		$this->db->where("is_deleted='0'");  
		$this->db->where("is_archived='0'"); 
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	} 
	
	function get_total_archived_properties_nums(){
		$temp_agents_ids = ''; 
		$vs_id = $this->session->userdata('us_id');  
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
		
		if($vs_user_type_id==2){ 
			$agnt_arrs = $this->general_model->get_gen_all_manager_agents_list($vs_id);
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		} 
		
		if($vs_user_type_id==3){  
			$this->db->where("assigned_to_id=$vs_id");
		}else if($vs_user_type_id==2){
			if($temp_agents_ids != ''){ 
				$this->db->where("(assigned_to_id='$vs_id' OR assigned_to_id IN ($temp_agents_ids))"); 
			}else{  
				$this->db->where("assigned_to_id='$vs_id' ");
			} 
		}
		
		$this->db->where("is_deleted='0'");  
		$this->db->where("is_archived='1'"); 
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	}
	
	
	/* dashboard functions ends */  
	
}  ?>