<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmls_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}  

	 /* xmls module starts  */ 
	  
	 
	 
	 function get_all_xml_cstm_properties(){  
		$query = $this->db->query("SELECT p.*, c.name AS cate_name, u.name AS assign_usr_name, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no, e.name AS emirat_name, el.name AS emlc_name, sl.name AS sub_loc_name, src_lst.title AS src_title FROM properties_tbl p
		LEFT JOIN categories_tbl c ON p.category_id=c.id  
		LEFT JOIN users_tbl u ON p.assigned_to_id=u.id 
		LEFT JOIN owners_tbl ow ON p.owner_id=ow.id
		LEFT JOIN emirates_tbl e ON p.emirate_id=e.id
		LEFT JOIN emirate_locations_tbl el ON p.location_id=el.id  
		LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id 
		LEFT JOIN source_of_listings_tbl src_lst ON p.source_of_listing=src_lst.id 
		WHERE FIND_IN_SET('1', p.show_on_portal_ids) AND p.is_deleted='0' AND p.is_archived='0' ORDER BY p.created_on DESC"); 
		return $query->result();  
		
		
		
		/* "SELECT * FROM properties_tbl WHERE is_deleted='0' AND is_archived='0' ORDER BY created_on DESC" */  
		 	
		/*$query = $this->db->query("SELECT p.id, p.ref_no, p.title, p.epb_ref, p.assigned_to_id, p.is_new, p.show_on_portal_ids,pj.title AS proj_title, u.name AS crt_usr_name, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no, p.created_on AS created_on FROM properties_tbl p LEFT JOIN users_tbl u ON p.created_by=u.id LEFT JOIN projects_tbl pj ON p.project_id=pj.id LEFT JOIN owners_tbl ow ON p.owner_id=ow.id WHERE p.is_deleted='0' AND p.is_archived='0' $whrs ORDER BY p.id DESC $limits "); */
	} 
	
	
	function get_all_xml_cstm_projects(){  
		$query = $this->db->query("SELECT * FROM projects_tbl ORDER BY sort_order ASC"); 
		return $query->result();  
	} 
	
	function get_property_dropzone_photos_by_id($args1){ 
		if($args1>0){
			$this->db->order_by("sort_order", "asc");
			$query = $this->db->get_where('property_images_tbl',array('property_id'=> $args1));
			return $query->result();
		}
	}
	
	
	function get_property_dropzone_documents_by_id($args1){ 
		if($args1>0){ 
			$query = $this->db->get_where('property_documents_tbl',array('property_id'=> $args1));
			return $query->result();
		}
	}
	 
	function get_techicals_by_property_id($property_id1){  
		if($property_id1>0){ 
			$query = $this->db->get_where('property_techicals_tbl',array('property_id'=> $property_id1));
			return $query->result();
		}
	}
	
	function get_layouts_by_property_id($property_id1){  
		if($property_id1>0){ 
			$query = $this->db->get_where('property_layouts_tbl',array('property_id'=> $property_id1));
			return $query->result();
		}
	} 
	
	
	function get_project_by_id($project_id1){ 
		if($project_id1 >0){
			$query = $this->db->get_where('projects_tbl',array('id'=> $project_id1));
			return $query->row();
		}
	}
	 
	function get_category_by_id($category_id1){ 
		if($category_id1 >0){
			$query = $this->db->get_where('categories_tbl',array('id'=> $category_id1));
			return $query->row();
		}
	} 
	
	
	function get_agents_name(){ 
		$query = $this->db->get_where('users_tbl',array('role_id'=> '3'));
		return $query->result(); 
	}
	 
	 
	function get_all_propertyfinder_xmls_list_properties_list(){  
		$query = $this->db->query("SELECT p.*, c.id AS cate_id, c.name AS cate_name, c.property_type AS cate_property_type, e.name AS emirat_name, u.id AS asgn_usr_id, u.name AS asgn_usr_name, u.phone_no AS asgn_phone_no, u.email AS asgn_email,u.image AS asgn_usr_image, u.address AS asgn_usr_address, u.rera_no AS asgn_usr_rera_no, el.name AS emlc_name, sl.name AS sub_loc_name, ow.name AS ownr_name, ow.phone_no AS ownr_phone_no FROM properties_tbl p 
		LEFT JOIN categories_tbl c ON p.category_id=c.id 
		LEFT JOIN users_tbl u ON p.assigned_to_id=u.id 
		LEFT JOIN emirates_tbl e ON p.emirate_id=e.id
		LEFT JOIN emirate_locations_tbl el ON p.location_id=el.id  
		LEFT JOIN emirate_sub_locations_tbl sl ON p.sub_location_id=sl.id  
		LEFT JOIN owners_tbl ow ON p.owner_id=ow.id  
		WHERE FIND_IN_SET('1', p.show_on_portal_ids) AND p.is_archived='0' AND p.is_deleted='0' AND p.property_status NOT IN (1,2) ORDER BY p.created_on DESC "); 
		return $query->result(); 
		
		/* AND p.is_archived='0' AND property_status NOT IN (1,2) */
	}
	
	/*
	
	bd.title AS bed_title,
	
	LEFT JOIN no_of_beds_tbl bd ON p.no_of_beds_id=bd.id 
	
	AND p.is_dealt='0' AND p.is_lead='0'
	*/
	
	
	function get_single_propertyfinder_xml_property(){  
		$query = $this->db->query("SELECT updated_on FROM properties_tbl WHERE FIND_IN_SET('4', show_on_portal_ids) AND is_archived='0' AND is_deleted='0' AND property_status NOT IN (1,2) ORDER BY updated_on DESC "); 
		return $query->row();
		/* AND is_dealt='0' AND is_lead='0' */
	} 
	 
 	/* xmls module ends */

	 
	
}  ?>