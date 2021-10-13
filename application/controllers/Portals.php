<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Portals extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				 /* ok */
				$res_nums = $this->general_model->check_controller_permission_access('Portals',$vs_user_role_id,'1');
				if($res_nums>0){
				   /* ok */
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			} 
			
			$this->load->model('portals_model');
			$this->load->model('users_model');
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}    
		
		
		/* portals operations starts */
		function index(){  
			$res_nums =  $this->general_model->check_controller_method_permission_access('Portals','index',$this->dbs_user_role_id,'1'); 
			if($res_nums>0){ 
				$data['records'] = $this->portals_model->get_all_portals();
				$data['page_headings']="Portals List";
				$this->load->view('portals/index',$data);
			}else{ 
				$this->load->view('no_permission_access'); 
			} 	 
		}
		 
		 function trash($args2=''){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Portals','trash',$this->dbs_user_role_id,'1');   
			if($res_nums>0){ 
				$data['page_headings']="Portals List";
				$this->portals_model->trash_portal($args2);
				redirect('portals/index');  
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 }
		 
		 
		 function trash_aj(){  
			$res_nums =  $this->general_model->check_controller_method_permission_access('Portals','trash',$this->dbs_user_role_id,'1');
			if($res_nums>0){ 
			
				 if(isset($_POST["args1"]) && $_POST["args1"]>0){
					$args1 = $this->input->post("args1"); 
					$this->portals_model->trash_portal($args1);
				 } 
				 
				 $data['records'] = $this->portals_model->get_all_portals();
				 $this->load->view('portals/index_aj',$data); 
			 
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 }  
		 
		 function trash_multiple(){  
		  	$res_nums =  $this->general_model->check_controller_method_permission_access('Portals','trash',$this->dbs_user_role_id,'1'); 
			if($res_nums>0){ 
		  
				if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
					
					$del_checks = $_POST["multi_action_check"]; 
					foreach($del_checks as $args2){  
						$this->portals_model->trash_portal($args2); 
					}  
				} 
				
				$data['records'] = $this->portals_model->get_all_portals();
				$this->load->view('portals/index_aj',$data);
				
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 }
		  
		 
	 function add($args1=''){ 
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Portals','add',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			 
			$data['page_headings'] = 'Add Portal';
			 
			$data['max_sort_val'] = $this->portals_model->get_max_portals_sort_val();
			if(isset($_POST) && !empty($_POST)){
				//$this->load->library('custom_validation'); 
				// get form input
				$name = $this->input->post("name");
				$sort_order = $this->input->post("sort_order");
				$url_address = $this->input->post("url_address");
				$description = $this->input->post("description"); 
				$status = isset($_POST['status']) ? 1 : 0;
				 
				// form validation
				$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean");  
				 $this->form_validation->set_rules('url_address',"URL Address", 'trim|required|xss_clean|prep_url|valid_url'); //modify this line
				$this->form_validation->set_rules("description", "description", "trim|xss_clean");   
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('portals/add',$data);
				}else if(isset($args1) && $args1!=''){
					 
					$datas = array('name' => $name,'sort_order' => $sort_order,'url_address' => $url_address,'description' => $description,'status' => $status); 
					$res = $this->portals_model->update_portal_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("portals/index");
				}else{ 
					$datas = array('name' => $name,'sort_order' => $sort_order,'url_address' => $url_address,'description' => $description,'status' => $status); 
					$res = $this->portals_model->insert_portal_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					 
					if(isset($_POST['saves_and_new'])){
						redirect("portals/add");
					}else{
						redirect("portals/index");	
					} 
				} 	 
				
			}else{
				$this->load->view('portals/add',$data);
			}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}
	} 
	
	
	 function update($args1=''){  
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Portals','update',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){
				
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;//
				$data['page_headings'] = 'Update Portal';
				$data['record'] = $this->portals_model->get_portal_by_id($args1);
			}   
			$data['max_sort_val'] = $this->portals_model->get_max_portals_sort_val();
			if(isset($_POST) && !empty($_POST)){ 
				// get form input
				$name = $this->input->post("name");
				$sort_order = $this->input->post("sort_order");
				$url_address = $this->input->post("url_address");
				$description = $this->input->post("description"); 
				$status = isset($_POST['status']) ? 1 : 0;
				 
				// form validation
				$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean");  
				 $this->form_validation->set_rules('url_address',"URL Address", 'trim|required|xss_clean|prep_url|valid_url'); //modify this line
				$this->form_validation->set_rules("description", "description", "trim|xss_clean");  
				 
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('portals/update',$data);
				}else if(isset($args1) && $args1!=''){
					 
					$datas = array('name' => $name,'sort_order' => $sort_order,'url_address' => $url_address,'description' => $description,'status' => $status); 
					$res = $this->portals_model->update_portal_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("portals/index");
				}  	 
				
			}else{
				$this->load->view('portals/update',$data);
			}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}
	}
		/* end of portals */
		 
	  
	}
?>
