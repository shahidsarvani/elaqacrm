<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deals extends CI_Controller{

    public function __construct(){ 
        parent::__construct();
		
		$this->login_vs_id = $vs_id = $this->session->userdata('us_id');
		$this->login_vs_user_role_id = $this->dbs_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
		$this->load->model('general_model');
		if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id >=1)){
			/* ok */
			$res_nums = $this->general_model->check_controller_permission_access('Deals',$vs_user_role_id,'1');
			if($res_nums>0){
				/* ok */	 
			}else{
				redirect('/');
			}  
			
		}else{
			redirect('/');
		}  
		
		$this->load->model('deals_model'); 
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
	  
	/* Deals ends */ 
	function sales_listing($temps_property_type=''){
		if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Deals','index',$this->dbs_role_id,'1');  
		if($res_nums>0){
			$paras_arrs = array();
			$data['contact_arrs'] = $this->general_model->get_gen_all_contacts_list();
			$data['owner_arrs'] =$this->general_model->get_gen_all_owners_list();
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			$s_val = $category_id_val = $assigned_to_id_val = $is_featured_val = $is_property_type = '';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
			
			$paras_arrs = array_merge($paras_arrs, array("types_val" => '1'));
	 
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val');
				$_SESSION['tmp_per_page_val'] = $per_page_val;
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				}
				
			if($this->input->post('refer_no')){
				$refer_no_val = $this->input->post('refer_no'); 
				$_SESSION['tmp_refer_no'] = $refer_no_val; 
				$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
			}else if(isset($_SESSION['tmp_refer_no'])){
					unset($_SESSION['tmp_refer_no']);
				}
			 
			if($this->input->post('unit_no')){
				$unit_no_val = $this->input->post('unit_no'); 
				$_SESSION['tmp_unit_no_val'] = $unit_no_val; 
				$paras_arrs = array_merge($paras_arrs, array("unit_no_val" => $unit_no_val));
			}else if(isset($_SESSION['tmp_unit_no_val'])){
					unset($_SESSION['tmp_unit_no_val']);
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
				
			if($this->input->post('sel_est_deal_date_val')){
				$sel_est_deal_date_val = $this->input->post('sel_est_deal_date_val'); 
				$_SESSION['tmp_est_deal_date_val'] = $sel_est_deal_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("est_deal_date_val" => $sel_est_deal_date_val));
			}else if(isset($_SESSION['tmp_est_deal_date_val'])){
					unset($_SESSION['tmp_est_deal_date_val']);
				}	 
	
			if($this->input->post('sel_emirate_location_id_val')){
				$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val'); 
				$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
			}else if(isset($_SESSION['tmp_emirate_location_id_val'])){
					unset($_SESSION['tmp_emirate_location_id_val']);
				} 
				
			if($this->input->post('sel_property_status_val')){
				$property_status_val = $this->input->post('sel_property_status_val'); 
				$_SESSION['tmp_property_status_val'] = $property_status_val;
				$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val));
			}else if(isset($_SESSION['tmp_property_status_val'])){
					unset($_SESSION['tmp_property_status_val']);
				}  
				
			if($this->input->post('sel_assigned_to_id_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_id_val'); 
				$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
			}else if(isset($_SESSION['tmp_assigned_to_id_val'])){
					unset($_SESSION['tmp_assigned_to_id_val']);
				}  
				
			if($this->input->post('owner_id_val')){
				$owner_id_val = $this->input->post('owner_id_val'); 
				$_SESSION['tmp_owner_id_val'] = $owner_id_val;
				$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));
			}else if(isset($_SESSION['tmp_owner_id_val'])){
					unset($_SESSION['tmp_owner_id_val']);
				} 
			
			if($this->input->post('contact_id_val')){
				$contact_id_val = $this->input->post('contact_id_val'); 
				$_SESSION['tmp_contact_id_val'] = $contact_id_val;
				$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val));
			}else if(isset($_SESSION['tmp_contact_id_val'])){
					unset($_SESSION['tmp_contact_id_val']);
				}
			 
			 
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			 
			//total rows count
			$totalRec = count($this->deals_model->get_all_cstm_deals_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/deals/sales_listing2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$records = $data['records'] = $this->deals_model->get_all_cstm_deals_properties($paras_arrs);
			
			/*if($vs_user_type_id==2){ 
				$arrs_field = array('user_type_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('user_type_id'=> '3'); 
			}
			 
			//$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_assigned(); */ 
			
			if($vs_user_type_id==3){
				$arrs_field = array('id' => $vs_id); 
			}else if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				//$arrs_field = array('status'=> '1'); 
				$arrs_field = array('role_id' => '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			  
			if(isset($_SESSION['Temp_Deal_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Deal_Documents_Files']);
				unset($_SESSION['Temp_Deal_Documents_IP_Address']);
				unset($_SESSION['Temp_Deal_Documents_DATE_Times']);
			}
			
			if(isset($_SESSION['Temp_Sellerlandlord_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Sellerlandlord_Documents_Files']);
				unset($_SESSION['Temp_Sellerlandlord_Documents_IP_Address']);
				unset($_SESSION['Temp_Sellerlandlord_Documents_DATE_Times']);
			}
			 
			if(isset($_SESSION['Temp_Buyertenant_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Buyertenant_Documents_Files']);
				unset($_SESSION['Temp_Buyertenant_Documents_IP_Address']);
				unset($_SESSION['Temp_Buyertenant_Documents_DATE_Times']);
			}		
					
			if(isset($_SESSION['Temp_Newtitledeed_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Newtitledeed_Documents_Files']);
				unset($_SESSION['Temp_Newtitledeed_Documents_IP_Address']);
				unset($_SESSION['Temp_Newtitledeed_Documents_DATE_Times']);
			}		 
					
			if(isset($_SESSION['Temp_Agency_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Agency_Documents_Files']);
				unset($_SESSION['Temp_Agency_Documents_IP_Address']);
				unset($_SESSION['Temp_Agency_Documents_DATE_Times']);
			}
			
			$data['page_headings'] = "Sales Deals Listing"; 
			$this->load->view('deals/sales_listing',$data); 	//deals_model  
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}

	function sales_listing2($temps_property_type=''){ 
	 	$res_nums =  $this->general_model->check_controller_method_permission_access('Deals','index',$this->dbs_role_id,'1');  
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
			 
			$paras_arrs = array_merge($paras_arrs, array("types_val" => '1'));
		
			$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val= $is_property_type='';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
			 
			if(isset($_POST['sel_per_page_val'])){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				}
			
			if(isset($_POST['refer_no'])){
				$refer_no_val = $this->input->post('refer_no'); 
				$_SESSION['tmp_refer_no'] = $refer_no_val; 
				$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
			}else if(isset($_SESSION['tmp_refer_no'])){
					unset($_SESSION['tmp_refer_no']);
				}
			 
			if(isset($_POST['unit_no'])){
				$unit_no_val = $this->input->post('unit_no'); 
				$_SESSION['tmp_unit_no_val'] = $unit_no_val; 
				$paras_arrs = array_merge($paras_arrs, array("unit_no_val" => $unit_no_val));
			}else if(isset($_SESSION['tmp_unit_no_val'])){
					unset($_SESSION['tmp_unit_no_val']);
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
			
			 
			if(isset($_POST['sel_est_deal_date_val'])){
				$sel_est_deal_date_val = $this->input->post('sel_est_deal_date_val');  
				if(strlen($sel_est_deal_date_val)>0){
					$_SESSION['tmp_est_deal_date_val'] = $sel_est_deal_date_val; 
					$paras_arrs = array_merge($paras_arrs, array("est_deal_date_val" => $sel_est_deal_date_val));
				}else{
					unset($_SESSION['tmp_est_deal_date_val']);	
				}
			}else if(isset($_SESSION['tmp_est_deal_date_val'])){ ///
				$sel_est_deal_date_val = $_SESSION['tmp_est_deal_date_val']; 
				$paras_arrs = array_merge($paras_arrs, array("est_deal_date_val" => $sel_est_deal_date_val));
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
			}else if(isset($_SESSION['tmp_emirate_location_id_val'])){
					unset($_SESSION['tmp_emirate_location_id_val']);
				}	
			 
			if(isset($_POST['sel_property_status_val'])){
				$property_status_val = $this->input->post('sel_property_status_val'); 
				$_SESSION['tmp_property_status_val'] = $property_status_val;
				$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val));
			}else if(isset($_SESSION['tmp_property_status_val'])){
					unset($_SESSION['tmp_property_status_val']);
				} 			
				
			if(isset($_POST['sel_assigned_to_id_val'])){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_id_val'); 
				$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
			}else if(isset($_SESSION['tmp_assigned_to_id_val'])){
					unset($_SESSION['tmp_assigned_to_id_val']);
				}
				
			if(isset($_POST['owner_id_val'])){
				$owner_id_val = $this->input->post('owner_id_val');  
				$_SESSION['tmp_owner_id_val'] = $owner_id_val;
				$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val)); 
				
			}else if(isset($_SESSION['tmp_owner_id_val'])){ ///
				$owner_id_val = $_SESSION['tmp_owner_id_val'];
				$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));
			} 
		
			if(isset($_POST['contact_id_val'])){
				$contact_id_val = $this->input->post('contact_id_val');  
				$_SESSION['tmp_contact_id_val'] = $contact_id_val;
				$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val)); 
				
			}else if(isset($_SESSION['tmp_contact_id_val'])){ ///
				$contact_id_val = $_SESSION['tmp_contact_id_val'];
				$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val));
			}   
			  
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}      
			//total rows count
			$totalRec = count($this->deals_model->get_all_cstm_deals_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/deals/sales_listing2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit'=> $show_pers_pg));
			
			$records = $data['records'] = $this->deals_model->get_all_cstm_deals_properties($paras_arrs); 
			
			$this->load->view('deals/sales_listing2',$data); 
		 
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}

	
	function rental_listing($temps_property_type=''){
		if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Deals','index',$this->dbs_role_id,'1');  
		if($res_nums>0){
				
			$paras_arrs = array(); 
			$data['contact_arrs'] = $this->general_model->get_gen_all_contacts_list();
			$data['owner_arrs'] =$this->general_model->get_gen_all_owners_list();
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val= $is_property_type='';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
			
			$paras_arrs = array_merge($paras_arrs, array("types_val" => '2'));
	 
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				} 
				
			if($this->input->post('refer_no')){
				$refer_no_val = $this->input->post('refer_no'); 
				$_SESSION['tmp_refer_no'] = $refer_no_val; 
				$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
			}else if(isset($_SESSION['tmp_refer_no'])){
					unset($_SESSION['tmp_refer_no']);
				}
			 
			if($this->input->post('unit_no')){
				$unit_no_val = $this->input->post('unit_no'); 
				$_SESSION['tmp_unit_no_val'] = $unit_no_val; 
				$paras_arrs = array_merge($paras_arrs, array("unit_no_val" => $unit_no_val));
			}else if(isset($_SESSION['tmp_unit_no_val'])){
					unset($_SESSION['tmp_unit_no_val']);
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
				
			if($this->input->post('sel_emirate_location_id_val')){
				$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val'); 
				$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
			}else if(isset($_SESSION['tmp_emirate_location_id_val'])){
					unset($_SESSION['tmp_emirate_location_id_val']);
				} 
				
			if($this->input->post('sel_property_status_val')){
				$property_status_val = $this->input->post('sel_property_status_val'); 
				$_SESSION['tmp_property_status_val'] = $property_status_val;
				$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val));
			}else if(isset($_SESSION['tmp_property_status_val'])){
					unset($_SESSION['tmp_property_status_val']);
				}  
				
			if($this->input->post('sel_assigned_to_id_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_id_val'); 
				$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
			}else if(isset($_SESSION['tmp_assigned_to_id_val'])){
					unset($_SESSION['tmp_assigned_to_id_val']);
				} 
				
			if($this->input->post('sel_est_deal_date_val')){
				$sel_est_deal_date_val = $this->input->post('sel_est_deal_date_val'); 
				$_SESSION['tmp_est_deal_date_val'] = $sel_est_deal_date_val; 
				$paras_arrs = array_merge($paras_arrs, array("est_deal_date_val" => $sel_est_deal_date_val));
			}else if(isset($_SESSION['tmp_est_deal_date_val'])){
					unset($_SESSION['tmp_est_deal_date_val']);
				}
				
			if($this->input->post('owner_id_val')){
				$owner_id_val = $this->input->post('owner_id_val'); 
				$_SESSION['tmp_owner_id_val'] = $owner_id_val;
				$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));
			}else if(isset($_SESSION['tmp_owner_id_val'])){
					unset($_SESSION['tmp_owner_id_val']);
				} 
			
			if($this->input->post('contact_id_val')){
				$contact_id_val = $this->input->post('contact_id_val'); 
				$_SESSION['tmp_contact_id_val'] = $contact_id_val;
				$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val));
			}else if(isset($_SESSION['tmp_contact_id_val'])){
					unset($_SESSION['tmp_contact_id_val']);
				}
			 
			 
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			 
			//total rows count
			$totalRec = count($this->deals_model->get_all_cstm_deals_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/deals/rental_listing');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$records = $data['records'] = $this->deals_model->get_all_cstm_deals_properties($paras_arrs);
			
			/*if($vs_user_type_id==2){ 
				$arrs_field = array('user_type_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('user_type_id'=> '3'); 
			}
			 
			//$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_assigned();*/
			
			
			if($vs_user_type_id==3){
				$arrs_field = array('id' => $vs_id); 
			}else if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				//$arrs_field = array('status'=> '1'); 
				$arrs_field = array('role_id' => '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			
			if(isset($_SESSION['Temp_Deal_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Deal_Documents_Files']);
				unset($_SESSION['Temp_Deal_Documents_IP_Address']);
				unset($_SESSION['Temp_Deal_Documents_DATE_Times']);
			}
			
			if(isset($_SESSION['Temp_Sellerlandlord_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Sellerlandlord_Documents_Files']);
				unset($_SESSION['Temp_Sellerlandlord_Documents_IP_Address']);
				unset($_SESSION['Temp_Sellerlandlord_Documents_DATE_Times']);
			}
			 
			if(isset($_SESSION['Temp_Buyertenant_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Buyertenant_Documents_Files']);
				unset($_SESSION['Temp_Buyertenant_Documents_IP_Address']);
				unset($_SESSION['Temp_Buyertenant_Documents_DATE_Times']);
			}		
					
			if(isset($_SESSION['Temp_Newtitledeed_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Newtitledeed_Documents_Files']);
				unset($_SESSION['Temp_Newtitledeed_Documents_IP_Address']);
				unset($_SESSION['Temp_Newtitledeed_Documents_DATE_Times']);
			}		 
					
			if(isset($_SESSION['Temp_Agency_Documents_DATE_Times'])){ 
				unset($_SESSION['Temp_Agency_Documents_Files']);
				unset($_SESSION['Temp_Agency_Documents_IP_Address']);
				unset($_SESSION['Temp_Agency_Documents_DATE_Times']);
			}
			
			$data['page_headings']="Rental Deals Listing"; 
			$this->load->view('deals/rental_listing',$data);  
			
		}else{
			$datas['page_headings'] = "Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}

	function rental_listing2($temps_property_type=''){ 
	 	$res_nums =  $this->general_model->check_controller_method_permission_access('Deals','index',$this->dbs_role_id,'1');  
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
			 
			$paras_arrs = array_merge($paras_arrs, array("types_val" => '2'));
		
			$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val= $is_property_type='';
			$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
			
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				}
			
			if($this->input->post('refer_no')){
				$refer_no_val = $this->input->post('refer_no'); 
				$_SESSION['tmp_refer_no'] = $refer_no_val; 
				$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
			}else if(isset($_SESSION['tmp_refer_no'])){
					unset($_SESSION['tmp_refer_no']);
				}
			 
			if($this->input->post('unit_no')){
				$unit_no_val = $this->input->post('unit_no'); 
				$_SESSION['tmp_unit_no_val'] = $unit_no_val; 
				$paras_arrs = array_merge($paras_arrs, array("unit_no_val" => $unit_no_val));
			}else if(isset($_SESSION['tmp_unit_no_val'])){
					unset($_SESSION['tmp_unit_no_val']);
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
				 
			if($this->input->post('sel_emirate_location_id_val')){
				$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val'); 
				$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
			}else if(isset($_SESSION['tmp_emirate_location_id_val'])){
					unset($_SESSION['tmp_emirate_location_id_val']);
				}			 
					
			if($this->input->post('sel_property_status_val')){
				$property_status_val = $this->input->post('sel_property_status_val'); 
				$_SESSION['tmp_property_status_val'] = $property_status_val;
				$paras_arrs = array_merge($paras_arrs, array("property_status_val" => $property_status_val));
			}else if(isset($_SESSION['tmp_property_status_val'])){
					unset($_SESSION['tmp_property_status_val']);
				} 			
				
			if($this->input->post('sel_assigned_to_id_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_id_val'); 
				$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
				$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
			}else if(isset($_SESSION['tmp_assigned_to_id_val'])){
					unset($_SESSION['tmp_assigned_to_id_val']);
				}  
			
			if(isset($_POST['sel_est_deal_date_val'])){
				$sel_est_deal_date_val = $this->input->post('sel_est_deal_date_val');  
				if(strlen($sel_est_deal_date_val)>0){
					$_SESSION['tmp_est_deal_date_val'] = $sel_est_deal_date_val; 
					$paras_arrs = array_merge($paras_arrs, array("est_deal_date_val" => $sel_est_deal_date_val));
				}else{
					unset($_SESSION['tmp_est_deal_date_val']);	
				}
			}else if(isset($_SESSION['tmp_est_deal_date_val'])){ ///
				$sel_est_deal_date_val = $_SESSION['tmp_est_deal_date_val']; 
				$paras_arrs = array_merge($paras_arrs, array("est_deal_date_val" => $sel_est_deal_date_val));
			}
			
			if(isset($_POST['owner_id_val'])){
				$owner_id_val = $this->input->post('owner_id_val');  
				$_SESSION['tmp_owner_id_val'] = $owner_id_val;
				$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val)); 
				
			}else if(isset($_SESSION['tmp_owner_id_val'])){ ///
				$owner_id_val = $_SESSION['tmp_owner_id_val'];
				$paras_arrs = array_merge($paras_arrs, array("owner_id_val" => $owner_id_val));
			} 
		
			if(isset($_POST['contact_id_val'])){
				$contact_id_val = $this->input->post('contact_id_val');  
				$_SESSION['tmp_contact_id_val'] = $contact_id_val;
				$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val)); 
				
			}else if(isset($_SESSION['tmp_contact_id_val'])){ ///
				$contact_id_val = $_SESSION['tmp_contact_id_val'];
				$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val));
			}	
				 
			  
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}      
			//total rows count
			$totalRec = count($this->deals_model->get_all_cstm_deals_properties($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/deals/rental_listing2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit'=> $show_pers_pg));
			
			$records = $data['records'] = $this->deals_model->get_all_cstm_deals_properties($paras_arrs); 
			
			$this->load->view('deals/rental_listing2',$data); 
		 
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}


	function operate_deal($args0='1', $args1=''){ 
		if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}
		
		$this->load->model('categories_model');
		$this->load->model('no_of_bedrooms_model');
		$this->load->model('properties_model');
		$this->load->model('leads_model');
		
		$data['lead_arrs'] = $this->leads_model->get_all_leads();
		  
		$data['args0'] = $args0;   
		/*get_gen_all_users_list();*/
		//$data['user_arrs'] = $this->general_model->get_gen_all_users_assigned();
		$vs_id = $this->session->userdata('us_id'); 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		
		if($vs_user_type_id==3){
			$arrs_field = array('id' => $vs_id); 
		}else if($vs_user_type_id==2){ 
			$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
		}else{
			//$arrs_field = array('status'=> '1'); 
			$arrs_field = array('role_id' => '3'); 
		}
		
		$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
		 		
 		$data['emirate_arrs'] = $this->emirates_model->get_all_emirates();
		$data['emirate_location_arrs'] = $this->emirates_location_model->fetch_emirate_locations('');
		$data['emirate_sub_location_arrs']= $this->emirates_sub_location_model->fetch_emirate_sub_locations('');
		
		$data['category_arrs'] = $this->categories_model->get_all_categories();
		$data['beds_arrs'] = $this->no_of_bedrooms_model->get_all_no_of_beds(); 
		$data['contact_arrs'] = $this->general_model->get_gen_all_contacts_list(); 
		$data['properties_arrs'] = $this->properties_model->get_all_properties_list(); 
		 
		$max_deal_id_val = $this->deals_model->get_max_deal_id();
		$max_deal_id_val = $max_deal_id_val+1; 
		$max_deal_id_val = str_pad($max_deal_id_val, 4, '0', STR_PAD_LEFT); 
	 	$data['auto_ref_no'] = "D-".$max_deal_id_val; 
		$dl_type = '';
		if(isset($args0) && $args0==1){
			$dl_type = " Sale ";	
		}else if(isset($args0) && $args0==2){
			$dl_type = " Rent ";
		} 
		 
	 	if(isset($args1) && $args1!=''){
			$data['args1'] = $args1;
			$data['page_headings'] = "Update $dl_type Deal";
			$update_record_arr = $data['record'] = $this->deals_model->get_deal_by_id($args1);
		
		}else{ 
			$data['page_headings'] = "Add $dl_type Deal";
		}   
		
		if(isset($_POST) && !empty($_POST)){  
			
 			$owner_id = (isset($_POST['owner_id']) && strlen($_POST['owner_id'])>0) ? $this->input->post("owner_id") :'';
			//$contact_id = (isset($_POST['contact_id']) && $_POST['contact_id']>0) ? $this->input->post("contact_id") :'';
			$lead_id = (isset($_POST['lead_id']) && strlen($_POST['lead_id'])>0) ? $this->input->post("lead_id") :''; 
			$property_id = (isset($_POST['property_id']) && strlen($_POST['property_id'])>0) ? $this->input->post("property_id") :'';		
			$ref_no = '';
			if($property_id >0){
				/*$ress0 = $this->general_model->get_gen_property_info_by_id($property_id); 
				if(isset($ress0)){
					$ref_no = $ress0->ref_no;
				}*/
			}  
			 
			$ref_no = $this->input->post("ref_no");
			$types = $this->input->post("types"); 
			$status = $this->input->post("status"); 
			$deal_price = $this->input->post("deal_price"); 
			$deposit = $this->input->post("deposit"); 
			$commission = $this->input->post("commission");
			$agent1_id = $this->input->post("agent1_id"); 
			$agent1_commission_percentage = $this->input->post("agent1_commission_percentage"); 
			$agent1_commission_value = $this->input->post("agent1_commission_value"); 
			$agent2_id = $this->input->post("agent2_id"); 
			$agent2_commission_percentage = $this->input->post("agent2_commission_percentage"); 
			$agent2_commission_value = $this->input->post("agent2_commission_value");   
			$est_deal_date = $this->input->post("est_deal_date"); 
			$act_deal_date = $this->input->post("act_deal_date");  
			$unit_no = $this->input->post("unit_no");  
			$category_id = $this->input->post("category_id"); 
			$no_of_beds_id = $this->input->post("no_of_beds_id");  
			$emirate_id = $this->input->post("emirate_id");
			$location_id = $this->input->post("location_id");
			$sub_location_id = $this->input->post("sub_location_id");  
			$contact_id1 = $this->input->post("contact_id1");
			//$renewal_date = $this->input->post("renewal_date"); 
			//$set_reminder = $this->input->post("set_reminder");
			$renewal_date = isset($_POST['renewal_date']) ? $this->input->post("renewal_date") :'';	
			$set_reminder = isset($_POST['set_reminder']) ? $this->input->post("set_reminder") :'';	 
			$notes = $this->input->post("notes");
			$created_on = date('Y-m-d H:i:s');
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$created_by = $this->session->userdata('us_id');
		
			$this->form_validation->set_rules("ref_no", "Ref No", "trim|required|xss_clean"); 
			//$this->form_validation->set_rules("property_id", "Property", "trim|required|xss_clean"); 
			$is_unique_propertyid = '|is_unique[properties_deals_tbl.property_id]';
			if(isset($update_record_arr)){ 
				if($update_record_arr->property_id == $property_id) {
					$is_unique_propertyid = '';
				} 
			}  
			
			/*$this->form_validation->set_rules("property_id", "Property", "trim|required|xss_clean|greater_than[0]{$is_unique_propertyid}",array('greater_than' => 'Select Deal Property!','is_unique' => 'This Property Deal has been created already!'));*/
			 
			$this->form_validation->set_rules("property_id", "Property", "trim|required|xss_clean|greater_than[0]",array('greater_than' => 'Select Deal Property!','is_unique' => 'This Property Deal has been created already!'));
			
			$this->form_validation->set_rules("types", "Type", "trim|required|xss_clean");
			 
			//$this->form_validation->set_rules('owner_id', 'Seller', 'trim|required|xss_clean|greater_than[0]',array('greater_than' => 'Select Deal Seller!'));
			
			$tmpusr_type = " Buyer ";
			if(isset($args0) && $args0==1){
				$tmpusr_type = " Buyer ";	
			}else if(isset($args0) && $args0==2){
				$tmpusr_type = " Tenant ";
			}  
			  
			$this->form_validation->set_rules("contact_id1", "$tmpusr_type", "trim|required|xss_clean");  
			   	
			$this->form_validation->set_rules("status", "Status", "trim|required|xss_clean");
			$this->form_validation->set_rules("notes", "Notes", "trim|required|xss_clean");
			 
	if($this->form_validation->run() == FALSE){
		// validation fail
		$this->load->view('deals/operate_deal',$data);
		
	}else if(isset($args1) && $args1!=''){      
		 
		$datas = array('lead_id' => $lead_id,'ref_no' => $ref_no,'types' => $types,'owner_id' => $owner_id,'contact_id' => $contact_id1,'property_id' => $property_id,'status' => $status,'deal_price' => $deal_price,'deposit' => $deposit,'commission' => $commission,'agent1_id' => $agent1_id,'agent1_commission_percentage' => $agent1_commission_percentage,'agent1_commission_value' => $agent1_commission_value,'agent2_id' => $agent2_id,'agent2_commission_percentage' => $agent2_commission_percentage,'agent2_commission_value' => $agent2_commission_value,'est_deal_date'=>$est_deal_date,'act_deal_date' => $act_deal_date,'unit_no' => $unit_no,'category_id' => $category_id,'no_of_beds_id' => $no_of_beds_id,'emirate_id'=>$emirate_id,'location_id' => $location_id,'sub_location_id' => $sub_location_id,'renewal_date' => $renewal_date,'set_reminder' => $set_reminder,'notes' => $notes); 
					
		$res = $this->deals_model->update_deal_data($args1,$datas); 
		if(isset($res)){
			$this->session->set_flashdata('success_msg','Record updated successfully!');
		}else{
			$this->session->set_flashdata('error_msg','Error: while updating record!');
		} 
		
		if(isset($types) && $types==1){
			redirect("deals/sales_listing/"); 
		}else{ 
			redirect("deals/rental_listing/");
		}
			
	}else{  
		
		$datas = array('lead_id' => $lead_id,'ref_no' => $ref_no,'types' => $types,'owner_id' => $owner_id,'contact_id' => $contact_id1,'property_id' => $property_id,'status' => $status,'deal_price' => $deal_price,'deposit' => $deposit,'commission' => $commission,'agent1_id' => $agent1_id,'agent1_commission_percentage' => $agent1_commission_percentage,'agent1_commission_value' => $agent1_commission_value,'agent2_id' => $agent2_id,'agent2_commission_percentage' => $agent2_commission_percentage,'agent2_commission_value' => $agent2_commission_value,'est_deal_date'=>$est_deal_date,'act_deal_date' => $act_deal_date,'unit_no' => $unit_no,'category_id' => $category_id,'no_of_beds_id' => $no_of_beds_id,'emirate_id'=>$emirate_id,'location_id' => $location_id,'sub_location_id' => $sub_location_id,'renewal_date' => $renewal_date,'set_reminder' => $set_reminder,'notes' => $notes,'created_by' => $created_by,'created_on' => $created_on,'ip_address' => $ip_address); 
		$res = $this->deals_model->insert_deal_data($datas); 
		if(isset($res)){ 
				$last_deal_id = $this->db->insert_id();  
				
				if(isset($_SESSION['Temp_Deal_Documents_Files']) && count($_SESSION['Temp_Deal_Documents_Files'])>0){
					 $tmp_ips = $_SESSION['Temp_Deal_Documents_IP_Address'];
					 $tmp_dts = $_SESSION['Temp_Deal_Documents_DATE_Times'];
					 
					$datas3 = array('deal_id' => $last_deal_id); 
					$this->deals_model->update_temp_property_dropzone_deal_documents('-1',$tmp_ips,$tmp_dts,$datas3);
				}
				
				
				if(isset($_SESSION['Temp_Sellerlandlord_Documents_Files']) && count($_SESSION['Temp_Sellerlandlord_Documents_Files'])>0){
					 $tmp_ips = $_SESSION['Temp_Sellerlandlord_Documents_IP_Address'];
					 $tmp_dts = $_SESSION['Temp_Sellerlandlord_Documents_DATE_Times'];
					 
					$datas3 = array('deal_id' => $last_deal_id); 
					$this->deals_model->update_temp_property_dropzone_sellerlandlord_documents('-1',$tmp_ips,$tmp_dts,$datas3);
				}
				
				
				if(isset($_SESSION['Temp_Buyertenant_Documents_Files']) && count($_SESSION['Temp_Buyertenant_Documents_Files'])>0){
					 $tmp_ips = $_SESSION['Temp_Buyertenant_Documents_IP_Address'];
					 $tmp_dts = $_SESSION['Temp_Buyertenant_Documents_DATE_Times'];
					 
					$datas3 = array('deal_id' => $last_deal_id); 
					$this->deals_model->update_temp_property_dropzone_buyertenant_documents('-1',$tmp_ips,$tmp_dts,$datas3);
				}
				
				
				if(isset($_SESSION['Temp_Newtitledeed_Documents_Files']) && count($_SESSION['Temp_Newtitledeed_Documents_Files'])>0){
					 $tmp_ips = $_SESSION['Temp_Newtitledeed_Documents_IP_Address'];
					 $tmp_dts = $_SESSION['Temp_Newtitledeed_Documents_DATE_Times'];
					 
					$datas3 = array('deal_id' => $last_deal_id); 
					$this->deals_model->update_temp_property_dropzone_newtitledeed_documents('-1',$tmp_ips,$tmp_dts,$datas3);
				}
				
				
				if(isset($_SESSION['Temp_Agency_Documents_Files']) && count($_SESSION['Temp_Agency_Documents_Files'])>0){
					 $tmp_ips = $_SESSION['Temp_Agency_Documents_IP_Address'];
					 $tmp_dts = $_SESSION['Temp_Agency_Documents_DATE_Times'];
					 
					$datas3 = array('deal_id' => $last_deal_id); 
					$this->deals_model->update_temp_property_dropzone_agency_documents('-1',$tmp_ips,$tmp_dts,$datas3);
				}
				 /* updation needed */ 
				$this->session->set_flashdata('success_msg','Record inserted successfully!');
			}else{
				$this->session->set_flashdata('error_msg','Error: while inserting record!');
			}
			 
			if(isset($types) && $types==1){
				redirect("deals/sales_listing/"); 
			}else{ 
				redirect("deals/rental_listing/");
			}
		}   
		
	}else{
		$this->load->view('deals/operate_deal',$data);
	}
}

	function trash_deal($args0='',$args2=''){   
		if($this->login_vs_user_role_id==1){
			$data['page_headings']="Deals Listing";
			if($args2 >0){
				$this->deals_model->trash_deal($args2);
			}
			
			if(isset($args0) && $args0=='2'){
				redirect("deals/sales_listing");
			}else{ 
				redirect('deals/rental_listing'); 
			} 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	}
	 
	
	function deal_detail($args1=''){ 
		if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		
		if(isset($args1) && $args1 >0){
		
			$this->load->model('categories_model');
			$this->load->model('no_of_bedrooms_model');
			$this->load->model('properties_model');
			$this->load->model('leads_model');
		
			$data['page_headings'] = 'Deal Detail';
			$data['documents_arr1s'] = $this->deals_model->get_property_dropzone_sellerlandlord_documents_by_id($args1);
			$data['documents_arr2s'] = $this->deals_model->get_property_dropzone_buyertenant_documents_by_id($args1);
	
			$data['documents_arr3s'] = $this->deals_model->get_property_dropzone_deal_documents_by_id($args1);
			
			$data['documents_arr4s'] = $this->deals_model->get_property_dropzone_newtitledeed_documents_by_id($args1);
			$data['documents_arr5s'] = $this->deals_model->get_property_dropzone_agency_documents_by_id($args1);
			 
			$data['record'] = $this->deals_model->get_deal_by_id($args1);  
			
			$this->load->view('deals/deal_detail',$data);
		}else{
			echo "Invalid access!";	
		}
	} 
	
	
	function property_deal_documents_files_upload(){ 
		$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
		$tmp_dt_time = date('Y-m-d H:i');
		$tmp_propty_id = (isset($_POST["proprtyid"]) && $_POST['proprtyid']>0) ? $_POST['proprtyid'] : -1;
		$docmnt_name = $docmnts_error = $docmnts_error0 = '';  
		
		$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
		
		$docs_ret = array();
		$max_size = 2000; //max image size in Pixels 
		$watermark_png_file = base_url().'assets/images/watermark.png';
			
		if(isset($_FILES["dealdocuments"]['name']) && count($_FILES["dealdocuments"]['name'])>0){ 
			 
			for($j=0; $j < count($_FILES["dealdocuments"]['name']); $j++){ 
				
				if(isset($_FILES['dealdocuments']['tmp_name'][$j]) && $_FILES['dealdocuments']['tmp_name'][$j]!=''){ 
					if(!(in_array($_FILES['dealdocuments']['type'][$j],$docmnts_alw_typs ))){
						$tmp_docmnts_type = "'".($_FILES['dealdocuments']['type'][$j])."'";
						$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
						$docmnts_error .= $docmnts_error0;
					}
					
					if($docmnts_error0==''){
					 
						$docmnt_name = $this->general_model->fileExists($_FILES['dealdocuments']['name'][$j],"downloads/property_deal_documents/");  //thumbs/
						
						$image_size = $docmnt_sizes = $_FILES['dealdocuments']['size'][$j];  
						$docs_ret[]= $docmnt_name;
						  
						$image_name = $docmnt_name; 
						$image_temp = $_FILES['dealdocuments']['tmp_name'][$j]; //file temp
						$image_type = $_FILES['dealdocuments']['type'][$j];
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
								imagejpeg($new_canvas, "downloads/property_deal_documents/".$image_name , 90);
								
								//free up memory
								imagedestroy($new_canvas); 
								imagedestroy($image_resource);
								//die();
							}
						}else{
							copy($_FILES['dealdocuments']['tmp_name'][$j],"downloads/property_deal_documents/".$docmnt_name);   	
						}    
						 
						 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
						  
						 $this->deals_model->insert_property_deal_documents_data($datas2);
					}  
				}   
			}  
		}else if(isset($_FILES["dealdocuments"]['tmp_name']) && $_FILES['dealdocuments']['tmp_name']!=''){ 
		
			if(!(in_array($_FILES['dealdocuments']['type'],$docmnts_alw_typs ))){
				$tmp_docmnts_type = "'".($_FILES['dealdocuments']['type'])."'";
				$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
				$docmnts_error .= $docmnts_error0;
			}
			
			if($docmnts_error0==''){
			
				$docmnt_name = $this->general_model->fileExists($_FILES['dealdocuments']['name'],"downloads/property_deal_documents/");  //thumbs/
				
				// copy($_FILES['dealdocuments']['tmp_name'],"downloads/property_deal_documents/".$docmnt_name);  
				$image_size = $docmnt_sizes = $_FILES['dealdocuments']['size']; 
				$docs_ret[]= $docmnt_name;
				   
				$image_name = $docmnt_name; 
				$image_temp = $_FILES['dealdocuments']['tmp_name']; //file temp
				$image_type = $_FILES['dealdocuments']['type'];
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
						imagejpeg($new_canvas, "downloads/property_deal_documents/".$image_name , 90);
						
						//free up memory
						imagedestroy($new_canvas); 
						imagedestroy($image_resource);
						//die();
					}
				}else{
					copy($_FILES['dealdocuments']['tmp_name'],"downloads/property_deal_documents/".$docmnt_name);   	
				}   
				 
				 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
				 $this->deals_model->insert_property_deal_documents_data($datas2);
			}
		}
		echo json_encode($docs_ret);
	}
	
	function temp_property_deal_documents_files_upload(){ 
		/* media photo script starts */ 
		if(isset($_FILES["dealdocuments"]) && count($_FILES["dealdocuments"]['name'])>0){
			$_SESSION['Temp_Deal_Documents_Files'] = $_FILES["dealdocuments"];
		}else if(isset($_FILES["dealdocuments"]['tmp_name']) && $_FILES['dealdocuments']['tmp_name']!=''){
			$_SESSION['Temp_Deal_Documents_Files'] = $_FILES["dealdocuments"];
		}else{
			unset($_SESSION['Temp_Deal_Documents_Files']);
		} 
		
		$docmnt_name = $docmnts_error = $docmnts_error0 = ''; 
		 
		$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
		
		$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
		$tmp_dt_time = date('Y-m-d H:i');
		$tmp_propty_id = -1;
		$docs_ret = array();
		$max_size = 2000; //max image size in Pixels 
		$watermark_png_file = base_url().'assets/images/watermark.png';
			 
		if(isset($_FILES["dealdocuments"]['name']) && count($_FILES["dealdocuments"]['name'])>0){ 
			$_SESSION['Temp_Deal_Documents_IP_Address'] = $tmp_ip_address;
			$_SESSION['Temp_Deal_Documents_DATE_Times'] = $tmp_dt_time;
			  
			for($j=0; $j < count($_FILES["dealdocuments"]['name']); $j++){ 
				
				if(isset($_FILES['dealdocuments']['tmp_name'][$j]) && $_FILES['dealdocuments']['tmp_name'][$j]!=''){ 
					if(!(in_array($_FILES['dealdocuments']['type'][$j],$docmnts_alw_typs ))){
						$tmp_docmnts_type = "'".($_FILES['dealdocuments']['type'][$j])."'";
						$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
						$docmnts_error .= $docmnts_error0;
					}
					 //file type
					
					if($docmnts_error0==''){ 
						//@unlink("downloads/property_deal_documents/{$docmnt_name}");
						$docmnt_name = $this->general_model->fileExists($_FILES['dealdocuments']['name'][$j],"downloads/property_deal_documents/");  //thumbs/
						  
						$image_size = $docmnt_sizes = $_FILES['dealdocuments']['size'][$j]; 
						$docs_ret[]= $docmnt_name; 
						$image_name = $docmnt_name; 
						$image_temp = $_FILES['dealdocuments']['tmp_name'][$j]; //file temp
						$image_type = $_FILES['dealdocuments']['type'][$j];
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
								imagejpeg($new_canvas, "downloads/property_deal_documents/".$image_name , 90);
								
								//free up memory
								imagedestroy($new_canvas); 
								imagedestroy($image_resource);
								//die();
							}
						}else{
							copy($_FILES['dealdocuments']['tmp_name'][$j],"downloads/property_deal_documents/".$docmnt_name); 	
						}  
						
						 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
						  
						 $this->deals_model->insert_property_deal_documents_data($datas2);
						  
					}  
				}   
			}  
		}else if(isset($_FILES["dealdocuments"]['tmp_name']) && $_FILES['dealdocuments']['tmp_name']!=''){ 
			$_SESSION['Temp_Deal_Documents_IP_Address'] = $tmp_ip_address;
			$_SESSION['Temp_Deal_Documents_DATE_Times'] = $tmp_dt_time;
			
			$docmnt_name = $docmnts_error = $docmnts_error0 = '';   
			
			$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
		
			if(!(in_array($_FILES['dealdocuments']['type'],$docmnts_alw_typs ))){
				$tmp_docmnts_type = "'".($_FILES['dealdocuments']['type'])."'";
				$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
				$docmnts_error .= $docmnts_error0;
			}
			
			if($docmnts_error0==''){
			
				$docmnt_name = $this->general_model->fileExists($_FILES['dealdocuments']['name'],"downloads/property_deal_documents/");  //thumbs/
				
				// copy($_FILES['dealdocuments']['tmp_name'],"downloads/property_deal_documents/".$docmnt_name);  
				$image_size = $docmnt_sizes = $_FILES['dealdocuments']['size']; 
				$docs_ret[]= $docmnt_name; 
				$image_name = $docmnt_name; 
				
				$image_temp = $_FILES['dealdocuments']['tmp_name']; //file temp
				$image_type = $_FILES['dealdocuments']['type'];
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
						imagejpeg($new_canvas, "downloads/property_deal_documents/".$image_name , 90);
						
						//free up memory
						imagedestroy($new_canvas); 
						imagedestroy($image_resource);
						//die();
					}
				}else{
					copy($_FILES['dealdocuments']['tmp_name'],"downloads/property_deal_documents/".$docmnt_name);   	
				}  
				 
				 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
				 $this->deals_model->insert_property_deal_documents_data($datas2);
			}
		}
		
		echo json_encode($docs_ret); 
		/* media photo script ends */ 
	}
	
	
	function fetch_property_ref_no($args1=''){  
		if(isset($args1) && $args1 >0){ 
			$data['res'] = $this->general_model->get_gen_property_info_by_id($args1);  
			$this->load->view('ajax/fetch_property_ref_no',$data);
		} 
	}
	
	function fetch_property_type($args1=''){  
		if(isset($args1) && $args1 >0){ 
			$data['res'] = $this->general_model->get_gen_property_info_by_id($args1);  
			$this->load->view('ajax/fetch_property_type',$data);
		} 
	}
	
	function fetch_property_ownerid($args1=''){  
		if(isset($args1) && $args1 >0){ 
			$ress = $this->general_model->get_gen_property_info_by_id($args1);  
			if(isset($ress)){
				 echo $ress->owner_id;
			}
		} 
	}
	
	function fetch_property_deal_price($args1=''){  
		if(isset($args1) && $args1 >0){ 
			$data['res'] = $this->general_model->get_gen_property_info_by_id($args1);  
			$this->load->view('ajax/fetch_property_deal_price',$data);
		} 
	}
 	
	function fetch_property_brief($args1=''){    
		if(isset($args1) && $args1 >0){  
			$data['category_arrs'] = $this->categories_model->get_all_categories();
			$data['beds_arrs'] = $this->no_of_bedrooms_model->get_all_no_of_beds();
			$data['emirate_arrs'] = $this->emirates_model->get_all_emirates();
			$data['emirate_location_arrs'] = $this->emirates_location_model->fetch_emirate_locations('');
			$data['emirate_sub_location_arrs']= $this->emirates_sub_location_model->fetch_emirate_sub_locations('');  
			$data['rec'] = $this->general_model->get_gen_property_info_by_id($args1);  
			$this->load->view('ajax/fetch_property_brief',$data);
		} 
	}

	/* end of properties  */ 
	
	
	
	/* deal sellerlandlord drop zone functions starts here */	 
	function property_sellerlandlord_documents_files_upload(){ 
			$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
			$tmp_dt_time = date('Y-m-d H:i');
			$tmp_propty_id = (isset($_POST["proprtyid"]) && $_POST['proprtyid']>0) ? $_POST['proprtyid'] : -1;
			$docmnt_name = $docmnts_error = $docmnts_error0 = ''; 
			$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			 
			$docs_ret = array();
			$max_size = 2000; //max image size in Pixels 
			$watermark_png_file = base_url().'assets/images/watermark.png';
				
			if(isset($_FILES["sellerlandlorddocuments"]['name']) && count($_FILES["sellerlandlorddocuments"]['name'])>0){ 
				 
				for($j=0; $j < count($_FILES["sellerlandlorddocuments"]['name']); $j++){ 
					
					if(isset($_FILES["sellerlandlorddocuments"]['tmp_name'][$j]) && $_FILES["sellerlandlorddocuments"]['tmp_name'][$j]!=''){ 
						if(!(in_array($_FILES["sellerlandlorddocuments"]['type'][$j],$docmnts_alw_typs ))){
							$tmp_docmnts_type = "'".($_FILES["sellerlandlorddocuments"]['type'][$j])."'";
							$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
							$docmnts_error .= $docmnts_error0;
						}
						
						if($docmnts_error0==''){
							
							$docmnt_name = $this->general_model->fileExists($_FILES["sellerlandlorddocuments"]['name'][$j],"downloads/property_sellerlandlord_documents/");  //thumbs/
							
							$image_size = $docmnt_sizes = $_FILES["sellerlandlorddocuments"]['size'][$j];  
							$docs_ret[]= $docmnt_name;
							  
							$image_name = $docmnt_name; 
							$image_temp = $_FILES["sellerlandlorddocuments"]['tmp_name'][$j]; //file temp
							$image_type = $_FILES["sellerlandlorddocuments"]['type'][$j];
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
									imagejpeg($new_canvas, "downloads/property_sellerlandlord_documents/".$image_name , 90);
									
									//free up memory
									imagedestroy($new_canvas); 
									imagedestroy($image_resource);
									//die();
								}
							}else{
								copy($_FILES["sellerlandlorddocuments"]['tmp_name'][$j],"downloads/property_sellerlandlord_documents/".$docmnt_name);   	
							}    
							 
							 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
							  
							 $this->deals_model->insert_property_sellerlandlord_documents_data($datas2);
						}  
					}   
				}  
			}else if(isset($_FILES["sellerlandlorddocuments"]['tmp_name']) && $_FILES["sellerlandlorddocuments"]['tmp_name']!=''){ 
			
				if(!(in_array($_FILES["sellerlandlorddocuments"]['type'],$docmnts_alw_typs ))){
					$tmp_docmnts_type = "'".($_FILES["sellerlandlorddocuments"]['type'])."'";
					$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
					$docmnts_error .= $docmnts_error0;
				}
				
				if($docmnts_error0==''){
				
					$docmnt_name = $this->general_model->fileExists($_FILES["sellerlandlorddocuments"]['name'],"downloads/property_sellerlandlord_documents/");  //thumbs/
					
					$image_size = $docmnt_sizes = $_FILES["sellerlandlorddocuments"]['size']; 
					$docs_ret[]= $docmnt_name;
					   
					$image_name = $docmnt_name; 
					$image_temp = $_FILES["sellerlandlorddocuments"]['tmp_name']; //file temp
					$image_type = $_FILES["sellerlandlorddocuments"]['type'];
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
							imagejpeg($new_canvas, "downloads/property_sellerlandlord_documents/".$image_name , 90);
							
							//free up memory
							imagedestroy($new_canvas); 
							imagedestroy($image_resource);
							//die();
						}
					}else{
						copy($_FILES["sellerlandlorddocuments"]['tmp_name'],"downloads/property_sellerlandlord_documents/".$docmnt_name);   	
					}   
					 
					 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
					 $this->deals_model->insert_property_sellerlandlord_documents_data($datas2);
				}
			}
			echo json_encode($docs_ret);
		}
		
	function temp_property_sellerlandlord_documents_files_upload(){ 
			/* media photo script starts */ 
			if(isset($_FILES["sellerlandlorddocuments"]) && count($_FILES["sellerlandlorddocuments"]['name'])>0){
				$_SESSION['Temp_Sellerlandlord_Documents_Files'] = $_FILES["sellerlandlorddocuments"];
			}else if(isset($_FILES["sellerlandlorddocuments"]['tmp_name']) && $_FILES["sellerlandlorddocuments"]['tmp_name']!=''){
				$_SESSION['Temp_Sellerlandlord_Documents_Files'] = $_FILES["sellerlandlorddocuments"];
			}else{
				unset($_SESSION['Temp_Sellerlandlord_Documents_Files']);
			} 
			
			$docmnt_name = $docmnts_error = $docmnts_error0 = '';  
			$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			
			$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
			$tmp_dt_time = date('Y-m-d H:i');
			$tmp_propty_id = -1;
			$docs_ret = array();
			$max_size = 2000; //max image size in Pixels 
			$watermark_png_file = base_url().'assets/images/watermark.png';
				  
			if(isset($_FILES["sellerlandlorddocuments"]['name']) && count($_FILES["sellerlandlorddocuments"]['name'])>0){ 
				$_SESSION['Temp_Sellerlandlord_Documents_IP_Address'] = $tmp_ip_address;
				$_SESSION['Temp_Sellerlandlord_Documents_DATE_Times'] = $tmp_dt_time;
				  
				for($j=0; $j < count($_FILES["sellerlandlorddocuments"]['name']); $j++){ 
					
					if(isset($_FILES["sellerlandlorddocuments"]['tmp_name'][$j]) && $_FILES["sellerlandlorddocuments"]['tmp_name'][$j]!=''){ 
						if(!(in_array($_FILES["sellerlandlorddocuments"]['type'][$j],$docmnts_alw_typs ))){
							$tmp_docmnts_type = "'".($_FILES["sellerlandlorddocuments"]['type'][$j])."'";
							$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
							$docmnts_error .= $docmnts_error0;
						}
						 //file type
						
						if($docmnts_error0==''){ 
							//@unlink("downloads/property_sellerlandlord_documents/{$docmnt_name}");
							$docmnt_name = $this->general_model->fileExists($_FILES["sellerlandlorddocuments"]['name'][$j],"downloads/property_sellerlandlord_documents/");  //thumbs/
							  
							$image_size = $docmnt_sizes = $_FILES["sellerlandlorddocuments"]['size'][$j]; 
							$docs_ret[]= $docmnt_name; 
							$image_name = $docmnt_name; 
							$image_temp = $_FILES["sellerlandlorddocuments"]['tmp_name'][$j]; //file temp
							$image_type = $_FILES["sellerlandlorddocuments"]['type'][$j];
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
									imagejpeg($new_canvas, "downloads/property_sellerlandlord_documents/".$image_name , 90);
									
									//free up memory
									imagedestroy($new_canvas); 
									imagedestroy($image_resource);
									//die();
								}
							}else{
								copy($_FILES["sellerlandlorddocuments"]['tmp_name'][$j],"downloads/property_sellerlandlord_documents/".$docmnt_name); 	
							}  
							
							 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
							  
							 $this->deals_model->insert_property_sellerlandlord_documents_data($datas2);
							  
						}  
					}   
				}  
			}else if(isset($_FILES["sellerlandlorddocuments"]['tmp_name']) && $_FILES["sellerlandlorddocuments"]['tmp_name']!=''){ 
				$_SESSION['Temp_Sellerlandlord_Documents_IP_Address'] = $tmp_ip_address;
				$_SESSION['Temp_Sellerlandlord_Documents_DATE_Times'] = $tmp_dt_time;
				
				$docmnt_name = $docmnts_error = $docmnts_error0 = '';   
				$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
			
				if(!(in_array($_FILES["sellerlandlorddocuments"]['type'],$docmnts_alw_typs ))){
					$tmp_docmnts_type = "'".($_FILES["sellerlandlorddocuments"]['type'])."'";
					$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
					$docmnts_error .= $docmnts_error0;
				}
				
				if($docmnts_error0==''){
				
					$docmnt_name = $this->general_model->fileExists($_FILES["sellerlandlorddocuments"]['name'],"downloads/property_sellerlandlord_documents/");  //thumbs/
				 
					$image_size = $docmnt_sizes = $_FILES["sellerlandlorddocuments"]['size']; 
					$docs_ret[]= $docmnt_name; 
					$image_name = $docmnt_name; 
					
					$image_temp = $_FILES["sellerlandlorddocuments"]['tmp_name']; //file temp
					$image_type = $_FILES["sellerlandlorddocuments"]['type'];
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
							imagejpeg($new_canvas, "downloads/property_sellerlandlord_documents/".$image_name , 90);
							
							//free up memory
							imagedestroy($new_canvas); 
							imagedestroy($image_resource);
							//die();
						}
					}else{
						copy($_FILES["sellerlandlorddocuments"]['tmp_name'],"downloads/property_sellerlandlord_documents/".$docmnt_name);   	
					}  
					 
					 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
					 $this->deals_model->insert_property_sellerlandlord_documents_data($datas2);
				}
			}
			
			echo json_encode($docs_ret); 
			/* media photo script ends */ 
		}
		
	function get_property_dropzone_sellerlandlord_documents_by_id($args1=''){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_property_dropzone_sellerlandlord_documents_by_id($args1); 
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
		
	function get_temp_post_property_dropzone_sellerlandlord_documents(){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_temp_post_property_dropzone_sellerlandlord_documents(); 
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

	function delete_property_dropzone_sellerlandlord_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
			
			if(strlen($tmp_fle_name)>0 && $tmp_proprty_id>0){ 
				$dlt_res = $this->deals_model->delete_property_dropzone_sellerlandlord_documents($tmp_fle_name,$tmp_proprty_id);
				if($dlt_res){
					unlink("downloads/property_sellerlandlord_documents/".$tmp_fle_name);
				}
			} 	
		}
	}
	
	function delete_temp_property_dropzone_sellerlandlord_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){		
			$tmp_ip_address= isset($_SESSION['Temp_Sellerlandlord_Documents_IP_Address']) ? $_SESSION['Temp_Sellerlandlord_Documents_IP_Address']:'';
			$tmp_dt_time = isset($_SESSION['Temp_Sellerlandlord_Documents_DATE_Times']) ? $_SESSION['Temp_Sellerlandlord_Documents_DATE_Times']:'';	
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
				
			if($tmp_proprty_id== -1 && (strlen($tmp_fle_name)>0 && strlen($tmp_ip_address)>0 && strlen($tmp_dt_time)>0)){
			
				$dlt_res = $this->deals_model->delete_temp_property_dropzone_sellerlandlord_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
				
				if($dlt_res){
					unlink("downloads/property_sellerlandlord_documents/".$tmp_fle_name);
				} 
			} 	  	
		}
	} 
	/* deal sellerlandlord drop zone functions ends here */
		
		
		
		
	/* deal buyertenant drop zone functions starts here */	
	function property_buyertenant_documents_files_upload(){ 
			$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
			$tmp_dt_time = date('Y-m-d H:i');
			$tmp_propty_id = (isset($_POST["proprtyid"]) && $_POST['proprtyid']>0) ? $_POST['proprtyid'] : -1;
			$docmnt_name = $docmnts_error = $docmnts_error0 = '';  
			
			$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
			$docs_ret = array();
			$max_size = 2000; //max image size in Pixels 
			$watermark_png_file = base_url().'assets/images/watermark.png';
				
			if(isset($_FILES["buyertenantdocuments"]['name']) && count($_FILES["buyertenantdocuments"]['name'])>0){ 
				 
				for($j=0; $j < count($_FILES["buyertenantdocuments"]['name']); $j++){ 
					
					if(isset($_FILES["buyertenantdocuments"]['tmp_name'][$j]) && $_FILES["buyertenantdocuments"]['tmp_name'][$j]!=''){ 
						if(!(in_array($_FILES["buyertenantdocuments"]['type'][$j],$docmnts_alw_typs ))){
							$tmp_docmnts_type = "'".($_FILES["buyertenantdocuments"]['type'][$j])."'";
							$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
							$docmnts_error .= $docmnts_error0;
						}
						
						if($docmnts_error0==''){
							
							$docmnt_name = $this->general_model->fileExists($_FILES["buyertenantdocuments"]['name'][$j],"downloads/property_buyertenant_documents/");  //thumbs/
							
							
							$image_size = $docmnt_sizes = $_FILES["buyertenantdocuments"]['size'][$j];  
							$docs_ret[]= $docmnt_name;
							  
							$image_name = $docmnt_name; 
							$image_temp = $_FILES["buyertenantdocuments"]['tmp_name'][$j]; //file temp
							$image_type = $_FILES["buyertenantdocuments"]['type'][$j];
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
									imagejpeg($new_canvas, "downloads/property_buyertenant_documents/".$image_name , 90);
									
									//free up memory
									imagedestroy($new_canvas); 
									imagedestroy($image_resource);
									//die();
								}
							}else{
								copy($_FILES["buyertenantdocuments"]['tmp_name'][$j],"downloads/property_buyertenant_documents/".$docmnt_name);   	
							}    
							 
							 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
							  
							 $this->deals_model->insert_property_buyertenant_documents_data($datas2);
						}  
					}   
				}  
			}else if(isset($_FILES["buyertenantdocuments"]['tmp_name']) && $_FILES["buyertenantdocuments"]['tmp_name']!=''){ 
			
				if(!(in_array($_FILES["buyertenantdocuments"]['type'],$docmnts_alw_typs ))){
					$tmp_docmnts_type = "'".($_FILES["buyertenantdocuments"]['type'])."'";
					$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
					$docmnts_error .= $docmnts_error0;
				}
				
				if($docmnts_error0==''){
				
					$docmnt_name = $this->general_model->fileExists($_FILES["buyertenantdocuments"]['name'],"downloads/property_buyertenant_documents/");  //thumbs/
					
					$image_size = $docmnt_sizes = $_FILES["buyertenantdocuments"]['size']; 
					$docs_ret[]= $docmnt_name;
					   
					$image_name = $docmnt_name; 
					$image_temp = $_FILES["buyertenantdocuments"]['tmp_name']; //file temp
					$image_type = $_FILES["buyertenantdocuments"]['type'];
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
							imagejpeg($new_canvas, "downloads/property_buyertenant_documents/".$image_name , 90);
							
							//free up memory
							imagedestroy($new_canvas); 
							imagedestroy($image_resource);
							//die();
						}
					}else{
						copy($_FILES["buyertenantdocuments"]['tmp_name'],"downloads/property_buyertenant_documents/".$docmnt_name);   	
					}   
					 
					 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
					 $this->deals_model->insert_property_buyertenant_documents_data($datas2);
				}
			}
			echo json_encode($docs_ret);
		}
			 
	function temp_property_buyertenant_documents_files_upload(){ 
			/* media photo script starts */ 
			if(isset($_FILES["buyertenantdocuments"]) && count($_FILES["buyertenantdocuments"]['name'])>0){
				$_SESSION['Temp_Buyertenant_Documents_Files'] = $_FILES["buyertenantdocuments"];
			}else if(isset($_FILES["buyertenantdocuments"]['tmp_name']) && $_FILES["buyertenantdocuments"]['tmp_name']!=''){
				$_SESSION['Temp_Buyertenant_Documents_Files'] = $_FILES["buyertenantdocuments"];
			}else{
				unset($_SESSION['Temp_Buyertenant_Documents_Files']);
			}  
			
			$docmnt_name = $docmnts_error = $docmnts_error0 = '';   
			$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
			$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
			$tmp_dt_time = date('Y-m-d H:i');
			$tmp_propty_id = -1;
			$docs_ret = array();
			$max_size = 2000; //max image size in Pixels 
			$watermark_png_file = base_url().'assets/images/watermark.png';
				  
			if(isset($_FILES["buyertenantdocuments"]['name']) && count($_FILES["buyertenantdocuments"]['name'])>0){ 
				$_SESSION['Temp_Buyertenant_Documents_IP_Address'] = $tmp_ip_address;
				$_SESSION['Temp_Buyertenant_Documents_DATE_Times'] = $tmp_dt_time;
				  
				for($j=0; $j < count($_FILES["buyertenantdocuments"]['name']); $j++){ 
					
					if(isset($_FILES["buyertenantdocuments"]['tmp_name'][$j]) && $_FILES["buyertenantdocuments"]['tmp_name'][$j]!=''){ 
						if(!(in_array($_FILES["buyertenantdocuments"]['type'][$j],$docmnts_alw_typs ))){
							$tmp_docmnts_type = "'".($_FILES["buyertenantdocuments"]['type'][$j])."'";
							$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
							$docmnts_error .= $docmnts_error0;
						}
						 //file type
						
						if($docmnts_error0==''){ 
							//@unlink("downloads/property_buyertenant_documents/{$docmnt_name}");
							$docmnt_name = $this->general_model->fileExists($_FILES["buyertenantdocuments"]['name'][$j],"downloads/property_buyertenant_documents/");  //thumbs/
							  
							$image_size = $docmnt_sizes = $_FILES["buyertenantdocuments"]['size'][$j]; 
							$docs_ret[]= $docmnt_name; 
							$image_name = $docmnt_name; 
							$image_temp = $_FILES["buyertenantdocuments"]['tmp_name'][$j]; //file temp
							$image_type = $_FILES["buyertenantdocuments"]['type'][$j];
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
									imagejpeg($new_canvas, "downloads/property_buyertenant_documents/".$image_name , 90);
									
									//free up memory
									imagedestroy($new_canvas); 
									imagedestroy($image_resource);
									//die();
								}
							}else{
								copy($_FILES["buyertenantdocuments"]['tmp_name'][$j],"downloads/property_buyertenant_documents/".$docmnt_name); 	
							}  
							
							 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
							  
							 $this->deals_model->insert_property_buyertenant_documents_data($datas2); 
						}  
					}   
				}  
			}else if(isset($_FILES["buyertenantdocuments"]['tmp_name']) && $_FILES["buyertenantdocuments"]['tmp_name']!=''){ 
				$_SESSION['Temp_Buyertenant_Documents_IP_Address'] = $tmp_ip_address;
				$_SESSION['Temp_Buyertenant_Documents_DATE_Times'] = $tmp_dt_time;
				
				$docmnt_name = $docmnts_error = $docmnts_error0 = '';  
				
				$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
			
				if(!(in_array($_FILES["buyertenantdocuments"]['type'],$docmnts_alw_typs ))){
					$tmp_docmnts_type = "'".($_FILES["buyertenantdocuments"]['type'])."'";
					$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
					$docmnts_error .= $docmnts_error0;
				}
				
				if($docmnts_error0==''){
				
					$docmnt_name = $this->general_model->fileExists($_FILES["buyertenantdocuments"]['name'],"downloads/property_buyertenant_documents/");  //thumbs/
					 
					$image_size = $docmnt_sizes = $_FILES["buyertenantdocuments"]['size']; 
					$docs_ret[]= $docmnt_name; 
					$image_name = $docmnt_name; 
					
					$image_temp = $_FILES["buyertenantdocuments"]['tmp_name']; //file temp
					$image_type = $_FILES["buyertenantdocuments"]['type'];
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
							imagejpeg($new_canvas, "downloads/property_buyertenant_documents/".$image_name , 90);
							
							//free up memory
							imagedestroy($new_canvas); 
							imagedestroy($image_resource);
							//die();
						}
					}else{
						copy($_FILES["buyertenantdocuments"]['tmp_name'],"downloads/property_buyertenant_documents/".$docmnt_name);   	
					}  
					 
					 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
					 $this->deals_model->insert_property_buyertenant_documents_data($datas2);
				}
			}
			
			echo json_encode($docs_ret); 
			/* media photo script ends */ 
		}
		     
	function get_property_dropzone_buyertenant_documents_by_id($args1=''){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_property_dropzone_buyertenant_documents_by_id($args1); 
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
	 
	function get_temp_post_property_dropzone_buyertenant_documents(){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_temp_post_property_dropzone_buyertenant_documents(); 
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
	 
	function delete_property_dropzone_buyertenant_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
			
			if(strlen($tmp_fle_name)>0 && $tmp_proprty_id>0){ 
				$dlt_res = $this->deals_model->delete_property_dropzone_buyertenant_documents($tmp_fle_name,$tmp_proprty_id);
				if($dlt_res){
					unlink("downloads/property_buyertenant_documents/".$tmp_fle_name);
				}
			} 	
		}
	}
			 
	function delete_temp_property_dropzone_buyertenant_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){		
			$tmp_ip_address= isset($_SESSION['Temp_Buyertenant_Documents_IP_Address']) ? $_SESSION['Temp_Buyertenant_Documents_IP_Address']:'';
			$tmp_dt_time = isset($_SESSION['Temp_Buyertenant_Documents_DATE_Times']) ? $_SESSION['Temp_Buyertenant_Documents_DATE_Times']:'';	
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
				
			if($tmp_proprty_id== -1 && (strlen($tmp_fle_name)>0 && strlen($tmp_ip_address)>0 && strlen($tmp_dt_time)>0)){
			
				$dlt_res = $this->deals_model->delete_temp_property_dropzone_buyertenant_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
				
				if($dlt_res){
					unlink("downloads/property_buyertenant_documents/".$tmp_fle_name);
				} 
			} 	  	
		}
	}
	/* deal buyertenant drop zone functions ends here */	
	
	
	/* deal newtitledeed drop zone functions starts here */			 
	function property_newtitledeed_documents_files_upload(){ 
			$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
			$tmp_dt_time = date('Y-m-d H:i');
			$tmp_propty_id = (isset($_POST["proprtyid"]) && $_POST['proprtyid']>0) ? $_POST['proprtyid'] : -1;
			$docmnt_name = $docmnts_error = $docmnts_error0 = '';  
			
			$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			
			$docs_ret = array();
			$max_size = 2000; //max image size in Pixels 
			$watermark_png_file = base_url().'assets/images/watermark.png';
				
			if(isset($_FILES["newtitledeeddocuments"]['name']) && count($_FILES["newtitledeeddocuments"]['name'])>0){ 
				 
				for($j=0; $j < count($_FILES["newtitledeeddocuments"]['name']); $j++){ 
					
					if(isset($_FILES["newtitledeeddocuments"]['tmp_name'][$j]) && $_FILES["newtitledeeddocuments"]['tmp_name'][$j]!=''){ 
						if(!(in_array($_FILES["newtitledeeddocuments"]['type'][$j],$docmnts_alw_typs ))){
							$tmp_docmnts_type = "'".($_FILES["newtitledeeddocuments"]['type'][$j])."'";
							$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
							$docmnts_error .= $docmnts_error0;
						}
						
						if($docmnts_error0==''){
							
							$docmnt_name = $this->general_model->fileExists($_FILES["newtitledeeddocuments"]['name'][$j],"downloads/property_newtitledeed_documents/");  //thumbs/
							
							
							$image_size = $docmnt_sizes = $_FILES["newtitledeeddocuments"]['size'][$j];  
							$docs_ret[]= $docmnt_name;
							  
							$image_name = $docmnt_name; 
							$image_temp = $_FILES["newtitledeeddocuments"]['tmp_name'][$j]; //file temp
							$image_type = $_FILES["newtitledeeddocuments"]['type'][$j];
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
									imagejpeg($new_canvas, "downloads/property_newtitledeed_documents/".$image_name , 90);
									
									//free up memory
									imagedestroy($new_canvas); 
									imagedestroy($image_resource);
									//die();
								}
							}else{
								copy($_FILES["newtitledeeddocuments"]['tmp_name'][$j],"downloads/property_newtitledeed_documents/".$docmnt_name);   	
							}    
							 
							 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
							  
							 $this->deals_model->insert_property_newtitledeed_documents_data($datas2);
						}  
					}   
				}  
			}else if(isset($_FILES["newtitledeeddocuments"]['tmp_name']) && $_FILES["newtitledeeddocuments"]['tmp_name']!=''){ 
			
				if(!(in_array($_FILES["newtitledeeddocuments"]['type'],$docmnts_alw_typs ))){
					$tmp_docmnts_type = "'".($_FILES["newtitledeeddocuments"]['type'])."'";
					$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
					$docmnts_error .= $docmnts_error0;
				}
				
				if($docmnts_error0==''){
				
					$docmnt_name = $this->general_model->fileExists($_FILES["newtitledeeddocuments"]['name'],"downloads/property_newtitledeed_documents/");  //thumbs/
					
					$image_size = $docmnt_sizes = $_FILES["newtitledeeddocuments"]['size']; 
					$docs_ret[]= $docmnt_name;
					   
					$image_name = $docmnt_name; 
					$image_temp = $_FILES["newtitledeeddocuments"]['tmp_name']; //file temp
					$image_type = $_FILES["newtitledeeddocuments"]['type'];
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
							imagejpeg($new_canvas, "downloads/property_newtitledeed_documents/".$image_name , 90);
							
							//free up memory
							imagedestroy($new_canvas); 
							imagedestroy($image_resource);
							//die();
						}
					}else{
						copy($_FILES["newtitledeeddocuments"]['tmp_name'],"downloads/property_newtitledeed_documents/".$docmnt_name);   	
					}   
					 
					 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
					 $this->deals_model->insert_property_newtitledeed_documents_data($datas2);
				}
			}
			echo json_encode($docs_ret);
		}  
			 
	function temp_property_newtitledeed_documents_files_upload(){ 
			/* media photo script starts */ 
			if(isset($_FILES["newtitledeeddocuments"]) && count($_FILES["newtitledeeddocuments"]['name'])>0){
				$_SESSION['Temp_Newtitledeed_Documents_Files'] = $_FILES["newtitledeeddocuments"];
			}else if(isset($_FILES["newtitledeeddocuments"]['tmp_name']) && $_FILES["newtitledeeddocuments"]['tmp_name']!=''){
				$_SESSION['Temp_Newtitledeed_Documents_Files'] = $_FILES["newtitledeeddocuments"];
			}else{
				unset($_SESSION['Temp_Newtitledeed_Documents_Files']);
			}  
			
			$docmnt_name = $docmnts_error = $docmnts_error0 = ''; 
			 
			$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			
			$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
			$tmp_dt_time = date('Y-m-d H:i');
			$tmp_propty_id = -1;
			$docs_ret = array();
			$max_size = 2000; //max image size in Pixels 
			$watermark_png_file = base_url().'assets/images/watermark.png';
				  
			if(isset($_FILES["newtitledeeddocuments"]['name']) && count($_FILES["newtitledeeddocuments"]['name'])>0){ 
				$_SESSION['Temp_Newtitledeed_Documents_IP_Address'] = $tmp_ip_address;
				$_SESSION['Temp_Newtitledeed_Documents_DATE_Times'] = $tmp_dt_time;
				  
				for($j=0; $j < count($_FILES["newtitledeeddocuments"]['name']); $j++){ 
					
					if(isset($_FILES["newtitledeeddocuments"]['tmp_name'][$j]) && $_FILES["newtitledeeddocuments"]['tmp_name'][$j]!=''){ 
						if(!(in_array($_FILES["newtitledeeddocuments"]['type'][$j],$docmnts_alw_typs ))){
							$tmp_docmnts_type = "'".($_FILES["newtitledeeddocuments"]['type'][$j])."'";
							$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
							$docmnts_error .= $docmnts_error0;
						}
						 //file type
						
						if($docmnts_error0==''){ 
							//@unlink("downloads/property_newtitledeed_documents/{$docmnt_name}");
							$docmnt_name = $this->general_model->fileExists($_FILES["newtitledeeddocuments"]['name'][$j],"downloads/property_newtitledeed_documents/");  //thumbs/
							  
							$image_size = $docmnt_sizes = $_FILES["newtitledeeddocuments"]['size'][$j]; 
							$docs_ret[]= $docmnt_name; 
							$image_name = $docmnt_name; 
							$image_temp = $_FILES["newtitledeeddocuments"]['tmp_name'][$j]; //file temp
							$image_type = $_FILES["newtitledeeddocuments"]['type'][$j];
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
									imagejpeg($new_canvas, "downloads/property_newtitledeed_documents/".$image_name , 90);
									
									//free up memory
									imagedestroy($new_canvas); 
									imagedestroy($image_resource);
									//die();
								}
							}else{
								copy($_FILES["newtitledeeddocuments"]['tmp_name'][$j],"downloads/property_newtitledeed_documents/".$docmnt_name); 	
							}  
							
							 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
							  
							 $this->deals_model->insert_property_newtitledeed_documents_data($datas2);
							  
						}  
					}   
				}  
			}else if(isset($_FILES["newtitledeeddocuments"]['tmp_name']) && $_FILES["newtitledeeddocuments"]['tmp_name']!=''){ 
				$_SESSION['Temp_Newtitledeed_Documents_IP_Address'] = $tmp_ip_address;
				$_SESSION['Temp_Newtitledeed_Documents_DATE_Times'] = $tmp_dt_time;
				
				$docmnt_name = $docmnts_error = $docmnts_error0 = ''; 
				 
				$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			
				if(!(in_array($_FILES["newtitledeeddocuments"]['type'],$docmnts_alw_typs ))){
					$tmp_docmnts_type = "'".($_FILES["newtitledeeddocuments"]['type'])."'";
					$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
					$docmnts_error .= $docmnts_error0;
				}
				
				if($docmnts_error0==''){
				
					$docmnt_name = $this->general_model->fileExists($_FILES["newtitledeeddocuments"]['name'],"downloads/property_newtitledeed_documents/");  //thumbs/
					 
					$image_size = $docmnt_sizes = $_FILES["newtitledeeddocuments"]['size']; 
					$docs_ret[]= $docmnt_name; 
					$image_name = $docmnt_name; 
					
					$image_temp = $_FILES["newtitledeeddocuments"]['tmp_name']; //file temp
					$image_type = $_FILES["newtitledeeddocuments"]['type'];
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
							imagejpeg($new_canvas, "downloads/property_newtitledeed_documents/".$image_name , 90);
							
							//free up memory
							imagedestroy($new_canvas); 
							imagedestroy($image_resource);
							//die();
						}
					}else{
						copy($_FILES["newtitledeeddocuments"]['tmp_name'],"downloads/property_newtitledeed_documents/".$docmnt_name);   	
					}  
					 
					 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
					 $this->deals_model->insert_property_newtitledeed_documents_data($datas2);
				}
			}
			
			echo json_encode($docs_ret); 
			/* media photo script ends */ 
		}
		     
	function get_property_dropzone_newtitledeed_documents_by_id($args1=''){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_property_dropzone_newtitledeed_documents_by_id($args1); 
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
			 
	function get_temp_post_property_dropzone_newtitledeed_documents(){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_temp_post_property_dropzone_newtitledeed_documents(); 
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
		 
	function delete_property_dropzone_newtitledeed_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
			
			if(strlen($tmp_fle_name)>0 && $tmp_proprty_id>0){ 
				$dlt_res = $this->deals_model->delete_property_dropzone_newtitledeed_documents($tmp_fle_name,$tmp_proprty_id);
				if($dlt_res){
					unlink("downloads/property_newtitledeed_documents/".$tmp_fle_name);
				}
			} 	
		}
	}
	 
	function delete_temp_property_dropzone_newtitledeed_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){		
			$tmp_ip_address= isset($_SESSION['Temp_Newtitledeed_Documents_IP_Address']) ? $_SESSION['Temp_Newtitledeed_Documents_IP_Address']:'';
			$tmp_dt_time = isset($_SESSION['Temp_Newtitledeed_Documents_DATE_Times']) ? $_SESSION['Temp_Newtitledeed_Documents_DATE_Times']:'';	
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
				
			if($tmp_proprty_id== -1 && (strlen($tmp_fle_name)>0 && strlen($tmp_ip_address)>0 && strlen($tmp_dt_time)>0)){
			
				$dlt_res = $this->deals_model->delete_temp_property_dropzone_newtitledeed_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
				
				if($dlt_res){
					unlink("downloads/property_newtitledeed_documents/".$tmp_fle_name);
				} 
			} 	  	
		}
	} 
	/* deal newtitledeed drop zone functions ends here */
	
	
	/* deal agencydocuments drop zone functions starts here */			 
	function property_agency_documents_files_upload(){ 
		$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
		$tmp_dt_time = date('Y-m-d H:i');
		$tmp_propty_id = (isset($_POST["proprtyid"]) && $_POST['proprtyid']>0) ? $_POST['proprtyid'] : -1;
		$docmnt_name = $docmnts_error = $docmnts_error0 = '';  
		
		$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
		$docs_ret = array();
		$max_size = 2000; //max image size in Pixels 
		$watermark_png_file = base_url().'assets/images/watermark.png';
			
		if(isset($_FILES["agencydocuments"]['name']) && count($_FILES["agencydocuments"]['name'])>0){ 
			 
			for($j=0; $j < count($_FILES["agencydocuments"]['name']); $j++){ 
				
				if(isset($_FILES["agencydocuments"]['tmp_name'][$j]) && $_FILES["agencydocuments"]['tmp_name'][$j]!=''){ 
					if(!(in_array($_FILES["agencydocuments"]['type'][$j],$docmnts_alw_typs ))){
						$tmp_docmnts_type = "'".($_FILES["agencydocuments"]['type'][$j])."'";
						$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
						$docmnts_error .= $docmnts_error0;
					}
					
					if($docmnts_error0==''){
						
						$docmnt_name = $this->general_model->fileExists($_FILES["agencydocuments"]['name'][$j],"downloads/property_agency_documents/");  //thumbs/
						
						
						$image_size = $docmnt_sizes = $_FILES["agencydocuments"]['size'][$j];  
						$docs_ret[]= $docmnt_name;
						  
						$image_name = $docmnt_name; 
						$image_temp = $_FILES["agencydocuments"]['tmp_name'][$j]; //file temp
						$image_type = $_FILES["agencydocuments"]['type'][$j];
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
								imagejpeg($new_canvas, "downloads/property_agency_documents/".$image_name , 90);
								
								//free up memory
								imagedestroy($new_canvas); 
								imagedestroy($image_resource);
								//die();
							}
						}else{
							copy($_FILES["agencydocuments"]['tmp_name'][$j],"downloads/property_agency_documents/".$docmnt_name);   	
						}    
						 
						 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
						  
						 $this->deals_model->insert_property_agency_documents_data($datas2);
					}  
				}   
			}  
		}else if(isset($_FILES["agencydocuments"]['tmp_name']) && $_FILES["agencydocuments"]['tmp_name']!=''){ 
		
			if(!(in_array($_FILES["agencydocuments"]['type'],$docmnts_alw_typs ))){
				$tmp_docmnts_type = "'".($_FILES["agencydocuments"]['type'])."'";
				$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
				$docmnts_error .= $docmnts_error0;
			}
			
			if($docmnts_error0==''){
			
				$docmnt_name = $this->general_model->fileExists($_FILES["agencydocuments"]['name'],"downloads/property_agency_documents/");  //thumbs/
				
				$image_size = $docmnt_sizes = $_FILES["agencydocuments"]['size']; 
				$docs_ret[]= $docmnt_name;
				   
				$image_name = $docmnt_name; 
				$image_temp = $_FILES["agencydocuments"]['tmp_name']; //file temp
				$image_type = $_FILES["agencydocuments"]['type'];
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
						imagejpeg($new_canvas, "downloads/property_agency_documents/".$image_name , 90);
						
						//free up memory
						imagedestroy($new_canvas); 
						imagedestroy($image_resource);
						//die();
					}
				}else{
					copy($_FILES["agencydocuments"]['tmp_name'],"downloads/property_agency_documents/".$docmnt_name);   	
				}   
				 
				 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
				 $this->deals_model->insert_property_agency_documents_data($datas2);
			}
		}
		echo json_encode($docs_ret);
	}  
			 
	function temp_property_agency_documents_files_upload(){ 
			/* media photo script starts */ 
			if(isset($_FILES["agencydocuments"]) && count($_FILES["agencydocuments"]['name'])>0){
				$_SESSION['Temp_Agency_Documents_Files'] = $_FILES["agencydocuments"];
			}else if(isset($_FILES["agencydocuments"]['tmp_name']) && $_FILES["agencydocuments"]['tmp_name']!=''){
				$_SESSION['Temp_Agency_Documents_Files'] = $_FILES["agencydocuments"];
			}else{
				unset($_SESSION['Temp_Agency_Documents_Files']);
			}  
			
			$docmnt_name = $docmnts_error = $docmnts_error0 = '';  
			
			$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			
			$tmp_ip_address = $_SERVER['REMOTE_ADDR'];
			$tmp_dt_time = date('Y-m-d H:i');
			$tmp_propty_id = -1;
			$docs_ret = array();
			$max_size = 2000; //max image size in Pixels 
			$watermark_png_file = base_url().'assets/images/watermark.png';
				  
			if(isset($_FILES["agencydocuments"]['name']) && count($_FILES["agencydocuments"]['name'])>0){ 
				$_SESSION['Temp_Agency_Documents_IP_Address'] = $tmp_ip_address;
				$_SESSION['Temp_Agency_Documents_DATE_Times'] = $tmp_dt_time;
				  
				for($j=0; $j < count($_FILES["agencydocuments"]['name']); $j++){ 
					
					if(isset($_FILES["agencydocuments"]['tmp_name'][$j]) && $_FILES["agencydocuments"]['tmp_name'][$j]!=''){ 
						if(!(in_array($_FILES["agencydocuments"]['type'][$j],$docmnts_alw_typs ))){
							$tmp_docmnts_type = "'".($_FILES["agencydocuments"]['type'][$j])."'";
							$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
							$docmnts_error .= $docmnts_error0;
						}
						 //file type
						
						if($docmnts_error0==''){ 
							//@unlink("downloads/property_agency_documents/{$docmnt_name}");
							$docmnt_name = $this->general_model->fileExists($_FILES["agencydocuments"]['name'][$j],"downloads/property_agency_documents/");  //thumbs/
							  
							$image_size = $docmnt_sizes = $_FILES["agencydocuments"]['size'][$j]; 
							$docs_ret[]= $docmnt_name; 
							$image_name = $docmnt_name; 
							$image_temp = $_FILES["agencydocuments"]['tmp_name'][$j]; //file temp
							$image_type = $_FILES["agencydocuments"]['type'][$j];
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
									imagejpeg($new_canvas, "downloads/property_agency_documents/".$image_name , 90);
									
									//free up memory
									imagedestroy($new_canvas); 
									imagedestroy($image_resource);
									//die();
								}
							}else{
								copy($_FILES["agencydocuments"]['tmp_name'][$j],"downloads/property_agency_documents/".$docmnt_name); 	
							}  
							
							 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
							  
							 $this->deals_model->insert_property_agency_documents_data($datas2);
							  
						}  
					}   
				}  
			}else if(isset($_FILES["agencydocuments"]['tmp_name']) && $_FILES["agencydocuments"]['tmp_name']!=''){ 
				$_SESSION['Temp_Agency_Documents_IP_Address'] = $tmp_ip_address;
				$_SESSION['Temp_Agency_Documents_DATE_Times'] = $tmp_dt_time;
				
				$docmnt_name = $docmnts_error = $docmnts_error0 = '';  
				
				$docmnts_alw_typs = array('image/jpg','image/jpeg','image/png','image/gif', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			
				if(!(in_array($_FILES["agencydocuments"]['type'],$docmnts_alw_typs ))){
					$tmp_docmnts_type = "'".($_FILES["agencydocuments"]['type'])."'";
					$docmnts_error0 = "Documents(s): $tmp_docmnts_type not allowed!<br>";
					$docmnts_error .= $docmnts_error0;
				}
				
				if($docmnts_error0==''){
				
					$docmnt_name = $this->general_model->fileExists($_FILES["agencydocuments"]['name'],"downloads/property_agency_documents/");  //thumbs/
					 
					$image_size = $docmnt_sizes = $_FILES["agencydocuments"]['size']; 
					$docs_ret[]= $docmnt_name; 
					$image_name = $docmnt_name; 
					
					$image_temp = $_FILES["agencydocuments"]['tmp_name']; //file temp
					$image_type = $_FILES["agencydocuments"]['type'];
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
							imagejpeg($new_canvas, "downloads/property_agency_documents/".$image_name , 90);
							
							//free up memory
							imagedestroy($new_canvas); 
							imagedestroy($image_resource);
							//die();
						}
					}else{
						copy($_FILES["agencydocuments"]['tmp_name'],"downloads/property_agency_documents/".$docmnt_name);   	
					}  
					 
					 $datas2 = array('name' => $docmnt_name,'sizes' => $docmnt_sizes,'deal_id' => $tmp_propty_id,'ip_address' => $tmp_ip_address,'datatimes' => $tmp_dt_time); 
					 $this->deals_model->insert_property_agency_documents_data($datas2);
				}
			}
			
			echo json_encode($docs_ret); 
			/* media photo script ends */ 
		}
		     
	function get_property_dropzone_agency_documents_by_id($args1=''){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_property_dropzone_agency_documents_by_id($args1); 
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
			 
	function get_temp_post_property_dropzone_agency_documents(){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_temp_post_property_dropzone_agency_documents(); 
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
	
	function delete_property_dropzone_agency_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
			
			if(strlen($tmp_fle_name)>0 && $tmp_proprty_id>0){ 
				$dlt_res = $this->deals_model->delete_property_dropzone_agency_documents($tmp_fle_name,$tmp_proprty_id);
				if($dlt_res){
					unlink("downloads/property_agency_documents/".$tmp_fle_name);
				}
			} 	
		}
	}
	
	function get_property_dropzone_deal_documents_by_id($args1=''){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_property_dropzone_deal_documents_by_id($args1); 
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
	
	function get_temp_post_property_dropzone_deal_documents(){  
		$docs_result  = array();  
		$db_docs_arrs = $this->deals_model->get_temp_post_property_dropzone_deal_documents(); 
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
		 
	function delete_temp_property_dropzone_agency_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){		
			$tmp_ip_address= isset($_SESSION['Temp_Agency_Documents_IP_Address']) ? $_SESSION['Temp_Agency_Documents_IP_Address']:'';
			$tmp_dt_time = isset($_SESSION['Temp_Agency_Documents_DATE_Times']) ? $_SESSION['Temp_Agency_Documents_DATE_Times']:'';	
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
				
			if($tmp_proprty_id== -1 && (strlen($tmp_fle_name)>0 && strlen($tmp_ip_address)>0 && strlen($tmp_dt_time)>0)){
			
				$dlt_res = $this->deals_model->delete_temp_property_dropzone_agency_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
				
				if($dlt_res){
					unlink("downloads/property_agency_documents/".$tmp_fle_name);
				} 
			} 	  	
		}
	} 
	
	function delete_property_dropzone_deal_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
			
			if(strlen($tmp_fle_name)>0 && $tmp_proprty_id>0){ 
				$dlt_res = $this->deals_model->delete_property_dropzone_deal_documents($tmp_fle_name,$tmp_proprty_id);
				if($dlt_res){
					unlink("downloads/property_deal_documents/".$tmp_fle_name);
				}
			} 	
		}
	} 
	
	function delete_temp_property_dropzone_deal_documents_files(){
		if(isset($_POST["proprtyid"]) && (isset($_POST['flename']) && $_POST['flename']!='')){		
			$tmp_ip_address= isset($_SESSION['Temp_Deal_Documents_IP_Address']) ? $_SESSION['Temp_Deal_Documents_IP_Address']:'';
			$tmp_dt_time = isset($_SESSION['Temp_Deal_Documents_DATE_Times']) ? $_SESSION['Temp_Deal_Documents_DATE_Times']:'';	
			$tmp_fle_name = trim($_POST['flename']);
			$tmp_proprty_id = trim($_POST['proprtyid']); 
				
			if($tmp_proprty_id== -1 && (strlen($tmp_fle_name)>0 && strlen($tmp_ip_address)>0 && strlen($tmp_dt_time)>0)){
			
				$dlt_res = $this->deals_model->delete_temp_property_dropzone_deal_documents($tmp_fle_name,$tmp_proprty_id,$tmp_ip_address,$tmp_dt_time);
				
				if($dlt_res){
					unlink("downloads/property_deal_documents/".$tmp_fle_name);
				} 
			} 	  	
		}
	} 
	
	/* deal agencydocuments drop zone functions ends here */ 
	
	
	
	
	
	/* Deals ends */   
}
?>
