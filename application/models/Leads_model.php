<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leads_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}  

	/* leads functions starts */
	function get_all_cstm_properties_deals($params = array()){ 
		
		$vs_user_type_id= $this->session->userdata('us_user_type_id'); 
		$temp_agents_ids = ''; 
		 
		$whrs ='';
		$vs_id = $this->session->userdata('us_id');  
		   
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val'];  
			if(strlen($q_val)>0){
				$whrs .= " AND p.ref_no LIKE '%$q_val%' "; 
			}
		}  

		 
		if(array_key_exists("price_val",$params) && array_key_exists("to_price_val",$params)){ 
			$str_price_val = $params['price_val'];
			$to_price_val = $params['to_price_val']; 
			
			if($str_price_val>0 && $to_price_val>0){
				$whrs .=" AND ( p.price >='$str_price_val' AND p.price <='$to_price_val' ) ";
			}  
		} 
		 
		if(array_key_exists("unit_no_val",$params)){
			$unit_no_val = $params['unit_no_val'];  
			if(strlen($unit_no_val)>0){
				$whrs .= " AND p.unit_no LIKE '%$unit_no_val%' "; 
			}
		} 
		
		if(array_key_exists("property_type_val",$params)){
			$property_type_val = $params['property_type_val'];  
			if($property_type_val>0){
				$whrs .= " AND p.property_type='$property_type_val' "; 
			}
		}else
		if(array_key_exists("paras1_val",$params)){
			$paras1_val = $params['paras1_val'];  
			if($paras1_val>0){ 
				$whrs .= " AND p.property_type='$paras1_val' "; 
			}
		}  
		 	
		
		if(array_key_exists("category_id_val",$params)){
			$category_id_val = $params['category_id_val'];  
			if($category_id_val>0){
				$whrs .= " AND p.category_id='$category_id_val' "; 
			}
		}    
		
		/*if(array_key_exists("beds_id_val",$params)){
			$beds_id_val = $params['beds_id_val'];   
			if(strlen($beds_id_val)>0){
				$whrs .= " AND p.no_of_beds_id IN ($beds_id_val) "; 
			}
		} */
		
		
		if(array_key_exists("emirate_location_id_val",$params)){
			$emirate_location_id_val = $params['emirate_location_id_val'];
			if(strlen($emirate_location_id_val)>0){
				$whrs .= " AND p.sub_location_id IN ($emirate_location_id_val) "; 
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
		   
		$query = $this->db->query("SELECT p.id, p.ref_no, p.types, p.plot_area, p.price, p.property_type, p.is_lead, p.unit_no, sl.name AS sub_loc_name, ct.name AS cate_name, bd.title AS bed_title FROM properties_tbl p LEFT JOIN categories_tbl ct ON p.category_id=ct.id LEFT JOIN no_of_beds_tbl bd ON p.no_of_beds_id=bd.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id WHERE p.is_deleted='0' $whrs ORDER BY p.created_on DESC $limits "); 
		return $query->result(); 
		
		/* LEFT JOIN emirates_tbl em ON p.emirate_id=em.id LEFT JOIN emirate_locations_tbl lc ON p.location_id=lc.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id
		
		em.name AS emrt_name, lc.name AS loc_name, sl.name AS sub_loc_name  p.is_lead='1' LEFT JOIN users_tbl u ON p.created_by=u.id */
		  
	} 
	
	
	function get_all_cstm_properties_deals_leads($params = array()){ 
		
		$vs_user_type_id= $this->session->userdata('us_user_type_id'); 
		$temp_agents_ids = ''; 
		 
		$whrs ='';
		$vs_id = $this->session->userdata('us_id');  
		   
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val'];  
			if(strlen($q_val)>0){
				$whrs .= " AND p.ref_no LIKE '%$q_val%' "; 
			}
		}  
		 
		if(array_key_exists("price_val",$params) && array_key_exists("to_price_val",$params)){ 
			$str_price_val = $params['price_val'];
			$to_price_val = $params['to_price_val']; 
			
			if($str_price_val>0 && $to_price_val>0){
				$whrs .=" AND ( p.price >='$str_price_val' AND p.price <='$to_price_val' ) ";
			}  
		} 
		 
		if(array_key_exists("unit_no_val",$params)){
			$unit_no_val = $params['unit_no_val'];  
			if(strlen($unit_no_val)>0){
				$whrs .= " AND p.unit_no LIKE '%$unit_no_val%' "; 
			}
		} 
		
		if(array_key_exists("property_type_val",$params)){
			$property_type_val = $params['property_type_val'];  
			if($property_type_val>0){
				$whrs .= " AND p.property_type='$property_type_val' "; 
			}
		}else
		if(array_key_exists("paras1_val",$params)){
			$paras1_val = $params['paras1_val'];  
			if($paras1_val>0){ 
				//$whrs .= " AND p.property_type='$paras1_val' "; 
			}
		}  
		 	
		
		if(array_key_exists("category_id_val",$params)){
			$category_id_val = $params['category_id_val'];  
			if($category_id_val>0){
				$whrs .= " AND p.category_id='$category_id_val' "; 
			}
		}    
		
		/*if(array_key_exists("beds_id_val",$params)){
			$beds_id_val = $params['beds_id_val'];   
			if(strlen($beds_id_val)>0){
				$whrs .= " AND p.no_of_beds_id IN ($beds_id_val) "; 
			}
		} */
		
		
		if(array_key_exists("emirate_location_id_val",$params)){
			$emirate_location_id_val = $params['emirate_location_id_val'];
			if(strlen($emirate_location_id_val)>0){
				$whrs .= " AND p.sub_location_id IN ($emirate_location_id_val) "; 
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
		   
		$query = $this->db->query("SELECT p.id, p.ref_no, p.types, p.plot_area, p.price, p.property_type, p.is_lead, p.unit_no, sl.name AS sub_loc_name, ct.name AS cate_name, bd.title AS bed_title FROM properties_tbl p LEFT JOIN categories_tbl ct ON p.category_id=ct.id LEFT JOIN no_of_beds_tbl bd ON p.no_of_beds_id=bd.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id WHERE p.is_deleted='0' $whrs ORDER BY p.created_on DESC $limits "); 
		return $query->result(); 
		
		/* LEFT JOIN emirates_tbl em ON p.emirate_id=em.id LEFT JOIN emirate_locations_tbl lc ON p.location_id=lc.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id
		
		em.name AS emrt_name, lc.name AS loc_name, sl.name AS sub_loc_name  p.is_lead='1' LEFT JOIN users_tbl u ON p.created_by=u.id */
		  
	} 
	
	
	function get_all_cstm_properties_deals_old($params = array()){ 
		
		$vs_user_type_id= $this->session->userdata('us_user_type_id'); 
		$temp_agents_ids = ''; 
		 
		$whrs ='';
		$vs_id = $this->session->userdata('us_id');  
		   
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val'];  
			if(strlen($q_val)>0){
				$whrs .= " AND p.ref_no LIKE '%$q_val%' "; 
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
		 
		$query = $this->db->query("SELECT p.id, p.ref_no, p.types, p.plot_area, p.price, p.property_type, p.is_lead, ct.name AS cate_name, bd.title AS bed_title, p.emirate_id, p.location_id, p.sub_location_id FROM properties_tbl p LEFT JOIN categories_tbl ct ON p.category_id=ct.id LEFT JOIN no_of_beds_tbl bd ON p.no_of_beds_id=bd.id WHERE p.is_deleted='0' $whrs ORDER BY p.created_on DESC $limits ");    
		
		return $query->result();   
		/* p.emirate_id, p.location_id, p.sub_location_id
		p.is_lead='1' LEFT JOIN users_tbl u ON p.created_by=u.id   p.id >'0' */
		
		/* , em.name AS emrt_name, lc.name AS loc_name, sl.name AS sub_loc_name
		LEFT JOIN emirates_tbl em ON p.emirate_id=em.id LEFT JOIN emirate_locations_tbl lc ON p.location_id=lc.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id */
	}
	
	
	function get_all_cstm_properties_leads($params = array()){ 
		
		$vs_user_type_id= $this->session->userdata('us_user_type_id'); 
		$temp_agents_ids = ''; 
		 
		$whrs ='';
		$vs_id = $this->session->userdata('us_id');  
		   
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val'];  
			if(strlen($q_val)>0){
				$whrs .= " AND p.ref_no LIKE '%$q_val%' "; 
			}
		}  
		 
		if(array_key_exists("price_val",$params) && array_key_exists("to_price_val",$params)){ 
			$str_price_val = $params['price_val'];
			$to_price_val = $params['to_price_val']; 
			
			if($str_price_val>0 && $to_price_val>0){
				$whrs .=" AND ( p.price >='$str_price_val' AND p.price <='$to_price_val' ) ";
			}  
		}
		
		if(array_key_exists("unit_no_val",$params)){
			$unit_no_val = $params['unit_no_val'];  
			if(strlen($unit_no_val)>0){
				$whrs .= " AND p.unit_no LIKE '%$unit_no_val%' "; 
			}
		} 
		
		if(array_key_exists("property_type_val",$params)){
			$property_type_val = $params['property_type_val'];  
			if($property_type_val>0){
				$whrs .= " AND p.property_type='$property_type_val' "; 
			}
		} 
		 	
		
		if(array_key_exists("category_id_val",$params)){
			$category_id_val = $params['category_id_val'];  
			if($category_id_val>0){
				$whrs .= " AND p.category_id='$category_id_val' "; 
			}
		}    
		
		/*if(array_key_exists("beds_id_val",$params)){
			$beds_id_val = $params['beds_id_val'];   
			if(strlen($beds_id_val)>0){
				$whrs .= " AND p.no_of_beds_id IN ($beds_id_val) "; 
			}
		} */
		
		
		if(array_key_exists("emirate_location_id_val",$params)){
			$emirate_location_id_val = $params['emirate_location_id_val'];
			if(strlen($emirate_location_id_val)>0){
				$whrs .= " AND p.sub_location_id IN ($emirate_location_id_val) "; 
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
		   
		     
		   
		$query = $this->db->query("SELECT p.id, p.ref_no, p.types, p.plot_area, p.price, p.property_type, p.is_lead, p.unit_no, sl.name AS sub_loc_name, ct.name AS cate_name, bd.title AS bed_title FROM properties_tbl p LEFT JOIN categories_tbl ct ON p.category_id=ct.id LEFT JOIN no_of_beds_tbl bd ON p.no_of_beds_id=bd.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id WHERE p.is_deleted='0' $whrs ORDER BY p.created_on DESC $limits "); 
		return $query->result(); 
		
		/* LEFT JOIN emirates_tbl em ON p.emirate_id=em.id LEFT JOIN emirate_locations_tbl lc ON p.location_id=lc.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id
		
		em.name AS emrt_name, lc.name AS loc_name, sl.name AS sub_loc_name  p.is_lead='1' LEFT JOIN users_tbl u ON p.created_by=u.id */
		  
	} 
	
	function get_all_cstm_leads_properties($params = array()){  
		
		$vs_user_type_id= $this->session->userdata('us_user_type_id'); 
		$temp_agents_ids = '';
		if($vs_user_type_id==2){  
			$vs_id = $this->session->userdata('us_id');
			$agnt_arrs = $this->get_all_manager_agents_list($vs_id); 
			
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		} 
		  
		$whrs ='';
		
		if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id'); 
			$whrs .=" AND l.agent_id=$vs_id ";
		}else if($vs_user_type_id==2){  
		
			if(array_key_exists("assigned_to_id_val",$params)){
				$assigned_to_id_val =   $params['assigned_to_id_val'];
				if(strlen($assigned_to_id_val)>0){ 
					$whrs .=" AND l.agent_id IN ($assigned_to_id_val) ";
				}  
			}else{  
				if($temp_agents_ids!=''){
					$whrs .=" AND l.agent_id IN ($temp_agents_ids) ";
				} 
			}
		}else if(array_key_exists("assigned_to_id_val",$params)){
				$assigned_to_id_val = $params['assigned_to_id_val']; 
				if(strlen($assigned_to_id_val)>0){ 
					$whrs .=" AND l.agent_id IN ($assigned_to_id_val) ";
				}
			}  
			
		if(array_key_exists("refer_no_val",$params)){
			$refer_no_val = $params['refer_no_val'];  
			if(strlen($refer_no_val)>0){
				$whrs .= " AND l.ref_no LIKE '%$refer_no_val%' "; 
			}
		}     
		
		if(array_key_exists("leads_type_val",$params)){
			$leads_type_val = $params['leads_type_val'];  
			if(strlen($leads_type_val)>0){
				$whrs .=" AND l.lead_type='$leads_type_val' ";
			}
		}
		 
		if(array_key_exists("leads_status_val",$params)){
			$leads_status_val = $params['leads_status_val'];  
			if(strlen($leads_status_val)>0){
				$whrs .=" AND l.lead_status='$leads_status_val' ";
			}
		}
		
		if(array_key_exists("leads_sub_status_val",$params)){
			$leads_sub_status_val = $params['leads_sub_status_val'];  
			if(strlen($leads_sub_status_val)>0){ 
				$whrs .=" AND l.lead_sub_status='$leads_sub_status_val' ";
			}
		}
		 	
		
		if(array_key_exists("prioritys_val",$params)){
			$prioritys_val = $params['prioritys_val'];  
			if(strlen($prioritys_val)>0){ 
				$whrs .=" AND l.priority='$prioritys_val' ";
			}
		}  
		 
		if(array_key_exists("contact_id_val",$params)){
			$contact_id_val = $params['contact_id_val'];  
			if(strlen($contact_id_val)>0){ 
				$whrs .=" AND l.contact_id IN ( $contact_id_val ) ";
			}
		} 
	 
		if(array_key_exists("inquiry_from_date_val",$params) && array_key_exists("inquiry_to_date_val",$params)){ 
			$inquiry_from_date_val = $params['inquiry_from_date_val'];
			$inquiry_to_date_val = $params['inquiry_to_date_val']; 
			
			if(strlen($inquiry_from_date_val)>0 && strlen($inquiry_to_date_val)>0){
				 
				$whrs .=" AND ( l.enquiry_date >='$inquiry_from_date_val' AND l.enquiry_date <='$inquiry_to_date_val' ) ";
			}  
        }  
		
		
		$p_chk=0;
		if(array_key_exists("price_val",$params) && array_key_exists("to_price_val",$params)){ 
			$str_price_val = $params['price_val'];
			$to_price_val = $params['to_price_val']; 
			
			if(strlen($str_price_val)>0 && strlen($to_price_val)>0){
				$p_chk=1;
				$whrs .=" AND ( p.price >='$str_price_val' AND p.price <='$to_price_val' ) ";
			}  
        } 
		
		if(array_key_exists("emirate_location_id_val",$params)){
			$emirate_location_id_val = $params['emirate_location_id_val'];  
			if(strlen($emirate_location_id_val)>0){ 
				$p_chk=1;
				$whrs .=" AND p.sub_location_id IN ($emirate_location_id_val) ";
			}
		}   
		
		if(array_key_exists("no_of_beds_id_val",$params)){
			$no_of_beds_id_val = $params['no_of_beds_id_val'];  
			if(strlen($no_of_beds_id_val)>0){ 
				$p_chk=1;
				$whrs .=" AND p.no_of_beds_id IN ($no_of_beds_id_val) ";
			}
		}  
		
		if(array_key_exists("category_id_val",$params)){
			$category_id_val = $params['category_id_val'];  
			if(strlen($category_id_val)>0){ 
				$p_chk=1;
				$whrs .=" AND p.category_id IN ($category_id_val) ";
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
		
		/*if($p_chk==1){ 
			$query = $this->db->query("SELECT l.*, s.name AS cnt_name, s.phone_no AS cnt_phone_no, u.name AS crt_name, u.phone_no AS crt_phone_no, p.price, p.sub_location_id, p.no_of_beds_id FROM properties_tbl p, leads_tbl l LEFT JOIN siteusers_tbl s ON l.contact_id=s.id LEFT JOIN users_tbl u ON l.created_by=u.id WHERE l.id >'0' $whrs AND ( l.property_id_1=p.id OR l.property_id_2=p.id OR l.property_id_3=p.id OR l.property_id_4=p.id ) group by l.id ORDER BY l.created_on DESC $limits ");  	
			return $query->result(); 
			
		}else{
			$query = $this->db->query("SELECT l.*, s.name AS cnt_name, s.phone_no AS cnt_phone_no, u.name AS crt_name, u.phone_no AS crt_phone_no FROM leads_tbl l LEFT JOIN siteusers_tbl s ON l.contact_id=s.id LEFT JOIN users_tbl u ON l.created_by=u.id WHERE l.id >'0' $whrs ORDER BY l.created_on DESC $limits ");  	
			return $query->result(); 
		} */
		
		$query = $this->db->query("SELECT l.*, s.name AS cnt_name, s.phone_no AS cnt_phone_no, u.name AS crt_name, u.phone_no AS crt_phone_no, p.price, p.sub_location_id, p.no_of_beds_id , p.category_id, s.updated_on as cnt_updated_on FROM properties_tbl p, leads_tbl l LEFT JOIN siteusers_tbl s ON l.contact_id=s.id LEFT JOIN users_tbl u ON l.created_by=u.id WHERE l.id >'0' $whrs AND ( l.property_id_1=p.id OR l.property_id_2=p.id OR l.property_id_3=p.id OR l.property_id_4=p.id ) group by l.id ORDER BY l.created_on DESC $limits ");  	
			return $query->result();
	}  
	 
	function get_all_cstm_deals_properties($params = array()){  
		
		$vs_user_type_id= $this->session->userdata('us_user_type_id'); 
		$temp_agents_ids = '';
		 
		$whrs ='';
		  
		if(array_key_exists("types_val",$params)){
			$types_val = $params['types_val'];  
			if(strlen($types_val)>0){
				$whrs .= " AND d.types='$types_val' "; 
			}
		}
		
		if(array_key_exists("assigned_to_id_val",$params)){
			$assigned_to_id_val = $params['assigned_to_id_val'];  
			if(strlen($assigned_to_id_val)>0){
				$whrs .= " AND ( d.agent1_id IN ($assigned_to_id_val) OR d.agent2_id IN ($assigned_to_id_val) ) ";
			}
		} 
		
		if(array_key_exists("refer_no_val",$params)){
			$refer_no_val = $params['refer_no_val'];  
			if(strlen($refer_no_val)>0){
				$whrs .= " AND d.ref_no LIKE '%$refer_no_val%' "; 
			}
		}  
		
		if(array_key_exists("unit_no_val",$params)){
			$unit_no_val = $params['unit_no_val'];  
			if(strlen($unit_no_val)>0){
				$whrs .= " AND d.unit_no LIKE '%$unit_no_val%' "; 
			}
		}  
		
		
		if(array_key_exists("est_deal_date_val",$params)){
			$est_deal_date_val = $params['est_deal_date_val'];  
			if(strlen($est_deal_date_val)>0){
				$whrs .= " AND d.est_deal_date='$est_deal_date_val' "; 
			}
		} 
		
		 	
		if(array_key_exists("price_val",$params) && array_key_exists("to_price_val",$params)){ 
			$str_price_val = $params['price_val'];
			$to_price_val = $params['to_price_val']; 
			
			if($str_price_val>0 && $to_price_val>0){
				$whrs .=" AND ( d.deal_price >='$str_price_val' AND d.deal_price <='$to_price_val' ) ";
			}  
        } 
		
		if(array_key_exists("emirate_location_id_val",$params)){
			$emirate_location_id_val = $params['emirate_location_id_val'];  
			if(strlen($emirate_location_id_val)>0){ 
				$whrs .=" AND d.sub_location_id IN ($emirate_location_id_val) ";
			}
		}    
		
		if(array_key_exists("property_status_val",$params)){
			$property_status_val = $params['property_status_val']; 
			if(strlen($property_status_val)>0){ 
				$whrs .=" AND d.status='$property_status_val' ";
			}
		} 
		 
		if(array_key_exists("owner_id_val",$params)){
			$owner_id_val = $params['owner_id_val']; 
			if(strlen($owner_id_val)>0){  
				$whrs .=" AND d.owner_id IN ($owner_id_val) ";
			}
		} 
		
		if(array_key_exists("contact_id_val",$params)){
			$contact_id_val = $params['contact_id_val']; 
			if(strlen($contact_id_val)>0){  
				$whrs .=" AND d.contact_id IN ($contact_id_val) ";
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
		 
		$query = $this->db->query("SELECT d.*, s.name AS cnt_name, s.phone_no AS cnt_phone_no, ow.name AS owner_name, ow.phone_no AS owner_phone_no, sl.name AS sub_loc_name FROM properties_deals_tbl d LEFT JOIN siteusers_tbl s ON d.contact_id=s.id LEFT JOIN owners_tbl ow ON d.owner_id=ow.id LEFT JOIN emirate_sub_locations_tbl sl ON d.sub_location_id=sl.id WHERE d.id >'0' $whrs ORDER BY d.created_on DESC $limits ");  	
		return $query->result();   
	} 
	
			 
	function get_deal_property_popup_detail($paras1){   
		
		$query = $this->db->query("SELECT p.*, c.name AS cate_name FROM properties_tbl p LEFT JOIN categories_tbl c ON p.category_id=c.id WHERE p.id=$paras1 ");  	
		return $query->row();
	} 
	
	function get_deal_lead_property_popup_detail($paras1){    
		$query = $this->db->query("SELECT l.*, s.name AS cnt_name, s.phone_no AS cnt_phone_no, s.email AS cnt_email FROM leads_tbl l LEFT JOIN siteusers_tbl s ON l.contact_id=s.id  WHERE l.id=$paras1 ");  	
		return $query->row();
	} 
	
	
	function get_lead_property_popup_detail($paras1){   
		
		$query = $this->db->query("SELECT p.*, c.name AS cate_name FROM properties_tbl p LEFT JOIN categories_tbl c ON p.category_id=c.id WHERE p.id=$paras1 ");  	
		return $query->row();
	} 
	
	function get_lead_by_id($args1){ 
		$query = $this->db->get_where('leads_tbl',array('id'=> $args1));
		return $query->row();
	} 
	
	function get_all_leads(){
	   $query = $this->db->get('leads_tbl');
	   return $query->result(); 
	}  
	 
	function insert_lead_data($data){ 
		return $this->db->insert('leads_tbl', $data);
	}  
	
	function update_lead_data($args1,$data){ 
		if($args1>0){
			$this->db->where('id',$args1);
			return $this->db->update('leads_tbl', $data);
		}
	}
	
	function insert_deal_data($data){ 
		return $this->db->insert('properties_deals_tbl', $data);
	} 
	
	function update_deal_data($args1,$data){ 
		if($args1>0){
			$this->db->where('id',$args1);
			return $this->db->update('properties_deals_tbl', $data);
		}
	}
	
	function trash_deal($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('properties_deals_tbl');
		} 
		return true;
	}
	
	function trash_lead($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('leads_tbl');
		} 
		return true;
	}
	
	function get_max_lead_id(){
		$this->db->select_max("id");
		$rets = $this->db->get('leads_tbl')->row();  
		return $rets->id; 
	} 
	
	function get_max_deal_id(){
		$this->db->select_max("id");
		$rets = $this->db->get('properties_deals_tbl')->row();  
		return $rets->id; 
	} 
	
	function get_deal_by_id($args1){ 
		$query = $this->db->get_where('properties_deals_tbl',array('id'=> $args1));
		return $query->row();
	}
	
	function chk_lead_reminds_data($paras0,$paras1){  
		$query = $this->db->get_where('leads_reminder_tbl',array('assigned_id'=> $paras0,'lead_id'=> $paras1));
		return $query->row();
	}
	
	function insert_lead_reminds_data($data){ 
		return $this->db->insert('leads_reminder_tbl', $data);
	}  
	
	function update_lead_reminds_data($paras0,$paras1,$data){ 
		$this->db->where('assigned_id',$paras0);
		$this->db->where('lead_id',$paras1);
		return $this->db->update('leads_reminder_tbl',$data);
	}
	
	function trash_lead_reminds_data($paras0,$paras1){
		if($paras0 >0 && $paras1 >0){
			$this->db->where('assigned_id',$paras0);
			$this->db->where('lead_id',$paras1); 
			$this->db->delete('leads_reminder_tbl');
		} 
		return true;
	}
	/* leads functions ends */   
 	   

	 
	
}  ?>