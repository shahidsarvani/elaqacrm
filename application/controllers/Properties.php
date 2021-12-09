<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Properties extends CI_Controller{

    public function __construct(){ 
        parent::__construct();
		
		$this->login_vs_id = $vs_id = $this->session->userdata('us_id');
		$this->login_vs_user_role_id = $this->dbs_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
		$this->load->model('general_model');
		if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id >=1)){
			/* ok */
			$res_nums = $this->general_model->check_controller_permission_access('Properties',$vs_user_role_id,'1');
			if($res_nums>0){
				/* ok */	 
			}else{
				redirect('/');
			}  
			
		}else{
			redirect('/');
		}  
		
		$this->load->model('properties_model'); 
		$this->load->model('portals_model'); 
		$this->load->model('categories_model'); 
		$this->load->model('emirates_model'); 
		$this->load->model('emirates_location_model'); 
		$this->load->model('emirates_sub_location_model');  
		$this->load->model('source_of_listings_model');  
		$this->load->model('property_features_model'); 
		$this->load->model('admin_model');  
		$this->load->library('Ajax_pagination'); 
		$this->load->library('email');
		$this->perPage = 25;
    }   
	  
	/* properties operations starts */
	
	/*
	$res_nums =  $this->general_model->check_controller_method_permission_access('Portals','update',$this->dbs_user_role_id,'1');
	*/ 
	
	function index($args_vals=''){
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','index',$this->dbs_role_id,'1'); 
		 
		if($res_nums>0){
			$data = array();	
			$paras_arrs = array();	
			$data['page_headings']="Properties Listings"; 
			 
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val= $is_property_type='';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
			
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				} 
				
			if($this->input->post('s_val')){
				$s_val = $this->input->post('s_val'); 
				$_SESSION['tmp_s_val'] = $s_val; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}else if(isset($_SESSION['tmp_s_val'])){
					unset($_SESSION['tmp_s_val']);
				}   	
				
			if($this->input->post('category_id_vals')){
				$category_id_vals = $this->input->post('category_id_vals'); 
				$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
			}else if(isset($_SESSION['tmp_category_id_vals'])){
					unset($_SESSION['tmp_category_id_vals']);
				}
				
			if($this->input->post('emirate_id_vals')){
				$emirate_id_vals = $this->input->post('emirate_id_vals'); 
				$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
			}else if(isset($_SESSION['tmp_emirate_id_vals'])){
					unset($_SESSION['tmp_emirate_id_vals']);
				}
				
			if($this->input->post('location_id_vals')){
				$location_id_vals = $this->input->post('location_id_vals'); 
				$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
			}else if(isset($_SESSION['tmp_location_id_vals'])){
					unset($_SESSION['tmp_location_id_vals']);
				}  	
				
			if($this->input->post('sub_location_id_vals')){
				$sub_location_id_vals = $this->input->post('sub_location_id_vals'); 
				$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
			}else if(isset($_SESSION['tmp_sub_location_id_vals'])){
					unset($_SESSION['tmp_sub_location_id_vals']);
				}
				
			if($this->input->post('portal_id_vals')){
				$portal_id_vals = $this->input->post('portal_id_vals'); 
				$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
			}else if(isset($_SESSION['tmp_portal_id_vals'])){
					unset($_SESSION['tmp_portal_id_vals']);
				}
				
			if($this->input->post('assigned_to_id_vals')){
				$assigned_to_id_vals = $this->input->post('assigned_to_id_vals'); 
				$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
			}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){
					unset($_SESSION['tmp_assigned_to_id_vals']);
				}
				
			if($this->input->post('owner_id_vals')){
				$owner_id_vals = $this->input->post('owner_id_vals'); 
				$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
			}else if(isset($_SESSION['tmp_owner_id_vals'])){
					unset($_SESSION['tmp_owner_id_vals']);
				}
				
			if($this->input->post('property_status_vals')){
				$property_status_vals = $this->input->post('property_status_vals'); 
				$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
				$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
			}else if(isset($_SESSION['tmp_property_status_vals'])){
					unset($_SESSION['tmp_property_status_vals']);
				}
				
			if($this->input->post('price')){
				$price_val = $this->input->post('price'); 
				$_SESSION['tmp_price_val'] = $price_val; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}else if(isset($_SESSION['tmp_price_val'])){
					unset($_SESSION['tmp_price_val']);
				}
				
			if($this->input->post('to_price')){
				$to_price_val = $this->input->post('to_price'); 
				$_SESSION['tmp_to_price_val'] = $to_price_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}else if(isset($_SESSION['tmp_to_price_val'])){
					unset($_SESSION['tmp_to_price_val']);
				}	 
			
			if($this->input->post('from_date')){
				$from_date_val = $this->input->post('from_date'); 
				$_SESSION['tmp_from_date_val'] = $from_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}else if(isset($_SESSION['tmp_from_date_val'])){
					unset($_SESSION['tmp_from_date_val']);
				}
				
			if($this->input->post('to_date')){
				$to_date_val = $this->input->post('to_date'); 
				$_SESSION['tmp_to_date_val'] = $to_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}else if(isset($_SESSION['tmp_to_date_val'])){
					unset($_SESSION['tmp_to_date_val']);
				}	 
				 
			//$is_property_type = 1;   
			/*$data['sel_property_type'] = $is_property_type;
			$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));*/
			 
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			 
			//total rows count
			$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#fetch_dya_list';
			$config['base_url']    = site_url('/properties/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs);
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			//$data['category_arrs'] = $this->admin_model->get_all_categories();
			 
			
			if(isset($args_vals) && $args_vals=="export_excel"){  
			 /* ok */
			}else{
			
				/* for dropzone temp storage unset starts */ 
				if(isset($_SESSION['Temp_Media_Images'])){
		
					$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_photos();
					if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
						foreach($db_docs_arrs as $db_docs_arr){
							 $tmp_fle_name = $db_docs_arr->image; 
							 $tmp_proprty_id = $db_docs_arr->property_id; 
							 $tmp_ip_address = $db_docs_arr->ip_address; 
							 $tmp_dt_time = $db_docs_arr->datatimes; 
							
							 if(strlen($tmp_fle_name)>0){
								unlink("downloads/property_photos/{$tmp_fle_name}");
							 }
							 
							 $this->properties_model->delete_temp_property_dropzone_photos($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
							 
						} 
					}  
				
					unset($_SESSION['Temp_Media_Images']);
					unset($_SESSION['Temp_IP_Address']);
					unset($_SESSION['Temp_DATE_Times']);  
				}  
				
				if(isset($_SESSION['Temp_Documents_Files'])){
					
					$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_documents(); 
					if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
						foreach($db_docs_arrs as $db_docs_arr){
							$tmp_fle_name = $db_docs_arr->name; 
							$tmp_proprty_id = $db_docs_arr->property_id; 
							$tmp_ip_address = $db_docs_arr->ip_address; 
							$tmp_dt_time = $db_docs_arr->datatimes; 
							
							if(strlen($tmp_fle_name)>0){
								unlink("downloads/property_documents/{$tmp_fle_name}");
							}
							
							$this->properties_model->delete_temp_property_dropzone_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
							
						} 
					}
					 
					unset($_SESSION['Temp_Documents_Files']);
					unset($_SESSION['Temp_Documents_IP_Address']);
					unset($_SESSION['Temp_Documents_DATE_Times']);  
				} 
				
				if(isset($_SESSION['Temp_NT_IP_Address'])){ 
					$tmp_proprty_id = -1;
					$tmp_ip_address = $_SESSION['Temp_NT_IP_Address']; 
					$tmp_dt_time = $_SESSION['Temp_NT_DATE_Times']; 
					 
					$this->properties_model->delete_temp_property_notes($tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
					   
					unset($_SESSION['Temp_NT_IP_Address']);
					unset($_SESSION['Temp_NT_DATE_Times']); 
				}  
				/* for dropzone temp storage unset end */  
				
				$this->load->view('properties/index',$data); 
			
			}
			  
		}else{
			$this->load->view('no_permission_access'); 
		} 
	}
				 
	function index2($temps_property_type=''){
	
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','index',$this->dbs_role_id,'1'); 
		 
		if($res_nums>0){		
			
		$paras_arrs = $data = array();	
		$page = $this->input->post('page');
		if(!$page){
			$offset = 0;
		}else{
			$offset = $page;
		} 
		
		$data['page'] = $page;
		
		/* permission checks */
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		/*$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val= $is_property_type='';
		$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';*/
	
		if($this->input->post('sel_per_page_val')){
			$per_page_val = $this->input->post('sel_per_page_val'); 
			$_SESSION['tmp_per_page_val'] = $per_page_val;  
			
		}else if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];
			}  
		 
		if(isset($_POST['s_val'])){
			$s_val = $this->input->post('s_val'); 
			if(strlen($s_val)>0){
				$_SESSION['tmp_s_val'] = $s_val; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}else{
				unset($_SESSION['tmp_s_val']);	
			}
			
		}else if(isset($_SESSION['tmp_s_val'])){
			$s_val = $_SESSION['tmp_s_val']; 
			$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
		}       
		 
		if(isset($_POST['category_id_vals'])){
			$category_id_vals = $this->input->post('category_id_vals');  
			$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals)); 
			
		}else if(isset($_SESSION['tmp_category_id_vals'])){   
			$category_id_vals = $_SESSION['tmp_category_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
		}  
		
		if(isset($_POST['emirate_id_vals'])){
			$emirate_id_vals = $this->input->post('emirate_id_vals');  
			$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals)); 
			
		}else if(isset($_SESSION['tmp_emirate_id_vals'])){  
			$emirate_id_vals = $_SESSION['tmp_emirate_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
		}  
		
		if(isset($_POST['location_id_vals'])){
			$location_id_vals = $this->input->post('location_id_vals');  
			$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals)); 
			
		}else if(isset($_SESSION['tmp_location_id_vals'])){  
			$location_id_vals = $_SESSION['tmp_location_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
		} 
		 
		if(isset($_POST['sub_location_id_vals'])){
			$sub_location_id_vals = $this->input->post('sub_location_id_vals');  
			$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals)); 
			
		}else if(isset($_SESSION['tmp_sub_location_id_vals'])){ 
			$sub_location_id_vals = $_SESSION['tmp_sub_location_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
		} 
		 
		if(isset($_POST['portal_id_vals'])){
			$portal_id_vals = $this->input->post('portal_id_vals');  
			$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals)); 
			
		}else if(isset($_SESSION['tmp_portal_id_vals'])){  
			$portal_id_vals = $_SESSION['tmp_portal_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
		}  
		 
		if(isset($_POST['assigned_to_id_vals'])){
			$assigned_to_id_vals = $this->input->post('assigned_to_id_vals');  
			$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals)); 
			
		}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){ 
			$assigned_to_id_vals = $_SESSION['tmp_assigned_to_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
		}
		
		if(isset($_POST['owner_id_vals'])){
			$owner_id_vals = $this->input->post('owner_id_vals');  
			$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals)); 
			
		}else if(isset($_SESSION['tmp_owner_id_vals'])){ 
			$owner_id_vals = $_SESSION['tmp_owner_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
		}
		
		if(isset($_POST['property_status_vals'])){
			$property_status_vals = $this->input->post('property_status_vals');  
			$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
			$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals)); 
			
		}else if(isset($_SESSION['tmp_property_status_vals'])){  ///
			$property_status_vals = $_SESSION['tmp_property_status_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
		} 
		  
		if(isset($_POST['price'])){
			$price_val = $this->input->post('price');  
			if(strlen($price_val)>0){
				$_SESSION['tmp_price_val'] = $price_val; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}else{
				unset($_SESSION['tmp_price_val']);	
			}
		}else if(isset($_SESSION['tmp_price_val'])){ ///
			$price_val = $_SESSION['tmp_price_val']; 
			$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
		}
		
		if(isset($_POST['to_price'])){
			$to_price_val = $this->input->post('to_price');  
			if(strlen($to_price_val)>0){
				$_SESSION['tmp_to_price_val'] = $to_price_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}else{
				unset($_SESSION['tmp_to_price_val']);	
			}
		}else if(isset($_SESSION['tmp_to_price_val'])){ ///
			$to_price_val = $_SESSION['tmp_to_price_val']; 
			$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
		}  
		
		if(isset($_POST['from_date'])){
			$from_date_val = $this->input->post('from_date');  
			if(strlen($from_date_val)>0){
				$_SESSION['tmp_from_date_val'] = $from_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}else{
				unset($_SESSION['tmp_from_date_val']);	
			}
		}else if(isset($_SESSION['tmp_from_date_val'])){ ///
			$from_date_val = $_SESSION['tmp_from_date_val']; 
			$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
		}
		
		if(isset($_POST['to_date'])){
			$to_date_val = $this->input->post('to_date');  
			if(strlen($to_date_val)>0){
				$_SESSION['tmp_to_date_val'] = $to_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}else{
				unset($_SESSION['tmp_to_date_val']);	
			}
		}else if(isset($_SESSION['tmp_to_date_val'])){ ///
			$to_date_val = $_SESSION['tmp_to_date_val']; 
			$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
		} 
			 
		 
			/*
			$is_property_type = 1;
			$data['sel_property_type'] = $is_property_type; 
			$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));*/
			   
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}   
			   
			//total rows count
			$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#fetch_dya_list';
			$config['base_url']    = site_url('/properties/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; // $this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit' => $show_pers_pg));
			
			$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs); 
			
			$this->load->view('properties/index2',$data); 
		 
		}else{
			$this->load->view('no_permission_access'); 
		} 
	}
	
	
	function sales_listings($args_vals=''){
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','index',$this->dbs_role_id,'1');  
		if($res_nums>0){
			$data = array();	
			$paras_arrs = array();	
			$data['page_headings'] = "Sales Listings"; 
			 
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val= $is_property_type='';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
			
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				} 
				
			if($this->input->post('s_val')){
				$s_val = $this->input->post('s_val'); 
				$_SESSION['tmp_s_val'] = $s_val; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}else if(isset($_SESSION['tmp_s_val'])){
					unset($_SESSION['tmp_s_val']);
				}   	
				
			if($this->input->post('category_id_vals')){
				$category_id_vals = $this->input->post('category_id_vals'); 
				$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
			}else if(isset($_SESSION['tmp_category_id_vals'])){
					unset($_SESSION['tmp_category_id_vals']);
				}
				
			if($this->input->post('emirate_id_vals')){
				$emirate_id_vals = $this->input->post('emirate_id_vals'); 
				$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
			}else if(isset($_SESSION['tmp_emirate_id_vals'])){
					unset($_SESSION['tmp_emirate_id_vals']);
				}
				
			if($this->input->post('location_id_vals')){
				$location_id_vals = $this->input->post('location_id_vals'); 
				$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
			}else if(isset($_SESSION['tmp_location_id_vals'])){
					unset($_SESSION['tmp_location_id_vals']);
				}  	
				
			if($this->input->post('sub_location_id_vals')){
				$sub_location_id_vals = $this->input->post('sub_location_id_vals'); 
				$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
			}else if(isset($_SESSION['tmp_sub_location_id_vals'])){
					unset($_SESSION['tmp_sub_location_id_vals']);
				}
				
			if($this->input->post('portal_id_vals')){
				$portal_id_vals = $this->input->post('portal_id_vals'); 
				$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
			}else if(isset($_SESSION['tmp_portal_id_vals'])){
					unset($_SESSION['tmp_portal_id_vals']);
				}
				
			if($this->input->post('assigned_to_id_vals')){
				$assigned_to_id_vals = $this->input->post('assigned_to_id_vals'); 
				$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
			}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){
					unset($_SESSION['tmp_assigned_to_id_vals']);
				}
				
			if($this->input->post('owner_id_vals')){
				$owner_id_vals = $this->input->post('owner_id_vals'); 
				$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
			}else if(isset($_SESSION['tmp_owner_id_vals'])){
					unset($_SESSION['tmp_owner_id_vals']);
				}
				
			if($this->input->post('property_status_vals')){
				$property_status_vals = $this->input->post('property_status_vals'); 
				$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
				$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
			}else if(isset($_SESSION['tmp_property_status_vals'])){
					unset($_SESSION['tmp_property_status_vals']);
				}
				
			if($this->input->post('price')){
				$price_val = $this->input->post('price'); 
				$_SESSION['tmp_price_val'] = $price_val; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}else if(isset($_SESSION['tmp_price_val'])){
					unset($_SESSION['tmp_price_val']);
				}
				
			if($this->input->post('to_price')){
				$to_price_val = $this->input->post('to_price'); 
				$_SESSION['tmp_to_price_val'] = $to_price_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}else if(isset($_SESSION['tmp_to_price_val'])){
					unset($_SESSION['tmp_to_price_val']);
				}	 
			
			if($this->input->post('from_date')){
				$from_date_val = $this->input->post('from_date'); 
				$_SESSION['tmp_from_date_val'] = $from_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}else if(isset($_SESSION['tmp_from_date_val'])){
					unset($_SESSION['tmp_from_date_val']);
				}
				
			if($this->input->post('to_date')){
				$to_date_val = $this->input->post('to_date'); 
				$_SESSION['tmp_to_date_val'] = $to_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}else if(isset($_SESSION['tmp_to_date_val'])){
					unset($_SESSION['tmp_to_date_val']);
				}	 
				 
			$is_property_type = 1;    /* for sale */
			$data['sel_property_type'] = $is_property_type;
			$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));
			 
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			 
			//total rows count
			$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/properties/sales_listings2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs);
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			//$data['category_arrs'] = $this->admin_model->get_all_categories();
			 
			
			if(isset($args_vals) && $args_vals=="export_excel"){
				$paras_arrs = $data = array();
				/* permission checks */
				$vs_user_type_id = $this->session->userdata('us_role_id');
				$vs_id = $this->session->userdata('us_id');
					 
				if(isset($_POST['refer_no'])){
					$refer_no_val = $this->input->post('refer_no'); 
					if(strlen($refer_no_val)>0){
						$_SESSION['tmp_refer_no'] = $refer_no_val; 
						$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
					}else{
						unset($_SESSION['tmp_refer_no']);	
					}
					
				}else if(isset($_SESSION['tmp_refer_no'])){
					$refer_no_val = $_SESSION['tmp_refer_no']; 
					$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
				} 
				
				
				if(isset($_POST['pics_nos'])){
					$pics_nos_val = $this->input->post('pics_nos'); 
					if(strlen($pics_nos_val)>0){
						$_SESSION['tmp_pics_nos'] = $pics_nos_val; 
						$paras_arrs = array_merge($paras_arrs, array("pics_nos_val" => $pics_nos_val));
					}else{
						unset($_SESSION['tmp_pics_nos']);	
					}
					
				}else if(isset($_SESSION['tmp_pics_nos'])){
					$pics_nos_val = $_SESSION['tmp_pics_nos']; 
					$paras_arrs = array_merge($paras_arrs, array("pics_nos_val" => $pics_nos_val));
				}  
				 
				if(isset($_POST['price'])){
					$price_val = $this->input->post('price');  
					if(strlen($price_val)>0){
						$_SESSION['tmp_price_val'] = $price_val; 
						$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
					}else{
						unset($_SESSION['tmp_price_val']);	
					}
				}else if(isset($_SESSION['tmp_price_val'])){ ///
					$price_val = $_SESSION['tmp_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
				} 
				
				if(isset($_POST['to_price'])){
					$to_price_val = $this->input->post('to_price');  
					if(strlen($to_price_val)>0){
						$_SESSION['tmp_to_price_val'] = $to_price_val; 
						$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
					}else{
						unset($_SESSION['tmp_to_price_val']);	
					}
				}else if(isset($_SESSION['tmp_to_price_val'])){ ///
					$to_price_val = $_SESSION['tmp_to_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
				} 
				 
				if(isset($_POST['sel_emirate_location_id_val'])){
					$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val');  
					$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val)); 
					
				}else if(isset($_SESSION['tmp_emirate_location_id_val'])){  ///
					$emirate_location_id_val = $_SESSION['tmp_emirate_location_id_val']; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
				}
						 
				$is_property_type = 1; 
			 
				if(isset($_POST['sel_no_of_beds_id_val'])){
					$no_of_beds_id_val = $this->input->post('sel_no_of_beds_id_val'); 
					$_SESSION['tmp_no_of_beds_id_val'] = $no_of_beds_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
					
				}else if(isset($_SESSION['tmp_no_of_beds_id_val'])){///
					$no_of_beds_id_val = $_SESSION['tmp_no_of_beds_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
				} 
				 
				if(isset($_POST['sel_owner_id_val'])){
					$owner_id_val = $this->input->post('sel_owner_id_val');  
					$_SESSION['tmp_owner_id_val'] = $owner_id_val;
					$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));  
					
				}else if(isset($_SESSION['tmp_owner_id_val'])){///
					$owner_id_val = $_SESSION['tmp_owner_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));
				}  
				 
				if(isset($_POST['sel_property_status_val'])){
					$property_status_val = $this->input->post('sel_property_status_val');  
					$_SESSION['tmp_property_status_val'] = $property_status_val;
					$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val)); 
					
				}else if(isset($_SESSION['tmp_property_status_val'])){ 
					$property_status_val = $_SESSION['tmp_property_status_val'];
					$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val));
				}  
				 
				if(isset($_POST['sel_assigned_to_id_val'])){
					$assigned_to_id_val = $this->input->post('sel_assigned_to_id_val');  
					$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val)); 
					
				}else if(isset($_SESSION['tmp_assigned_to_id_val'])){ ///
					$assigned_to_id_val = $_SESSION['tmp_assigned_to_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
				}  
				 
				if(isset($_POST['sel_portal_id_val'])){
					$portal_id_val = $this->input->post('sel_portal_id_val');  
					$_SESSION['tmp_portal_id_val'] = $portal_id_val;
					$paras_arrs = array_merge($paras_arrs, array("portal_id_val" => $portal_id_val)); 
					
				}else if(isset($_SESSION['tmp_portal_id_val'])){ ///
					$portal_id_val = $_SESSION['tmp_portal_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("portal_id_val" => $portal_id_val));
				}
					 
				$data['sel_property_type'] = $is_property_type;
				
				$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));
					
				$export_data_arrs = $this->properties_model->get_all_cstm_quick_properties($paras_arrs);
				  
				$dataToExports = []; 	 
				if(isset($export_data_arrs) && count($export_data_arrs)>0){
					foreach($export_data_arrs as $export_data_arr){ 
						$temp_arr = array();  
						
						$temp_arr['Ref No'] = stripslashes($export_data_arr->ref_no); 
						$temp_arr['Sub Location'] = stripslashes($export_data_arr->sub_loc_name); 
						$temp_arr['Bedrooms'] = stripslashes($export_data_arr->bed_title); 
						$temp_arr['Owner'] = stripslashes($export_data_arr->ownr_name).' ( '.$export_data_arr->ownr_phone_no.' )';
						$temp_arr['Price'] = number_format($export_data_arr->price,0,".",",");
						$temp_arr['Status'] = $this->general_model->get_gen_property_status($export_data_arr->property_status);
						 
						$us_nm ='';
						if($export_data_arr->assigned_to_id>0){
							$usr_arr =  $this->general_model->get_user_info_by_id($export_data_arr->assigned_to_id);
							$us_nm = stripslashes($usr_arr->name);
						}
						
						$temp_arr['Assigned To'] = $us_nm;  
					
						$dataToExports[] = $temp_arr;
					}
				}    
					
				// set header
				$filename = "CRM-Sale-Properties-".date('d-M-Y H:i:s').".xls";
				
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				$this->general_model->exportExcelData($dataToExports);
			  
		}else{
			
				/* for dropzone temp storage unset starts */ 
				if(isset($_SESSION['Temp_Media_Images'])){
		
					$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_photos();
					if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
						foreach($db_docs_arrs as $db_docs_arr){
							 $tmp_fle_name = $db_docs_arr->image; 
							 $tmp_proprty_id = $db_docs_arr->property_id; 
							 $tmp_ip_address = $db_docs_arr->ip_address; 
							 $tmp_dt_time = $db_docs_arr->datatimes; 
							
							 if(strlen($tmp_fle_name)>0){
								unlink("downloads/property_photos/{$tmp_fle_name}");
							 }
							 
							 $this->properties_model->delete_temp_property_dropzone_photos($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
							 
						} 
					}  
				
					unset($_SESSION['Temp_Media_Images']);
					unset($_SESSION['Temp_IP_Address']);
					unset($_SESSION['Temp_DATE_Times']);  
				}  
				
				if(isset($_SESSION['Temp_Documents_Files'])){
					
					$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_documents(); 
					if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
						foreach($db_docs_arrs as $db_docs_arr){
							$tmp_fle_name = $db_docs_arr->name; 
							$tmp_proprty_id = $db_docs_arr->property_id; 
							$tmp_ip_address = $db_docs_arr->ip_address; 
							$tmp_dt_time = $db_docs_arr->datatimes; 
							
							if(strlen($tmp_fle_name)>0){
								unlink("downloads/property_documents/{$tmp_fle_name}");
							}
							
							$this->properties_model->delete_temp_property_dropzone_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
							
						} 
					}
					 
					unset($_SESSION['Temp_Documents_Files']);
					unset($_SESSION['Temp_Documents_IP_Address']);
					unset($_SESSION['Temp_Documents_DATE_Times']);  
				} 
				
				if(isset($_SESSION['Temp_NT_IP_Address'])){ 
					$tmp_proprty_id = -1;
					$tmp_ip_address = $_SESSION['Temp_NT_IP_Address']; 
					$tmp_dt_time = $_SESSION['Temp_NT_DATE_Times']; 
					 
					$this->properties_model->delete_temp_property_notes($tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
					   
					unset($_SESSION['Temp_NT_IP_Address']);
					unset($_SESSION['Temp_NT_DATE_Times']); 
				}  
				/* for dropzone temp storage unset end */  
				
				$this->load->view('properties/sales_listings',$data); 
			
			}
			  
		}else{
			$this->load->view('no_permission_access'); 
		} 
	}

			 
	function sales_listings2($temps_property_type=''){  
	
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','index',$this->dbs_role_id,'1'); 
		 
		if($res_nums>0){		
			
		$paras_arrs = $data = array();	
		$page = $this->input->post('page');
		if(!$page){
			$offset = 0;
		}else{
			$offset = $page;
		} 
		
		$data['page'] = $page;
		
		/* permission checks */
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		/*$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val= $is_property_type='';
		$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';*/
	
		if($this->input->post('sel_per_page_val')){
			$per_page_val = $this->input->post('sel_per_page_val'); 
			$_SESSION['tmp_per_page_val'] = $per_page_val;  
			
		}else if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];
			}  
		 
		if(isset($_POST['s_val'])){
			$s_val = $this->input->post('s_val'); 
			if(strlen($s_val)>0){
				$_SESSION['tmp_s_val'] = $s_val; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}else{
				unset($_SESSION['tmp_s_val']);	
			}
			
		}else if(isset($_SESSION['tmp_s_val'])){
			$s_val = $_SESSION['tmp_s_val']; 
			$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
		}       
		 
		if(isset($_POST['category_id_vals'])){
			$category_id_vals = $this->input->post('category_id_vals');  
			$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals)); 
			
		}else if(isset($_SESSION['tmp_category_id_vals'])){   
			$category_id_vals = $_SESSION['tmp_category_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
		}  
		
		if(isset($_POST['emirate_id_vals'])){
			$emirate_id_vals = $this->input->post('emirate_id_vals');  
			$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals)); 
			
		}else if(isset($_SESSION['tmp_emirate_id_vals'])){  
			$emirate_id_vals = $_SESSION['tmp_emirate_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
		}  
		
		if(isset($_POST['location_id_vals'])){
			$location_id_vals = $this->input->post('location_id_vals');  
			$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals)); 
			
		}else if(isset($_SESSION['tmp_location_id_vals'])){  
			$location_id_vals = $_SESSION['tmp_location_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
		} 
		 
		if(isset($_POST['sub_location_id_vals'])){
			$sub_location_id_vals = $this->input->post('sub_location_id_vals');  
			$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals)); 
			
		}else if(isset($_SESSION['tmp_sub_location_id_vals'])){ 
			$sub_location_id_vals = $_SESSION['tmp_sub_location_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
		} 
		 
		if(isset($_POST['portal_id_vals'])){
			$portal_id_vals = $this->input->post('portal_id_vals');  
			$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals)); 
			
		}else if(isset($_SESSION['tmp_portal_id_vals'])){  
			$portal_id_vals = $_SESSION['tmp_portal_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
		}  
		 
		if(isset($_POST['assigned_to_id_vals'])){
			$assigned_to_id_vals = $this->input->post('assigned_to_id_vals');  
			$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals)); 
			
		}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){ 
			$assigned_to_id_vals = $_SESSION['tmp_assigned_to_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
		}
		
		if(isset($_POST['owner_id_vals'])){
			$owner_id_vals = $this->input->post('owner_id_vals');  
			$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals)); 
			
		}else if(isset($_SESSION['tmp_owner_id_vals'])){ 
			$owner_id_vals = $_SESSION['tmp_owner_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
		}
		
		if(isset($_POST['property_status_vals'])){
			$property_status_vals = $this->input->post('property_status_vals');  
			$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
			$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals)); 
			
		}else if(isset($_SESSION['tmp_property_status_vals'])){  ///
			$property_status_vals = $_SESSION['tmp_property_status_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
		} 
		  
		if(isset($_POST['price'])){
			$price_val = $this->input->post('price');  
			if(strlen($price_val)>0){
				$_SESSION['tmp_price_val'] = $price_val; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}else{
				unset($_SESSION['tmp_price_val']);	
			}
		}else if(isset($_SESSION['tmp_price_val'])){ ///
			$price_val = $_SESSION['tmp_price_val']; 
			$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
		}
		
		if(isset($_POST['to_price'])){
			$to_price_val = $this->input->post('to_price');  
			if(strlen($to_price_val)>0){
				$_SESSION['tmp_to_price_val'] = $to_price_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}else{
				unset($_SESSION['tmp_to_price_val']);	
			}
		}else if(isset($_SESSION['tmp_to_price_val'])){ ///
			$to_price_val = $_SESSION['tmp_to_price_val']; 
			$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
		}  
		
		if(isset($_POST['from_date'])){
			$from_date_val = $this->input->post('from_date');  
			if(strlen($from_date_val)>0){
				$_SESSION['tmp_from_date_val'] = $from_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}else{
				unset($_SESSION['tmp_from_date_val']);	
			}
		}else if(isset($_SESSION['tmp_from_date_val'])){ ///
			$from_date_val = $_SESSION['tmp_from_date_val']; 
			$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
		}
		
		if(isset($_POST['to_date'])){
			$to_date_val = $this->input->post('to_date');  
			if(strlen($to_date_val)>0){
				$_SESSION['tmp_to_date_val'] = $to_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}else{
				unset($_SESSION['tmp_to_date_val']);	
			}
		}else if(isset($_SESSION['tmp_to_date_val'])){ ///
			$to_date_val = $_SESSION['tmp_to_date_val']; 
			$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
		}   
			
			$is_property_type = 1;    /* for sale */
			$data['sel_property_type'] = $is_property_type;
			$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));
			   
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}   
			   
			//total rows count
			$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/properties/sales_listings2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; // $this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit' => $show_pers_pg));
			
			$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs); 
			
			$this->load->view('properties/sales_listings2',$data);  
		 
		}else{
			$this->load->view('no_permission_access'); 
		} 
	}
	
	
	
	 function rent_listings($args_vals=''){
		$res_nums = $this->general_model->check_controller_method_permission_access('Properties','index',$this->dbs_role_id,'1');  
		if($res_nums>0){
			$data = array();	
			$paras_arrs = array();	
			$data['page_headings'] = "Rental Listings"; 
			 
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val='';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
			
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				} 
				
			if($this->input->post('s_val')){
				$s_val = $this->input->post('s_val'); 
				$_SESSION['tmp_s_val'] = $s_val; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}else if(isset($_SESSION['tmp_s_val'])){
					unset($_SESSION['tmp_s_val']);
				}   	
				
			if($this->input->post('category_id_vals')){
				$category_id_vals = $this->input->post('category_id_vals'); 
				$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
			}else if(isset($_SESSION['tmp_category_id_vals'])){
					unset($_SESSION['tmp_category_id_vals']);
				}
				
			if($this->input->post('emirate_id_vals')){
				$emirate_id_vals = $this->input->post('emirate_id_vals'); 
				$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
			}else if(isset($_SESSION['tmp_emirate_id_vals'])){
					unset($_SESSION['tmp_emirate_id_vals']);
				}
				
			if($this->input->post('location_id_vals')){
				$location_id_vals = $this->input->post('location_id_vals'); 
				$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
			}else if(isset($_SESSION['tmp_location_id_vals'])){
					unset($_SESSION['tmp_location_id_vals']);
				}  	
				
			if($this->input->post('sub_location_id_vals')){
				$sub_location_id_vals = $this->input->post('sub_location_id_vals'); 
				$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
			}else if(isset($_SESSION['tmp_sub_location_id_vals'])){
					unset($_SESSION['tmp_sub_location_id_vals']);
				}
				
			if($this->input->post('portal_id_vals')){
				$portal_id_vals = $this->input->post('portal_id_vals'); 
				$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
			}else if(isset($_SESSION['tmp_portal_id_vals'])){
					unset($_SESSION['tmp_portal_id_vals']);
				}
				
			if($this->input->post('assigned_to_id_vals')){
				$assigned_to_id_vals = $this->input->post('assigned_to_id_vals'); 
				$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
			}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){
					unset($_SESSION['tmp_assigned_to_id_vals']);
				}
				
			if($this->input->post('owner_id_vals')){
				$owner_id_vals = $this->input->post('owner_id_vals'); 
				$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
			}else if(isset($_SESSION['tmp_owner_id_vals'])){
					unset($_SESSION['tmp_owner_id_vals']);
				}
				
			if($this->input->post('property_status_vals')){
				$property_status_vals = $this->input->post('property_status_vals'); 
				$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
				$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
			}else if(isset($_SESSION['tmp_property_status_vals'])){
					unset($_SESSION['tmp_property_status_vals']);
				}
				
			if($this->input->post('price')){
				$price_val = $this->input->post('price'); 
				$_SESSION['tmp_price_val'] = $price_val; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}else if(isset($_SESSION['tmp_price_val'])){
					unset($_SESSION['tmp_price_val']);
				}
				
			if($this->input->post('to_price')){
				$to_price_val = $this->input->post('to_price'); 
				$_SESSION['tmp_to_price_val'] = $to_price_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}else if(isset($_SESSION['tmp_to_price_val'])){
					unset($_SESSION['tmp_to_price_val']);
				}	 
			
			if($this->input->post('from_date')){
				$from_date_val = $this->input->post('from_date'); 
				$_SESSION['tmp_from_date_val'] = $from_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}else if(isset($_SESSION['tmp_from_date_val'])){
					unset($_SESSION['tmp_from_date_val']);
				}
				
			if($this->input->post('to_date')){
				$to_date_val = $this->input->post('to_date'); 
				$_SESSION['tmp_to_date_val'] = $to_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}else if(isset($_SESSION['tmp_to_date_val'])){
					unset($_SESSION['tmp_to_date_val']);
				}	 
				 
			$is_property_type = 2;    /* for rental */
			$data['sel_property_type'] = $is_property_type;
			$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));
			 
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			 
			//total rows count
			$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/properties/rent_listings2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs);
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			//$data['category_arrs'] = $this->admin_model->get_all_categories();
			 
			
			if(isset($args_vals) && $args_vals=="export_excel"){   
				$paras_arrs = $data='';
				$dataToExports = [];  
				$paras_arrs = $data = array();	 
				
				/* permission checks */
				$vs_user_type_id = $this->session->userdata('us_role_id');
				$vs_id = $this->session->userdata('us_id'); 
				  
				if($this->input->post('sel_per_page_val')){
					$per_page_val = $this->input->post('sel_per_page_val'); 
					$_SESSION['tmp_per_page_val'] = $per_page_val;  
					
				}else if(isset($_SESSION['tmp_per_page_val'])){
						$per_page_val = $_SESSION['tmp_per_page_val'];
					}
				   
				if(isset($_POST['refer_no'])){
					$refer_no_val = $this->input->post('refer_no'); 
					if(strlen($refer_no_val)>0){
						$_SESSION['tmp_refer_no'] = $refer_no_val; 
						$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
					}else{
						unset($_SESSION['tmp_refer_no']);	
					}
					
				}else if(isset($_SESSION['tmp_refer_no'])){
					$refer_no_val = $_SESSION['tmp_refer_no']; 
					$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
				}
				
				if(isset($_POST['pics_nos'])){
					$pics_nos_val = $this->input->post('pics_nos'); 
					if(strlen($pics_nos_val)>0){
						$_SESSION['tmp_pics_nos'] = $pics_nos_val; 
						$paras_arrs = array_merge($paras_arrs, array("pics_nos_val" => $pics_nos_val));
					}else{
						unset($_SESSION['tmp_pics_nos']);	
					}
					
				}else if(isset($_SESSION['tmp_pics_nos'])){
					$pics_nos_val = $_SESSION['tmp_pics_nos']; 
					$paras_arrs = array_merge($paras_arrs, array("pics_nos_val" => $pics_nos_val));
				}
				
				 
				if(isset($_POST['price'])){
					$price_val = $this->input->post('price');  
					if(strlen($price_val)>0){
						$_SESSION['tmp_price_val'] = $price_val; 
						$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
					}else{
						unset($_SESSION['tmp_price_val']);	
					}
				}else if(isset($_SESSION['tmp_price_val'])){ ///
					$price_val = $_SESSION['tmp_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
				}
				
				if(isset($_POST['to_price'])){
					$to_price_val = $this->input->post('to_price');  
					if(strlen($to_price_val)>0){
						$_SESSION['tmp_to_price_val'] = $to_price_val; 
						$paras_arrs = array_merge($paras_arrs,array("to_price_val" => $to_price_val));
					}else{
						unset($_SESSION['tmp_to_price_val']);	
					}
				}else if(isset($_SESSION['tmp_to_price_val'])){ ///
					$to_price_val = $_SESSION['tmp_to_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
				} 
						
				
				if(isset($_POST['sel_emirate_location_id_val'])){
					$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val');  
					$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val)); 
					
				}else if(isset($_SESSION['tmp_emirate_location_id_val'])){  ///
					$emirate_location_id_val = $_SESSION['tmp_emirate_location_id_val']; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
				}
						 
				$is_property_type = 2; 
				
				if(isset($_POST['sel_no_of_beds_id_val'])){
					$no_of_beds_id_val = $this->input->post('sel_no_of_beds_id_val'); 
					$_SESSION['tmp_no_of_beds_id_val'] = $no_of_beds_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
					
				}else if(isset($_SESSION['tmp_no_of_beds_id_val'])){///
					$no_of_beds_id_val = $_SESSION['tmp_no_of_beds_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
				} 
				 
				if(isset($_POST['sel_owner_id_val'])){
					$owner_id_val = $this->input->post('sel_owner_id_val');  
					$_SESSION['tmp_owner_id_val'] = $owner_id_val;
					$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));  
					
				}else if(isset($_SESSION['tmp_owner_id_val'])){///
					$owner_id_val = $_SESSION['tmp_owner_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));
				}  
					 
				if(isset($_POST['sel_property_status_val'])){
					$property_status_val = $this->input->post('sel_property_status_val');  
					$_SESSION['tmp_property_status_val'] = $property_status_val;
					$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val)); 
					
				}else if(isset($_SESSION['tmp_property_status_val'])){ 
					$property_status_val = $_SESSION['tmp_property_status_val'];
					$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val));
				}  
					 
				if(isset($_POST['sel_assigned_to_id_val'])){
					$assigned_to_id_val = $this->input->post('sel_assigned_to_id_val');  
					$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val)); 
					
				}else if(isset($_SESSION['tmp_assigned_to_id_val'])){ ///
					$assigned_to_id_val = $_SESSION['tmp_assigned_to_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
				}  
				
				if(isset($_POST['sel_portal_id_val'])){
					$portal_id_val = $this->input->post('sel_portal_id_val');  
					$_SESSION['tmp_portal_id_val'] = $portal_id_val;
					$paras_arrs = array_merge($paras_arrs, array("portal_id_val" => $portal_id_val)); 
					
				}else if(isset($_SESSION['tmp_portal_id_val'])){ ///
					$portal_id_val = $_SESSION['tmp_portal_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("portal_id_val" => $portal_id_val));
				}
					 
				$data['sel_property_type'] = $is_property_type;
				
				$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type)); 
				 
				$export_data_arrs = $this->properties_model->get_all_cstm_quick_properties($paras_arrs);
				
				if(isset($export_data_arrs) && count($export_data_arrs)>0){
				foreach($export_data_arrs as $export_data_arr){ 
				$temp_arr = array();  
				
				$temp_arr['Ref No'] = stripslashes($export_data_arr->ref_no); 
				$temp_arr['Sub Location'] = stripslashes($export_data_arr->sub_loc_name); 
				$temp_arr['Bedrooms'] = stripslashes($export_data_arr->bed_title); 
				$temp_arr['Owner'] = stripslashes($export_data_arr->ownr_name).' ( '.$export_data_arr->ownr_phone_no.' )';
				$temp_arr['Price'] = number_format($export_data_arr->price,0,".",",");
				$temp_arr['Status'] = $this->general_model->get_gen_property_status($export_data_arr->property_status);
				 
				$us_nm ='';
				if($export_data_arr->assigned_to_id>0){
					$usr_arr =  $this->general_model->get_user_info_by_id($export_data_arr->assigned_to_id);
					$us_nm = stripslashes($usr_arr->name);
				}
				
				$temp_arr['Assigned To'] = $us_nm;   
				$dataToExports[] = $temp_arr;
				
				}
			}   
			
			// set header
			$filename = "CRM-Rent-Properties-".date('d-M-Y H:i:s').".xls";
			
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			$this->general_model->exportExcelData($dataToExports);  
			 
		}else{
		
			/* for dropzone temp storage unset starts */ 
			if(isset($_SESSION['Temp_Media_Images'])){
	
				$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_photos();
				if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
					foreach($db_docs_arrs as $db_docs_arr){
						 $tmp_fle_name = $db_docs_arr->image; 
						 $tmp_proprty_id = $db_docs_arr->property_id; 
						 $tmp_ip_address = $db_docs_arr->ip_address; 
						 $tmp_dt_time = $db_docs_arr->datatimes; 
						
						 if(strlen($tmp_fle_name)>0){
							unlink("downloads/property_photos/{$tmp_fle_name}");
						 }
						 
						 $this->properties_model->delete_temp_property_dropzone_photos($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
						 
					} 
				}  
			
				unset($_SESSION['Temp_Media_Images']);
				unset($_SESSION['Temp_IP_Address']);
				unset($_SESSION['Temp_DATE_Times']);  
			}  
			
			if(isset($_SESSION['Temp_Documents_Files'])){
				
				$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_documents(); 
				if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
					foreach($db_docs_arrs as $db_docs_arr){
						$tmp_fle_name = $db_docs_arr->name; 
						$tmp_proprty_id = $db_docs_arr->property_id; 
						$tmp_ip_address = $db_docs_arr->ip_address; 
						$tmp_dt_time = $db_docs_arr->datatimes; 
						
						if(strlen($tmp_fle_name)>0){
							unlink("downloads/property_documents/{$tmp_fle_name}");
						}
						
						$this->properties_model->delete_temp_property_dropzone_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
						
					} 
				}
				 
				unset($_SESSION['Temp_Documents_Files']);
				unset($_SESSION['Temp_Documents_IP_Address']);
				unset($_SESSION['Temp_Documents_DATE_Times']);  
			} 
			
			if(isset($_SESSION['Temp_NT_IP_Address'])){ 
				$tmp_proprty_id = -1;
				$tmp_ip_address = $_SESSION['Temp_NT_IP_Address']; 
				$tmp_dt_time = $_SESSION['Temp_NT_DATE_Times']; 
				 
				$this->properties_model->delete_temp_property_notes($tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
				   
				unset($_SESSION['Temp_NT_IP_Address']);
				unset($_SESSION['Temp_NT_DATE_Times']); 
			}  
			/* for dropzone temp storage unset end */  
			
			$this->load->view('properties/rent_listings',$data); 
		
		}
			  
		}else{
			$this->load->view('no_permission_access'); 
		} 
	}

			 
	function rent_listings2($temps_property_type=''){  
	
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties', 'index', $this->dbs_role_id,'1'); 
		 
		if($res_nums>0){		
			
		$paras_arrs = $data = array();	
		$page = $this->input->post('page');
		if(!$page){
			$offset = 0;
		}else{
			$offset = $page;
		} 
		
		$data['page'] = $page;
		
		/* permission checks */
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		/*$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val='';
		$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';*/
	
		if($this->input->post('sel_per_page_val')){
			$per_page_val = $this->input->post('sel_per_page_val'); 
			$_SESSION['tmp_per_page_val'] = $per_page_val;  
			
		}else if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];
			}  
		 
		if(isset($_POST['s_val'])){
			$s_val = $this->input->post('s_val'); 
			if(strlen($s_val)>0){
				$_SESSION['tmp_s_val'] = $s_val; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}else{
				unset($_SESSION['tmp_s_val']);	
			}
			
		}else if(isset($_SESSION['tmp_s_val'])){
			$s_val = $_SESSION['tmp_s_val']; 
			$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
		}       
		 
		if(isset($_POST['category_id_vals'])){
			$category_id_vals = $this->input->post('category_id_vals');  
			$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals)); 
			
		}else if(isset($_SESSION['tmp_category_id_vals'])){   
			$category_id_vals = $_SESSION['tmp_category_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
		}  
		
		if(isset($_POST['emirate_id_vals'])){
			$emirate_id_vals = $this->input->post('emirate_id_vals');  
			$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals)); 
			
		}else if(isset($_SESSION['tmp_emirate_id_vals'])){  
			$emirate_id_vals = $_SESSION['tmp_emirate_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
		}  
		
		if(isset($_POST['location_id_vals'])){
			$location_id_vals = $this->input->post('location_id_vals');  
			$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals)); 
			
		}else if(isset($_SESSION['tmp_location_id_vals'])){  
			$location_id_vals = $_SESSION['tmp_location_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
		} 
		 
		if(isset($_POST['sub_location_id_vals'])){
			$sub_location_id_vals = $this->input->post('sub_location_id_vals');  
			$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals)); 
			
		}else if(isset($_SESSION['tmp_sub_location_id_vals'])){ 
			$sub_location_id_vals = $_SESSION['tmp_sub_location_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
		} 
		 
		if(isset($_POST['portal_id_vals'])){
			$portal_id_vals = $this->input->post('portal_id_vals');  
			$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals)); 
			
		}else if(isset($_SESSION['tmp_portal_id_vals'])){  
			$portal_id_vals = $_SESSION['tmp_portal_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
		}  
		 
		if(isset($_POST['assigned_to_id_vals'])){
			$assigned_to_id_vals = $this->input->post('assigned_to_id_vals');  
			$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals)); 
			
		}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){ 
			$assigned_to_id_vals = $_SESSION['tmp_assigned_to_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
		}
		
		if(isset($_POST['owner_id_vals'])){
			$owner_id_vals = $this->input->post('owner_id_vals');  
			$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
			$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals)); 
			
		}else if(isset($_SESSION['tmp_owner_id_vals'])){ 
			$owner_id_vals = $_SESSION['tmp_owner_id_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
		}
		
		if(isset($_POST['property_status_vals'])){
			$property_status_vals = $this->input->post('property_status_vals');  
			$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
			$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals)); 
			
		}else if(isset($_SESSION['tmp_property_status_vals'])){  ///
			$property_status_vals = $_SESSION['tmp_property_status_vals']; 
			$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
		} 
		  
		if(isset($_POST['price'])){
			$price_val = $this->input->post('price');  
			if(strlen($price_val)>0){
				$_SESSION['tmp_price_val'] = $price_val; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}else{
				unset($_SESSION['tmp_price_val']);	
			}
		}else if(isset($_SESSION['tmp_price_val'])){ ///
			$price_val = $_SESSION['tmp_price_val']; 
			$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
		}
		
		if(isset($_POST['to_price'])){
			$to_price_val = $this->input->post('to_price');  
			if(strlen($to_price_val)>0){
				$_SESSION['tmp_to_price_val'] = $to_price_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}else{
				unset($_SESSION['tmp_to_price_val']);	
			}
		}else if(isset($_SESSION['tmp_to_price_val'])){ ///
			$to_price_val = $_SESSION['tmp_to_price_val']; 
			$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
		}  
		
		if(isset($_POST['from_date'])){
			$from_date_val = $this->input->post('from_date');  
			if(strlen($from_date_val)>0){
				$_SESSION['tmp_from_date_val'] = $from_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}else{
				unset($_SESSION['tmp_from_date_val']);	
			}
		}else if(isset($_SESSION['tmp_from_date_val'])){ ///
			$from_date_val = $_SESSION['tmp_from_date_val']; 
			$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
		}
		
		if(isset($_POST['to_date'])){
			$to_date_val = $this->input->post('to_date');  
			if(strlen($to_date_val)>0){
				$_SESSION['tmp_to_date_val'] = $to_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}else{
				unset($_SESSION['tmp_to_date_val']);	
			}
		}else if(isset($_SESSION['tmp_to_date_val'])){ ///
			$to_date_val = $_SESSION['tmp_to_date_val']; 
			$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
		}   
			
			$is_property_type = 2;    /* for rental */
			$data['sel_property_type'] = $is_property_type;
			$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));
			   
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}   
			   
			//total rows count
			$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/properties/rent_listings2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; // $this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit' => $show_pers_pg));
			
			$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs); 
			
			$this->load->view('properties/rent_listings2',$data);  
		 
		}else{
			$this->load->view('no_permission_access'); 
		} 
	}
	
	
	function archived_listings($args_vals=''){
		$res_nums = $this->general_model->check_controller_method_permission_access('Properties','index',$this->dbs_role_id,'1');  
		if($res_nums>0){
			$data = array();	
			$paras_arrs = array();	
			$data['page_headings'] = "Archived Listings"; 
			 
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			$s_val = $category_id_val = $assigned_to_id_val = $is_featured_val = '';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
			
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				} 
				
			if($this->input->post('s_val')){
				$s_val = $this->input->post('s_val'); 
				$_SESSION['tmp_s_val'] = $s_val; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}else if(isset($_SESSION['tmp_s_val'])){
					unset($_SESSION['tmp_s_val']);
				}   	
				
			if($this->input->post('category_id_vals')){
				$category_id_vals = $this->input->post('category_id_vals'); 
				$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
			}else if(isset($_SESSION['tmp_category_id_vals'])){
					unset($_SESSION['tmp_category_id_vals']);
				}
				
			if($this->input->post('emirate_id_vals')){
				$emirate_id_vals = $this->input->post('emirate_id_vals'); 
				$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
			}else if(isset($_SESSION['tmp_emirate_id_vals'])){
					unset($_SESSION['tmp_emirate_id_vals']);
				}
				
			if($this->input->post('location_id_vals')){
				$location_id_vals = $this->input->post('location_id_vals'); 
				$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
			}else if(isset($_SESSION['tmp_location_id_vals'])){
					unset($_SESSION['tmp_location_id_vals']);
				}  	
				
			if($this->input->post('sub_location_id_vals')){
				$sub_location_id_vals = $this->input->post('sub_location_id_vals'); 
				$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
			}else if(isset($_SESSION['tmp_sub_location_id_vals'])){
					unset($_SESSION['tmp_sub_location_id_vals']);
				}
				
			if($this->input->post('portal_id_vals')){
				$portal_id_vals = $this->input->post('portal_id_vals'); 
				$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
			}else if(isset($_SESSION['tmp_portal_id_vals'])){
					unset($_SESSION['tmp_portal_id_vals']);
				}
				
			if($this->input->post('assigned_to_id_vals')){
				$assigned_to_id_vals = $this->input->post('assigned_to_id_vals'); 
				$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
			}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){
					unset($_SESSION['tmp_assigned_to_id_vals']);
				}
				
			if($this->input->post('owner_id_vals')){
				$owner_id_vals = $this->input->post('owner_id_vals'); 
				$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
			}else if(isset($_SESSION['tmp_owner_id_vals'])){
					unset($_SESSION['tmp_owner_id_vals']);
				}
				
			if($this->input->post('property_status_vals')){
				$property_status_vals = $this->input->post('property_status_vals'); 
				$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
				$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
			}else if(isset($_SESSION['tmp_property_status_vals'])){
					unset($_SESSION['tmp_property_status_vals']);
				}
				
			if($this->input->post('price')){
				$price_val = $this->input->post('price'); 
				$_SESSION['tmp_price_val'] = $price_val; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}else if(isset($_SESSION['tmp_price_val'])){
					unset($_SESSION['tmp_price_val']);
				}
				
			if($this->input->post('to_price')){
				$to_price_val = $this->input->post('to_price'); 
				$_SESSION['tmp_to_price_val'] = $to_price_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}else if(isset($_SESSION['tmp_to_price_val'])){
					unset($_SESSION['tmp_to_price_val']);
				}	 
			
			if($this->input->post('from_date')){
				$from_date_val = $this->input->post('from_date'); 
				$_SESSION['tmp_from_date_val'] = $from_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}else if(isset($_SESSION['tmp_from_date_val'])){
					unset($_SESSION['tmp_from_date_val']);
				}
				
			if($this->input->post('to_date')){
				$to_date_val = $this->input->post('to_date'); 
				$_SESSION['tmp_to_date_val'] = $to_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}else if(isset($_SESSION['tmp_to_date_val'])){
					unset($_SESSION['tmp_to_date_val']);
				}	 
			
			/* for rental */	 
			/*$is_property_type = 2;    
			$data['sel_property_type'] = $is_property_type;
			$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));*/
			 
			$paras_arrs = array_merge($paras_arrs, array("is_archived" => '1'));
			  
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			 
			//total rows count
			$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/properties/archived_listings2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs);
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			//$data['category_arrs'] = $this->admin_model->get_all_categories();
			 
			if(isset($args_vals) && $args_vals=="export_excel"){   
				$paras_arrs = $data='';
				$dataToExports = [];  
				$paras_arrs = $data = array();	 
				
				/* permission checks */
				$vs_user_type_id = $this->session->userdata('us_role_id');
				$vs_id = $this->session->userdata('us_id'); 
				  
				if($this->input->post('sel_per_page_val')){
					$per_page_val = $this->input->post('sel_per_page_val'); 
					$_SESSION['tmp_per_page_val'] = $per_page_val;  
					
				}else if(isset($_SESSION['tmp_per_page_val'])){
						$per_page_val = $_SESSION['tmp_per_page_val'];
					}
				   
				if(isset($_POST['refer_no'])){
					$refer_no_val = $this->input->post('refer_no'); 
					if(strlen($refer_no_val)>0){
						$_SESSION['tmp_refer_no'] = $refer_no_val; 
						$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
					}else{
						unset($_SESSION['tmp_refer_no']);	
					}
					
				}else if(isset($_SESSION['tmp_refer_no'])){
					$refer_no_val = $_SESSION['tmp_refer_no']; 
					$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
				}
				
				if(isset($_POST['pics_nos'])){
					$pics_nos_val = $this->input->post('pics_nos'); 
					if(strlen($pics_nos_val)>0){
						$_SESSION['tmp_pics_nos'] = $pics_nos_val; 
						$paras_arrs = array_merge($paras_arrs, array("pics_nos_val" => $pics_nos_val));
					}else{
						unset($_SESSION['tmp_pics_nos']);	
					}
					
				}else if(isset($_SESSION['tmp_pics_nos'])){
					$pics_nos_val = $_SESSION['tmp_pics_nos']; 
					$paras_arrs = array_merge($paras_arrs, array("pics_nos_val" => $pics_nos_val));
				}
				
				 
				if(isset($_POST['price'])){
					$price_val = $this->input->post('price');  
					if(strlen($price_val)>0){
						$_SESSION['tmp_price_val'] = $price_val; 
						$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
					}else{
						unset($_SESSION['tmp_price_val']);	
					}
				}else if(isset($_SESSION['tmp_price_val'])){ ///
					$price_val = $_SESSION['tmp_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
				}
				
				if(isset($_POST['to_price'])){
					$to_price_val = $this->input->post('to_price');  
					if(strlen($to_price_val)>0){
						$_SESSION['tmp_to_price_val'] = $to_price_val; 
						$paras_arrs = array_merge($paras_arrs,array("to_price_val" => $to_price_val));
					}else{
						unset($_SESSION['tmp_to_price_val']);	
					}
				}else if(isset($_SESSION['tmp_to_price_val'])){ ///
					$to_price_val = $_SESSION['tmp_to_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
				}
				
				if(isset($_POST['sel_emirate_location_id_val'])){
					$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val');  
					$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val)); 
					
				}else if(isset($_SESSION['tmp_emirate_location_id_val'])){  ///
					$emirate_location_id_val = $_SESSION['tmp_emirate_location_id_val']; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
				} 
				
				if(isset($_POST['sel_no_of_beds_id_val'])){
					$no_of_beds_id_val = $this->input->post('sel_no_of_beds_id_val'); 
					$_SESSION['tmp_no_of_beds_id_val'] = $no_of_beds_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
					
				}else if(isset($_SESSION['tmp_no_of_beds_id_val'])){///
					$no_of_beds_id_val = $_SESSION['tmp_no_of_beds_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
				} 
				 
				if(isset($_POST['sel_owner_id_val'])){
					$owner_id_val = $this->input->post('sel_owner_id_val');  
					$_SESSION['tmp_owner_id_val'] = $owner_id_val;
					$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));  
					
				}else if(isset($_SESSION['tmp_owner_id_val'])){///
					$owner_id_val = $_SESSION['tmp_owner_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));
				}  
					 
				if(isset($_POST['sel_property_status_val'])){
					$property_status_val = $this->input->post('sel_property_status_val');  
					$_SESSION['tmp_property_status_val'] = $property_status_val;
					$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val)); 
					
				}else if(isset($_SESSION['tmp_property_status_val'])){ 
					$property_status_val = $_SESSION['tmp_property_status_val'];
					$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val));
				}  
					 
				if(isset($_POST['sel_assigned_to_id_val'])){
					$assigned_to_id_val = $this->input->post('sel_assigned_to_id_val');  
					$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val)); 
					
				}else if(isset($_SESSION['tmp_assigned_to_id_val'])){ ///
					$assigned_to_id_val = $_SESSION['tmp_assigned_to_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
				}  
				
				if(isset($_POST['sel_portal_id_val'])){
					$portal_id_val = $this->input->post('sel_portal_id_val');  
					$_SESSION['tmp_portal_id_val'] = $portal_id_val;
					$paras_arrs = array_merge($paras_arrs, array("portal_id_val" => $portal_id_val)); 
					
				}else if(isset($_SESSION['tmp_portal_id_val'])){ ///
					$portal_id_val = $_SESSION['tmp_portal_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("portal_id_val" => $portal_id_val));
				}
			
				/*$is_property_type = 2; 		 
				$data['sel_property_type'] = $is_property_type; 
				$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type)); */
				$paras_arrs = array_merge($paras_arrs, array("is_archived" => '1'));
				 
				$export_data_arrs = $this->properties_model->get_all_cstm_quick_properties($paras_arrs);
				
				if(isset($export_data_arrs) && count($export_data_arrs)>0){
				foreach($export_data_arrs as $export_data_arr){ 
				$temp_arr = array();  
				
				$temp_arr['Ref No'] = stripslashes($export_data_arr->ref_no); 
				$temp_arr['Sub Location'] = stripslashes($export_data_arr->sub_loc_name); 
				$temp_arr['Bedrooms'] = stripslashes($export_data_arr->bed_title); 
				$temp_arr['Owner'] = stripslashes($export_data_arr->ownr_name).' ( '.$export_data_arr->ownr_phone_no.' )';
				$temp_arr['Price'] = number_format($export_data_arr->price,0,".",",");
				$temp_arr['Status'] = $this->general_model->get_gen_property_status($export_data_arr->property_status);
				 
				$us_nm ='';
				if($export_data_arr->assigned_to_id>0){
					$usr_arr =  $this->general_model->get_user_info_by_id($export_data_arr->assigned_to_id);
					$us_nm = stripslashes($usr_arr->name);
				}
				
				$temp_arr['Assigned To'] = $us_nm;   
				$dataToExports[] = $temp_arr;
				
				}
			}   
			
			// set header
			$filename = "CRM-Archived-Properties-".date('d-M-Y H:i:s').".xls";
			
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			$this->general_model->exportExcelData($dataToExports);  
			 
		}else{
		
			/* for dropzone temp storage unset starts */ 
			if(isset($_SESSION['Temp_Media_Images'])){
	
				$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_photos();
				if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
					foreach($db_docs_arrs as $db_docs_arr){
						 $tmp_fle_name = $db_docs_arr->image; 
						 $tmp_proprty_id = $db_docs_arr->property_id; 
						 $tmp_ip_address = $db_docs_arr->ip_address; 
						 $tmp_dt_time = $db_docs_arr->datatimes; 
						
						 if(strlen($tmp_fle_name)>0){
							unlink("downloads/property_photos/{$tmp_fle_name}");
						 }
						 
						 $this->properties_model->delete_temp_property_dropzone_photos($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
						 
					} 
				}  
			
				unset($_SESSION['Temp_Media_Images']);
				unset($_SESSION['Temp_IP_Address']);
				unset($_SESSION['Temp_DATE_Times']);  
			}  
			
			if(isset($_SESSION['Temp_Documents_Files'])){
				
				$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_documents(); 
				if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
					foreach($db_docs_arrs as $db_docs_arr){
						$tmp_fle_name = $db_docs_arr->name; 
						$tmp_proprty_id = $db_docs_arr->property_id; 
						$tmp_ip_address = $db_docs_arr->ip_address; 
						$tmp_dt_time = $db_docs_arr->datatimes; 
						
						if(strlen($tmp_fle_name)>0){
							unlink("downloads/property_documents/{$tmp_fle_name}");
						}
						
						$this->properties_model->delete_temp_property_dropzone_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
						
					} 
				}
				 
				unset($_SESSION['Temp_Documents_Files']);
				unset($_SESSION['Temp_Documents_IP_Address']);
				unset($_SESSION['Temp_Documents_DATE_Times']);  
			} 
			
			if(isset($_SESSION['Temp_NT_IP_Address'])){ 
				$tmp_proprty_id = -1;
				$tmp_ip_address = $_SESSION['Temp_NT_IP_Address']; 
				$tmp_dt_time = $_SESSION['Temp_NT_DATE_Times']; 
				 
				$this->properties_model->delete_temp_property_notes($tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
				   
				unset($_SESSION['Temp_NT_IP_Address']);
				unset($_SESSION['Temp_NT_DATE_Times']); 
			}  
			/* for dropzone temp storage unset end */  
			
			$this->load->view('properties/archived_listings',$data); 
		
		}
			  
		}else{
			$this->load->view('no_permission_access'); 
		} 
	}

			 
	function archived_listings2($temps_property_type=''){  
	
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties', 'index', $this->dbs_role_id,'1'); 
		 
		if($res_nums>0){		
				
			$paras_arrs = $data = array();	
			$page = $this->input->post('page');
			if(!$page){
				$offset = 0;
			}else{
				$offset = $page;
			} 
			
			$data['page'] = $page;
			
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			/*$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val='';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';*/
		
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					$show_pers_pg = $_SESSION['tmp_per_page_val'];
				}  
			 
			if(isset($_POST['s_val'])){
				$s_val = $this->input->post('s_val'); 
				if(strlen($s_val)>0){
					$_SESSION['tmp_s_val'] = $s_val; 
					$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
				}else{
					unset($_SESSION['tmp_s_val']);	
				}
				
			}else if(isset($_SESSION['tmp_s_val'])){
				$s_val = $_SESSION['tmp_s_val']; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}       
			 
			if(isset($_POST['category_id_vals'])){
				$category_id_vals = $this->input->post('category_id_vals');  
				$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals)); 
				
			}else if(isset($_SESSION['tmp_category_id_vals'])){   
				$category_id_vals = $_SESSION['tmp_category_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
			}  
			
			if(isset($_POST['emirate_id_vals'])){
				$emirate_id_vals = $this->input->post('emirate_id_vals');  
				$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals)); 
				
			}else if(isset($_SESSION['tmp_emirate_id_vals'])){  
				$emirate_id_vals = $_SESSION['tmp_emirate_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
			}  
			
			if(isset($_POST['location_id_vals'])){
				$location_id_vals = $this->input->post('location_id_vals');  
				$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals)); 
				
			}else if(isset($_SESSION['tmp_location_id_vals'])){  
				$location_id_vals = $_SESSION['tmp_location_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
			} 
			 
			if(isset($_POST['sub_location_id_vals'])){
				$sub_location_id_vals = $this->input->post('sub_location_id_vals');  
				$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals)); 
				
			}else if(isset($_SESSION['tmp_sub_location_id_vals'])){ 
				$sub_location_id_vals = $_SESSION['tmp_sub_location_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
			} 
			 
			if(isset($_POST['portal_id_vals'])){
				$portal_id_vals = $this->input->post('portal_id_vals');  
				$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals)); 
				
			}else if(isset($_SESSION['tmp_portal_id_vals'])){  
				$portal_id_vals = $_SESSION['tmp_portal_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
			}  
			 
			if(isset($_POST['assigned_to_id_vals'])){
				$assigned_to_id_vals = $this->input->post('assigned_to_id_vals');  
				$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals)); 
				
			}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){ 
				$assigned_to_id_vals = $_SESSION['tmp_assigned_to_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
			}
			
			if(isset($_POST['owner_id_vals'])){
				$owner_id_vals = $this->input->post('owner_id_vals');  
				$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals)); 
				
			}else if(isset($_SESSION['tmp_owner_id_vals'])){ 
				$owner_id_vals = $_SESSION['tmp_owner_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
			}
			
			if(isset($_POST['property_status_vals'])){
				$property_status_vals = $this->input->post('property_status_vals');  
				$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
				$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals)); 
				
			}else if(isset($_SESSION['tmp_property_status_vals'])){  ///
				$property_status_vals = $_SESSION['tmp_property_status_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
			} 
			  
			if(isset($_POST['price'])){
				$price_val = $this->input->post('price');  
				if(strlen($price_val)>0){
					$_SESSION['tmp_price_val'] = $price_val; 
					$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
				}else{
					unset($_SESSION['tmp_price_val']);	
				}
			}else if(isset($_SESSION['tmp_price_val'])){ ///
				$price_val = $_SESSION['tmp_price_val']; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}
			
			if(isset($_POST['to_price'])){
				$to_price_val = $this->input->post('to_price');  
				if(strlen($to_price_val)>0){
					$_SESSION['tmp_to_price_val'] = $to_price_val; 
					$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
				}else{
					unset($_SESSION['tmp_to_price_val']);	
				}
			}else if(isset($_SESSION['tmp_to_price_val'])){ ///
				$to_price_val = $_SESSION['tmp_to_price_val']; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}  
			
			if(isset($_POST['from_date'])){
				$from_date_val = $this->input->post('from_date');  
				if(strlen($from_date_val)>0){
					$_SESSION['tmp_from_date_val'] = $from_date_val; 
					$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
				}else{
					unset($_SESSION['tmp_from_date_val']);	
				}
			}else if(isset($_SESSION['tmp_from_date_val'])){ ///
				$from_date_val = $_SESSION['tmp_from_date_val']; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}
			
			if(isset($_POST['to_date'])){
				$to_date_val = $this->input->post('to_date');  
				if(strlen($to_date_val)>0){
					$_SESSION['tmp_to_date_val'] = $to_date_val; 
					$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
				}else{
					unset($_SESSION['tmp_to_date_val']);	
				}
			}else if(isset($_SESSION['tmp_to_date_val'])){ ///
				$to_date_val = $_SESSION['tmp_to_date_val']; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}   
				/* for rental */
				/*$is_property_type = 2;    
				$data['sel_property_type'] = $is_property_type;
				$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));*/
				$paras_arrs = array_merge($paras_arrs, array("is_archived" => '1'));
				   
				if(isset($_SESSION['tmp_per_page_val'])){
					$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
				}else{
					$show_pers_pg = $this->perPage;
				}   
				   
				//total rows count
				$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
				
				//pagination configuration
				$config['target']      = '#dyns_list';
				$config['base_url']    = site_url('/properties/archived_listings2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $show_pers_pg; // $this->perPage;
				
				$this->ajax_pagination->initialize($config); 
				
				$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit' => $show_pers_pg));
				
				$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs); 
				
				$this->load->view('properties/archived_listings2',$data);  
			 
			}else{
				$this->load->view('no_permission_access'); 
			} 
		}
	
	
 	function deleted_listings($args_vals=''){
		$res_nums = $this->general_model->check_controller_method_permission_access('Properties','index',$this->dbs_role_id,'1');  
		if($res_nums>0){
			$data = array();	
			$paras_arrs = array();	
			$data['page_headings'] = "Deleted Listings"; 
			 
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			$s_val = $category_id_val = $assigned_to_id_val = $is_featured_val = '';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
			
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				} 
				
			if($this->input->post('s_val')){
				$s_val = $this->input->post('s_val'); 
				$_SESSION['tmp_s_val'] = $s_val; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}else if(isset($_SESSION['tmp_s_val'])){
					unset($_SESSION['tmp_s_val']);
				}   	
				
			if($this->input->post('category_id_vals')){
				$category_id_vals = $this->input->post('category_id_vals'); 
				$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
			}else if(isset($_SESSION['tmp_category_id_vals'])){
					unset($_SESSION['tmp_category_id_vals']);
				}
				
			if($this->input->post('emirate_id_vals')){
				$emirate_id_vals = $this->input->post('emirate_id_vals'); 
				$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
			}else if(isset($_SESSION['tmp_emirate_id_vals'])){
					unset($_SESSION['tmp_emirate_id_vals']);
				}
				
			if($this->input->post('location_id_vals')){
				$location_id_vals = $this->input->post('location_id_vals'); 
				$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
			}else if(isset($_SESSION['tmp_location_id_vals'])){
					unset($_SESSION['tmp_location_id_vals']);
				}  	
				
			if($this->input->post('sub_location_id_vals')){
				$sub_location_id_vals = $this->input->post('sub_location_id_vals'); 
				$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
			}else if(isset($_SESSION['tmp_sub_location_id_vals'])){
					unset($_SESSION['tmp_sub_location_id_vals']);
				}
				
			if($this->input->post('portal_id_vals')){
				$portal_id_vals = $this->input->post('portal_id_vals'); 
				$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
			}else if(isset($_SESSION['tmp_portal_id_vals'])){
					unset($_SESSION['tmp_portal_id_vals']);
				}
				
			if($this->input->post('assigned_to_id_vals')){
				$assigned_to_id_vals = $this->input->post('assigned_to_id_vals'); 
				$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
			}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){
					unset($_SESSION['tmp_assigned_to_id_vals']);
				}
				
			if($this->input->post('owner_id_vals')){
				$owner_id_vals = $this->input->post('owner_id_vals'); 
				$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
			}else if(isset($_SESSION['tmp_owner_id_vals'])){
					unset($_SESSION['tmp_owner_id_vals']);
				}
				
			if($this->input->post('property_status_vals')){
				$property_status_vals = $this->input->post('property_status_vals'); 
				$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
				$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
			}else if(isset($_SESSION['tmp_property_status_vals'])){
					unset($_SESSION['tmp_property_status_vals']);
				}
				
			if($this->input->post('price')){
				$price_val = $this->input->post('price'); 
				$_SESSION['tmp_price_val'] = $price_val; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}else if(isset($_SESSION['tmp_price_val'])){
					unset($_SESSION['tmp_price_val']);
				}
				
			if($this->input->post('to_price')){
				$to_price_val = $this->input->post('to_price'); 
				$_SESSION['tmp_to_price_val'] = $to_price_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}else if(isset($_SESSION['tmp_to_price_val'])){
					unset($_SESSION['tmp_to_price_val']);
				}	 
			
			if($this->input->post('from_date')){
				$from_date_val = $this->input->post('from_date'); 
				$_SESSION['tmp_from_date_val'] = $from_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}else if(isset($_SESSION['tmp_from_date_val'])){
					unset($_SESSION['tmp_from_date_val']);
				}
				
			if($this->input->post('to_date')){
				$to_date_val = $this->input->post('to_date'); 
				$_SESSION['tmp_to_date_val'] = $to_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}else if(isset($_SESSION['tmp_to_date_val'])){
					unset($_SESSION['tmp_to_date_val']);
				}	 
			
			/* for rental */	 
			/*$is_property_type = 2;    
			$data['sel_property_type'] = $is_property_type;
			$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));*/
			
			
			$paras_arrs = array_merge($paras_arrs, array("is_deleted" => '1'));
			 
			  
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			 
			//total rows count
			$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/properties/deleted_listings2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs);
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			//$data['category_arrs'] = $this->admin_model->get_all_categories();
			 
			if(isset($args_vals) && $args_vals=="export_excel"){   
				$paras_arrs = $data='';
				$dataToExports = [];  
				$paras_arrs = $data = array();	 
				
				/* permission checks */
				$vs_user_type_id = $this->session->userdata('us_role_id');
				$vs_id = $this->session->userdata('us_id'); 
				  
				if($this->input->post('sel_per_page_val')){
					$per_page_val = $this->input->post('sel_per_page_val'); 
					$_SESSION['tmp_per_page_val'] = $per_page_val;  
					
				}else if(isset($_SESSION['tmp_per_page_val'])){
						$per_page_val = $_SESSION['tmp_per_page_val'];
					}
				   
				if(isset($_POST['refer_no'])){
					$refer_no_val = $this->input->post('refer_no'); 
					if(strlen($refer_no_val)>0){
						$_SESSION['tmp_refer_no'] = $refer_no_val; 
						$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
					}else{
						unset($_SESSION['tmp_refer_no']);	
					}
					
				}else if(isset($_SESSION['tmp_refer_no'])){
					$refer_no_val = $_SESSION['tmp_refer_no']; 
					$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
				}
				
				if(isset($_POST['pics_nos'])){
					$pics_nos_val = $this->input->post('pics_nos'); 
					if(strlen($pics_nos_val)>0){
						$_SESSION['tmp_pics_nos'] = $pics_nos_val; 
						$paras_arrs = array_merge($paras_arrs, array("pics_nos_val" => $pics_nos_val));
					}else{
						unset($_SESSION['tmp_pics_nos']);	
					}
					
				}else if(isset($_SESSION['tmp_pics_nos'])){
					$pics_nos_val = $_SESSION['tmp_pics_nos']; 
					$paras_arrs = array_merge($paras_arrs, array("pics_nos_val" => $pics_nos_val));
				}
				
				 
				if(isset($_POST['price'])){
					$price_val = $this->input->post('price');  
					if(strlen($price_val)>0){
						$_SESSION['tmp_price_val'] = $price_val; 
						$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
					}else{
						unset($_SESSION['tmp_price_val']);	
					}
				}else if(isset($_SESSION['tmp_price_val'])){ ///
					$price_val = $_SESSION['tmp_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
				}
				
				if(isset($_POST['to_price'])){
					$to_price_val = $this->input->post('to_price');  
					if(strlen($to_price_val)>0){
						$_SESSION['tmp_to_price_val'] = $to_price_val; 
						$paras_arrs = array_merge($paras_arrs,array("to_price_val" => $to_price_val));
					}else{
						unset($_SESSION['tmp_to_price_val']);	
					}
				}else if(isset($_SESSION['tmp_to_price_val'])){ ///
					$to_price_val = $_SESSION['tmp_to_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
				}
				
				if(isset($_POST['sel_emirate_location_id_val'])){
					$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val');  
					$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val)); 
					
				}else if(isset($_SESSION['tmp_emirate_location_id_val'])){  ///
					$emirate_location_id_val = $_SESSION['tmp_emirate_location_id_val']; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
				} 
				
				if(isset($_POST['sel_no_of_beds_id_val'])){
					$no_of_beds_id_val = $this->input->post('sel_no_of_beds_id_val'); 
					$_SESSION['tmp_no_of_beds_id_val'] = $no_of_beds_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
					
				}else if(isset($_SESSION['tmp_no_of_beds_id_val'])){///
					$no_of_beds_id_val = $_SESSION['tmp_no_of_beds_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
				} 
				 
				if(isset($_POST['sel_owner_id_val'])){
					$owner_id_val = $this->input->post('sel_owner_id_val');  
					$_SESSION['tmp_owner_id_val'] = $owner_id_val;
					$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));  
					
				}else if(isset($_SESSION['tmp_owner_id_val'])){///
					$owner_id_val = $_SESSION['tmp_owner_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));
				}  
					 
				if(isset($_POST['sel_property_status_val'])){
					$property_status_val = $this->input->post('sel_property_status_val');  
					$_SESSION['tmp_property_status_val'] = $property_status_val;
					$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val)); 
					
				}else if(isset($_SESSION['tmp_property_status_val'])){ 
					$property_status_val = $_SESSION['tmp_property_status_val'];
					$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val));
				}  
					 
				if(isset($_POST['sel_assigned_to_id_val'])){
					$assigned_to_id_val = $this->input->post('sel_assigned_to_id_val');  
					$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val)); 
					
				}else if(isset($_SESSION['tmp_assigned_to_id_val'])){ ///
					$assigned_to_id_val = $_SESSION['tmp_assigned_to_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
				}  
				
				if(isset($_POST['sel_portal_id_val'])){
					$portal_id_val = $this->input->post('sel_portal_id_val');  
					$_SESSION['tmp_portal_id_val'] = $portal_id_val;
					$paras_arrs = array_merge($paras_arrs, array("portal_id_val" => $portal_id_val)); 
					
				}else if(isset($_SESSION['tmp_portal_id_val'])){ ///
					$portal_id_val = $_SESSION['tmp_portal_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("portal_id_val" => $portal_id_val));
				}
			
				/*$is_property_type = 2; 		 
				$data['sel_property_type'] = $is_property_type; 
				$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type)); */
				 
				$paras_arrs = array_merge($paras_arrs, array("is_deleted" => '1')); 
				$export_data_arrs = $this->properties_model->get_all_cstm_quick_properties($paras_arrs);
				
				if(isset($export_data_arrs) && count($export_data_arrs)>0){
				foreach($export_data_arrs as $export_data_arr){ 
				$temp_arr = array();  
				
				$temp_arr['Ref No'] = stripslashes($export_data_arr->ref_no); 
				$temp_arr['Sub Location'] = stripslashes($export_data_arr->sub_loc_name); 
				$temp_arr['Bedrooms'] = stripslashes($export_data_arr->bed_title); 
				$temp_arr['Owner'] = stripslashes($export_data_arr->ownr_name).' ( '.$export_data_arr->ownr_phone_no.' )';
				$temp_arr['Price'] = number_format($export_data_arr->price,0,".",",");
				$temp_arr['Status'] = $this->general_model->get_gen_property_status($export_data_arr->property_status);
				 
				$us_nm ='';
				if($export_data_arr->assigned_to_id>0){
					$usr_arr =  $this->general_model->get_user_info_by_id($export_data_arr->assigned_to_id);
					$us_nm = stripslashes($usr_arr->name);
				}
				
				$temp_arr['Assigned To'] = $us_nm;   
				$dataToExports[] = $temp_arr;
				
				}
			}   
			
			// set header
			$filename = "CRM-Deleted-Properties-".date('d-M-Y H:i:s').".xls";
			
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			$this->general_model->exportExcelData($dataToExports);  
			 
		}else{ 
			
			$this->load->view('properties/deleted_listings',$data); 
		
		}
			  
		}else{
			$this->load->view('no_permission_access'); 
		} 
	} 
			 
	function deleted_listings2($temps_property_type=''){  
	
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties', 'index', $this->dbs_role_id,'1'); 
		 
		if($res_nums>0){		
				
			$paras_arrs = $data = array();	
			$page = $this->input->post('page');
			if(!$page){
				$offset = 0;
			}else{
				$offset = $page;
			} 
			
			$data['page'] = $page;
			
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			/*$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val='';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';*/
		
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					$show_pers_pg = $_SESSION['tmp_per_page_val'];
				}  
			 
			if(isset($_POST['s_val'])){
				$s_val = $this->input->post('s_val'); 
				if(strlen($s_val)>0){
					$_SESSION['tmp_s_val'] = $s_val; 
					$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
				}else{
					unset($_SESSION['tmp_s_val']);	
				}
				
			}else if(isset($_SESSION['tmp_s_val'])){
				$s_val = $_SESSION['tmp_s_val']; 
				$paras_arrs = array_merge($paras_arrs, array("s_val" => $s_val));
			}       
			 
			if(isset($_POST['category_id_vals'])){
				$category_id_vals = $this->input->post('category_id_vals');  
				$_SESSION['tmp_category_id_vals'] = $category_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals)); 
				
			}else if(isset($_SESSION['tmp_category_id_vals'])){   
				$category_id_vals = $_SESSION['tmp_category_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_vals" => $category_id_vals));
			}  
			
			if(isset($_POST['emirate_id_vals'])){
				$emirate_id_vals = $this->input->post('emirate_id_vals');  
				$_SESSION['tmp_emirate_id_vals'] = $emirate_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals)); 
				
			}else if(isset($_SESSION['tmp_emirate_id_vals'])){  
				$emirate_id_vals = $_SESSION['tmp_emirate_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_id_vals" => $emirate_id_vals));
			}  
			
			if(isset($_POST['location_id_vals'])){
				$location_id_vals = $this->input->post('location_id_vals');  
				$_SESSION['tmp_location_id_vals'] = $location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals)); 
				
			}else if(isset($_SESSION['tmp_location_id_vals'])){  
				$location_id_vals = $_SESSION['tmp_location_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("location_id_vals" => $location_id_vals));
			} 
			 
			if(isset($_POST['sub_location_id_vals'])){
				$sub_location_id_vals = $this->input->post('sub_location_id_vals');  
				$_SESSION['tmp_sub_location_id_vals'] = $sub_location_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals)); 
				
			}else if(isset($_SESSION['tmp_sub_location_id_vals'])){ 
				$sub_location_id_vals = $_SESSION['tmp_sub_location_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("sub_location_id_vals" => $sub_location_id_vals));
			} 
			 
			if(isset($_POST['portal_id_vals'])){
				$portal_id_vals = $this->input->post('portal_id_vals');  
				$_SESSION['tmp_portal_id_vals'] = $portal_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals)); 
				
			}else if(isset($_SESSION['tmp_portal_id_vals'])){  
				$portal_id_vals = $_SESSION['tmp_portal_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
			}  
			 
			if(isset($_POST['assigned_to_id_vals'])){
				$assigned_to_id_vals = $this->input->post('assigned_to_id_vals');  
				$_SESSION['tmp_assigned_to_id_vals'] = $assigned_to_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals)); 
				
			}else if(isset($_SESSION['tmp_assigned_to_id_vals'])){ 
				$assigned_to_id_vals = $_SESSION['tmp_assigned_to_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_vals" => $assigned_to_id_vals));
			}
			
			if(isset($_POST['owner_id_vals'])){
				$owner_id_vals = $this->input->post('owner_id_vals');  
				$_SESSION['tmp_owner_id_vals'] = $owner_id_vals; 
				$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals)); 
				
			}else if(isset($_SESSION['tmp_owner_id_vals'])){ 
				$owner_id_vals = $_SESSION['tmp_owner_id_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("owner_id_vals" => $owner_id_vals));
			}
			
			if(isset($_POST['property_status_vals'])){
				$property_status_vals = $this->input->post('property_status_vals');  
				$_SESSION['tmp_property_status_vals'] = $property_status_vals; 
				$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals)); 
				
			}else if(isset($_SESSION['tmp_property_status_vals'])){  ///
				$property_status_vals = $_SESSION['tmp_property_status_vals']; 
				$paras_arrs = array_merge($paras_arrs, array("property_status_vals" => $property_status_vals));
			} 
			  
			if(isset($_POST['price'])){
				$price_val = $this->input->post('price');  
				if(strlen($price_val)>0){
					$_SESSION['tmp_price_val'] = $price_val; 
					$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
				}else{
					unset($_SESSION['tmp_price_val']);	
				}
			}else if(isset($_SESSION['tmp_price_val'])){ ///
				$price_val = $_SESSION['tmp_price_val']; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}
			
			if(isset($_POST['to_price'])){
				$to_price_val = $this->input->post('to_price');  
				if(strlen($to_price_val)>0){
					$_SESSION['tmp_to_price_val'] = $to_price_val; 
					$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
				}else{
					unset($_SESSION['tmp_to_price_val']);	
				}
			}else if(isset($_SESSION['tmp_to_price_val'])){ ///
				$to_price_val = $_SESSION['tmp_to_price_val']; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}  
			
			if(isset($_POST['from_date'])){
				$from_date_val = $this->input->post('from_date');  
				if(strlen($from_date_val)>0){
					$_SESSION['tmp_from_date_val'] = $from_date_val; 
					$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
				}else{
					unset($_SESSION['tmp_from_date_val']);	
				}
			}else if(isset($_SESSION['tmp_from_date_val'])){ ///
				$from_date_val = $_SESSION['tmp_from_date_val']; 
				$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			}
			
			if(isset($_POST['to_date'])){
				$to_date_val = $this->input->post('to_date');  
				if(strlen($to_date_val)>0){
					$_SESSION['tmp_to_date_val'] = $to_date_val; 
					$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
				}else{
					unset($_SESSION['tmp_to_date_val']);	
				}
			}else if(isset($_SESSION['tmp_to_date_val'])){ ///
				$to_date_val = $_SESSION['tmp_to_date_val']; 
				$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			}   
				/* for rental */
				/*$is_property_type = 2;    
				$data['sel_property_type'] = $is_property_type;
				$paras_arrs = array_merge($paras_arrs, array("is_property_type" => $is_property_type));*/
				
				$paras_arrs = array_merge($paras_arrs, array("is_deleted" => '1'));
				   
				if(isset($_SESSION['tmp_per_page_val'])){
					$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
				}else{
					$show_pers_pg = $this->perPage;
				}   
				   
				//total rows count
				$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
				
				//pagination configuration
				$config['target']      = '#dyns_list';
				$config['base_url']    = site_url('/properties/deleted_listings2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $show_pers_pg; // $this->perPage;
				
				$this->ajax_pagination->initialize($config); 
				
				$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit' => $show_pers_pg));
				
				$records = $data['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs); 
				
				$this->load->view('properties/deleted_listings2',$data);  
			 
			}else{
				$this->load->view('no_permission_access'); 
			} 
		}
		
		
		
	 function delete_aj(){   
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','trash',$this->dbs_role_id,'1'); 
		 
		if($res_nums>0){
			 
			 if(isset($_POST["args1"]) && $_POST["args1"]>1){
				$args1 = $this->input->post("args1"); 
				$this->permissions_model->trash_permission($args1);
			 }  
			 
			 $this->index2();
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	 }
	 
	  function del_restore_aj($args0='0', $args1){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','trash',$this->dbs_role_id,'1');  
		if($res_nums>0){
				
			$data['page_headings'] = "Listings"; 
			
			if(isset($args1) && $args1>0){
			
				$datetimes = date('Y-m-d H:i:s');
				$datas = array('updated_on' => $datetimes,'is_deleted' => '0'); 
				$this->properties_model->update_property_data($args1, $datas);  
			}
			
			//$this->deleted_listings2();
			
			redirect('properties/deleted_listings/'); 
		
		}else{
			$this->load->view('no_permission_access'); 
		}
	 } 
	 
	  function trash_aj(){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','trash',$this->dbs_role_id,'1');  
		if($res_nums>0){
				
		$data['page_headings'] = "Listings"; 
		
		if(isset($_POST["args1"]) && $_POST["args1"]>0){
			$args1 = $this->input->post("args1"); 
			$pht_arrs = $this->properties_model->get_all_property_photos_by_property_id($args1);  
			$docxs_arrs = $this->properties_model->get_all_property_documents_by_property_id($args1); 
				
				if(isset($pht_arrs) && count($pht_arrs) >0){
					foreach($pht_arrs as $pht_arr){
						$tmp_phts = $pht_arr->image;
						if(strlen($tmp_phts)>0){
							unlink("downloads/property_photos/{$tmp_phts}");
						}
					}
					
					$this->properties_model->trash_property_photo($args1);
				} 
				
				if(isset($docxs_arrs) && count($docxs_arrs) >0){
					foreach($docxs_arrs as $docxs_arr){
						$tmp_fls3 = $docxs_arr->name;
						if(strlen($tmp_fls3)>0){
							unlink("downloads/property_documents/{$tmp_fls3}");
						}
					}
					$this->properties_model->trash_property_documents($args1);
				}	
				 
				$this->properties_model->trash_property($args1);
				
				//$this->properties_model->delete_properties_portals_data($args2);
				 
				//$this->properties_model->trash_property_assigned_portal_feature_data($args2);
				}
			//redirect('properties/deleted_properties_list'); 
			 $this->deleted_listings2();
		}else{
			$this->load->view('no_permission_access'); 
		}
	 } 
	
	 
	  function trash_multiple($paras1 ='0'){    
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','trash',$this->dbs_role_id,'1');  
		if($res_nums>0){
					
			$data['page_headings'] = "Listings";  
				
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				$del_checks = $_POST["multi_action_check"]; 
				
				foreach($del_checks as $args1){ 
					  
					$pht_arrs = $this->properties_model->get_all_property_photos_by_property_id($args1);  
					$docxs_arrs = $this->properties_model->get_all_property_documents_by_property_id($args1); 
						
						if(isset($pht_arrs) && count($pht_arrs) >0){
							foreach($pht_arrs as $pht_arr){
								$tmp_phts = $pht_arr->image;
								if(strlen($tmp_phts)>0){
									unlink("downloads/property_photos/{$tmp_phts}");
								}
							}
							
							$this->properties_model->trash_property_photo($args1);
						} 
						
						if(isset($docxs_arrs) && count($docxs_arrs) >0){
							foreach($docxs_arrs as $docxs_arr){
								$tmp_fls3 = $docxs_arr->name;
								if(strlen($tmp_fls3)>0){
									unlink("downloads/property_documents/{$tmp_fls3}");
								}
							}
							$this->properties_model->trash_property_documents($args1);
						}	
						 
						$this->properties_model->trash_property($args1);
						
						//$this->properties_model->delete_properties_portals_data($args2);
						 
						//$this->properties_model->trash_property_assigned_portal_feature_data($args2); 
					}
				}
				//redirect('properties/deleted_properties_list'); 
				 $this->deleted_listings2();
			}else{
			$this->load->view('no_permission_access'); 
		}
	 } 
	 
	 
	 
	 // sales 0
	 // rent 4
	 // Archived 1
	 // 
	function delete_property($args0='0', $args1=''){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','trash',$this->dbs_role_id,'1');  
		if($res_nums>0){
			if(isset($args1) && $args1!=''){ /*deleted*/ 
				 /* sending email on delete property starts */ 
				$property_dtl ='';   
				$datetimes = date('Y-m-d H:i:s');
				$datas = array('updated_on' => $datetimes,'is_deleted' => '1');		
				$res0 = $this->properties_model->update_property_data($args1,$datas); 
				if(isset($res0)){ 
					
					$created_on = date('Y-m-d H:i:s');		
					$property_record_arr = $this->properties_model->get_property_by_id($args1);
					if(isset($property_record_arr)){
						$sel_db_portal_ids = $property_record_arr->show_on_portal_ids;
						$tmps_db_portal_ids_arr = explode(',',$sel_db_portal_ids);
						if(isset($tmps_db_portal_ids_arr) && in_array("2", $tmps_db_portal_ids_arr)){
							$dubizzle_propty_nums = $this->properties_model->count_portal_property_by_id($args1,'2');
							if($dubizzle_propty_nums==0){  
								$datas333 = array('property_id' => $args1,'portal_id' => '2','datetimes' => $created_on);
								$this->properties_model->insert_portal_property_data($datas333);
							}else if($dubizzle_propty_nums>0){ 
								$datas333 = array('datetimes' => $created_on);
								$this->properties_model->update_portal_property_datas($args1,'2',$datas333);
							}
						}  
					}
							
						if(isset($args0) && $args0 ==6){
							redirect("properties/portal_properties_list");
						}else if(isset($args0) && $args0==5){   
							redirect("properties/leads_properties_list");
						}else if(isset($args0) && $args0==4){   
							//redirect("properties/rent_listings");
							$this->rent_listings2();
						}else if(isset($args0) && $args0==3){
							//redirect("properties/sales_listings");
							$this->sales_listings2();
						}else if(isset($args0) && $args0==2){
							redirect("properties/dealt_properties_list");
						}else if($args0==1){
							redirect("properties/archived_listings");	
						}else{ 
							//redirect("properties/sales_listings");
							$this->sales_listings2();
						} 
						
					}else{
						//redirect($this->agent->referrer());
						
						if(isset($args0) && $args0 ==6){
							redirect("properties/portal_properties_list");
						}else if(isset($args0) && $args0==5){   
							redirect("properties/leads_properties_list");
						}else if(isset($args0) && $args0==4){   
							//redirect("properties/rent_listings");
							$this->rent_listings2();
						}else if(isset($args0) && $args0==3){
							//redirect("properties/sales_listings");
							$this->sales_listings2();
						}else if(isset($args0) && $args0==2){
							redirect("properties/dealt_properties_list");
						}else if($args0==1){
							redirect("properties/archived_listings");	
						}else{ 
							//redirect("properties/sales_listings");
							$this->sales_listings2();
						} 
						
					}
				}else{
					redirect($this->agent->referrer());
				}
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	}

	
	function delete_selected_properties(){  
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','trash',$this->dbs_role_id,'1');  
		if($res_nums>0){
			
			if(isset($_POST['multi_action_check']) && count($_POST['multi_action_check'])>0 && isset($_POST['args0'])){ 
				$args0 = $_POST['args0'];
				$del_checks = $_POST['multi_action_check'];
			
				foreach($del_checks as $args1){ 	 
				
					$property_dtl =''; 
					$datetimes = date('Y-m-d H:i:s');
					$datas = array('updated_on' => $datetimes,'is_deleted' => '1');		
					$res0 = $this->properties_model->update_property_data($args1,$datas); 
					if(isset($res0)){
						$created_on = date('Y-m-d H:i:s');		
						$property_record_arr = $this->properties_model->get_property_by_id($args1);
						if(isset($property_record_arr) && count($property_record_arr)>0){
							$sel_db_portal_ids = $property_record_arr->show_on_portal_ids;
							$tmps_db_portal_ids_arr = explode(',',$sel_db_portal_ids);
							if(isset($tmps_db_portal_ids_arr) && in_array("2", $tmps_db_portal_ids_arr)){
								$dubizzle_propty_nums = $this->properties_model->count_portal_property_by_id($args1,'2');
								if($dubizzle_propty_nums==0){  
									$datas333 = array('property_id' => $args1,'portal_id' => '2','datetimes' => $created_on);
									$this->properties_model->insert_portal_property_data($datas333);
								}else if($dubizzle_propty_nums>0){ 
									$datas333 = array('datetimes' => $created_on);
									$this->properties_model->update_portal_property_datas($args1,'2',$datas333);
								}
							}  
						} 		
					} 	
				}  
					
				if(isset($args0) && $args0 ==6){
					redirect("properties/portal_properties_list");
				}else if(isset($args0) && $args0==5){   
					redirect("properties/leads_properties_list");
				}else if(isset($args0) && $args0==4){   
					//redirect("properties/rent_listings");
					$this->rent_listings2();
				}else if(isset($args0) && $args0==3){
					//redirect("properties/sales_listings");
					$this->sales_listings2();
				}else if(isset($args0) && $args0==2){
					redirect("properties/dealt_properties_list");
				}else if($args0==1){
					redirect("properties/archived_listings");	
				}else{ 
					//redirect("properties/sales_listings");
					$this->sales_listings2();
				}  		
					
			}else{  
				//redirect($this->agent->referrer());
				 
				$args0 = (isset($_POST['args0'])) ? $_POST['args0'] : 0;
				
				if(isset($args0) && $args0 ==6){
					redirect("properties/portal_properties_list");
				}else if(isset($args0) && $args0==5){   
					redirect("properties/leads_properties_list");
				}else if(isset($args0) && $args0==4){   
					//redirect("properties/rent_listings");
					$this->rent_listings2();
				}else if(isset($args0) && $args0==3){
					//redirect("properties/sales_listings");
					$this->sales_listings2();
				}else if(isset($args0) && $args0==2){
					redirect("properties/dealt_properties_list");
				}else if($args0==1){
					redirect("properties/archived_listings");	
				}else{ 
					//redirect("properties/sales_listings");
					$this->sales_listings2();
				} 
			} 
		 
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}    
	} 
 
	 
	 function add($args0='0'){  
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','add',$this->dbs_user_role_id,'1');
		if($res_nums>0){ 
		
			$config_arrs = $this->general_model->get_configuration();
			$conf_sale_inititals = stripslashes($config_arrs->sale_inititals);
			$conf_rent_inititals = stripslashes($config_arrs->rent_inititals);
			$data['conf_sale_inititals']  = $conf_sale_inititals; 
			$data['conf_rent_inititals']  = $conf_rent_inititals;
			$data['args0']  = $args0; 
			/*$max_property_id_val = $this->admin_model->get_max_property_id();*/
			 
			$max_property_id_val = $this->properties_model->get_max_property_ref_no_val();
			$max_property_id_val = $max_property_id_val+1; 
			$max_property_id_val = str_pad($max_property_id_val, 4, '0', STR_PAD_LEFT); 
			$max_property_id_val = $max_property_id_val;
			
			/*$max_property_id_val = $conf_company_inititals.$max_property_id_val;*/
			$data['auto_ref_no'] = $max_property_id_val; 
		
			$data['page_headings'] = "Add Property";	
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
			$data['owner_arrs'] = $this->general_model->get_gen_all_owners_list(); 
			$data['emirate_arrs'] = $this->emirates_model->get_all_emirates();
			$data['source_of_listing_arrs'] = $this->source_of_listings_model->get_all_properties_source_of_listings();
			
			if(isset($_POST) && !empty($_POST)){ 
				$date_times = date('Y-m-d H:i:s');
				$ip_address = $_SERVER['REMOTE_ADDR'];
				
				$title = $this->input->post("title");
				$description = $this->input->post("description");
				$property_type = (isset($_POST['property_type'])) ? $this->input->post("property_type") : '';
				$category_id = $this->input->post("category_id"); 
				
				$show_on_portal_ids_vals = (isset($_POST['show_on_portal_ids']) && count($_POST['show_on_portal_ids'])>0) ? implode(',',$_POST['show_on_portal_ids']) : '';  
				
				$ref_no = $this->input->post("ref_no");
				$assigned_to_id = $this->input->post("assigned_to_id");
				$owner_id = $this->input->post("owner_id");
				$no_of_beds_id = $this->input->post("no_of_beds_id");
				$no_of_baths = $this->input->post("no_of_baths");
				$emirate_id = $this->input->post("emirate_id");
				$location_id = $this->input->post("location_id");
				$sub_location_id = $this->input->post("sub_location_id");
				$property_address = $this->input->post("property_address");
				$plot_area = $this->input->post("plot_area");
				$property_ms_unit = $this->input->post("property_ms_unit");
				$price = $this->input->post("price"); 
				$property_status = $this->input->post("property_status");
				$youtube_video_link = $this->input->post("youtube_video_link");
				$is_furnished = $this->input->post("is_furnished");
				$source_of_listing = $this->input->post("source_of_listing");
				$private_amenities_data = $this->input->post("private_amenities_data");
				$commercial_amenities_data = $this->input->post("commercial_amenities_data");
				   
				// form validation
				$this->form_validation->set_rules("title", "Title", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("description", "Description", "trim|required|xss_clean");  
				 $this->form_validation->set_rules('property_type',"Property Type", 'trim|required|xss_clean');  
				$this->form_validation->set_rules("category_id", "Category", "trim|xss_clean");    
				$this->form_validation->set_rules("ref_no", "Ref No", "trim|required|xss_clean");
				$this->form_validation->set_rules("assigned_to_id", "Assigned To", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("owner_id", "Owners", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("no_of_beds_id", "Bedrooms", "trim|required|xss_clean");  
				$this->form_validation->set_rules("no_of_baths", "Bathrooms", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("emirate_id", "Emirates", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("location_id", "Locations", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("sub_location_id", "Sub Locations", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("property_address", "Address", "trim|required|xss_clean");   
				$this->form_validation->set_rules("plot_area", "Plot Area", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("property_ms_unit", "Measuring Unit", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("price", "Price", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("property_status", "Property Status", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("is_furnished", "Is Furnished", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("source_of_listing", "Source of Listing", "trim|required|xss_clean");   
				 
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('properties/add',$data);
				}else{  
				
					$datas = array('title' => $title,'description' => $description,'property_type' => $property_type,'category_id' => $category_id,'show_on_portal_ids' => $show_on_portal_ids_vals,'private_amenities_data' => $private_amenities_data,'commercial_amenities_data' => $commercial_amenities_data,'ref_no' => $ref_no,'assigned_to_id' => $assigned_to_id,'owner_id' => $owner_id,'no_of_beds_id' => $no_of_beds_id,'no_of_baths' => $no_of_baths,'emirate_id' => $emirate_id,'location_id' => $location_id,'sub_location_id' => $sub_location_id,'property_address' => $property_address,'plot_area' => $plot_area,'property_ms_unit' => $property_ms_unit,'price' => $price,'property_status' => $property_status,'youtube_video_link' => $youtube_video_link,'is_furnished' => $is_furnished,'source_of_listing' => $source_of_listing,'created_by' => $vs_id,'ip_address' => $ip_address,'created_on' => $date_times);   
					
					$res = $this->properties_model->insert_property_data($datas); 
					if(isset($res)){
						$last_property_id = $this->db->insert_id();
							 
						/*  photo script starts */	
						if(isset($_SESSION['Temp_Media_Images']) && count($_SESSION['Temp_Media_Images'])>0){
							 /*$_FILES["images"] = $_SESSION['Temp_Media_Images'];*/
							 $tmp_ips = $_SESSION['Temp_IP_Address'];
							 $tmp_dts = $_SESSION['Temp_DATE_Times'];
							 
							$datas3 = array('property_id' => $last_property_id); 
							$this->properties_model->update_temp_property_dropzone_photos('-1',$tmp_ips,$tmp_dts,$datas3);
						}  
						/*  photo script ends */
		
						/* property documents script starts */ 
						if(isset($_SESSION['Temp_Documents_Files']) && count($_SESSION['Temp_Documents_Files'])>0){
							 /*$_FILES["documents"] = $_SESSION['Temp_Documents_Files'];*/
							 $tmp_ips = $_SESSION['Temp_Documents_IP_Address'];
							 $tmp_dts = $_SESSION['Temp_Documents_DATE_Times'];
							 
							$datas3 = array('property_id' => $last_property_id); 
							$this->properties_model->update_temp_property_dropzone_documents('-1',$tmp_ips,$tmp_dts,$datas3);
						}  
						/* property documents script ends */
		 
						/* property notes script starts */ 
						if(isset($_SESSION['Temp_NT_IP_Address']) && strlen($_SESSION['Temp_NT_DATE_Times'])>0){ 
							 $tmp_ips = $_SESSION['Temp_NT_IP_Address'];
							 $tmp_dts = $_SESSION['Temp_NT_DATE_Times'];
							 
							$datas3 = array('property_id' => $last_property_id); 
							$this->properties_model->update_temp_property_notes('-1',$tmp_ips,$tmp_dts,$datas3);
						}  
						/* property notes script ends */
							
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					}
					
					if(isset($_SESSION['Temp_Media_Images'])){
						unset($_SESSION['Temp_Media_Images']);
						unset($_SESSION['Temp_IP_Address']);
						unset($_SESSION['Temp_DATE_Times']);  
					}  
					
					if(isset($_SESSION['Temp_Documents_Files'])){
						unset($_SESSION['Temp_Documents_Files']);
						unset($_SESSION['Temp_Documents_IP_Address']);
						unset($_SESSION['Temp_Documents_DATE_Times']);  
					}
					
					if(isset($_SESSION['Temp_NT_IP_Address'])){
						unset($_SESSION['Temp_NT_IP_Address']);
						unset($_SESSION['Temp_NT_DATE_Times']);  
					}
						 
					if(isset($_POST['saves_and_new'])){
						redirect("properties/add/".$args0);
					}else{
					 
						if(isset($args0) && $args0==1){
							redirect("properties/archived_listings");	
						}else if(isset($args0) && $args0==2){
							redirect("properties/dealt_properties_list");
						}else if(isset($args0) && $args0==3){
							redirect("properties/sales_listings");
						}else if(isset($args0) && $args0==4){   
							redirect("properties/rent_listings");
						}else if(isset($args0) && $args0 ==5){ 
							redirect("properties/leads_properties_list");
						}else if(isset($args0) && $args0==6){   
							redirect("properties/portal_properties_list");	
						}else{ 
							redirect("properties/properties_list");
						}  	
					} 
				} 	 
				
			}else{
				$this->load->view('properties/add',$data);
			}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}
	}  
	 
	 
	 function update($args0='0', $args1=''){ 
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','update',$this->dbs_user_role_id,'1');
		if($res_nums>0){ 
			$config_arrs = $this->general_model->get_configuration();
			$conf_sale_inititals = stripslashes($config_arrs->sale_inititals);
			$conf_rent_inititals = stripslashes($config_arrs->rent_inititals);
			$data['conf_sale_inititals']  = $conf_sale_inititals; 
			$data['conf_rent_inititals']  = $conf_rent_inititals;
			$data['args0'] = $args0;  
			/*$max_property_id_val = $this->admin_model->get_max_property_id();*/
			 
			$max_property_id_val = $this->properties_model->get_max_property_ref_no_val();
			$max_property_id_val = $max_property_id_val+1; 
			$max_property_id_val = str_pad($max_property_id_val, 4, '0', STR_PAD_LEFT); 
			$max_property_id_val = $max_property_id_val;
			
			/*$max_property_id_val = $conf_company_inititals.$max_property_id_val;*/
			$data['auto_ref_no'] = $max_property_id_val; 
		  
			$data['page_headings'] = "Update Property";	
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			$data['owner_arrs'] = $this->general_model->get_gen_all_owners_list(); 
			$data['emirate_arrs'] = $this->emirates_model->get_all_emirates();
			$data['source_of_listing_arrs'] = $this->source_of_listings_model->get_all_properties_source_of_listings();
			
			if($args1>0){ 
				$data['args1'] = $args1; 
				$data['record'] = $this->properties_model->get_property_by_id($args1);
			}
			
			if(isset($_POST) && !empty($_POST)){ 
				$date_times = date('Y-m-d H:i:s');
				$ip_address = $_SERVER['REMOTE_ADDR'];
				
				$title = $this->input->post("title");
				$description = $this->input->post("description");
				$property_type = (isset($_POST['property_type'])) ? $this->input->post("property_type") : '';
				$category_id = $this->input->post("category_id"); 
				
				$show_on_portal_ids_vals = (isset($_POST['show_on_portal_ids']) && count($_POST['show_on_portal_ids'])>0) ? implode(',',$_POST['show_on_portal_ids']) : '';  
				
				/*$ref_no = $this->input->post("ref_no");*/
				$assigned_to_id = $this->input->post("assigned_to_id");
				$owner_id = $this->input->post("owner_id");
				$no_of_beds_id = $this->input->post("no_of_beds_id");
				$no_of_baths = $this->input->post("no_of_baths");
				$emirate_id = $this->input->post("emirate_id");
				$location_id = $this->input->post("location_id");
				$sub_location_id = $this->input->post("sub_location_id");
				$property_address = $this->input->post("property_address");
				$plot_area = $this->input->post("plot_area");
				$property_ms_unit = $this->input->post("property_ms_unit");
				$price = $this->input->post("price"); 
				$property_status = $this->input->post("property_status");
				$youtube_video_link = $this->input->post("youtube_video_link");
				$is_furnished = $this->input->post("is_furnished");
				$source_of_listing = $this->input->post("source_of_listing");
				$private_amenities_data = $this->input->post("private_amenities_data");
				$commercial_amenities_data = $this->input->post("commercial_amenities_data");
				   
				// form validation
				$this->form_validation->set_rules("title", "Title", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("description", "Description", "trim|required|xss_clean");  
				 $this->form_validation->set_rules('property_type',"Property Type", 'trim|required|xss_clean');  
				$this->form_validation->set_rules("category_id", "Category", "trim|xss_clean");    
				/*$this->form_validation->set_rules("ref_no", "Ref No", "trim|required|xss_clean");*/
				$this->form_validation->set_rules("assigned_to_id", "Assigned To", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("owner_id", "Owners", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("no_of_beds_id", "Bedrooms", "trim|required|xss_clean");  
				$this->form_validation->set_rules("no_of_baths", "Bathrooms", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("emirate_id", "Emirates", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("location_id", "Locations", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("sub_location_id", "Sub Locations", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("property_address", "Address", "trim|required|xss_clean");   
				$this->form_validation->set_rules("plot_area", "Plot Area", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("property_ms_unit", "Measuring Unit", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("price", "Price", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("property_status", "Property Status", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("is_furnished", "Is Furnished", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("source_of_listing", "Source of Listing", "trim|required|xss_clean");   
				 
				if($this->form_validation->run() == FALSE){
					// validation fail
					$this->load->view('properties/update',$data);
				}else if($args1>0){ /*'ref_no' => $ref_no,*/ 
					$datas = array('title' => $title,'description' => $description,'property_type' => $property_type,'category_id' => $category_id,'show_on_portal_ids' => $show_on_portal_ids_vals,'private_amenities_data' => $private_amenities_data,'commercial_amenities_data' => $commercial_amenities_data,'assigned_to_id' => $assigned_to_id,'owner_id' => $owner_id,'no_of_beds_id' => $no_of_beds_id,'no_of_baths' => $no_of_baths,'emirate_id' => $emirate_id,'location_id' => $location_id,'sub_location_id' => $sub_location_id,'property_address' => $property_address,'plot_area' => $plot_area,'property_ms_unit' => $property_ms_unit,'price' => $price,'property_status' => $property_status,'youtube_video_link' => $youtube_video_link,'is_furnished' => $is_furnished,'source_of_listing' => $source_of_listing,'ip_address' => $ip_address,'updated_on' => $date_times);   
					
					$res = $this->properties_model->update_property_data($args1,$datas); 
					if(isset($res)){  
						
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}  
					 
					/*if(isset($_POST['saves_and_new'])){
						redirect("properties/add");
					}else{
						redirect("properties/index");	
					}*/ 
					
					if(isset($args0) && $args0==1){
						redirect("properties/archived_listings");	
					}else if(isset($args0) && $args0==2){
						redirect("properties/dealt_properties_list");
					}else if(isset($args0) && $args0==3){
						redirect("properties/sales_listings");
					}else if(isset($args0) && $args0==4){   
						redirect("properties/rent_listings");
					}else if(isset($args0) && $args0 ==5){ 
						redirect("properties/leads_properties_list");
					}else if(isset($args0) && $args0==6){   
						redirect("properties/portal_properties_list");	
					}else{ 
						redirect("properties/properties_list");
					}  
					
					/*if($args0 == 3){
						redirect("properties/add");
					}else if($args0 == 4){
						redirect("properties/add");
					}else */
					
				} 	 
				
			}else{
				$this->load->view('properties/update',$data);
			}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}
	}  
	 
	 
	 function property_detail($args1=''){
		$res_nums =  $this->general_model->check_controller_method_permission_access('Properties','view',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			if($args1>0){ 
			
				$data['page_headings'] = "Update Property";	
				$vs_user_type_id = $this->session->userdata('us_role_id');
				$vs_id = $this->session->userdata('us_id'); 
				$data['args1'] = $args1; 
				$data['record'] = $this->properties_model->get_property_detail_by_id($args1);
			 
				$this->load->view('properties/property_detail',$data); 
				
			}else{
				$this->load->view('no_permission_access'); 
			} 
		}else{ 
			$this->load->view('no_permission_access'); 
		}
	}  


	 /* properties operations starts */
	 
	 //function trash($args2=''){ }  
	    
	 function fetch_emirate_locations($args3=''){ 
		$data['emirate_location_arrs'] = $this->properties_model->fetch_emirate_locations($args3);
		$this->load->view('ajax/fetch_emirate_locations',$data); 
	 }
	 
	 function fetch_emirate_sub_locations($args3=''){ 
		$data['emirate_sub_location_arrs'] = $this->properties_model->fetch_emirate_sub_locations($args3);
		$this->load->view('ajax/fetch_emirate_sub_locations',$data); 
	 }
	 
	 
	  function fetch_property_list_emirate_locations($args3=''){ 
		$data['emirate_location_arrs'] = $this->properties_model->fetch_property_list_emirate_locations($args3);
		$this->load->view('ajax/fetch_property_list_emirate_locations',$data); 
	 }							
	 
	 function fetch_property_list_emirate_sub_locations($args3=''){ 
		$data['emirate_sub_location_arrs'] = $this->properties_model->fetch_property_list_emirate_sub_locations($args3);
		$this->load->view('ajax/fetch_property_list_emirate_sub_locations',$data); 
	 }
	  
	 
	 function operate_property_notes(){  
	  
		$ip_address1 = $_SERVER['REMOTE_ADDR']; 
		$datatimes1 = date('Y-m-d H:i:s');
		
		if(isset($_POST['propertyid'])){
			$propertyid1 = $this->input->post('propertyid');  
		}else{
			$propertyid1 = -1; 	
		}
		
		if(isset($_POST['notes_txt']) && strlen($_POST['notes_txt'])>0){
			$notes_txt = $this->input->post('notes_txt');     
		}  
		
		$tmp_datas = array('user_id' => $this->login_vs_id,'notes' => $notes_txt,'property_id' => $propertyid1,'ip_address' => $ip_address1,'datatimes' => $datatimes1);	
		 
		$this->properties_model->insert_temp_property_notes($tmp_datas);
		
		if($propertyid1 == -1){  
			$_SESSION['Temp_NT_DATE_Times'] = $datatimes1;
			$_SESSION['Temp_NT_IP_Address'] = $ip_address1;
			
			$data['nt_arrs'] = $this->properties_model->get_temp_property_notes(); 
		}else{
			$data['nt_arrs'] = $this->properties_model->get_property_notes($propertyid1); 
		} 
		
		$this->load->view('properties/property_notes_list',$data); 
	  
	}  
	 
	  function fetch_property_emirate_locations($args3=''){ 
		$data['emirate_location_arrs'] = $this->properties_model->fetch_emirate_locations($args3);
		$this->load->view('ajax/fetch_emirate_property_locations',$data); 
	 }
	 
	 function fetch_property_emirate_sub_locations($args3=''){ 
		$data['emirate_sub_location_arrs'] = $this->properties_model->fetch_emirate_sub_locations($args3);
		$this->load->view('ajax/fetch_emirate_property_sub_locations',$data); 
	 } 
	 
	 function fetch_property_emirate_sub_location_areas($args3=''){ 
		$data['emirate_sub_location_area_arrs'] = $this->general_model->get_emirate_sub_location_areas_info_by_id($args3);
		$this->load->view('ajax/fetch_emirate_property_sub_location_areas',$data); 
	 } 
	
	 function fetch_property_type_status($args3=''){ 
		$data['property_type'] = $args3;
		$this->load->view('ajax/fetch_property_type_status',$data); 
	 } 
	 
	 function property_media_photos_order_settings(){ 
		$datetimes = date('Y-m-d H:i');
		$tmp_proprtyid = -1;           
		$tmp_ips = (isset($_SESSION['Temp_IP_Address']) && strlen($_SESSION['Temp_IP_Address'])>0) ? $_SESSION['Temp_IP_Address']: '';
		$tmp_dts = (isset($_SESSION['Temp_DATE_Times']) && strlen($_SESSION['Temp_DATE_Times'])>0) ? $_SESSION['Temp_DATE_Times']: ''; 
			
			
		if(isset($_POST['propertyid'])){
			$propertyid = $_POST['propertyid'];
			$cstm_data_arrss = json_decode($_POST['data']);
			if(isset($cstm_data_arrss) && count($cstm_data_arrss)>0){
				foreach($cstm_data_arrss as $cstm_data_arrs){ 
					$img_order = $cstm_data_arrs[0];	
					$img_name = $cstm_data_arrs[1];  
					
					$tmp_datas = array('sort_order' => $img_order,'datatimes' => $datetimes);	
					if($propertyid == -1){ 
						$_SESSION['Temp_DATE_Times'] = $datetimes;	
						$this->properties_model->set_property_tmp_photos_order_by_propertyid_name($tmp_proprtyid,$img_name,$tmp_ips,$tmp_dts,$tmp_datas);
						 
					}else{
						$this->properties_model->set_property_photos_order_by_propertyid_name($propertyid, $img_name,$tmp_datas);  
					} 
				} 
			} 
			 
			$prp_tmp_datas = array('updated_on' => $datetimes);	
			$this->properties_model->update_property_data($propertyid,$prp_tmp_datas);
		}   
	}
	
	
	 function get_property_dropzone_photos_by_id($args1=''){
		$docs_result  = array();   
		$db_docs_arrs = $this->properties_model->get_property_dropzone_photos_by_id($args1); 
		if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
			foreach($db_docs_arrs as $db_docs_arr){
				$tempobj['name'] = $db_docs_arr->image;
				$tempobj['size'] = $db_docs_arr->sizes;
				$docs_result[] = $tempobj;
			} 
		} 
		header('Content-type: text/json');
		header('Content-type: application/json');
		echo json_encode($docs_result);
	
	}


	 function delete_property_dropzone_photos(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
			
			if(strlen($tmp_fle_name)>0 && $tmp_proprty_id>0){ 
				$dlt_res = $this->properties_model->delete_property_dropzone_photos($tmp_fle_name,$tmp_proprty_id);
				if($dlt_res){
					unlink("downloads/property_photos/".$tmp_fle_name);
				}
			} 	
		}
	}  


	 function get_temp_post_property_dropzone_photos(){
		$docs_result  = array();   
		$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_photos();
		if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
			foreach($db_docs_arrs as $db_docs_arr){
				$tempobj['name'] = $db_docs_arr->image;
				$tempobj['size'] = $db_docs_arr->sizes;
				$docs_result[] = $tempobj;
			} 
		} 
		header('Content-type: text/json');
		header('Content-type: application/json');
		echo json_encode($docs_result);
	
	}
	 
	 
	 function delete_temp_property_dropzone_photos(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){		
			$tmp_ip_address= isset($_SESSION['Temp_IP_Address']) ? $_SESSION['Temp_IP_Address']:'';
			$tmp_dt_time = isset($_SESSION['Temp_DATE_Times']) ? $_SESSION['Temp_DATE_Times']:'';	
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
				
			if($tmp_proprty_id== -1 && (strlen($tmp_fle_name)>0 && strlen($tmp_ip_address)>0 && strlen($tmp_dt_time)>0)){
			
				$dlt_res = $this->properties_model->delete_temp_property_dropzone_photos($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
				
				if($dlt_res){
					unlink("downloads/property_photos/".$tmp_fle_name);
				} 
			} 	  	
		}
	}
	 
	 
	 function property_media_photos_upload(){ 
		$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
		$tmp_dt_time = date('Y-m-d H:i');
		$tmp_propty_id = (isset($_POST["proprtyid"]) && $_POST['proprtyid']>0) ? $_POST['proprtyid'] : -1;
		$phto_name = $phto_error = $phto_error0 = '';  
		
		$phto_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
		$phto_ret = array();
		$max_size = 2000; //max image size in Pixels 
		$watermark_png_file = base_url().'assets/images/watermark.png'; 
		
		if(isset($_FILES["images"]['name']) && count($_FILES["images"]['name'])>0){ 
			
			for($j=0; $j < count($_FILES["images"]['name']); $j++){ 
				
				if(isset($_FILES['images']['tmp_name'][$j]) && $_FILES['images']['tmp_name'][$j]!=''){ 
					if(!(in_array($_FILES['images']['type'][$j],$phto_alw_typs))){
						$tmp_phto_type = "'".($_FILES['images']['type'][$j])."'";
						$phto_error0 = "Photo(s): $tmp_phto_type not allowed!<br>";
						$phto_error .= $phto_error0;
					}
					
					if($phto_error0==''){
					
						//@unlink("downloads/property_photos/{$phto_name}");
						//$parentpageid1 = str_replace('-',' ',$parentpageid);
						$tmpimg_nm = str_replace(' ','', $_FILES['images']['name'][$j]);
						$phto_name = $this->general_model->fileExists($tmpimg_nm,"downloads/property_photos/");  //thumbs/
						
						$image_size = $phto_sizes = $_FILES['images']['size'][$j];  
						$phto_ret[]= $phto_name;
						  
						$image_name = $phto_name; 
						$image_temp = $_FILES['images']['tmp_name'][$j]; //file temp
						$image_type = $_FILES['images']['type'][$j];
						switch(strtolower($image_type)){ //determine uploaded image type 
							//Create new image from file
							case 'image/png': 
								$image_resource = imagecreatefrompng($image_temp);
								break;
							case 'image/gif':
								$image_resource = imagecreatefromgif($image_temp);
								break;          
							case 'image/jpeg': case 'image/pjpeg':
								$image_resource = imagecreatefromjpeg($image_temp);
								break;
							default:
								$image_resource = false;
						} 
							
						if($image_resource){
							//Copy and resize part of an image with resampling
							list($img_width, $img_height) = getimagesize($image_temp);
							
							//Construct a proportional size of new image
							$image_scale        = min($max_size / $img_width, $max_size / $img_height); 
							$new_image_width    = ceil($image_scale * $img_width);
							$new_image_height   = ceil($image_scale * $img_height);
							$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
						
							if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height)) {
								  
								//center watermark
								$watermark_left = ($new_image_width/2)-(450/2); //watermark left
								$watermark_bottom = ($new_image_height/2)-(170/2); //watermark bottom
						
								$watermark = imagecreatefrompng($watermark_png_file); //watermark image
								imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 175); //merge image
								
								//Or Save image to the folder
								imagejpeg($new_canvas, "downloads/property_photos/".$image_name , 90);
								
								//free up memory
								imagedestroy($new_canvas); 
								imagedestroy($image_resource);
								//die();
							}
						}else{
							 copy($_FILES['images']['tmp_name'][$j],"downloads/property_photos/".$phto_name);  	
						}   
		  
						if($tmp_propty_id== -1){
							$sort_val = $this->properties_model->get_tmp_max_property_photos_sort_val($tmp_propty_id,$tmp_ip_address);
						}else{
							$sort_val = $this->properties_model->get_max_property_photos_sort_val($tmp_propty_id);
						}
						 $sort_val = $sort_val +1;
						 
						 
						 $datas2 = array('image' => $phto_name,'sort_order' => $sort_val,'sizes' => $phto_sizes,'property_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
						 $this->properties_model->insert_property_photo_data($datas2);
					}  
				}   
			}  
		}else if(isset($_FILES["images"]['tmp_name']) && $_FILES['images']['tmp_name']!=''){ 
		
			if(!(in_array($_FILES['images']['type'],$phto_alw_typs))){
				$tmp_phto_type = "'".($_FILES['images']['type'])."'";
				$phto_error0 = "Photo(s): $tmp_phto_type not allowed!<br>";
				$phto_error .= $phto_error0;
			}
			
			if($phto_error0==''){
				$tmpimg_nm = str_replace(' ','', $_FILES['images']['name']);
				$phto_name = $this->general_model->fileExists($tmpimg_nm,"downloads/property_photos/");  //thumbs/
				 
				$image_size = $phto_sizes = $_FILES['images']['size']; 
				$phto_ret[]= $phto_name;
				  
				$image_name = $phto_name; 
				$image_temp = $_FILES['images']['tmp_name']; //file temp
				$image_type = $_FILES['images']['type'];
				switch(strtolower($image_type)){ //determine uploaded image type 
					//Create new image from file
					case 'image/png': 
						$image_resource = imagecreatefrompng($image_temp);
						break;
					case 'image/gif':
						$image_resource = imagecreatefromgif($image_temp);
						break;          
					case 'image/jpeg': case 'image/pjpeg':
						$image_resource = imagecreatefromjpeg($image_temp);
						break;
					default:
						$image_resource = false;
				} 
					
				if($image_resource){
					//Copy and resize part of an image with resampling
					list($img_width, $img_height) = getimagesize($image_temp);
					
					//Construct a proportional size of new image
					$image_scale        = min($max_size / $img_width, $max_size / $img_height); 
					$new_image_width    = ceil($image_scale * $img_width);
					$new_image_height   = ceil($image_scale * $img_height);
					$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
				
					if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height)) {
						  
						//center watermark
						$watermark_left = ($new_image_width/2)-(450/2); //watermark left
						$watermark_bottom = ($new_image_height/2)-(170/2); //watermark bottom
				
						$watermark = imagecreatefrompng($watermark_png_file); //watermark image
						imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 175); //merge image
						
						//Or Save image to the folder
						imagejpeg($new_canvas, "downloads/property_photos/".$image_name , 90);
						
						//free up memory
						imagedestroy($new_canvas); 
						imagedestroy($image_resource);
						//die();
					}
				}else{
					copy($_FILES['images']['tmp_name'],"downloads/property_photos/".$phto_name);  	
				}   
				 
				 if($tmp_propty_id== -1){
					$sort_val = $this->properties_model->get_tmp_max_property_photos_sort_val($tmp_propty_id,$tmp_ip_address);
				}else{
					$sort_val = $this->properties_model->get_max_property_photos_sort_val($tmp_propty_id);
				}
				 $sort_val = $sort_val +1; 
				 
				 $datas2 = array('image' => $phto_name,'sort_order' => $sort_val,'sizes' => $phto_sizes,'property_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time);
				  
				 $this->properties_model->insert_property_photo_data($datas2);
			}
		}
		echo json_encode($phto_ret);
	}
	 
	 
	 function temp_property_media_photos_upload(){ 
		/* media photo script starts */ 
		if(isset($_FILES["images"]) && count($_FILES["images"]['name'])>0){
			$_SESSION['Temp_Media_Images'] = $_FILES["images"];
		}else if(isset($_FILES["images"]['tmp_name']) && $_FILES['images']['tmp_name']!=''){
			$_SESSION['Temp_Media_Images'] = $_FILES["images"];
		}else{
			unset($_SESSION['Temp_Media_Images']);
		} 
		
		$phto_name = $phto_error = $phto_error0 = '';  
		
		$phto_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
		$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
		$tmp_dt_time = date('Y-m-d H:i');
		$tmp_propty_id = -1;
		$phto_ret = array();
		$max_size = 2000; //max image size in Pixels 
		$watermark_png_file = base_url().'assets/images/watermark.png';

 
		if(isset($_FILES["images"]['name']) && count($_FILES["images"]['name'])>0){ 
			$_SESSION['Temp_IP_Address'] = $tmp_ip_address;
			$_SESSION['Temp_DATE_Times'] = $tmp_dt_time;
			
			for($j=0; $j < count($_FILES["images"]['name']); $j++){ 
				
				if(isset($_FILES['images']['tmp_name'][$j]) && $_FILES['images']['tmp_name'][$j]!=''){ 
					if(!(in_array($_FILES['images']['type'][$j],$phto_alw_typs))){
						$tmp_phto_type = "'".($_FILES['images']['type'][$j])."'";
						$phto_error0 = "Photo(s): $tmp_phto_type not allowed!<br>";
						$phto_error .= $phto_error0;
					}
					
					if($phto_error0==''){
					
						//@unlink("downloads/property_photos/{$phto_name}");
						$tmpimg_nm = str_replace(' ','', $_FILES['images']['name'][$j]); 
						 
						$phto_name = $this->general_model->fileExists($tmpimg_nm,"downloads/property_photos/");  //thumbs/
						   
						 $image_size = $phto_sizes = $_FILES['images']['size'][$j]; 
						 $phto_ret[]= $phto_name;
						  
						$image_name = $phto_name; 
						$image_temp = $_FILES['images']['tmp_name'][$j]; //file temp
						$image_type = $_FILES['images']['type'][$j];
						switch(strtolower($image_type)){ //determine uploaded image type 
							//Create new image from file
							case 'image/png': 
								$image_resource = imagecreatefrompng($image_temp);
								break;
							case 'image/gif':
								$image_resource = imagecreatefromgif($image_temp);
								break;          
							case 'image/jpeg': case 'image/pjpeg':
								$image_resource = imagecreatefromjpeg($image_temp);
								break;
							default:
								$image_resource = false;
						} 
							
						if($image_resource){
							//Copy and resize part of an image with resampling
							list($img_width, $img_height) = getimagesize($image_temp);
							
							//Construct a proportional size of new image
							$image_scale        = min($max_size / $img_width, $max_size / $img_height); 
							$new_image_width    = ceil($image_scale * $img_width);
							$new_image_height   = ceil($image_scale * $img_height);
							$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
						
							if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height)) {
								  
								//center watermark
								$watermark_left = ($new_image_width/2)-(450/2); //watermark left
								$watermark_bottom = ($new_image_height/2)-(170/2); //watermark bottom
						
								$watermark = imagecreatefrompng($watermark_png_file); //watermark image
								imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 175); //merge image
								
								//Or Save image to the folder
								imagejpeg($new_canvas, "downloads/property_photos/".$image_name , 90);
								
								//free up memory
								imagedestroy($new_canvas); 
								imagedestroy($image_resource);
								//die();
							}
						}else{
							 copy($_FILES['images']['tmp_name'][$j],"downloads/property_photos/".$phto_name);	
						}  
						  
						 
						if($tmp_propty_id== -1){
							$sort_val = $this->properties_model->get_tmp_max_property_photos_sort_val($tmp_propty_id,$tmp_ip_address);
						}else{
							$sort_val = $this->properties_model->get_max_property_photos_sort_val($tmp_propty_id);
						}
						 $sort_val = $sort_val +1;  
						 
						 $datas2 = array('image' => $phto_name,'sort_order' => $sort_val,'sizes' => $phto_sizes,'property_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
						  
						 $this->properties_model->insert_property_photo_data($datas2);	 
						 
					}  
				}   
			}  
		}else if(isset($_FILES["images"]['tmp_name']) && $_FILES['images']['tmp_name']!=''){ 
			$_SESSION['Temp_IP_Address'] = $tmp_ip_address;
			$_SESSION['Temp_DATE_Times'] = $tmp_dt_time;
			
			$phto_name = $phto_error = $phto_error0 = '';   
			
			$phto_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
			if(!(in_array($_FILES['images']['type'],$phto_alw_typs))){
				$tmp_phto_type = "'".($_FILES['images']['type'])."'";
				$phto_error0 = "Photo(s): $tmp_phto_type not allowed!<br>";
				$phto_error .= $phto_error0;
			}
			
			if($phto_error0==''){
				$tmpimg_nm = str_replace(' ','', $_FILES['images']['name']); 
				$phto_name = $this->general_model->fileExists($tmpimg_nm,"downloads/property_photos/");  //thumbs/
				  
				 $image_size = $phto_sizes = $_FILES['images']['size']; 
				 $phto_ret[]= $phto_name;
				  
				$image_name = $phto_name; 
				$image_temp = $_FILES['images']['tmp_name']; //file temp
				$image_type = $_FILES['images']['type'];
				switch(strtolower($image_type)){ //determine uploaded image type 
					//Create new image from file
					case 'image/png': 
						$image_resource = imagecreatefrompng($image_temp);
						break;
					case 'image/gif':
						$image_resource = imagecreatefromgif($image_temp);
						break;          
					case 'image/jpeg': case 'image/pjpeg':
						$image_resource = imagecreatefromjpeg($image_temp);
						break;
					default:
						$image_resource = false;
				} 
					
				if($image_resource){
					//Copy and resize part of an image with resampling
					list($img_width, $img_height) = getimagesize($image_temp);
					
					//Construct a proportional size of new image
					$image_scale        = min($max_size / $img_width, $max_size / $img_height); 
					$new_image_width    = ceil($image_scale * $img_width);
					$new_image_height   = ceil($image_scale * $img_height);
					$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
				
					if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height)) {
						  
						//center watermark
						$watermark_left = ($new_image_width/2)-(450/2); //watermark left
						$watermark_bottom = ($new_image_height/2)-(170/2); //watermark bottom
				
						$watermark = imagecreatefrompng($watermark_png_file); //watermark image
						imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 175); //merge image
						
						//Or Save image to the folder
						imagejpeg($new_canvas, "downloads/property_photos/".$image_name , 90);
						
						//free up memory
						imagedestroy($new_canvas); 
						imagedestroy($image_resource);
						//die();
					}
				}else{
					 copy($_FILES['images']['tmp_name'],"downloads/property_photos/".$phto_name); 
				}   
				   
				 
				 if($tmp_propty_id== -1){
					$sort_val = $this->properties_model->get_tmp_max_property_photos_sort_val($tmp_propty_id,$tmp_ip_address);
				}else{
					$sort_val = $this->properties_model->get_max_property_photos_sort_val($tmp_propty_id);
				}
				 $sort_val = $sort_val +1;   
				  
				 $datas2 = array('image' => $phto_name,'sort_order' => $sort_val,'sizes' => $phto_sizes,'property_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
				 $this->properties_model->insert_property_photo_data($datas2);
				  
			}
		}
		
		echo json_encode($phto_ret); 
		/* media photo script ends */ 
	} 
	
	
	
	
	function get_property_dropzone_documents_by_id($args1=''){  
		$docs_result  = array();  
		$db_docs_arrs = $this->properties_model->get_property_dropzone_documents_by_id($args1); 
		if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
			foreach($db_docs_arrs as $db_docs_arr){
				$tempobj['name'] = $db_docs_arr->name;
				$tempobj['size'] = $db_docs_arr->sizes;
				$docs_result[] = $tempobj;
			} 
		}
		header('Content-type: text/json');
		header('Content-type: application/json');
		echo json_encode($docs_result);
	}
	
	
	function get_temp_post_property_dropzone_documents(){  
		$docs_result  = array();  
		$db_docs_arrs = $this->properties_model->get_temp_post_property_dropzone_documents(); 
		if(isset($db_docs_arrs) && count($db_docs_arrs)>0){ 
			foreach($db_docs_arrs as $db_docs_arr){
				$tempobj['name'] = $db_docs_arr->name;
				$tempobj['size'] = $db_docs_arr->sizes;
				$docs_result[] = $tempobj;
			} 
		}
		header('Content-type: text/json');
		header('Content-type: application/json');
		echo json_encode($docs_result);
	} 
	
	
	function delete_property_dropzone_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
			
			if(strlen($tmp_fle_name)>0 && $tmp_proprty_id>0){ 
				$dlt_res = $this->properties_model->delete_property_dropzone_documents($tmp_fle_name,$tmp_proprty_id);
				if($dlt_res){
					unlink("downloads/property_documents/".$tmp_fle_name);
				}
			} 	
		}
	} 
	
	
	function delete_temp_property_dropzone_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){		
			$tmp_ip_address= isset($_SESSION['Temp_Documents_IP_Address']) ? $_SESSION['Temp_Documents_IP_Address']:'';
			$tmp_dt_time = isset($_SESSION['Temp_Documents_DATE_Times']) ? $_SESSION['Temp_Documents_DATE_Times']:'';	
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
				
			if($tmp_proprty_id== -1 && (strlen($tmp_fle_name)>0 && strlen($tmp_ip_address)>0 && strlen($tmp_dt_time)>0)){
			
				$dlt_res = $this->properties_model->delete_temp_property_dropzone_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
				
				if($dlt_res){
					unlink("downloads/property_documents/".$tmp_fle_name);
				} 
			} 	  	
		}
	} 
	
	
	function property_documents_files_upload(){ 
		$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
		$tmp_dt_time = date('Y-m-d H:i');
		$tmp_propty_id = (isset($_POST["proprtyid"]) && $_POST['proprtyid']>0) ? $_POST['proprtyid'] : -1;
		$docmnt_name = $docmnts_error = $docmnts_error0 = '';
		
		$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
		
		$docs_ret = array();
		$max_size = 2000; //max image size in Pixels 
		$watermark_png_file = base_url().'assets/images/watermark.png';
			
		if(isset($_FILES["documents"]['name']) && count($_FILES["documents"]['name'])>0){ 
			 
			for($j=0; $j < count($_FILES["documents"]['name']); $j++){ 
				
				if(isset($_FILES['documents']['tmp_name'][$j]) && $_FILES['documents']['tmp_name'][$j]!=''){ 
					if(!(in_array($_FILES['documents']['type'][$j],$docmnts_alw_typs ))){
						$tmp_docmnts_type = "'".($_FILES['documents']['type'][$j])."'";
						$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
						$docmnts_error .= $docmnts_error0;
					}
					
					if($docmnts_error0==''){
					
						//@unlink("downloads/property_documents/{$docmnt_name}");
						//$parentpageid1 = str_replace('-',' ',$parentpageid);
						
						$docmnt_name = $this->general_model->fileExists($_FILES['documents']['name'][$j],"downloads/property_documents/");  //thumbs/
						
						$image_size = $docmnt_sizes = $_FILES['documents']['size'][$j];  
						$docs_ret[]= $docmnt_name;
						  
						$image_name = $docmnt_name; 
						$image_temp = $_FILES['documents']['tmp_name'][$j]; //file temp
						$image_type = $_FILES['documents']['type'][$j];
						switch(strtolower($image_type)){ //determine uploaded image type 
							//Create new image from file
							case 'image/png': 
								$image_resource = imagecreatefrompng($image_temp);
								break;
							case 'image/gif':
								$image_resource = imagecreatefromgif($image_temp);
								break;          
							case 'image/jpeg': case 'image/pjpeg':
								$image_resource = imagecreatefromjpeg($image_temp);
								break;
							default:
								$image_resource = false;
						} 
							
						if($image_resource){
							//Copy and resize part of an image with resampling
							list($img_width, $img_height) = getimagesize($image_temp);
							
							//Construct a proportional size of new image
							$image_scale        = min($max_size / $img_width, $max_size / $img_height); 
							$new_image_width    = ceil($image_scale * $img_width);
							$new_image_height   = ceil($image_scale * $img_height);
							$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
						
							if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height)) {
								  
								//center watermark
								$watermark_left = ($new_image_width/2)-(450/2); //watermark left
								$watermark_bottom = ($new_image_height/2)-(170/2); //watermark bottom
						
								$watermark = imagecreatefrompng($watermark_png_file); //watermark image
								imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 175); //merge image
								
								//Or Save image to the folder
								imagejpeg($new_canvas, "downloads/property_documents/".$image_name , 90);
								
								//free up memory
								imagedestroy($new_canvas); 
								imagedestroy($image_resource);
								//die();
							}
						}else{
							copy($_FILES['documents']['tmp_name'][$j],"downloads/property_documents/".$docmnt_name);   	
						}    
						 
						 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'property_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
						  
						 $this->properties_model->insert_property_documents_data($datas2);
					}  
				}   
			}  
		}else if(isset($_FILES["documents"]['tmp_name']) && $_FILES['documents']['tmp_name']!=''){ 
		
			if(!(in_array($_FILES['documents']['type'],$docmnts_alw_typs ))){
				$tmp_docmnts_type = "'".($_FILES['documents']['type'])."'";
				$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
				$docmnts_error .= $docmnts_error0;
			}
			
			if($docmnts_error0==''){
			
				$docmnt_name = $this->general_model->fileExists($_FILES['documents']['name'],"downloads/property_documents/");  //thumbs/
				
				// copy($_FILES['documents']['tmp_name'],"downloads/property_documents/".$docmnt_name);  
				$image_size = $docmnt_sizes = $_FILES['documents']['size']; 
				$docs_ret[]= $docmnt_name;
				   
				$image_name = $docmnt_name; 
				$image_temp = $_FILES['documents']['tmp_name']; //file temp
				$image_type = $_FILES['documents']['type'];
				switch(strtolower($image_type)){ //determine uploaded image type 
					//Create new image from file
					case 'image/png': 
						$image_resource = imagecreatefrompng($image_temp);
						break;
					case 'image/gif':
						$image_resource = imagecreatefromgif($image_temp);
						break;          
					case 'image/jpeg': case 'image/pjpeg':
						$image_resource = imagecreatefromjpeg($image_temp);
						break;
					default:
						$image_resource = false;
				} 
					
				if($image_resource){
					//Copy and resize part of an image with resampling
					list($img_width, $img_height) = getimagesize($image_temp);
					
					//Construct a proportional size of new image
					$image_scale        = min($max_size / $img_width, $max_size / $img_height); 
					$new_image_width    = ceil($image_scale * $img_width);
					$new_image_height   = ceil($image_scale * $img_height);
					$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
				
					if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height)) {
						  
						//center watermark
						$watermark_left = ($new_image_width/2)-(450/2); //watermark left
						$watermark_bottom = ($new_image_height/2)-(170/2); //watermark bottom
				
						$watermark = imagecreatefrompng($watermark_png_file); //watermark image
						imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 175); //merge image
						//Or Save image to the folder
						imagejpeg($new_canvas, "downloads/property_documents/".$image_name , 90);
						
						//free up memory
						imagedestroy($new_canvas); 
						imagedestroy($image_resource);
						//die();
					}
				}else{
					copy($_FILES['documents']['tmp_name'],"downloads/property_documents/".$docmnt_name);   	
				}   
				 
				 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'property_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
				 $this->properties_model->insert_property_documents_data($datas2);
			}
		}
		echo json_encode($docs_ret);
	}  
	
	
	function temp_property_documents_files_upload(){ 
		/* media photo script starts */ 
		if(isset($_FILES["documents"]) && count($_FILES["documents"]['name'])>0){
			$_SESSION['Temp_Documents_Files'] = $_FILES["documents"];
		}else if(isset($_FILES["documents"]['tmp_name']) && $_FILES['documents']['tmp_name']!=''){
			$_SESSION['Temp_Documents_Files'] = $_FILES["documents"];
		}else{
			unset($_SESSION['Temp_Documents_Files']);
		} 
		
		$docmnt_name = $docmnts_error = $docmnts_error0 = '';  
		
		$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
		
		$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
		$tmp_dt_time = date('Y-m-d H:i');
		$tmp_propty_id = -1;
		$docs_ret = array();
		$max_size = 2000; //max image size in Pixels 
		$watermark_png_file = base_url().'assets/images/watermark.png';
			 
		if(isset($_FILES["documents"]['name']) && count($_FILES["documents"]['name'])>0){ 
			$_SESSION['Temp_Documents_IP_Address'] = $tmp_ip_address;
			$_SESSION['Temp_Documents_DATE_Times'] = $tmp_dt_time;
			  
			for($j=0; $j < count($_FILES["documents"]['name']); $j++){ 
				
				if(isset($_FILES['documents']['tmp_name'][$j]) && $_FILES['documents']['tmp_name'][$j]!=''){ 
					if(!(in_array($_FILES['documents']['type'][$j],$docmnts_alw_typs ))){
						$tmp_docmnts_type = "'".($_FILES['documents']['type'][$j])."'";
						$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
						$docmnts_error .= $docmnts_error0;
					}
					 //file type
					
					if($docmnts_error0==''){ 
						//@unlink("downloads/property_documents/{$docmnt_name}");
						$docmnt_name = $this->general_model->fileExists($_FILES['documents']['name'][$j],"downloads/property_documents/");  //thumbs/
						  
						$image_size = $docmnt_sizes = $_FILES['documents']['size'][$j]; 
						$docs_ret[]= $docmnt_name; 
						$image_name = $docmnt_name; 
						$image_temp = $_FILES['documents']['tmp_name'][$j]; //file temp
						$image_type = $_FILES['documents']['type'][$j];
						switch(strtolower($image_type)){ //determine uploaded image type 
							//Create new image from file
							case 'image/png': 
								$image_resource = imagecreatefrompng($image_temp);
								break;
							case 'image/gif':
								$image_resource = imagecreatefromgif($image_temp);
								break;          
							case 'image/jpeg': case 'image/pjpeg':
								$image_resource = imagecreatefromjpeg($image_temp);
								break;
							default:
								$image_resource = false;
						} 
							
						if($image_resource){
							//Copy and resize part of an image with resampling
							list($img_width, $img_height) = getimagesize($image_temp);
							
							//Construct a proportional size of new image
							$image_scale        = min($max_size / $img_width, $max_size / $img_height); 
							$new_image_width    = ceil($image_scale * $img_width);
							$new_image_height   = ceil($image_scale * $img_height);
							$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
					
							if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height)) {
								  
								//center watermark
								$watermark_left = ($new_image_width/2)-(450/2); //watermark left
								$watermark_bottom = ($new_image_height/2)-(170/2); //watermark bottom
					
								$watermark = imagecreatefrompng($watermark_png_file); //watermark image
								imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 175); //merge image
								
								//Or Save image to the folder
								imagejpeg($new_canvas, "downloads/property_documents/".$image_name , 90);
								
								//free up memory
								imagedestroy($new_canvas); 
								imagedestroy($image_resource);
								//die();
							}
						}else{
							copy($_FILES['documents']['tmp_name'][$j],"downloads/property_documents/".$docmnt_name); 	
						}  
						
						 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'property_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
						  
						 $this->properties_model->insert_property_documents_data($datas2);
						  
					}  
				}   
			}  
		}else if(isset($_FILES["documents"]['tmp_name']) && $_FILES['documents']['tmp_name']!=''){ 
			$_SESSION['Temp_Documents_IP_Address'] = $tmp_ip_address;
			$_SESSION['Temp_Documents_DATE_Times'] = $tmp_dt_time;
			
			$docmnt_name = $docmnts_error = $docmnts_error0 = '';    
			
			$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
		
			if(!(in_array($_FILES['documents']['type'],$docmnts_alw_typs ))){
				$tmp_docmnts_type = "'".($_FILES['documents']['type'])."'";
				$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
				$docmnts_error .= $docmnts_error0;
			}
			
			if($docmnts_error0==''){
			
				$docmnt_name = $this->general_model->fileExists($_FILES['documents']['name'],"downloads/property_documents/");  //thumbs/
				
				// copy($_FILES['documents']['tmp_name'],"downloads/property_documents/".$docmnt_name);  
				$image_size = $docmnt_sizes = $_FILES['documents']['size']; 
				$docs_ret[]= $docmnt_name; 
				$image_name = $docmnt_name; 
				
				$image_temp = $_FILES['documents']['tmp_name']; //file temp
				$image_type = $_FILES['documents']['type'];
				switch(strtolower($image_type)){ //determine uploaded image type 
					//Create new image from file
					case 'image/png': 
						$image_resource = imagecreatefrompng($image_temp);
						break;
					case 'image/gif':
						$image_resource = imagecreatefromgif($image_temp);
						break;          
					case 'image/jpeg': case 'image/pjpeg':
						$image_resource = imagecreatefromjpeg($image_temp);
						break;
					default:
						$image_resource = false;
				} 
					
				if($image_resource){
					//Copy and resize part of an image with resampling
					list($img_width, $img_height) = getimagesize($image_temp);
					
					//Construct a proportional size of new image
					$image_scale        = min($max_size / $img_width, $max_size / $img_height); 
					$new_image_width    = ceil($image_scale * $img_width);
					$new_image_height   = ceil($image_scale * $img_height);
					$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
			
					if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height)) {
						  
						//center watermark
						$watermark_left = ($new_image_width/2)-(450/2); //watermark left
						$watermark_bottom = ($new_image_height/2)-(170/2); //watermark bottom
			
						$watermark = imagecreatefrompng($watermark_png_file); //watermark image
						imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 175); //merge image
						
						//Or Save image to the folder
						imagejpeg($new_canvas, "downloads/property_documents/".$image_name , 90);
						
						//free up memory
						imagedestroy($new_canvas); 
						imagedestroy($image_resource);
						//die();
					}
				}else{
					copy($_FILES['documents']['tmp_name'],"downloads/property_documents/".$docmnt_name);   	
				}  
				 
				 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'property_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
				 $this->properties_model->insert_property_documents_data($datas2);
			}
		}
		
		echo json_encode($docs_ret); 
		/* media photo script ends */ 
	}
	  	
	
	
	
	
	

	function portal_properties_list($paras1=''){ 
		$paras_arrs = $datas = array(); 
		$datas['page_headings']="Portal(s) Properties";
		$datas['paras1'] = $paras1;
		
		if(isset($paras1) && $paras1>0){
			$portal_id_vals = $paras1; 
			$_SESSION['tmp_portal_id_vals'] = $portal_id_vals;  
			$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
		 
		}else if(isset($_SESSION['tmp_portal_id_vals'])){
				unset($_SESSION['tmp_portal_id_vals']);
			}   
			 
		//total rows count
		$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
		//pagination configuration
		$config['target']      = '#properties_list';
		$config['base_url']    = site_url('/properties/portal_properties_list2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		
		$this->ajax_pagination->initialize($config);
		
		 
		$paras_arrs = array_merge($paras_arrs, array('limit'=>$this->perPage));
		$datas['records'] = $this->properties_model->get_all_cstm_properties($paras_arrs);  
		
		$this->load->view('properties/portal_properties_list',$datas); 
}
	
	
	
	function portal_properties_list2(){
		  
		$paras_arrs = $datas = array();
		$page = $this->input->post('page');
		if(!$page){
			$offset = 0;
		}else{
			$offset = $page;
		} 
		
		$datas['page'] = $page;
		 
		if(isset($_SESSION['tmp_portal_id_vals'])){ 
			$portal_id_vals = $_SESSION['tmp_portal_id_vals'];  
			$paras_arrs = array_merge($paras_arrs, array("portal_id_vals" => $portal_id_vals));
		}
		
		 
		//total rows count
		$totalRec = count($this->properties_model->get_all_cstm_properties($paras_arrs));
		//pagination configuration
		$config['target']      = '#properties_list';
		$config['base_url']    = site_url('/properties/portal_properties_list2'); 
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		
		$this->ajax_pagination->initialize($config);
		
		$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit'=>$this->perPage));
		
		$datas['records'] = $this->properties_model->get_all_recent_properties_list($paras_arrs); 
		
		$this->load->view('properties/portal_properties_list2',$datas);
	}

	
	
	
	
	
	
}
?>
