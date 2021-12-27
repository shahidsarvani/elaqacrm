<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	} 
  
 	/* Reports function starts */  
	function total_property_type_categories_report($assigned_to_id_val,$category_id_val,$property_type_val,$from_date_val,$to_date_val){ 
	 
		$wheres = $temp_agents_ids = '';
		$vs_user_type_id= $this->session->userdata('us_role_id');  
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
		
		if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id');
			$wheres = " AND p.assigned_to_id=$vs_id "; 
		}else if($vs_user_type_id==2){  
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres = " AND p.assigned_to_id='$assigned_to_id_val' ";
			}else if($temp_agents_ids!=''){
					$wheres = " AND p.assigned_to_id IN ($temp_agents_ids) ";
				}  
		}else if($vs_user_type_id==1){ 
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres = " AND p.assigned_to_id='$assigned_to_id_val' ";
			} 
		}  
			
		$wheres_2 =" group by p.category_id, p.property_type ";
		$wheres_1 ='';
		if(strlen($category_id_val)>0 && strlen($property_type_val)>0){
			$wheres_1 =" AND p.category_id=$category_id_val AND p.property_type=$property_type_val ";
		}else  
		if(strlen($category_id_val)>0){
			$wheres_1 =" AND p.category_id=$category_id_val ";
		}else  
		if(strlen($property_type_val)>0){
			$wheres_1 =" AND p.property_type=$property_type_val "; 
		}
		 
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){   
			$wheres_1 .=" AND ( DATE_FORMAT(p.created_on,'%Y-%m-%d')>='$from_date_val' AND DATE_FORMAT(p.created_on,'%Y-%m-%d')<='$to_date_val' ) ";
		}  
 
		$sql_1 = "select count(p.id) as CNT_NUMS from properties_tbl p, categories_tbl c where p.category_id=c.id AND p.is_archived='0' AND p.is_deleted='0' $wheres $wheres_1 $wheres_2";   
		 
		$query = $this->db->query($sql_1);
		return $query->row();  
	} 
	
	
	
	function property_type_categories_report($assigned_to_id_val,$category_id_val,$property_type_val,$from_date_val,$to_date_val){   
		$wheres = $temp_agents_ids = '';
		$vs_user_type_id= $this->session->userdata('us_role_id');  
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
		
		if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id');
			$wheres = " AND p.assigned_to_id=$vs_id "; 
		}else if($vs_user_type_id==2){  
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres = " AND p.assigned_to_id='$assigned_to_id_val' ";
			}else if($temp_agents_ids!=''){
					$wheres = " AND p.assigned_to_id IN ($temp_agents_ids) ";
				}  
		}else if($vs_user_type_id==1){ 
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres = " AND p.assigned_to_id='$assigned_to_id_val' ";
			} 
		}  
			
		$wheres_2 =" group by p.category_id, p.property_type ";
		$wheres_1 ='';
		if(strlen($category_id_val)>0 && strlen($property_type_val)>0){
			$wheres_1 =" AND p.category_id=$category_id_val AND p.property_type=$property_type_val ";
		}else  
		if(strlen($category_id_val)>0){
			$wheres_1 =" AND p.category_id=$category_id_val ";
		}else  
		if(strlen($property_type_val)>0){
			$wheres_1 =" AND p.property_type=$property_type_val "; 
		}
		
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){   
			$wheres_1 .=" AND ( DATE_FORMAT(p.created_on,'%Y-%m-%d')>='$from_date_val' AND DATE_FORMAT(p.created_on,'%Y-%m-%d')<='$to_date_val' ) ";
		} 
			 
		$sql_1 = "select count(p.id) as NUMS, p.category_id, c.name as cate_name, p.property_type from properties_tbl p, categories_tbl c where p.category_id=c.id AND p.is_archived='0' AND p.is_deleted='0' $wheres $wheres_1 $wheres_2 ";
		$query = $this->db->query($sql_1);
		return $query->result();
		//return $query->result_array();   
	} 
	
	
	
	function total_property_type_source_report($assigned_to_id_val,$source_of_listing_val,$property_type_val,$from_date_val,$to_date_val){ 
	 
		$wheres = $temp_agents_ids = '';
		$vs_user_type_id= $this->session->userdata('us_role_id');  
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
		
		if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id');
			$wheres = " AND p.assigned_to_id=$vs_id "; 
		}else if($vs_user_type_id==2){  
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres = " AND p.assigned_to_id='$assigned_to_id_val' ";
			}else if($temp_agents_ids!=''){
					$wheres = " AND p.assigned_to_id IN ($temp_agents_ids) ";
				}  
		}else if($vs_user_type_id==1){ 
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres = " AND p.assigned_to_id='$assigned_to_id_val' ";
			} 
		}  
			 
		$wheres_2 =" group by p.source_of_listing, p.property_type ";
		$wheres_1 ='';
		if(strlen($source_of_listing_val)>0 && strlen($property_type_val)>0){
			$wheres_1 =" AND p.source_of_listing=$source_of_listing_val AND p.property_type=$property_type_val ";
		}else  
		if(strlen($source_of_listing_val)>0){
			$wheres_1 =" AND p.source_of_listing=$source_of_listing_val ";
		}else  
		if(strlen($property_type_val)>0){
			$wheres_1 =" AND p.property_type=$property_type_val "; 
		} 
		 
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){   
			$wheres_1 .=" AND ( DATE_FORMAT(p.created_on,'%Y-%m-%d')>='$from_date_val' AND DATE_FORMAT(p.created_on,'%Y-%m-%d')<='$to_date_val' ) ";
		}  
 
		$sql_1 = "select count(p.id) as CNT_NUMS from properties_tbl p, source_of_listings_tbl s where p.source_of_listing=s.id AND p.is_archived='0' AND p.is_deleted='0' $wheres $wheres_1 ";   
		 
		$query = $this->db->query($sql_1);
		return $query->row();  
	}
	
	
	
	function property_type_source_report($assigned_to_id_val,$source_of_listing_val,$property_type_val,$from_date_val,$to_date_val){   
		$wheres = $temp_agents_ids = '';
		$vs_user_type_id= $this->session->userdata('us_role_id');  
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
		
		if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id');
			$wheres = " AND p.assigned_to_id=$vs_id "; 
		}else if($vs_user_type_id==2){  
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres = " AND p.assigned_to_id='$assigned_to_id_val' ";
			}else if($temp_agents_ids!=''){
					$wheres = " AND p.assigned_to_id IN ($temp_agents_ids) ";
				}  
		}else if($vs_user_type_id==1){ 
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres = " AND p.assigned_to_id='$assigned_to_id_val' ";
			} 
		}  
			
		$wheres_2 =" group by p.source_of_listing, p.property_type ";
		$wheres_1 ='';
		if(strlen($source_of_listing_val)>0 && strlen($property_type_val)>0){
			$wheres_1 =" AND p.source_of_listing=$source_of_listing_val AND p.property_type=$property_type_val ";
		}else  
		if(strlen($source_of_listing_val)>0){
			$wheres_1 =" AND p.source_of_listing=$source_of_listing_val ";
		}else  
		if(strlen($property_type_val)>0){
			$wheres_1 =" AND p.property_type=$property_type_val "; 
		}
		
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){   
			$wheres_1 .=" AND ( DATE_FORMAT(p.created_on,'%Y-%m-%d')>='$from_date_val' AND DATE_FORMAT(p.created_on,'%Y-%m-%d')<='$to_date_val' ) ";
		} 
			 
		$sql_1 = "select count(p.id) as NUMS, p.source_of_listing, s.title as s_title, p.property_type from properties_tbl p, source_of_listings_tbl s where p.source_of_listing=s.id AND p.is_archived='0' AND p.is_deleted='0'  $wheres $wheres_1 $wheres_2 ";   
		 
		$query = $this->db->query($sql_1);
		return $query->result(); 
	} 
	
	
	function get_total_custom_meetings_nums($assigned_to_id_val,$from_date_val,$to_date_val){   
		
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
		 
		$this->db->select_sum('nos_of_meetings');
		$this->db->from('meetings_views_tbl');
		
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){
			$this->db->where("dated>='$from_date_val'");  
			$this->db->where("dated<='$to_date_val'"); 
		}
		  
		$vs_id = $this->session->userdata('us_id');	
		if($vs_user_type_id==3){ 
			$this->db->where("user_id=$vs_id"); 
		}else if($vs_user_type_id==2){  
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){ 
				$this->db->where("user_id='$assigned_to_id_val' "); 
			}else{ 	 
				if($temp_agents_ids!=''){ 
					$this->db->where(" ( user_id='$vs_id' OR user_id IN ($temp_agents_ids) ) "); 
				}else{  
					$this->db->where(" user_id='$vs_id' ");
				} 
			} 
		}else if($vs_user_type_id==1){ 
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){ 
				$this->db->where("user_id='$assigned_to_id_val' "); 
			} 
		}	 
		$query = $this->db->get();
		return $query->row()->nos_of_meetings;
	}
	
	
	function get_total_custom_views_nums($assigned_to_id_val,$from_date_val,$to_date_val){   
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
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
		
		$this->db->select_sum('nos_of_views');
		$this->db->from('meetings_views_tbl');
		
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){
			$this->db->where("dated>='$from_date_val'");  
			$this->db->where("dated<='$to_date_val'"); 
		} 
		 
		/*if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id');
			$this->db->where("user_id=$vs_id"); 
		}else if($vs_user_type_id==2){  
				if($temp_agents_ids!=''){
					$this->db->where("user_id IN ($temp_agents_ids) ");
				} 
			} */
		$vs_id = $this->session->userdata('us_id');
		if($vs_user_type_id==3){ 
			$this->db->where("user_id=$vs_id"); 
		}else if($vs_user_type_id==2){  
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){ 
				$this->db->where("user_id='$assigned_to_id_val' "); 
			}else{
				if($temp_agents_ids!=''){ 
					$this->db->where(" ( user_id='$vs_id' OR user_id IN ($temp_agents_ids) ) "); 
				}else{ 
					$this->db->where(" user_id='$vs_id' ");
				}
			}
		}else if($vs_user_type_id==1){ 
		 	if(isset($assigned_to_id_val) && $assigned_to_id_val >0){ 
				$this->db->where("user_id='$assigned_to_id_val' "); 
			} 
		}	
			
		$query = $this->db->get();
		return $query->row()->nos_of_views;
	}
	
	function get_all_manager_agents_list($mngrs_ids){ 
	   $query = $this->db->get_where('users_tbl',array('parent_id'=> $mngrs_ids));
	   return $query->result();
	} 
	
	function get_all_total_property_deals_report($assigned_to_id_val,$types_val,$status_val,$from_date_val,$to_date_val){  
	
		$wheres_1 = $temp_agents_ids = '';
		$vs_user_type_id= $this->session->userdata('us_role_id');  
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
		
		if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id');
			$wheres_1 = " AND agent2_id=$vs_id "; 
		}else if($vs_user_type_id==2){  
			if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres_1 = " AND agent2_id='$assigned_to_id_val' ";
			}else if($temp_agents_ids!=''){
					$wheres_1 = " AND agent2_id IN ($temp_agents_ids) ";
				}  
		}else if($vs_user_type_id==1){ 
			if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres_1 = " AND agent2_id='$assigned_to_id_val' ";
			} 
		}  
		
		 
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){   
			$wheres_1 .=" AND ( act_deal_date>='$from_date_val' AND act_deal_date<='$to_date_val' ) ";
		} 
		
		if(strlen($types_val)>0 && strlen($types_val)>0){
			$wheres_1 .=" AND types='$types_val' ";
		} 
		 
		if(strlen($status_val)>0){
			$wheres_1 .=" AND status='$status_val' "; 
		}
		
		$sql_1 = "select count(id) as NUMS, SUM(deal_price) AS deal_price_vals from properties_deals_tbl WHERE id >'0' $wheres_1 ";   
		$query = $this->db->query($sql_1);
		return $query->row(); 
	}  
	
	function get_cstm_property_deals_report_list($assigned_to_id_val,$types_val,$status_val,$from_date_val,$to_date_val){   
		$wheres = $wheres_1 = $temp_agents_ids = ''; 
		$vs_user_type_id= $this->session->userdata('us_role_id');  
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
		
		if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id');
			$wheres_1 = " AND agent2_id=$vs_id "; 
		}else if($vs_user_type_id==2){  
			if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres_1 = " AND agent2_id='$assigned_to_id_val' ";
			}else if($temp_agents_ids!=''){
					$wheres_1 = " AND agent2_id IN ($temp_agents_ids) ";
				}  
		}else if($vs_user_type_id==1){ 
			if(isset($assigned_to_id_val) && $assigned_to_id_val >0){
				$wheres_1 = " AND agent2_id='$assigned_to_id_val' ";
			} 
		}
		
		 
			
		$wheres_2 = " group by types, status "; 
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){   
			$wheres_1 .=" AND ( act_deal_date>='$from_date_val' AND act_deal_date<='$to_date_val' ) ";
		} 
		
		if(strlen($types_val)>0 && strlen($types_val)>0){
			$wheres_1 .=" AND types='$types_val' ";
		} 
		 
		if(strlen($status_val)>0){
			$wheres_1 .=" AND status='$status_val' "; 
		}	
 
		$sql_1 = "select count(id) as NUMS, types, status, SUM(deal_price) AS deal_price_vals from properties_deals_tbl where id >'0' $wheres_1 $wheres_2 ";   
		 
		$query = $this->db->query($sql_1);
		return $query->result();  
	} 
	
	
	function get_all_total_property_leads_report($assigned_to_id_val,$types_val,$from_date_val,$to_date_val){  
		$vs_id = $this->session->userdata('us_id'); 
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
		$temp_agents_ids = '';
		if($vs_user_type_id==2){
			$agnt_arrs = $this->get_all_manager_agents_list($vs_id); 
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		}
		 
		$wheres_1 = '';
		if($vs_user_type_id==3){ 
			$wheres_1 .=" AND agent_id=$vs_id ";
		}else if($vs_user_type_id==2){  
		
			if(strlen($assigned_to_id_val)>0){   
				$wheres_1 .=" AND agent_id IN ($assigned_to_id_val) "; 
			}else{  
				if($temp_agents_ids!=''){ 
					$wheres_1 .=" AND ( agent_id='$vs_id' OR agent_id IN ($temp_agents_ids) ) "; 
				}else{ 
					$wheres_1 .=" AND agent_id='$vs_id'  ";
				}	 
			}
		}else if(strlen($assigned_to_id_val)>0){ 
				$wheres_1 .=" AND agent_id IN ($assigned_to_id_val) ";
			}   
	 
		
		if(strlen($types_val)>0){
			$wheres_1 .=" AND lead_type='$types_val' ";
		} 
		
		
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){  
			$wheres_1 .=" AND ( enquiry_date>='$from_date_val' AND enquiry_date<='$to_date_val' ) ";
		}
		
		$sql_1 = " select count(id) as NUMS from leads_tbl where id>'0' $wheres_1 ";   
		$query = $this->db->query($sql_1);
		return $query->row(); 
	}
	
	
	function get_cstm_property_leads_report_list($assigned_to_id_val,$types_val,$from_date_val,$to_date_val){   
		
		$temp_agents_ids = '';
		$vs_id = $this->session->userdata('us_id');
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
		$temp_agents_ids = '';
		if($vs_user_type_id==2){   
			$agnt_arrs = $this->get_all_manager_agents_list($vs_id); 
			
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		}
		
		$wheres = $wheres_1 = ''; 
		 
		if($vs_user_type_id==3){ 
			$wheres_1 .=" AND agent_id=$vs_id ";
		}else if($vs_user_type_id==2){  
		
			if(strlen($assigned_to_id_val)>0){   
				$wheres_1 .=" AND agent_id IN ($assigned_to_id_val) "; 
			}else{  
				if($temp_agents_ids!=''){ 
					$wheres_1 .=" AND ( agent_id='$vs_id' OR agent_id IN ($temp_agents_ids) ) "; 
				}else{ 
					$wheres_1 .=" AND agent_id='$vs_id'  ";
				}	 
			}
		}else if(strlen($assigned_to_id_val)>0){ 
				$wheres_1 .=" AND agent_id IN ($assigned_to_id_val) ";
			} 
		
		
		
		$wheres_2 = " group by lead_type ";
		  
		if(strlen($types_val)>0){
			$wheres_1 .=" AND lead_type='$types_val' ";
		} 
		
		if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){  
			$wheres_1 .=" AND ( enquiry_date>='$from_date_val' AND enquiry_date<='$to_date_val' ) ";
		}  	
 
		$sql_1 = "select count(id) as NUMS, lead_type from leads_tbl where id >'0' $wheres_1 $wheres_2 "; 
		$query = $this->db->query($sql_1);
		return $query->result(); 
	} 
	
	
	
	function get_all_total_agent_property_leads_source_report($assigned_to_id_val){  
		$wheres_1 = $temp_agents_ids = ''; 
		$vs_id = $this->session->userdata('us_id');
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
		
		if($vs_user_type_id==3){ 
			$wheres_1 .= " AND user_id=$vs_id ";
		}else if($vs_user_type_id==2){  
		
			if(strlen($assigned_to_id_val)>0){   
				$wheres_1 .= " AND user_id IN ($assigned_to_id_val) "; 
			}else{  
				if($temp_agents_ids!=''){ 
					$wheres_1 .= " AND ( user_id='$vs_id' OR user_id IN ($temp_agents_ids) ) "; 
				}else{ 
					$wheres_1 .= " AND user_id='$vs_id'  ";
				}	 
			}
		}else if(strlen($assigned_to_id_val)>0){ 
				$wheres_1 .= " AND user_id IN ($assigned_to_id_val) ";
			}
			
		$sql_1 = "select SUM(nos_of_views) as sum_nos_of_views from meetings_views_tbl where id>'0' $wheres_1 ";   
		$query = $this->db->query($sql_1);
		return $query->row(); 
	}
	
	
	function get_all_total_property_leads_source_report($assigned_to_id_val,$source_of_listing_val,$from_date2_val,$to_date2_val){  
		$vs_id = $this->session->userdata('us_id');	 
		$vs_user_type_id= $this->session->userdata('us_ole_id'); 
		$temp_agents_ids = '';
		if($vs_user_type_id==2){   
			$agnt_arrs = $this->get_all_manager_agents_list($vs_id); 
			
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		}
		 
		$wheres_1 = '';   
		if($vs_user_type_id==3){ 
			$wheres_1 .=" AND agent_id=$vs_id ";
		}else if($vs_user_type_id==2){  
		
			if(strlen($assigned_to_id_val)>0){   
				$wheres_1 .=" AND agent_id IN ($assigned_to_id_val) "; 
			}else{  
				if($temp_agents_ids!=''){ 
					$wheres_1 .=" AND ( agent_id='$vs_id' OR agent_id IN ($temp_agents_ids) ) "; 
				}else{ 
					$wheres_1 .=" AND agent_id='$vs_id'  ";
				}	 
			}
		}else if(strlen($assigned_to_id_val)>0){ 
				$wheres_1 .=" AND agent_id IN ($assigned_to_id_val) ";
			}   
	 
		
		if(strlen($source_of_listing_val)>0){
			$wheres_1 .=" AND source_of_listing='$source_of_listing_val' ";
		} 
		 
		if((isset($from_date2_val) && strlen($from_date2_val)>0) && (isset($to_date2_val) && strlen($to_date2_val)>0)){  
			$wheres_1 .=" AND ( enquiry_date>='$from_date2_val' AND enquiry_date<='$to_date2_val' ) ";
		}
		
		$sql_1 = " select count(id) as NUMS from leads_tbl where id>'0' $wheres_1 ";   
		$query = $this->db->query($sql_1);
		return $query->row(); 
	}
	
	
	function get_cstm_property_leads_report_source_list($assigned_to_id_val,$source_of_listing_val,$from_date2_val,$to_date2_val){   
		
		$temp_agents_ids = '';
		$vs_id = $this->session->userdata('us_id');
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
		$temp_agents_ids = '';
		if($vs_user_type_id==2){   
			$agnt_arrs = $this->get_all_manager_agents_list($vs_id); 
			
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		}
		
		$wheres = $wheres_1 = ''; 
		if($vs_user_type_id==3){ 
			$wheres_1 .=" AND agent_id=$vs_id ";
		}else if($vs_user_type_id==2){  
		
			if(strlen($assigned_to_id_val)>0){   
				$wheres_1 .=" AND agent_id IN ($assigned_to_id_val) "; 
			}else{  
				if($temp_agents_ids!=''){ 
					$wheres_1 .=" AND ( agent_id='$vs_id' OR agent_id IN ($temp_agents_ids) ) "; 
				}else{ 
					$wheres_1 .=" AND agent_id='$vs_id'  ";
				}	 
			}
		}else if(strlen($assigned_to_id_val)>0){ 
				$wheres_1 .=" AND agent_id IN ($assigned_to_id_val) ";
			} 
		
		
		
		$wheres_2 = " group by source_of_listing ";
		  
		if(strlen($source_of_listing_val)>0){
			$wheres_1 .=" AND source_of_listing='$source_of_listing_val' ";
		} 
		 
		if((isset($from_date2_val) && strlen($from_date2_val)>0) && (isset($to_date2_val) && strlen($to_date2_val)>0)){  
			$wheres_1 .=" AND ( enquiry_date>='$from_date2_val' AND enquiry_date<='$to_date2_val' ) ";
		} 	
 
		$sql_1 = "select count(id) as NUMS, source_of_listing from leads_tbl where id >'0' $wheres_1 $wheres_2 "; 
		$query = $this->db->query($sql_1);
		return $query->result();
		//return $query->result_array();   
	}	 
	 
	/* Reports function ends */
	
}  ?>