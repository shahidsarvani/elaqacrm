<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emirates_sub_location_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	} 
   
	/* emirate sub location function starts */ 
	
	function get_all_emirate_with_sub_locations(){
		$this->db->order_by("s.name", "asc"); 
		$this->db->select("s.*, l.name AS location_name, e.name AS emirate_name");
		$this->db->from('emirate_sub_locations_tbl s, emirate_locations_tbl l, emirates_tbl e');
		$this->db->where('s.emirate_location_id=l.id'); 
		$this->db->where('l.emirate_id=e.id'); 
		$query = $this->db->get();
	   	return $query->result();
	} 
	
	function get_all_emirate_sub_locations(){
	   $query = $this->db->get('emirate_sub_locations_tbl');
	   return $query->result();
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
	
	function get_emirate_sub_location_by_id($args1){ 
		$query = $this->db->get_where('emirate_sub_locations_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_emirate_sub_location_data($data){ 
		return $this->db->insert('emirate_sub_locations_tbl', $data);
	}
	
	function update_emirate_sub_location_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('emirate_sub_locations_tbl', $data);
	}

	function trash_emirate_sub_location($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('emirate_sub_locations_tbl');
		} 
		return true;
	}
	/* emirate sub locations function ends */ 
	
}  ?>