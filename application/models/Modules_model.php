<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modules_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}  
	
	/* modules function starts */ 
	
	function trash_module($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('modules_tbl');
		} 
		return true;
	}
	
	function get_all_parent_modules($parnt_mod_id){
		if($parnt_mod_id!=''){
			$this->db->where('parent_id',$parnt_mod_id); 
		   $query = $this->db->get('modules_tbl');
		   return $query->result();
		}
	} 
	
	function get_all_modules(){
	   $query = $this->db->get('modules_tbl');
	   return $query->result();
	} 
	
	function get_module_by_id($args1){ 
		$query = $this->db->get_where('modules_tbl',array('id'=> $args1));
		return $query->row();
	}
	
	function insert_module_data($data){ 
		return $this->db->insert('modules_tbl', $data);
	}  
	
	function update_module_data($args1,$data){ 
		if($args1>0){
			$this->db->where('id',$args1);
			return $this->db->update('modules_tbl', $data);
		}
	}
	
	function get_max_modules_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('modules_tbl')->row();  
		return $rets->sort_order; 
	}
	
	/* modules function ends */  
	
}  ?>