<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currencies_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	} 
  
 	/* currencies function starts */
	function get_all_currencies(){
	   $this->db->order_by("name", "asc");
	   $query = $this->db->get('currencies_tbl');
	   return $query->result();
	} 
	
	function get_currency_by_id($args1){ 
		$query = $this->db->get_where('currencies_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_currency_data($data){ 
		return $this->db->insert('currencies_tbl', $data);
	}  
	
	function update_currency_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('currencies_tbl', $data);
	}

	function trash_currency($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('currencies_tbl');
		} 
		return true;
	}
	/* currencies function ends */
	
}  ?>