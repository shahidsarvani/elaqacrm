<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class No_of_bedrooms_model extends CI_Model {

	function __construct() {
		parent::__construct();  
	}  
	
	/* no_of_bedrooms function starts */ 
	function get_max_no_of_bedrooms_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('no_of_bedrooms_tbl')->row();  
		return $rets->sort_order; 
	}
	
	function get_all_no_of_bedrooms(){
		$this->db->order_by("sort_order", "asc");
	    $query = $this->db->get('no_of_bedrooms_tbl');
	    return $query->result();
	} 
	
	function get_no_of_bedroom_by_id($args1){ 
		$query = $this->db->get_where('no_of_bedrooms_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_no_of_bedroom_data($data){ 
		return $this->db->insert('no_of_bedrooms_tbl', $data);
	}  
	
	function update_no_of_bedroom_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('no_of_bedrooms_tbl', $data);
	}

	function trash_no_of_bed($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('no_of_bedrooms_tbl');
		} 
		return true;
	}
	/* no_of_bedrooms function ends */ 
	
}  ?>