<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class No_of_bedrooms extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				  
				$res_nums = $this->general_model->check_controller_permission_access('No_of_bedrooms',$vs_user_role_id,'1');
				if($res_nums>0){
					 
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			}
			 
			$this->load->model('no_of_bedrooms_model'); 
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}   
		 
		/* no_of_bedrooms operations starts */
		function index(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('No_of_bedrooms','index',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				$data['page_headings']="No of Bedrooms List";
				$data['records'] = $this->no_of_bedrooms_model->get_all_no_of_bedrooms(); 
				$this->load->view('no_of_bedrooms/index',$data);  
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 }     
		 
		 function trash($args2=''){    
			$res_nums =  $this->general_model->check_controller_method_permission_access('No_of_bedrooms','trash',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				
				$data['page_headings']="No of Bedrooms List";
				$this->no_of_bedrooms_model->trash_no_of_bed($args2);
				
				$this->general_model->trash_no_of_bedroom_portal_abbrevations_data($args2);
				redirect('no_of_bedrooms/index');  
				
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
			
		 }
		 
		 
		 function trash_aj(){  
			$res_nums =  $this->general_model->check_controller_method_permission_access('No_of_bedrooms','trash',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				
				if(isset($_POST["args1"]) && $_POST["args1"]>0){
					$args1 = $this->input->post("args1");  
					$this->no_of_bedrooms_model->trash_no_of_bed($args1); 
				 } 
				  
				 //$data['records'] = $this->no_of_bedrooms_model->get_all_no_of_bedrooms(); 
				 $data['records'] = $this->no_of_bedrooms_model->get_all_no_of_bedrooms(); 
				 $this->load->view('no_of_bedrooms/index_aj',$data); 
				  
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		 }  
		 
		 function trash_multiple(){ 
			$res_nums =  $this->general_model->check_controller_method_permission_access('No_of_bedrooms','trash',$this->dbs_user_role_id,'1'); 
			if($res_nums>0){
				
				if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
					$del_checks = $_POST["multi_action_check"]; 
					foreach($del_checks as $args2){   
						$this->no_of_bedrooms_model->trash_no_of_bed($args2);  
					}  
				}
				
				$data['records'] = $this->no_of_bedrooms_model->get_all_no_of_bedrooms(); 
				$this->load->view('no_of_bedrooms/index_aj',$data); 
				  
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		 }
		   
		 
	 function add(){   
	 
		$res_nums =  $this->general_model->check_controller_method_permission_access('No_of_bedrooms','add',$this->dbs_user_role_id,'1');  
		if($res_nums>0){ 
			 
			$data['page_headings'] = 'Add No of Bedroom';
			 
			$data['max_sort_val'] = $this->no_of_bedrooms_model->get_max_no_of_bedrooms_sort_val();
			
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
					$this->load->view('no_of_bedrooms/add',$data);
				}else if(isset($args1) && $args1!=''){
					  
					$datas = array('title' => $title,'sort_order' => $sort_order,'status' => $status); 
					$res = $this->no_of_bedrooms_model->update_no_of_bedroom_data($args1,$datas); 
					if(isset($res)){  
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("no_of_bedrooms/index");
				}else{ 
					$datas = array('title' => $title,'sort_order' => $sort_order,'status' => $status); 
					$res = $this->no_of_bedrooms_model->insert_no_of_bedroom_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					 
					
					if(isset($_POST['saves_and_new'])){
						redirect("no_of_bedrooms/add");
					}else{
						redirect("no_of_bedrooms/index");	
					} 
				} 	 
				
			}else{
				$this->load->view('no_of_bedrooms/add',$data);
			}
			
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		} 
		
		function update($args1=''){  
			
			$res_nums =  $this->general_model->check_controller_method_permission_access('No_of_bedrooms','update',$this->dbs_user_role_id,'1'); 
			if($res_nums>0){ 
				
				if(isset($args1) && $args1!=''){ 
					$data['args1'] = $args1;
					$data['page_headings'] = 'Update No of Bedroom';
					$data['record'] = $this->no_of_bedrooms_model->get_no_of_bedroom_by_id($args1);
				}
				
				$data['max_sort_val'] = $this->no_of_bedrooms_model->get_max_no_of_bedrooms_sort_val();
				
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
						$this->load->view('no_of_bedrooms/update',$data);
					}else if(isset($args1) && $args1!=''){
						  
						$datas = array('title' => $title,'sort_order' => $sort_order,'status' => $status); 
						$res = $this->no_of_bedrooms_model->update_no_of_bedroom_data($args1,$datas); 
						if(isset($res)){  
							$this->session->set_flashdata('success_msg','Record updated successfully!');
						}else{
							$this->session->set_flashdata('error_msg','Error: while updating record!');
						}
						
							redirect("no_of_bedrooms/index");
					}	 
					
				}else{
					$this->load->view('no_of_bedrooms/update',$data);
				}
				
				}else{ 
					$this->load->view('no_permission_access'); 
				} 
			}
		/* end of no_of_bedrooms */   
		 
	  
	}
?>
