<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages_model extends CI_Model {

	function __construct() {
		parent::__construct();  
	}  
	
	/* Packages function starts */ 
	function get_max_packages_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('packages_tbl')->row();  
		return $rets->sort_order; 
	}
	
	function get_all_packages(){
		$this->db->order_by("sort_order", "asc");
	    $query = $this->db->get('packages_tbl');
	    return $query->result();
	} 
	
	function get_package_by_id($args1){ 
		$query = $this->db->get_where('packages_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_package_data($data){ 
		return $this->db->insert('packages_tbl', $data);
	}  
	
	function update_package_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('packages_tbl', $data);
	}

	function trash_package($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('packages_tbl');
		} 
		return true;
	}
	/* Packages function ends */ 
	
}  ?>