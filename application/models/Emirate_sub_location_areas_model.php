<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emirate_sub_location_areas_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	} 
   
	/* emirate sub location areas function starts */  
	function get_all_areas_with_sub_locations(){
		$this->db->order_by("a.name", "asc"); 
		$this->db->select("a.*, s.name AS sub_location_name");
		$this->db->from('emirate_sub_location_areas_tbl a, emirate_sub_locations_tbl s');
		$this->db->where('a.emirate_sub_location_id=s.id');  
		$this->db->where('a.id<=100');  
		$query = $this->db->get();
	   	return $query->result();
	} 
	
	function get_all_emirate_sub_location_areas(){
	   $query = $this->db->get('emirate_sub_location_areas_tbl');
	   return $query->result();
	}
	
	function fetch_emirate_sub_location_areas($args3){ 
		if(strlen($args3)>0){
			$this->db->order_by("name", "asc");
			$query = $this->db->get_where('emirate_sub_location_areas_tbl',array('emirate_location_id'=> $args3));
			return $query->result();
		}else{
			return '';
		}
	}  
	
	function get_emirate_sub_location_area_by_id($args1){ 
		$query = $this->db->get_where('emirate_sub_location_areas_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_emirate_sub_location_area_data($data){ 
		return $this->db->insert('emirate_sub_location_areas_tbl', $data);
	}
	
	function update_emirate_sub_location_area_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('emirate_sub_location_areas_tbl', $data);
	}

	function trash_emirate_sub_location_area($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('emirate_sub_location_areas_tbl');
		} 
		return true;
	}
	/* emirate sub locations area function ends */ 
	
}  ?>