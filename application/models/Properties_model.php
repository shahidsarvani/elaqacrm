<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}  

	 /* properties photos starts  */ 
	 
	 
	function get_all_cstm_quick_properties($params = array()){ 
		
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
		 
		$whrs ='';
		$vs_id = $this->session->userdata('us_id'); 
		
		if($vs_user_type_id==3){ 
			$whrs .=" AND p.assigned_to_id=$vs_id ";
		}else if($vs_user_type_id==2){  
		
			if(array_key_exists("assigned_to_id_val",$params)){
				$assigned_to_id_val =   $params['assigned_to_id_val'];  
				if(strlen($assigned_to_id_val)>0){ 
					$whrs .=" AND p.assigned_to_id IN ($assigned_to_id_val) ";
				} 
			}else{  
				if($temp_agents_ids!=''){
					//$whrs .=" AND p.assigned_to_id IN ($temp_agents_ids) ";
					$whrs .=" AND ( p.assigned_to_id='$vs_id' OR p.assigned_to_id IN ($temp_agents_ids) ) "; 
				}else{ 
					$whrs .=" AND p.assigned_to_id='$vs_id'  ";
				}	 
			}
		}else if(array_key_exists("assigned_to_id_val",$params)){
				$assigned_to_id_val = $params['assigned_to_id_val']; 
				if(strlen($assigned_to_id_val)>0){ 
					$whrs .=" AND p.assigned_to_id IN ($assigned_to_id_val) ";
				}  
			}  
			
		/*$whrs .= " AND ( p.title LIKE '%$s_val%' OR p.description LIKE '%$s_val%' OR p.ref_no LIKE '%$s_val%' OR p.unit_no LIKE '%$s_val%' OR p.property_address LIKE '%$s_val%' ) ";*/
		if(array_key_exists("refer_no_val",$params)){
			$refer_no_val = $params['refer_no_val'];
			if(strlen($refer_no_val)>0){
				$whrs .= " AND p.ref_no LIKE '%$refer_no_val%' ";
			}
		}
		
		/*if(array_key_exists("unit_no_val",$params)){
			$unit_no_val = $params['unit_no_val'];  
			if(strlen($unit_no_val)>0){
				$whrs .= " AND p.unit_no LIKE '%$unit_no_val%' ";  
			}
		} */ 
		
		if(array_key_exists("price_val",$params) && array_key_exists("to_price_val",$params)){ 
			$str_price_val = $params['price_val'];
			$to_price_val = $params['to_price_val']; 
			
			if(strlen($str_price_val)>0 && strlen($to_price_val)>0){
				$whrs .=" AND ( p.price >='$str_price_val' AND p.price <='$to_price_val' ) ";
			}  
        } 
		
		if(array_key_exists("emirate_location_id_val",$params)){
			$emirate_location_id_val = $params['emirate_location_id_val'];  
			if(strlen($emirate_location_id_val)>0){ 
				$whrs .=" AND p.sub_location_id IN ($emirate_location_id_val) ";
			}
		}   
		
		if(array_key_exists("no_of_beds_id_val",$params)){
			$no_of_beds_id_val = $params['no_of_beds_id_val'];  
			if(strlen($no_of_beds_id_val)>0){ 
				$whrs .=" AND p.no_of_beds_id IN ($no_of_beds_id_val) ";
			}
		}  
		
		if(array_key_exists("owner_id_val",$params)){
			$owner_id_val = $params['owner_id_val']; 
			if(strlen($owner_id_val)>0){
			 
				$whrs .=" AND p.owner_id IN ($owner_id_val) ";
			}
		}
		
	$whrs1 = '';
	if(array_key_exists("portal_id_val",$params)){
		$portal_id_val = $params['portal_id_val']; 
		if(strlen($portal_id_val)>0){
			$tmp_portal_id_val_arrs = explode(',',$portal_id_val);
			if(isset($tmp_portal_id_val_arrs)){
				foreach($tmp_portal_id_val_arrs as $tmp_portal_id_val_arr){
					
					$whrs1 .= " FIND_IN_SET('$tmp_portal_id_val_arr', p.show_on_portal_ids) OR "; 	
				} 
				
				$whrs1 = substr("$whrs1",0,-3);
				
				$whrs .= " AND ( $whrs1 )";
			}  
		}
	}  
		
		/*if(array_key_exists("published_val",$params)){
			$sel_published_val = $params['published_val']; 
			if(strlen($sel_published_val)>0){
				$whrs .=" AND p.is_published=$sel_published_val";
			}
		} */
		
		if(array_key_exists("property_status_val",$params)){
			$property_status_val = $params['property_status_val']; 
			if($property_status_val>0){
				$whrs .= " AND p.property_status=$property_status_val";
			}
		}  
		
		if(array_key_exists("is_property_type",$params)){
			$is_property_type = $params['is_property_type']; 
			if($is_property_type>0){
				$whrs .= " AND p.property_type=$is_property_type";
			}
		} 
		
		
		if(array_key_exists("is_archived",$params)){
			$is_archived = $params['is_archived']; 
			if(strlen($is_archived)>0){
				$whrs .= " AND p.is_archived=$is_archived";
			}
		}else{
			$whrs .= " AND p.is_archived='0' ";
		}
		
		if(array_key_exists("is_deleted",$params)){
			$is_deleted = $params['is_deleted']; 
			if(strlen($is_deleted)>0){
				$whrs .= " AND p.is_deleted=$is_deleted";
			}
		}else{
			$whrs .= " AND p.is_deleted='0' ";
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
		  
		/*$query = $this->db->query("SELECT p.id, p.ref_no, p.unit_no, p.price, p.property_status, p.is_published, p.assigned_to_id, p.is_new, u.name AS crt_usr_name, sl.name AS sub_loc_name, bd.title AS bed_title, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no FROM properties_tbl p LEFT JOIN users_tbl u ON p.created_by=u.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id LEFT JOIN no_of_bedrooms_tbl bd ON p.no_of_beds_id=bd.id LEFT JOIN owners_tbl ow ON p.owner_id=ow.id WHERE p.is_deleted='0' AND p.is_archived='0' AND p.is_dealt='0' AND property_status NOT IN (1,2) AND p.is_lead='0' $whrs ORDER BY p.id DESC $limits "); */
		
		
		if(array_key_exists("pics_nos_val",$params)){
			$pics_nos_val = $params['pics_nos_val'];  
			if($pics_nos_val> -1){ 
				$query = $this->db->query("SELECT p.id, p.ref_no, p.price, p.property_status, p.assigned_to_id, p.is_new, p.show_on_portal_ids AS show_on_portal_ids, u.name AS crt_usr_name, sl.name AS sub_loc_name, bd.title AS bed_title, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no, COUNT(o.id) AS pics_nos FROM properties_tbl p LEFT JOIN users_tbl u ON p.created_by=u.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id LEFT JOIN no_of_bedrooms_tbl bd ON p.no_of_beds_id=bd.id LEFT JOIN owners_tbl ow ON p.owner_id=ow.id LEFT JOIN property_images_tbl o ON p.id=o.property_id WHERE p.id>0 AND property_status NOT IN (1,2) $whrs GROUP BY p.id HAVING COUNT(o.id)='$pics_nos_val' ORDER BY p.id DESC $limits ");
				
				 
			}else{
				$query = $this->db->query("SELECT p.id, p.ref_no, p.price, p.property_status, p.assigned_to_id, p.is_new, p.show_on_portal_ids AS show_on_portal_ids, u.name AS crt_usr_name, sl.name AS sub_loc_name, bd.title AS bed_title, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no FROM properties_tbl p LEFT JOIN users_tbl u ON p.created_by=u.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id LEFT JOIN no_of_bedrooms_tbl bd ON p.no_of_beds_id=bd.id LEFT JOIN owners_tbl ow ON p.owner_id=ow.id WHERE p.id>0 AND property_status NOT IN (1,2) $whrs ORDER BY p.id DESC $limits ");
			}
		}else{
		
			$query = $this->db->query("SELECT p.id, p.ref_no, p.price, p.property_status, p.assigned_to_id, p.is_new, p.show_on_portal_ids AS show_on_portal_ids, u.name AS crt_usr_name, sl.name AS sub_loc_name, bd.title AS bed_title, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no FROM properties_tbl p LEFT JOIN users_tbl u ON p.created_by=u.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id LEFT JOIN no_of_bedrooms_tbl bd ON p.no_of_beds_id=bd.id LEFT JOIN owners_tbl ow ON p.owner_id=ow.id WHERE p.id>0 AND property_status NOT IN (1,2) $whrs ORDER BY p.id DESC $limits "); 
		}   /*  p.is_deleted='0' AND p.is_archived='0' */
		return $query->result(); /* p.created_on DESC */
	}
	
	
	
	
	function get_all_cstm_popup_properties($params = array()){  
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
		 
		$whrs ='';
		$vs_id = $this->session->userdata('us_id');  
		if($vs_user_type_id==3){ 
			$whrs .=" AND p.assigned_to_id=$vs_id ";
		}else if($vs_user_type_id==2){
		
			if($temp_agents_ids!=''){ 
				$whrs .=" AND ( p.assigned_to_id='$vs_id' OR p.assigned_to_id IN ($temp_agents_ids) ) "; 
			}else{ 
				$whrs .=" AND p.assigned_to_id='$vs_id'  ";
			} 
		}  
			
		 
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val'];
			if(strlen($q_val)>0){
				$whrs .= " AND ( p.title LIKE '%$q_val%' OR p.description LIKE '%$q_val%' OR p.ref_no LIKE '%$q_val%' OR price LIKE '%$q_val%' )";
			}
		}
		
		
 	 
	
	
	/* property_type
	 
	category_id	no_of_beds_id	no_of_baths	emirate_id	location_id	sub_location_id	sub_location_area_id	property_address	youtube_video_link	property_ms_unit	plot_area	is_furnished	price	show_on_portal_ids	private_amenities_data	commercial_amenities_data	owner_id	property_status	source_of_listing	is_featured	next_available_date	feature_ids	no_of_views	location_latitude	location_longitude	created_on	is_new	is_deleted	is_archived	property_type	updated_on	ip_address	created_by */
		 
		
		 		 
		$limits ='';
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
			$tot_limit =   $params['limit'];
			$str_limit =   $params['start']; 			 
			$limits = " LIMIT $str_limit, $tot_limit ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
             $tot_limit =   $params['limit'];
			$limits = " LIMIT $tot_limit ";
		}   
		
		$query = $this->db->query("SELECT p.id, p.title as p_title, p.description as p_description, p.property_address, p.ref_no, p.price, p.property_status, p.assigned_to_id, p.is_new, p.show_on_portal_ids AS show_on_portal_ids, p.updated_on as updated_on, u.name AS crt_usr_name, sl.name AS sub_loc_name, bd.title AS bed_title, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no FROM properties_tbl p LEFT JOIN users_tbl u ON p.created_by=u.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id LEFT JOIN no_of_bedrooms_tbl bd ON p.no_of_beds_id=bd.id LEFT JOIN owners_tbl ow ON p.owner_id=ow.id WHERE p.is_archived='0' AND property_status NOT IN (1,2) $whrs ORDER BY p.id DESC $limits "); 
		    /*  p.is_deleted='0' AND p.is_archived='0' */
		return $query->result(); /* p.created_on DESC */
	}

		
		
		
    function get_tmp_max_property_photos_sort_val($tmp_proprtyid,$tmp_ips){
        if($tmp_proprtyid== -1 && strlen($tmp_ips)>0){
            $this->db->select_max("sort_order");
            $this->db->where('property_id',$tmp_proprtyid);
            $this->db->where('ip_address',$tmp_ips); 
            $rets = $this->db->get('property_images_tbl')->row();  
            return $rets->sort_order;
        } 
    } 
	
    
    function get_max_property_photos_sort_val($tmp_proprtyid){
        if($tmp_proprtyid >0){
            $this->db->select_max("sort_order");
            $this->db->where('property_id',$tmp_proprtyid); 
            $rets = $this->db->get('property_images_tbl')->row();  
            return $rets->sort_order;
        } 
    } 
	
	
	function get_property_dropzone_photos_by_id($args1){ 
		if($args1>0){
			$this->db->order_by("sort_order", "asc");
			$query = $this->db->get_where('property_images_tbl',array('property_id'=> $args1));
			return $query->result();
		}
	}
    
    
    function insert_property_photo_data($data){ 
        return $this->db->insert('property_images_tbl', $data);
    } 
	
	
	function delete_property_dropzone_photos($tmp_imgs,$tmp_proprtyid){
		$this->db->where('image',$tmp_imgs);
		$this->db->where('property_id',$tmp_proprtyid);  
		$this->db->delete('property_images_tbl'); 
		return true;
	} 
   
	
	function count_property_dropzone_photos_by_id($parass1){ 
	 	$num_rows =0;
		if($parass1>0){  
			$this->db->where(" property_id='$parass1' "); 
			$num_rows = $this->db->count_all_results('property_images_tbl'); 
		}
		return $num_rows;
	}   
	
    function get_temp_post_property_dropzone_photos(){ 
        $property_id1 = -1; 	
        $ip_address1 = $_SERVER['REMOTE_ADDR']; 
        $datatimes1 = date('Y-m-d');
        
        if(isset($_SESSION['Temp_IP_Address']) && isset($_SESSION['Temp_DATE_Times'])){
            $ip_address1 = $_SESSION['Temp_IP_Address'];
            $datatimes1 = $_SESSION['Temp_DATE_Times']; 
        }  
        $this->db->order_by("sort_order", "asc");
        $query = $this->db->get_where('property_images_tbl',array('property_id'=> $property_id1,'ip_address'=> $ip_address1,'datatimes'=> $datatimes1));
        return $query->result();
    }
    
    
    function delete_temp_property_dropzone_photos($tmp_imgs,$tmp_proprtyid,$tmp_ips,$tmp_dts){
        /*$this->db->where(" image='$tmp_imgs' AND ip_address='$tmp_ips' AND datatimes='$tmp_dts' AND property_id='$tmp_proprtyid' "); */
        if(strlen($tmp_imgs)>0){
            $this->db->where('image',$tmp_imgs);
        }
        $this->db->where('property_id',$tmp_proprtyid);
        $this->db->where('ip_address',$tmp_ips); 
        $this->db->where('datatimes',$tmp_dts);   
        $this->db->delete('property_images_tbl'); 
        return true;
    } 
	
	
	function set_property_tmp_photos_order_by_propertyid_name($tmp_proprtyid,$tmp_img_name,$tmp_ips,$tmp_dts,$data){
		
		if($tmp_proprtyid== -1 && strlen($tmp_ips)>0 && strlen($tmp_dts)>0 && strlen($tmp_img_name)>0){
			$this->db->where('property_id',$tmp_proprtyid);
			$this->db->where('ip_address',$tmp_ips);
			$this->db->where('datatimes',$tmp_dts);
			$this->db->where('image',$tmp_img_name);
			return $this->db->update('property_images_tbl', $data);
		} 
	}
	
	
	function set_property_photos_order_by_propertyid_name($tmp_proprtyid,$tmp_img_name,$data){
		if($tmp_proprtyid >0 && strlen($tmp_img_name)>0 ){
			$this->db->where('property_id',$tmp_proprtyid);
			$this->db->where('image',$tmp_img_name);
			return $this->db->update('property_images_tbl', $data);
		} 
	} 
	
	function update_temp_property_dropzone_photos($tmp_proprtyid,$tmp_ips,$tmp_dts,$data){
		if($tmp_proprtyid== -1 && strlen($tmp_ips)>0 && strlen($tmp_dts)>0){
			$this->db->where('property_id',$tmp_proprtyid);
			$this->db->where('ip_address',$tmp_ips);
			$this->db->where('datatimes',$tmp_dts);
			return $this->db->update('property_images_tbl', $data);
		} 
	}
	
	
     /* properties photos ends  */ 
	 
	 
    /* properties documents starts  */ 
	
	function insert_property_documents_data($data){ 
		return $this->db->insert('property_documents_tbl', $data);
	} 
    
    function get_temp_post_property_dropzone_documents(){ 
			$property_id4 = -1; 	
			$ip_address4 = $_SERVER['REMOTE_ADDR']; 
			$datatimes4 = date('Y-m-d');
				 
			if(isset($_SESSION['Temp_Documents_IP_Address']) && isset($_SESSION['Temp_Documents_DATE_Times'])){
				$ip_address4 = $_SESSION['Temp_Documents_IP_Address'];
				$datatimes4 = $_SESSION['Temp_Documents_DATE_Times'];
			} 
				
		$query = $this->db->get_where('property_documents_tbl',array('property_id'=> $property_id4,'ip_address'=> $ip_address4,'datatimes'=> $datatimes4));
		return $query->result();
	}   
    
	function delete_temp_property_dropzone_documents($tmp_imgs,$tmp_proprtyid,$tmp_ips,$tmp_dts){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('property_id',$tmp_proprtyid);
		$this->db->where('ip_address',$tmp_ips); 
		$this->db->where('datatimes',$tmp_dts);   
		$this->db->delete('property_documents_tbl'); 
		return true;
	} 
    
	function get_property_dropzone_documents_by_id($args1){
		$query= $this->db->get_where('property_documents_tbl',array('property_id'=> $args1));
		return $query->result();
	}
	
	function delete_property_dropzone_documents($tmp_imgs,$tmp_proprtyid){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('property_id',$tmp_proprtyid);  
		$this->db->delete('property_documents_tbl'); 
		return true;
	}  
	
	function count_property_dropzone_documents_by_id($parass1){ 
	 	$num_rows =0;
		if($parass1>0){  
			$this->db->where(" property_id='$parass1' "); 
			$num_rows = $this->db->count_all_results('property_documents_tbl'); 
		}
		return $num_rows;
	}
	
	function update_temp_property_dropzone_documents($tmp_proprtyid,$tmp_ips,$tmp_dts,$data){
		if($tmp_proprtyid== -1 && strlen($tmp_ips)>0 && strlen($tmp_dts)>0){
			$this->db->where('property_id',$tmp_proprtyid);
			$this->db->where('ip_address',$tmp_ips);
			$this->db->where('datatimes',$tmp_dts);
			return $this->db->update('property_documents_tbl', $data);
		} 
	}
	 
     /* properties documents ends  */ 
	
	function get_all_properties_list(){
		$query = $this->db->query("SELECT * FROM properties_tbl ORDER BY id DESC "); 
		return $query->result();
	} 
		
	function get_property_by_id($args1){ 
		$query = $this->db->get_where('properties_tbl',array('id'=> $args1));
		return $query->row();
	}
	
   	function insert_property_data($data){ 
		return $this->db->insert('properties_tbl', $data);
	}
	 
    function update_property_data($args1,$data){ 
		if($args1>0){
			$this->db->where('id',$args1);
			return $this->db->update('properties_tbl', $data);
		}
	}	 
	
	function fetch_emirate_locations($args3){ 
		if(strlen($args3)>0){
			$this->db->order_by("name", "asc");
			$query = $this->db->get_where('emirate_locations_tbl',array('emirate_id'=> $args3));
			return $query->result();
		}else{
			return '';
		}
	}  
	
	function fetch_emirate_sub_locations($args3){ 
		if(strlen($args3)>0){
			$this->db->order_by("name", "asc");
			$query = $this->db->get_where('emirate_sub_locations_tbl',array('emirate_location_id'=> $args3));
			return $query->result();
		}else{
			return '';
		}
	} 	
	
	
	function fetch_property_list_emirate_locations($args3){ 
		if(strlen($args3)>0){  
			$args3 = str_replace('_',',',$args3);
			$whrs = " AND emirate_id IN ( $args3 ) "; 
		
			$query = $this->db->query("SELECT * FROM emirate_locations_tbl WHERE id >'0' $whrs ORDER BY name ASC "); 
			return $query->result(); 
		}else{
			return '';
		}
	}  
	         
	function fetch_property_list_emirate_sub_locations($args3){ 
		if(strlen($args3)>0){
			$args3 = str_replace('_',',',$args3);
			$whrs = " AND emirate_location_id IN ( $args3 ) "; 
			$query = $this->db->query("SELECT * FROM emirate_sub_locations_tbl WHERE id >'0' $whrs ORDER BY name ASC "); 
			return $query->result();
			 
			/*$this->db->order_by("name", "asc");
			$query = $this->db->get_where('emirate_sub_locations_tbl',array('emirate_location_id'=> $args3));
			return $query->result();*/
		}else{
			return '';
		}
	}
	
	
	function insert_temp_property_notes($data){ 
		return $this->db->insert('property_notes_tbl', $data);
	}
			 
	
	function get_temp_property_notes(){ 
        $property_id1 = -1; 	
        $ip_address1 = $_SERVER['REMOTE_ADDR']; 
        $datatimes1 = date('Y-m-d H:i:s');
        
        if(isset($_SESSION['Temp_NT_IP_Address']) && isset($_SESSION['Temp_NT_DATE_Times'])){
            $ip_address1 = $_SESSION['Temp_NT_IP_Address'];
            $datatimes1 = $_SESSION['Temp_NT_DATE_Times']; 
        }  
        $this->db->order_by("datatimes", "desc");
        $query = $this->db->get_where('property_notes_tbl',array('property_id'=> $property_id1,'ip_address'=> $ip_address1)); /* ,'datatimes'=> $datatimes1 */
        return $query->result();
    }  
	
	function get_property_notes($property_id1){  
        
        if(isset($property_id1) && $property_id1>0){ 
         
			$this->db->order_by("datatimes", "desc");
			$query = $this->db->get_where('property_notes_tbl',array('property_id'=> $property_id1));
			return $query->result();
		}
    } 
	
	function update_temp_property_notes($tmp_proprtyid,$tmp_ips,$tmp_dts,$data){
		if($tmp_proprtyid== -1 && strlen($tmp_ips)>0){ /* && strlen($tmp_dts)>0 */
			$this->db->where('property_id',$tmp_proprtyid);
			$this->db->where('ip_address',$tmp_ips);
			//$this->db->where('datatimes',$tmp_dts);
			return $this->db->update('property_notes_tbl', $data);
		} 
	}
	
	
	function delete_temp_property_notes($tmp_proprtyid,$tmp_ips,$tmp_dts){ 
		$this->db->where('property_id',$tmp_proprtyid);
		$this->db->where('ip_address',$tmp_ips); 
		//$this->db->where('datatimes',$tmp_dts);   
		$this->db->delete('property_notes_tbl'); 
		return true;
	} 
	
	function get_all_manager_agents_list($mngrs_ids){ 
	   $query = $this->db->get_where('users_tbl',array('parent_id'=> $mngrs_ids));
	   return $query->result();
	} 
			
	function get_all_cstm_properties($params = array()){ 
	 
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
		 
		$whrs ='';
		$vs_id = $this->session->userdata('us_id'); 
		if($vs_user_type_id==3){ 
			$whrs .=" AND p.assigned_to_id=$vs_id ";
		}else if($vs_user_type_id==2){  
		
			if(array_key_exists("assigned_to_id_vals",$params)){
				$assigned_to_id_vals =   $params['assigned_to_id_vals']; 
				if(strlen($assigned_to_id_vals)>0){
					$whrs .=" AND p.assigned_to_id IN ($assigned_to_id_vals) ";
				}  
			}else{  
				if($temp_agents_ids!=''){ 
				 	$whrs .=" AND ( p.assigned_to_id='$vs_id' OR p.assigned_to_id IN ($temp_agents_ids) ) "; 
				}else{ 
					$whrs .=" AND p.assigned_to_id='$vs_id'  ";
				}  
			}
		}else if(array_key_exists("assigned_to_id_vals",$params)){
				$assigned_to_id_vals = $params['assigned_to_id_vals']; 
				if(strlen($assigned_to_id_vals)>0){
					$whrs .=" AND p.assigned_to_id IN ($assigned_to_id_vals) ";
				} 
			}    
		   
		if(array_key_exists("s_val",$params)){
			$s_val = $params['s_val'];  
			if(strlen($s_val)>0){
				$whrs .= " AND ( p.ref_no LIKE '%$s_val%' OR p.title LIKE '%$s_val%' OR p.description LIKE '%$s_val%' OR p.property_address LIKE '%$s_val%' ) "; 
			} 
		}       
		 
		if(array_key_exists("category_id_vals",$params)){
			$category_id_vals = $params['category_id_vals'];   
			if(strlen($category_id_vals)>0){ 
				//$whrs .=" AND FIND_IN_SET($category_id_vals, p.category_id) "; 
				$whrs .= " AND p.category_id IN ($category_id_vals) ";
			}
		}   
		
		if(array_key_exists("emirate_id_vals",$params)){
			$emirate_id_vals = $params['emirate_id_vals'];  
			if(strlen($emirate_id_vals)>0){  
				//$whrs .=" AND FIND_IN_SET($emirate_id_vals, p.emirate_id) ";  
				$whrs .= " AND p.emirate_id IN ($emirate_id_vals) ";
			}
		}  
		 
		if(array_key_exists("location_id_vals",$params)){
			$location_id_vals = $params['location_id_vals'];  
			if(strlen($location_id_vals)>0){ 
				//$whrs .=" AND FIND_IN_SET($location_id_vals, p.location_id) "; 
				$whrs .= " AND p.location_id IN ($location_id_vals) ";
			}
		} 
		
		if(array_key_exists("sub_location_id_vals",$params)){
			$sub_location_id_vals = $params['sub_location_id_vals'];  
			if(strlen($sub_location_id_vals)>0){ 
				//$whrs .=" AND FIND_IN_SET($sub_location_id_vals, p.sub_location_id) "; 
				$whrs .= " AND p.sub_location_id IN ($sub_location_id_vals) ";
			}
		}  	
		
		if(array_key_exists("portal_id_vals",$params)){
			$portal_id_vals = $params['portal_id_vals'];  
			if(strlen($portal_id_vals)>0){  
			 	$whrs .= " AND ( FIND_IN_SET($portal_id_vals, p.show_on_portal_ids) OR p.show_on_portal_ids IN ($portal_id_vals) ) "; 
			}
		}
		
		if(array_key_exists("owner_id_vals",$params)){
			$owner_id_vals = $params['owner_id_vals'];  
			if(strlen($owner_id_vals)>0){  
				//$whrs .=" AND FIND_IN_SET($owner_id_vals, p.owner_id) "; 
				$whrs .= " AND p.owner_id IN ($owner_id_vals) ";
			}
		}
		
		if(array_key_exists("property_status_vals",$params)){
			$property_status_vals = $params['property_status_vals']; 
			if(strlen($property_status_vals)>0){  
				//$whrs .=" AND FIND_IN_SET($property_status_vals, p.property_status) "; 
				$whrs .= " AND p.property_status IN ($property_status_vals) ";
			}
		}  
		
		if(array_key_exists("is_property_type",$params)){
			$is_property_type = $params['is_property_type']; 
			if($is_property_type>0){
				$whrs .= " AND p.property_type=$is_property_type";
			}
		}
		
		if(array_key_exists("is_archived",$params)){
			$is_archived = $params['is_archived'];
			if(strlen($is_archived)>0){
				$whrs .= " AND p.is_archived=$is_archived";
			}
		}else{
			$whrs .= " AND p.is_archived='0' ";
		}
		
		if(array_key_exists("is_deleted",$params)){
			$is_deleted = $params['is_deleted']; 
			if(strlen($is_deleted)>0){
				$whrs .= " AND p.is_deleted=$is_deleted";
			}
		}else{
			$whrs .= " AND p.is_deleted='0' ";
		}   
		
		if(array_key_exists("price_val",$params) && array_key_exists("to_price_val",$params)){ 
			$str_price_val = $params['price_val'];
			$to_price_val = $params['to_price_val']; 
			
			if(strlen($str_price_val)>0 && strlen($to_price_val)>0){
				$whrs .= " AND ( p.price >='$str_price_val' AND p.price <='$to_price_val' ) ";
			}  
        }
		
		if(array_key_exists("from_date_val",$params) && array_key_exists("to_date_val",$params)){ 
			$from_date_val = $params['from_date_val'];
			$to_date_val = $params['to_date_val']; 
			
			if(strlen($from_date_val)>0 && strlen($to_date_val)>0){
				$whrs .= " AND ( DATE_FORMAT(p.created_on,'%Y-%m-%d')>='$from_date_val' AND DATE_FORMAT(p.created_on,'%Y-%m-%d')<='$to_date_val' ) ";
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
		   
		$query = $this->db->query("SELECT p.id, p.ref_no, p.title, c.name AS cate_name, p.price, p.property_status, p.assigned_to_id, p.is_new, p.show_on_portal_ids, p.price, u.name AS crt_usr_name, em.name AS em_name, em_lc.name AS em_lc_name, sl.name AS sub_loc_name, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no, p.property_status AS property_status, p.created_on AS created_on FROM properties_tbl p LEFT JOIN users_tbl u ON p.created_by=u.id LEFT JOIN categories_tbl c ON p.category_id=c.id LEFT JOIN emirates_tbl em ON p.emirate_id=em.id LEFT JOIN emirate_locations_tbl em_lc ON p.location_id=em_lc.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id LEFT JOIN owners_tbl ow ON p.owner_id=ow.id WHERE p.id>0 $whrs ORDER BY p.id DESC $limits "); 
		return $query->result(); 
	} 
	
	function get_property_detail_by_id($paras1){   
		if($paras1>0){  
			$query = $this->db->query("SELECT p.*, c.name AS cate_name, u.name AS crt_usr_name, em.name AS em_name, em_lc.name AS em_lc_name, sl.name AS sub_loc_name, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no, sr_lst.title AS sr_lst_title FROM properties_tbl p LEFT JOIN users_tbl u ON p.created_by=u.id LEFT JOIN categories_tbl c ON p.category_id=c.id LEFT JOIN emirates_tbl em ON p.emirate_id=em.id LEFT JOIN emirate_locations_tbl em_lc ON p.location_id=em_lc.id LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id LEFT JOIN owners_tbl ow ON p.owner_id=ow.id LEFT JOIN source_of_listings_tbl sr_lst ON p.source_of_listing=sr_lst.id WHERE p.id=$paras1 "); 
			return $query->row();
		} 
	}
	
	function get_all_property_photos_by_property_id($args1){  
		$this->db->select('image'); 
		$this->db->from('property_images_tbl');   
		$this->db->where('property_id', $args1);
		return $this->db->get()->result();
	} 
	
	function get_all_property_documents_by_property_id($args1){  
		$this->db->select('name'); 
		$this->db->from('property_documents_tbl');   
		$this->db->where('property_id', $args1);
		return $this->db->get()->result();
	}
	
	function trash_property_photo($args2){
		if($args2 >0){
			$this->db->where('property_id', $args2);
			$this->db->delete('property_images_tbl');
		} 
		return true;
	}
	
	function trash_property_documents($args2){
		if($args2 >0){
			$this->db->where('property_id', $args2);
			$this->db->delete('property_documents_tbl');
		} 
		return true;
	} 
	
	function trash_property($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('properties_tbl');
		} 
		return true;
	}
	
	function delete_properties_portals_data($tmp_proprtyid){ 
		if($tmp_proprtyid>0){
			$this->db->where('property_id',$tmp_proprtyid);  
			$this->db->delete('properties_portals_tbl'); 
		}
		return true;
	} 
	
	function trash_property_assigned_portal_feature_data($paras1){
		if($paras1 >0){
			$this->db->where('property_id', $paras1); 
			$this->db->delete('properties_portal_features_tbl');
		} 
		return true;
	}
	
	
	function get_max_property_ref_no_val(){  
		$prop_ref_no_max_vals = 0;
		$prop_ref_no_vals = '';
		$query = $this->db->query("SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(ref_no,'BSO-R',''),'BSO-S',''),'L-',''),'LD-',''),'BSO-L','') AS ref_no FROM properties_tbl ");  /* where is_deleted='0' AND is_dealt='0' */
		$prop_ref_no_arrs = $query->result(); 
		if(isset($prop_ref_no_arrs)){  
			foreach($prop_ref_no_arrs as $prop_ref_no_arr){
				$prop_ref_no_vals .= $prop_ref_no_arr->ref_no.','; 
			}
			$prop_ref_no_vals = substr($prop_ref_no_vals, 0, -1);
			$prop_ref_no_tmp_arr = explode(',', $prop_ref_no_vals);
			
			$prop_ref_no_max_vals = max($prop_ref_no_tmp_arr);
		}
		 
		 return $prop_ref_no_max_vals; 
	}
	
	
	function insert_portal_property_data($data){ 
		return $this->db->insert('portal_deleted_properties', $data);
	} 
	
	function count_portal_property_by_id($parass1,$parass2){ 
	 	$num_rows =0;
		if($parass1>0 && $parass2>0){  
			$this->db->where(" property_id='$parass1' ");
			$this->db->where(" portal_id='$parass2' "); 
			$num_rows = $this->db->count_all_results('portal_deleted_properties'); 
		}
		return $num_rows;
	}
	
	function update_portal_property_datas($parass1,$parass2,$data){
		if($parass1>0 && $parass2>0){  
			$this->db->where(" property_id='$parass1' ");
			$this->db->where(" portal_id='$parass2' "); 
			return $this->db->update('portal_deleted_properties', $data);
		} 
	}
	
	function trash_deleted_portal_property($parass1,$parass2){
		if($parass1>0 && $parass2>0){  
			$this->db->where(" property_id='$parass1' ");
			$this->db->where(" portal_id='$parass2' ");  
			$this->db->delete('portal_deleted_properties'); 
			return true;
		} 
	}
	 
 	   
	/* propeties locations data starts */
	function get_property_loations_by_property_id($sl_propertyid){
		$query = $this->db->query("SELECT * FROM properties_locations_tbl WHERE property_id='".$sl_propertyid."' "); 
		return $query->result();
	} 
	
	function chk_loation_by_property_id($sl_propertyid){
		$query = $this->db->query("SELECT count(id) AS NUMS FROM properties_locations_tbl WHERE property_id='".$sl_propertyid."' "); 
		return $query->row()->NUMS; 
	}
	
	function chk_loation_by_property_location_ids($sl_locid, $sl_propertyid){
		$query = $this->db->query("SELECT count(id) AS NUMS FROM properties_locations_tbl WHERE property_id='".$sl_propertyid."' AND location_id='".$sl_locid."' "); 
		return $query->row()->NUMS; 
	}
	
	
   	function insert_property_loation_data($data){ 
		return $this->db->insert('properties_locations_tbl', $data);
	}
	 
    function update_property_loation_data($args1,$data){ 
		if($args1>0){
			$this->db->where('id',$args1);
			return $this->db->update('properties_locations_tbl', $data);
		}
	}
		 
	function trash_property_loation_data($paras1){
		if($paras1 >0){
			$this->db->where('property_id', $paras1); 
			$this->db->delete('properties_locations_tbl');
		} 
		return true;
	} 
	/* properties locations data ends */
	
}  ?>