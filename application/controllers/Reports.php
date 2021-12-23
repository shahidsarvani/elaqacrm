<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Reports extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				  
				$res_nums = $this->general_model->check_controller_permission_access('Reports',$vs_user_role_id,'1');
				if($res_nums>0){
					 
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			}
			 
			$this->load->model('categories_model');
			$this->load->model('portals_model'); 
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}   
		 
		/* Reports operations starts */
		function property_listing_report(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				$data['page_headings']="Listing Report";
				//$data['records'] = $this->categories_model->get_all_categories(); 
				//$this->load->view('categories/index',$data);  
				
				$this->load->view('no_permission_access'); 
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 } 
		 
		 function deals_reports(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				$data['page_headings'] = "Deals Report";
				//$data['records'] = $this->categories_model->get_all_categories(); 
				//$this->load->view('categories/index',$data);  
				
				$this->load->view('no_permission_access'); 
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 } 
		 
		 function leads_report(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				$data['page_headings'] = "Leads Report";
				//$data['records'] = $this->categories_model->get_all_categories(); 
				//$this->load->view('categories/index',$data);  
				
				$this->load->view('no_permission_access'); 
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 }      
		 
		  function meetings_viewing_report(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				$data['page_headings'] = "Meetings Viewing Report";
				//$data['records'] = $this->categories_model->get_all_categories(); 
				//$this->load->view('categories/index',$data);  
				
				$this->load->view('no_permission_access'); 
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 }  
		  
		/* end of Reports */   	 
	  
	}
?>
