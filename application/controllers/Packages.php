<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Packages extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				  
				$res_nums = $this->general_model->check_controller_permission_access('Packages',$vs_user_role_id,'1');
				if($res_nums>0){
					 
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			}
			 
			$this->load->model('packages_model'); 
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}   
		 
		/* packages operations starts */
		function index(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Packages','index',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				$data['page_headings'] = "Package List";
				$data['conf_currency_symbol'] = $currency = $this->general_model->get_gen_currency_symbol();
				
				$data['records'] = $this->packages_model->get_all_packages(); 
				$this->load->view('packages/index',$data);  
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 }     
		 
		 function trash($args2=''){    
			$res_nums =  $this->general_model->check_controller_method_permission_access('Packages','trash',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				
				$data['page_headings'] = "Packages List";
				$this->packages_model->trash_package($args2); 
				redirect('packages/index');  
				
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
			
		 }
		 
		 
		 function trash_aj(){  
			$res_nums =  $this->general_model->check_controller_method_permission_access('Packages','trash',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				
				if(isset($_POST["args1"]) && $_POST["args1"]>0){
					$args1 = $this->input->post("args1");  
					$this->packages_model->trash_package($args1);  
				 } 
				  
				 $data['records'] = $this->packages_model->get_all_packages(); 
				 $this->load->view('packages/index_aj',$data); 
				  
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		 }  
		 
		 function trash_multiple(){ 
			$res_nums =  $this->general_model->check_controller_method_permission_access('Packages','trash',$this->dbs_user_role_id,'1'); 
			if($res_nums>0){
				
				if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
					$del_checks = $_POST["multi_action_check"]; 
					foreach($del_checks as $args2){   
						$this->packages_model->trash_package($args2);  
					}  
				}  
				 
				$data['records'] = $this->packages_model->get_all_packages(); 
				$this->load->view('packages/index_aj',$data); 
				  
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		 }
		   
		 
	 function add(){
		$res_nums =  $this->general_model->check_controller_method_permission_access('Packages','add',$this->dbs_user_role_id,'1');  
		if($res_nums>0){ 
			 
			$data['page_headings'] = 'Add Package'; 
			$data['max_sort_val'] = $this->packages_model->get_max_packages_sort_val();
			$data['conf_currency_symbol'] = $currency = $this->general_model->get_gen_currency_symbol();
			
			if(isset($_POST) && !empty($_POST)){
				// get form input
				$name = $this->input->post("name"); 
				$price = $this->input->post("price");
				$sort_order = $this->input->post("sort_order");
				$package_type = $this->input->post("package_type"); 
				$duration = $this->input->post("duration");  
				$total_properties_nums = $this->input->post("total_properties_nums");
				$total_contacts_nums = $this->input->post("total_contacts_nums");
				$total_owners_nums = $this->input->post("total_owners_nums"); 
				$total_tasks_nums = $this->input->post("total_tasks_nums");  
				$description = $this->input->post("description"); 
				$status = isset($_POST['status']) ? 1 : 0; 
				  
				// form validation
				$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");
				$this->form_validation->set_rules("price", "Price", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("package_type", "Package Type", "trim|xss_clean"); 
				$this->form_validation->set_rules("duration", "Duration", "trim|xss_clean");  
				$this->form_validation->set_rules("description", "description", "trim|xss_clean");   
				
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('packages/add',$data);
				}else if(isset($args1) && $args1!=''){
					  
					$datas = array('name' => $name,'price' => $price,'sort_order' => $sort_order, 'package_type' => $package_type, 'duration' => $duration, 'total_properties_nums' => $total_properties_nums,'total_contacts_nums' => $total_contacts_nums, 'total_owners_nums' => $total_owners_nums, 'total_tasks_nums' => $total_tasks_nums, 'description' => $description,'status' => $status); 
					$res = $this->packages_model->update_package_data($args1,$datas); 
					if(isset($res)){  
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					redirect("packages/index");
					
				}else{ 
					$datas = array('name' => $name,'price' => $price,'sort_order' => $sort_order, 'total_properties_nums' => $total_properties_nums,'total_contacts_nums' => $total_contacts_nums, 'total_owners_nums' => $total_owners_nums, 'total_tasks_nums' => $total_tasks_nums, 'description' => $description,'status' => $status); 
					$res = $this->packages_model->insert_package_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					 
					
					if(isset($_POST['saves_and_new'])){
						redirect("packages/add");
					}else{
						redirect("packages/index");	
					} 
				} 	 
				
			}else{
				$this->load->view('packages/add',$data);
			}
			
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	} 
		
		function update($args1=''){
			$res_nums =  $this->general_model->check_controller_method_permission_access('Packages','update',$this->dbs_user_role_id,'1'); 
			if($res_nums>0){
				if(isset($args1) && $args1!=''){ 
					$data['args1'] = $args1;
					$data['page_headings'] = 'Update Package';
					$data['record'] = $this->packages_model->get_package_by_id($args1);
				}
				
				$data['max_sort_val'] = $this->packages_model->get_max_packages_sort_val();
				$data['conf_currency_symbol'] = $currency = $this->general_model->get_gen_currency_symbol();
				
				if(isset($_POST) && !empty($_POST)){
					// get form input
					$name = $this->input->post("name");
					$price = $this->input->post("price");
					$sort_order = $this->input->post("sort_order");
					$package_type = $this->input->post("package_type"); 
					$duration = $this->input->post("duration"); 
					$total_properties_nums = $this->input->post("total_properties_nums");
					$total_contacts_nums = $this->input->post("total_contacts_nums");
					$total_owners_nums = $this->input->post("total_owners_nums"); 
					$total_tasks_nums = $this->input->post("total_tasks_nums");  
					$description = $this->input->post("description"); 
					$status = isset($_POST['status']) ? 1 : 0; 
					 
					// form validation
					$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");
					$this->form_validation->set_rules("price", "Price", "trim|required|xss_clean"); 
					$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
					$this->form_validation->set_rules("package_type", "Package Type", "trim|xss_clean"); 
				    $this->form_validation->set_rules("duration", "Duration", "trim|xss_clean");  
					$this->form_validation->set_rules("description", "description", "trim|xss_clean");  
					
					if($this->form_validation->run() == FALSE){
					// validation fail
						$this->load->view('packages/update',$data);
					}else if(isset($args1) && $args1!=''){
						  
						$datas = array('name' => $name,'price' => $price,'sort_order' => $sort_order, 'package_type' => $package_type, 'duration' => $duration, 'total_properties_nums' => $total_properties_nums,'total_contacts_nums' => $total_contacts_nums, 'total_owners_nums' => $total_owners_nums, 'total_tasks_nums' => $total_tasks_nums, 'description' => $description,'status' => $status); 
						$res = $this->packages_model->update_package_data($args1,$datas); 
						if(isset($res)){  
							$this->session->set_flashdata('success_msg','Record updated successfully!');
						}else{
							$this->session->set_flashdata('error_msg','Error: while updating record!');
						}
						redirect("packages/index");
					}	 
					
				}else{
					$this->load->view('packages/update',$data);
				}
				
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		}
		/* end of packages */
	} ?>