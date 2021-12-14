<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deals_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}  

	/* properties photos starts */
	function get_all_cstm_deals_properties($params = array()){  
		
		$vs_user_type_id= $this->session->userdata('us_user_type_id'); 
		$temp_agents_ids = '';
		 
		$whrs ='';
		  
		if(array_key_exists("types_val",$params)){
			$types_val = $params['types_val'];  
			if(strlen($types_val)>0){
				$whrs .= " AND d.types='$types_val' "; 
			}
		}
		
		if(array_key_exists("assigned_to_id_val",$params)){
			$assigned_to_id_val = $params['assigned_to_id_val'];  
			if(strlen($assigned_to_id_val)>0){
				$whrs .= " AND ( d.agent1_id IN ($assigned_to_id_val) OR d.agent2_id IN ($assigned_to_id_val) ) ";
			}
		} 
		
		if(array_key_exists("refer_no_val",$params)){
			$refer_no_val = $params['refer_no_val'];  
			if(strlen($refer_no_val)>0){
				$whrs .= " AND d.ref_no LIKE '%$refer_no_val%' "; 
			}
		}  
		
		if(array_key_exists("unit_no_val",$params)){
			$unit_no_val = $params['unit_no_val'];  
			if(strlen($unit_no_val)>0){
				$whrs .= " AND d.unit_no LIKE '%$unit_no_val%' "; 
			}
		}  
		
		
		if(array_key_exists("est_deal_date_val",$params)){
			$est_deal_date_val = $params['est_deal_date_val'];  
			if(strlen($est_deal_date_val)>0){
				$whrs .= " AND d.est_deal_date='$est_deal_date_val' "; 
			}
		} 
		
		 	
		if(array_key_exists("price_val",$params) && array_key_exists("to_price_val",$params)){ 
			$str_price_val = $params['price_val'];
			$to_price_val = $params['to_price_val']; 
			
			if($str_price_val>0 && $to_price_val>0){
				$whrs .=" AND ( d.deal_price >='$str_price_val' AND d.deal_price <='$to_price_val' ) ";
			}  
        } 
		
		if(array_key_exists("emirate_location_id_val",$params)){
			$emirate_location_id_val = $params['emirate_location_id_val'];  
			if(strlen($emirate_location_id_val)>0){ 
				$whrs .=" AND d.sub_location_id IN ($emirate_location_id_val) ";
			}
		}    
		
		if(array_key_exists("property_status_val",$params)){
			$property_status_val = $params['property_status_val']; 
			if(strlen($property_status_val)>0){ 
				$whrs .=" AND d.status='$property_status_val' ";
			}
		} 
		 
		if(array_key_exists("owner_id_val",$params)){
			$owner_id_val = $params['owner_id_val']; 
			if(strlen($owner_id_val)>0){  
				$whrs .=" AND d.owner_id IN ($owner_id_val) ";
			}
		} 
		
		if(array_key_exists("contact_id_val",$params)){
			$contact_id_val = $params['contact_id_val']; 
			if(strlen($contact_id_val)>0){  
				$whrs .=" AND d.contact_id IN ($contact_id_val) ";
			}
		}
		 
		$limits ='';
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
			$tot_limit =   $params['limit'];
			$str_limit =   $params['start']; 			 
			$limits = " LIMIT $str_limit, $tot_limit ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
             $tot_limit =   $params['limit'];
			$limits = " LIMIT $tot_limit ";
		} 
		
		/*echo "SELECT d.*, s.name AS cnt_name, s.phone_no AS cnt_phone_no, ow.name AS owner_name, ow.phone_no AS owner_phone_no, sl.name AS sub_loc_name FROM properties_deals_tbl d LEFT JOIN contacts_tbl s ON d.contact_id=s.id LEFT JOIN owners_tbl ow ON d.owner_id=ow.id LEFT JOIN emirate_sub_locations_tbl sl ON d.sub_location_id=sl.id WHERE d.id >'0' $whrs ORDER BY d.created_on DESC $limits ";
		exit;*/
		
		/*echo "SELECT d.*, s.name AS cnt_name, s.phone_no AS cnt_phone_no, ow.name AS owner_name, ow.phone_no AS owner_phone_no, sl.name AS sub_loc_name FROM properties_deals_tbl d LEFT JOIN siteusers_tbl s ON d.contact_id=s.id LEFT JOIN owners_tbl ow ON d.owner_id=ow.id LEFT JOIN emirate_sub_locations_tbl sl ON d.sub_location_id=sl.id WHERE d.id >'0' $whrs ORDER BY d.created_on DESC $limits ";
		exit;
*/		 
		$query = $this->db->query("SELECT d.*, s.name AS cnt_name, s.phone_no AS cnt_phone_no, ow.name AS owner_name, ow.phone_no AS owner_phone_no, sl.name AS sub_loc_name FROM properties_deals_tbl d LEFT JOIN contacts_tbl s ON d.contact_id=s.id LEFT JOIN owners_tbl ow ON d.owner_id=ow.id LEFT JOIN emirate_sub_locations_tbl sl ON d.sub_location_id=sl.id WHERE d.id >'0' $whrs ORDER BY d.created_on DESC $limits ");  	
		return $query->result();   
	} 
	
	function get_max_deal_id(){
		$this->db->select_max("id");
		$rets = $this->db->get('properties_deals_tbl')->row();  
		return $rets->id; 
	} 
	
	function get_deal_by_id($args1){ 
		$query = $this->db->get_where('properties_deals_tbl',array('id'=> $args1));
		return $query->row();
	}
	
	function insert_deal_data($data){ 
		return $this->db->insert('properties_deals_tbl', $data);
	} 
	
	function update_deal_data($args1,$data){ 
		if($args1>0){
			$this->db->where('id',$args1);
			return $this->db->update('properties_deals_tbl', $data);
		}
	}
	
	function trash_deal($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('properties_deals_tbl');
		} 
		return true;
	}
	
	function update_temp_property_dropzone_deal_documents($tmp_proprtyid,$tmp_ips,$tmp_dts,$data){
		if($tmp_proprtyid== -1 && strlen($tmp_ips)>0 && strlen($tmp_dts)>0){
			$this->db->where('deal_id',$tmp_proprtyid);
			$this->db->where('ip_address',$tmp_ips);
			$this->db->where('datatimes',$tmp_dts);
			return $this->db->update('properties_deals_documents_tbl', $data);
		} 
	}
	
	function update_temp_property_dropzone_sellerlandlord_documents($tmp_proprtyid,$tmp_ips,$tmp_dts,$data){
		if($tmp_proprtyid== -1 && strlen($tmp_ips)>0 && strlen($tmp_dts)>0){
			$this->db->where('deal_id',$tmp_proprtyid);
			$this->db->where('ip_address',$tmp_ips);
			$this->db->where('datatimes',$tmp_dts);
			return $this->db->update('properties_sellerlandlord_documents_tbl', $data);
		} 
	}
	
	function update_temp_property_dropzone_buyertenant_documents($tmp_proprtyid,$tmp_ips,$tmp_dts,$data){
		if($tmp_proprtyid== -1 && strlen($tmp_ips)>0 && strlen($tmp_dts)>0){
			$this->db->where('deal_id',$tmp_proprtyid);
			$this->db->where('ip_address',$tmp_ips);
			$this->db->where('datatimes',$tmp_dts);
			return $this->db->update('properties_buyertenant_documents_tbl', $data);
		} 
	}
	
	function update_temp_property_dropzone_newtitledeed_documents($tmp_proprtyid,$tmp_ips,$tmp_dts,$data){
		if($tmp_proprtyid== -1 && strlen($tmp_ips)>0 && strlen($tmp_dts)>0){
			$this->db->where('deal_id',$tmp_proprtyid);
			$this->db->where('ip_address',$tmp_ips);
			$this->db->where('datatimes',$tmp_dts);
			return $this->db->update('properties_newtitledeed_documents_tbl', $data);
		} 
	}
	
	function update_temp_property_dropzone_agency_documents($tmp_proprtyid,$tmp_ips,$tmp_dts,$data){
		if($tmp_proprtyid== -1 && strlen($tmp_ips)>0 && strlen($tmp_dts)>0){
			$this->db->where('deal_id',$tmp_proprtyid);
			$this->db->where('ip_address',$tmp_ips);
			$this->db->where('datatimes',$tmp_dts);
			return $this->db->update('properties_agency_documents_tbl', $data);
		} 
	} 
	
	function get_property_dropzone_deal_documents_by_id($args1){
		$query= $this->db->get_where('properties_deals_documents_tbl',array('deal_id'=> $args1));
		return $query->result();
	}
	
	function get_property_dropzone_newtitledeed_documents_by_id($args1){
		$query= $this->db->get_where('properties_newtitledeed_documents_tbl',array('deal_id'=> $args1));
		return $query->result();
	}
	
	function get_property_dropzone_agency_documents_by_id($args1){
		$query= $this->db->get_where('properties_agency_documents_tbl',array('deal_id'=> $args1));
		return $query->result();
	}
	
	function insert_property_deal_documents_data($data){ 
		return $this->db->insert('properties_deals_documents_tbl', $data);
	}
	 
	function insert_property_sellerlandlord_documents_data($data){ 
		return $this->db->insert('properties_sellerlandlord_documents_tbl', $data);
	}
	
	function get_property_dropzone_sellerlandlord_documents_by_id($args1){
		$query= $this->db->get_where('properties_sellerlandlord_documents_tbl',array('deal_id'=> $args1));
		return $query->result();
	}
	
	function get_temp_post_property_dropzone_sellerlandlord_documents(){ 
		$deal_id4 = -1; 	
		$ip_address4 = $_SERVER['REMOTE_ADDR']; 
		$datatimes4 = date('Y-m-d');
			 
		if(isset($_SESSION['Temp_Sellerlandlord_Documents_IP_Address']) && isset($_SESSION['Temp_Sellerlandlord_Documents_DATE_Times'])){
			$ip_address4 = $_SESSION['Temp_Sellerlandlord_Documents_IP_Address'];
			$datatimes4 = $_SESSION['Temp_Sellerlandlord_Documents_DATE_Times'];
		} 
			
		$query = $this->db->get_where('properties_sellerlandlord_documents_tbl',array('deal_id'=> $deal_id4,'ip_address'=> $ip_address4,'datatimes'=> $datatimes4));
		return $query->result();
	}
	
	function delete_property_dropzone_sellerlandlord_documents($tmp_imgs,$tmp_proprtyid){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);  
		$this->db->delete('properties_sellerlandlord_documents_tbl'); 
		return true;
	} 
	
	function delete_temp_property_dropzone_sellerlandlord_documents($tmp_imgs,$tmp_proprtyid,$tmp_ips,$tmp_dts){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);
		$this->db->where('ip_address',$tmp_ips); 
		$this->db->where('datatimes',$tmp_dts);   
		$this->db->delete('properties_sellerlandlord_documents_tbl'); 
		return true;
	} 
	
	function insert_property_buyertenant_documents_data($data){ 
		return $this->db->insert('properties_buyertenant_documents_tbl', $data);
	}
	
	function get_property_dropzone_buyertenant_documents_by_id($args1){
		$query= $this->db->get_where('properties_buyertenant_documents_tbl',array('deal_id'=> $args1));
		return $query->result();
	}
	
	function get_temp_post_property_dropzone_buyertenant_documents(){ 
		$deal_id4 = -1; 	
		$ip_address4 = $_SERVER['REMOTE_ADDR']; 
		$datatimes4 = date('Y-m-d');
			 
		if(isset($_SESSION['Temp_Buyertenant_Documents_IP_Address']) && isset($_SESSION['Temp_Buyertenant_Documents_DATE_Times'])){
			$ip_address4 = $_SESSION['Temp_Buyertenant_Documents_IP_Address'];
			$datatimes4 = $_SESSION['Temp_Buyertenant_Documents_DATE_Times'];
		} 
				
		$query = $this->db->get_where('properties_buyertenant_documents_tbl',array('deal_id'=> $deal_id4,'ip_address'=> $ip_address4,'datatimes'=> $datatimes4));
		return $query->result();
	} 
	
	function delete_property_dropzone_buyertenant_documents($tmp_imgs,$tmp_proprtyid){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);  
		$this->db->delete('properties_buyertenant_documents_tbl'); 
		return true;
	} 
	
	function delete_temp_property_dropzone_buyertenant_documents($tmp_imgs,$tmp_proprtyid,$tmp_ips,$tmp_dts){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);
		$this->db->where('ip_address',$tmp_ips); 
		$this->db->where('datatimes',$tmp_dts);   
		$this->db->delete('properties_buyertenant_documents_tbl'); 
		return true;
	} 
	
	function insert_property_newtitledeed_documents_data($data){ 
		return $this->db->insert('properties_newtitledeed_documents_tbl', $data);
	}
	
	
	function get_temp_post_property_dropzone_newtitledeed_documents(){ 
		$deal_id4 = -1; 	
		$ip_address4 = $_SERVER['REMOTE_ADDR']; 
		$datatimes4 = date('Y-m-d');
			 
		if(isset($_SESSION['Temp_Newtitledeed_Documents_IP_Address']) && isset($_SESSION['Temp_Newtitledeed_Documents_DATE_Times'])){
			$ip_address4 = $_SESSION['Temp_Newtitledeed_Documents_IP_Address'];
			$datatimes4 = $_SESSION['Temp_Newtitledeed_Documents_DATE_Times'];
		} 
			
		$query = $this->db->get_where('properties_newtitledeed_documents_tbl',array('deal_id'=> $deal_id4,'ip_address'=> $ip_address4,'datatimes'=> $datatimes4));
		return $query->result();
	}
	
	function delete_property_dropzone_newtitledeed_documents($tmp_imgs,$tmp_proprtyid){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);  
		$this->db->delete('properties_newtitledeed_documents_tbl'); 
		return true;
	} 
	
	
	function delete_temp_property_dropzone_newtitledeed_documents($tmp_imgs,$tmp_proprtyid,$tmp_ips,$tmp_dts){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);
		$this->db->where('ip_address',$tmp_ips); 
		$this->db->where('datatimes',$tmp_dts);   
		$this->db->delete('properties_newtitledeed_documents_tbl'); 
		return true;
	} 
	
	function insert_property_agency_documents_data($data){ 
		return $this->db->insert('properties_agency_documents_tbl', $data);
	}
	
	function delete_property_dropzone_agency_documents($tmp_imgs,$tmp_proprtyid){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);  
		$this->db->delete('properties_agency_documents_tbl'); 
		return true;
	} 
	
	function delete_temp_property_dropzone_agency_documents($tmp_imgs,$tmp_proprtyid,$tmp_ips,$tmp_dts){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);
		$this->db->where('ip_address',$tmp_ips); 
		$this->db->where('datatimes',$tmp_dts);   
		$this->db->delete('properties_agency_documents_tbl'); 
		return true;
	} 
	
	function delete_property_dropzone_deal_documents($tmp_imgs,$tmp_proprtyid){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);  
		$this->db->delete('properties_deals_documents_tbl'); 
		return true;
	}  
	
	function delete_temp_property_dropzone_deal_documents($tmp_imgs,$tmp_proprtyid,$tmp_ips,$tmp_dts){
		$this->db->where('name',$tmp_imgs);
		$this->db->where('deal_id',$tmp_proprtyid);
		$this->db->where('ip_address',$tmp_ips); 
		$this->db->where('datatimes',$tmp_dts);   
		$this->db->delete('properties_deals_documents_tbl'); 
		return true;
	}
	
	function get_temp_post_property_dropzone_deal_documents(){ 
		$deal_id4 = -1; 	
		$ip_address4 = $_SERVER['REMOTE_ADDR']; 
		$datatimes4 = date('Y-m-d');
			 
		if(isset($_SESSION['Temp_Deal_Documents_IP_Address']) && isset($_SESSION['Temp_Deal_Documents_DATE_Times'])){
			$ip_address4 = $_SESSION['Temp_Deal_Documents_IP_Address'];
			$datatimes4 = $_SESSION['Temp_Deal_Documents_DATE_Times'];
		} 
			
	$query = $this->db->get_where('properties_deals_documents_tbl',array('deal_id'=> $deal_id4,'ip_address'=> $ip_address4,'datatimes'=> $datatimes4));
	return $query->result();
	}  
	 
	 
	 /* deals model ended */
}  ?>