<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Modules extends CI_Controller{
	
		public function __construct(){
			parent::__construct();
			
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_role_id = $this->dbs_role_id = $vs_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_role_id) && $vs_role_id>=1)){
				 
				$res_nums = $this->general_model->check_controller_permission_access('Modules',$vs_role_id,'1');
				if($res_nums>0){
					 
				}else{
					redirect('/');
				} 
			}else{
				redirect('/');
			} 
			
			$this->load->model('modules_model'); 
			$this->load->model('users_model'); 
			$this->load->model('admin_model'); 
			$perms_arrs = array('role_id'=> $vs_role_id);
			
			$this->load->library('Ajax_pagination');
			$this->perPage = 25;
		}   
		 
		/* modules module starts */
		function index(){  
			$res_nums =  $this->general_model->check_controller_method_permission_access('Modules','view',$this->login_vs_role_id,'1');
			if($res_nums>0){  
			
				$data['page_headings']= "Modules List";
				$data['records'] = $this->modules_model->get_all_modules();
				$this->load->view('modules/index',$data);
			
			}else{ 
				$this->load->view('no_permission_access'); 
			}    
		}
		
		function trash($args2=''){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Modules','trash',$this->login_vs_role_id,'1'); 
			if($res_nums>0){
				 
				$data['page_headings']="Modules List";
				if($args2 >1){
					$this->modules_model->trash_module($args2);
				}
				redirect('modules/index'); 
			
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 }
		 
		 
		 function trash_aj(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Modules','trash',$this->login_vs_role_id,'1'); 
			if($res_nums>0){
				 
				if(isset($_POST["args1"]) && $_POST["args1"]>0){
					$args1 = $this->input->post("args1"); 
					$this->modules_model->trash_module($args1); 
				}  
				 
				$data['records'] = $this->modules_model->get_all_modules();
				$this->load->view('modules/index_aj',$data);
			 
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
			
		 }  
		 
		 function trash_multiple(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Modules','trash',$this->login_vs_role_id,'1'); 
			if($res_nums>0){  
				if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
					$del_checks = $_POST["multi_action_check"]; 
					foreach($del_checks as $args2){    
						$this->modules_model->trash_module($args2);  
					}  
				}  
				 
				 $data['records'] = $this->modules_model->get_all_modules();
				 $this->load->view('modules/index_aj',$data);
			
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
			
		 }   
		 
		 
		 function add(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Modules','add',$this->login_vs_role_id,'1'); 
			if($res_nums>0){ 
				$data['page_headings'] = 'Add Module'; 
				
				if(isset($_POST) && !empty($_POST)){
					// get form input
					$name = $this->input->post("name"); 
					$parent_id = $this->input->post("parent_id"); 
					$sort_order = $this->input->post("sort_order");   
					$icon_name = $this->input->post("icon_name"); 
					$controller_name = $this->input->post("controller_name");
					$method_name = $this->input->post("method_name");
					   
					// form validation
					$this->form_validation->set_rules("name","Module Name","trim|required|xss_clean");  
					$this->form_validation->set_rules("parent_id","Parent Module","trim|required|xss_clean");
					$this->form_validation->set_rules("sort_order","Sort Order","trim|required|xss_clean"); 
					/*$this->form_validation->set_rules("controller_name","Controller Name","trim|required|xss_clean");*/
					
					if($this->form_validation->run() == FALSE){
						// validation fail  
						$this->load->view('modules/add',$data);
					}else{ 
						 
						$vs_id = $this->session->userdata('us_id');
						$created_on = date('Y-m-d H:i:s'); 
					 
						$datas = array('parent_id' => $parent_id,'name' => $name,'sort_order' => $sort_order,'icon_name' => $icon_name,'controller_name' => $controller_name, 'method_name' => $method_name, 'added_by' => $vs_id,'created_on' => $created_on); 
						$res = $this->modules_model->insert_module_data($datas); 
						if(isset($res)){
							$this->session->set_flashdata('success_msg','Record inserted successfully!');
						}else{
							$this->session->set_flashdata('error_msg','Error: while inserting record!');
						} 
						 
						if(isset($_POST['saves_and_new'])){
							redirect("modules/add");
						}else{
							redirect("modules/index");	
						}
					} 	 
					
				}else{
				$this->load->view('modules/add',$data);
			}
			
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		}
		
		 function update($args1=''){  
			$res_nums =  $this->general_model->check_controller_method_permission_access('Modules','update',$this->login_vs_role_id,'1');  
			
			if($res_nums>0){ 
			
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;//
				$data['page_headings'] = 'Update Module';
				$data['record'] = $this->modules_model->get_module_by_id($args1);
			}else{
				$data['page_headings'] = 'Add Module';
			}  
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$name = $this->input->post("name"); 
				$parent_id = $this->input->post("parent_id"); 
				$sort_order = $this->input->post("sort_order");  
				$icon_name = $this->input->post("icon_name"); 
				$controller_name = $this->input->post("controller_name");  
				$method_name = $this->input->post("method_name");   
				// form validation
				$this->form_validation->set_rules("name","Module Name","trim|required|xss_clean");  
				$this->form_validation->set_rules("parent_id","Parent Module","trim|required|xss_clean");
				$this->form_validation->set_rules("sort_order","Sort Order","trim|required|xss_clean"); 
				/*$this->form_validation->set_rules("controller_name","Controller Name","trim|required|xss_clean");*/
				
				if($this->form_validation->run() == FALSE){
					// validation fail  
					$this->load->view('modules/update',$data);
				}else if(isset($args1) && $args1!=''){
					$datas = array('parent_id' => $parent_id,'name' => $name,'sort_order' => $sort_order,'icon_name' => $icon_name,'controller_name' => $controller_name, 'method_name' => $method_name); 
					$res = $this->modules_model->update_module_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}  
					
					redirect("modules/index");
				} 	 
				
			}else{
				$this->load->view('modules/update',$data);
			}
			
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		}
		
		/* modules module end */ 
		 
		 
		}
	?>