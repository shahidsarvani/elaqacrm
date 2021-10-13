<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emirates_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	} 
  
 	/* emirates function starts */
	function get_all_emirates(){
	   $this->db->order_by("name", "asc");
	   $query = $this->db->get('emirates_tbl');
	   return $query->result();
	} 
	
	function get_emirate_by_id($args1){ 
		$query = $this->db->get_where('emirates_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_emirate_data($data){ 
		return $this->db->insert('emirates_tbl', $data);
	}  
	
	function update_emirate_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('emirates_tbl', $data);
	}

	function trash_emirate($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('emirates_tbl');
		} 
		return true;
	}
	/* emirates function ends */
	
}  ?>