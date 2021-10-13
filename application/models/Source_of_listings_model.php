<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Source_of_listings_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}  
	
	/* property source of listings function starts */
	function get_max_source_of_listings_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('source_of_listings_tbl')->row();  
		return $rets->sort_order; 
	} 
	 	
	function get_all_source_of_listings(){
		$this->db->order_by("sort_order", "asc");
	   	$query = $this->db->get('source_of_listings_tbl');
	   	return $query->result();
	} 
	
	function get_all_properties_source_of_listings(){
		$this->db->order_by("sort_order", "asc");
		$this->db->where('show_in_properties', '1');
	   	$query = $this->db->get('source_of_listings_tbl');
	   	return $query->result();
	} 
	
	function get_all_leads_source_of_listings(){
		$this->db->order_by("sort_order", "asc");
		$this->db->where('show_in_leads', '1');
	   	$query = $this->db->get('source_of_listings_tbl');
	   	return $query->result();
	} 
	
	function get_source_of_listing_by_id($args1){ 
		$query = $this->db->get_where('source_of_listings_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_source_of_listing_data($data){ 
		return $this->db->insert('source_of_listings_tbl', $data);
	}  
	
	function update_source_of_listing_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('source_of_listings_tbl', $data);
	}

	function trash_source_of_listing($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('source_of_listings_tbl');
		} 
		return true;
	}
	/* property source of listings function ends */
	  
	
}  ?>