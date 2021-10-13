<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Roles extends CI_Controller{
	
		public function __construct(){
			parent::__construct();
			 
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_role_id = $this->dbs_role_id = $vs_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_role_id) && $vs_role_id>=1)){
				/* ok */
				$res_nums = $this->general_model->check_controller_permission_access('Roles',$vs_role_id,'1');
				if($res_nums>0){
					/* ok */
				}else{
					redirect('/');
				} 
			}else{
				redirect('/');
			}
			 
			$this->load->model('users_model'); 
			$this->load->model('admin_model'); 
			$this->load->model('roles_model'); 
			$perms_arrs = array('role_id'=> $vs_role_id);
			
			$this->load->library('Ajax_pagination');
			$this->perPage = 25;
		}  
		  
		 
		function index(){  
			$res_nums = $this->general_model->check_controller_method_permission_access('Roles','index',$this->dbs_role_id,'1');
			if($res_nums>0){ 
			
				$data['page_headings']= "Roles List";
				$data['records'] = $this->roles_model->get_all_roles();
				$this->load->view('roles/index',$data);  
				 
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		}
		
		
		function trash($args2=''){  
			$res_nums = $this->general_model->check_controller_method_permission_access('Roles','trash',$this->dbs_role_id,'1');
			if($res_nums>0){
					
				$data['page_headings']="Roles List";
				if($args2 >1){
					$this->roles_model->trash_role($args2);
				}
				redirect('roles/index'); 
				
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		 }
		 
		 
		 function trash_aj(){   
			$res_nums = $this->general_model->check_controller_method_permission_access('Roles','trash',$this->dbs_role_id,'1'); 
			if($res_nums>0){
				
				 if(isset($_POST["args1"]) && $_POST["args1"]>0){
					$args1 = $this->input->post("args1"); 
					$this->roles_model->trash_role($args1); 
				 }  
				 
				 $data['records'] = $this->roles_model->get_all_roles();
				 $this->load->view('roles/index_aj',$data); 
				 
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		 }  
		 
		 function trash_multiple(){   
			$res_nums = $this->general_model->check_controller_method_permission_access('Roles','trash',$this->dbs_role_id,'1'); 
			if($res_nums>0){
				
				if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
					$del_checks = $_POST["multi_action_check"]; 
					foreach($del_checks as $args2){    
						$this->roles_model->trash_role($args2);  
					}  
				}  
				 
				$data['records'] = $this->roles_model->get_all_roles();
				$this->load->view('roles/index_aj',$data);
			 
			 }else{ 
				$this->load->view('no_permission_access'); 
			} 
		 }   
		 
		 
		 function add(){   
		 
			$res_nums = $this->general_model->check_controller_method_permission_access('Roles','add',$this->dbs_role_id,'1'); 
			if($res_nums>0){
				 
			$data['page_headings'] = 'Add Role';
			 
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$name = $this->input->post("name"); 
				// form validation
				$this->form_validation->set_rules("name", "Role Name", "trim|required|xss_clean");  
				
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('roles/add',$data);
				}else{ 
					$datas = array('name' => $name); 
					$res = $this->roles_model->insert_role_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					 
					if(isset($_POST['saves_and_new'])){
						redirect("roles/add");
					}else{
						redirect("roles/index");	
					}
				} 	 
				
				}else{
					$this->load->view('roles/add',$data);
				} 
			 }else{ 
				$this->load->view('no_permission_access'); 
			} 
		} 
			
			
		 function update($args1=''){  
		 
			$res_nums = $this->general_model->check_controller_method_permission_access('Roles','update',$this->dbs_role_id,'1'); 
			if($res_nums>0){
				
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;//
				$data['page_headings'] = 'Update Role';
				$data['record'] = $this->roles_model->get_role_by_id($args1);
			}else{
				$data['page_headings'] = 'Add Role';
			}  
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$name = $this->input->post("name"); 
				// form validation
				$this->form_validation->set_rules("name", "Role Name", "trim|required|xss_clean");  
				
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('users/update',$data);
				}else if(isset($args1) && $args1!=''){ 
					$datas = array('name' => $name); 
					$res = $this->roles_model->update_role_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("roles/index");
				} 	 
				
				}else{
					$this->load->view('roles/update',$data);
				} 
			 }else{ 
				$this->load->view('no_permission_access'); 
			} 
		}
		  
			
		}
	?>