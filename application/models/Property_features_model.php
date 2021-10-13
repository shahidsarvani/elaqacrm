<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_features_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}  
	
	/* property features function starts */
	function get_max_property_features_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('property_features_tbl')->row();  
		return $rets->sort_order; 
	} 
	 
	function get_all_property_features(){
	   $this->db->order_by("sort_order", "asc");
	   $query = $this->db->get('property_features_tbl');
	   return $query->result();
	}  
	
	function get_all_property_features_by_type($paras1){
		$this->db->order_by("sort_order", "asc");  
		if(strlen($paras1)>0){
			$this->db->where(" FIND_IN_SET($paras1, amenities_types) ");
		} 
		$query = $this->db->get('property_features_tbl');
		return $query->result();
	} 
	 
	function get_portal_property_features($paras1){ 	
		$this->db->order_by("sort_order", "asc");
		$this->db->where(" status='1' ");
		if(strlen($paras1)>0){
			$this->db->where(" FIND_IN_SET($paras1, portal_ids)  ");
		}
		$query = $this->db->get('property_features_tbl');
		return $query->result();
	}
	
	function get_all_property_features_in_id($paras1){
		if(strlen($paras1)>0){
			$this->db->where(" id IN ($paras1) ");
		}
		$query = $this->db->get('property_features_tbl');
		return $query->result();
	} 
	
	function get_property_feature_by_id($args1){ 
		$query = $this->db->get_where('property_features_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_property_feature_data($data){ 
		return $this->db->insert('property_features_tbl', $data);
	}  
	
	function update_property_feature_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('property_features_tbl', $data);
	}

	function trash_property_feature($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('property_features_tbl');
		} 
		return true;
	}
	/* property features function ends */
	
}  ?>