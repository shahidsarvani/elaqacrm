<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model {

	function __construct() {
		parent::__construct();  
	}  
	
	/* categories function starts */ 
	function get_max_categories_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('categories_tbl')->row();  
		return $rets->sort_order; 
	}
	
	function get_all_categories(){
		$this->db->order_by("sort_order", "asc");
	    $query = $this->db->get('categories_tbl');
	    return $query->result();
	} 
	
	function get_category_by_id($args1){ 
		$query = $this->db->get_where('categories_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_category_data($data){ 
		return $this->db->insert('categories_tbl', $data);
	}  
	
	function update_category_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('categories_tbl', $data);
	}

	function trash_category($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('categories_tbl');
		} 
		return true;
	}
	/* categories function ends */ 
	
}  ?>