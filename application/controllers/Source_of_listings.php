<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Source_of_listings extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				/* ok */
				$res_nums = $this->general_model->check_controller_permission_access('Source_of_listings',$vs_user_role_id,'1');
				if($res_nums>0){ 
					/* ok */
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			}
			 
			$this->load->model('source_of_listings_model');
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}   
	
	/* property source of listings operations starts */
	function index(){  
		
		$res_nums = $this->general_model->check_controller_method_permission_access('Source_of_listings','index',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){
			
			$data['records'] = $this->source_of_listings_model->get_all_source_of_listings();
			$data['page_headings']="Source of Listings List";
			$this->load->view('source_of_listings/index',$data);  
			
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }    
	 
	 function trash($args2=''){  
		$res_nums = $this->general_model->check_controller_method_permission_access('Source_of_listings','trash',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){
				
			$data['page_headings']="Source of Listings List";
			$this->source_of_listings_model->trash_source_of_listing($args2);
			redirect('source_of_listings/index');
			
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }  
	 
	 function trash_aj(){    
		
		$res_nums = $this->general_model->check_controller_method_permission_access('Source_of_listings','trash',$this->dbs_user_role_id,'1');  
		if($res_nums>0){
			
			 if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1");
				$this->source_of_listings_model->trash_source_of_listing($args1);  
			 } 
			 
			 $data['records'] = $this->source_of_listings_model->get_all_source_of_listings();
			 $this->load->view('source_of_listings/index_aj',$data); 
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }  
	 
	 function trash_multiple(){   
		
		$res_nums = $this->general_model->check_controller_method_permission_access('Source_of_listings','trash',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			 
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args2){   
					$this->source_of_listings_model->trash_source_of_listing($args2);  
				}  
			} 
		
			$data['records'] = $this->source_of_listings_model->get_all_source_of_listings();
			$this->load->view('source_of_listings/index_aj',$data);
		
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }  
	 
	 function add(){   
		$res_nums = $this->general_model->check_controller_method_permission_access('Source_of_listings','add',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			  
			$data['page_headings'] = 'Add Source of Listing';
			   
			$data['max_sort_val'] = $this->source_of_listings_model->get_max_source_of_listings_sort_val();
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$title = $this->input->post("title"); 
				$sort_order = $this->input->post("sort_order");
				$status = isset($_POST['status']) ? 1 : 0; 
				
				// form validation
				$this->form_validation->set_rules("title", "Title", "trim|required|xss_clean");
				$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
				 
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('source_of_listings/add',$data);
				}else{ 
					$datas = array('title' => $title,'sort_order' => $sort_order,'status' => $status); 
					$res = $this->source_of_listings_model->insert_source_of_listing_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					
					if(isset($_POST['saves_and_new'])){
						redirect("source_of_listings/add");
					}else{
						redirect("source_of_listings/index");	
					} 
				} 	 
				
			}else{
				$this->load->view('source_of_listings/add',$data);
			}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}
	 
	 
	 function update($args1=''){   
		
		$res_nums = $this->general_model->check_controller_method_permission_access('Source_of_listings','update',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			 
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;//
				$data['page_headings'] = 'Update Source of Listing';
				$data['record'] = $this->source_of_listings_model->get_source_of_listing_by_id($args1);
			}else{
				$data['page_headings'] = 'Add Source of Listing';
			}   
			$data['max_sort_val'] = $this->source_of_listings_model->get_max_source_of_listings_sort_val();
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$title = $this->input->post("title"); 
				$sort_order = $this->input->post("sort_order");
				$status = isset($_POST['status']) ? 1 : 0; 
				
				// form validation
				$this->form_validation->set_rules("title", "Title", "trim|required|xss_clean");
				$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
				 
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('source_of_listings/update',$data);
				}else if(isset($args1) && $args1!=''){
					 
					$datas = array('title' => $title,'sort_order' => $sort_order,'status' => $status); 
					$res = $this->source_of_listings_model->update_source_of_listing_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					} 
					
						redirect("source_of_listings/index");
				} 	 
				
			}else{
				$this->load->view('source_of_listings/update',$data);
			}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}
	/* end of property source of listings */
	
	  
	  
	}
?>
