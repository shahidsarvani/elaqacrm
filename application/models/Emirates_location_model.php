<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emirates_location_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}  
	
	/* emirate location function starts */
	function get_all_emirate_with_locations(){
		$this->db->order_by("l.name", "asc"); 
		$this->db->select("l.*, e.name AS emirate_name");
		$this->db->from('emirate_locations_tbl l, emirates_tbl e');
		$this->db->where('l.emirate_id=e.id'); 
		$query = $this->db->get();
	   	return $query->result();
	} 
	
	function get_all_emirate_locations(){
	   $query = $this->db->get('emirate_locations_tbl');
	   return $query->result();
	} 
	
	function get_emirate_location_by_id($args1){ 
		$query = $this->db->get_where('emirate_locations_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_emirate_location_data($data){ 
		return $this->db->insert('emirate_locations_tbl', $data);
	}  
	
	function update_emirate_location_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('emirate_locations_tbl', $data);
	}

	function trash_emirate_location($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('emirate_locations_tbl');
		} 
		return true;
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
	/* emirate locations function ends */ 
	
}  ?>