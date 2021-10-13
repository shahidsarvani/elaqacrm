<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	class Emirate_sub_location_areas extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){ 
				/* ok */
				$res_nums = $this->general_model->check_controller_permission_access('Emirate_sub_location_areas',$vs_user_role_id,'1');
				if($res_nums>0){
				 	/* ok */
				}else{
					redirect('/');
				}  
			}else{
				redirect('/');
			}
			 
			$this->load->model('emirate_sub_location_areas_model'); 
			$this->load->model('emirates_sub_location_model');
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}  
		 
	
	/* emirate sub locations operations starts */
	function index(){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Emirate_sub_location_areas','index',$this->dbs_user_role_id,'1');  
		if($res_nums>0){
			 
			$data['records'] = $this->emirate_sub_location_areas_model->get_all_areas_with_sub_locations();
			$data['page_headings']="Emirate Sub Location Areas List";
			$this->load->view('emirate_sub_location_areas/index',$data);  
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}
	 }  
	 
	 function trash($args2=''){  
		 $res_nums =  $this->general_model->check_controller_method_permission_access('Emirate_sub_location_areas','trash',$this->dbs_user_role_id,'1');  
		if($res_nums>0){
			
			$data['page_headings']="Emirate Sub Location Areas List";
			$this->emirate_sub_location_areas_model->trash_emirate_sub_location_area($args2);
			redirect('emirate_sub_location_areas/index');
			
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	 } 
	 
	 function trash_aj(){  
		 $res_nums =  $this->general_model->check_controller_method_permission_access('Emirate_sub_location_areas','trash',$this->dbs_user_role_id,'1');   
		if($res_nums>0){
			
			 if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1"); 
				$res = $this->emirate_sub_location_areas_model->trash_emirate_sub_location_area($args1);
			 } 
			 
			 $data['records'] = $this->emirate_sub_location_areas_model->get_all_areas_with_sub_locations(); 
			 $this->load->view('emirate_sub_location_areas/index_aj',$data);
			  
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }  
	 
	 function trash_multiple(){
	  	$res_nums =  $this->general_model->check_controller_method_permission_access('Emirate_sub_location_areas','trash',$this->dbs_user_role_id,'1');   
		if($res_nums>0){
			
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args2){  
					$res = $this->emirate_sub_location_areas_model->trash_emirate_sub_location_area($args2);   
				}  
			} 
		
			$data['records'] = $this->emirate_sub_location_areas_model->get_all_areas_with_sub_locations(); 
		 	$this->load->view('emirate_sub_location_areas/index_aj',$data);
		 
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }   
	  
	 function add(){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Emirate_sub_location_areas','add',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){ 
			$data['page_headings'] = 'Add Emirate Sub Location Area';  
			$this->load->model('emirates_location_model');
			$data['emirate_location_arrs'] = $this->emirates_location_model->get_all_emirate_locations();
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$name = $this->input->post("name"); 
				$emirate_sub_location_id = $this->input->post("emirate_sub_location_id");   
				$status = isset($_POST['status']) ? 1 : 0;
				 
				// form validation
				$this->form_validation->set_rules("name", "Sub Location Area Name", "trim|required|xss_clean");    
				$this->form_validation->set_rules("emirate_sub_location_id", "Emirate Sub Location", "trim|required|xss_clean"); 
				
				if($this->form_validation->run() == FALSE){
				// validation fail  
					$this->load->view('emirate_sub_location_areas/add',$data);
				}else{ 
					$datas = array('name' => $name,'emirate_sub_location_id' => $emirate_sub_location_id,'status' => $status); 
					$res = $this->emirate_sub_location_areas_model->insert_emirate_sub_location_area_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					  
					if(isset($_POST['saves_and_new'])){
						redirect("emirate_sub_location_areas/add");
					}else{
						redirect("emirate_sub_location_areas/index");	
					} 
				} 	 
				
			}else{
				$this->load->view('emirate_sub_location_areas/add',$data);
			}
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}  
	
	
	function update($args1=''){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Emirate_sub_location_areas','update',$this->dbs_user_role_id,'1');   
		if($res_nums>0){
			$this->load->model('emirates_location_model');
			$data['emirate_location_arrs'] = $this->emirates_location_model->get_all_emirate_locations();
			
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;//
				$data['page_headings'] = 'Update Emirate Sub Location Area';
				$data['record'] = $this->emirate_sub_location_areas_model->get_emirate_sub_location_area_by_id($args1);
			}else{
				$data['page_headings'] = 'Add Emirate Sub Location Area';
			}
			
			if(isset($_POST) && !empty($_POST)){ 
				// get form input
				$name = $this->input->post("name"); 
				$emirate_sub_location_id = $this->input->post("emirate_sub_location_id");   
				$status = isset($_POST['status']) ? 1 : 0;
				 
				// form validation
				$this->form_validation->set_rules("name", "Area Name", "trim|required|xss_clean");    
				$this->form_validation->set_rules("emirate_sub_location_id", "Emirate Sub Location", "trim|required|xss_clean"); 
				
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('/update',$data);
				}else if(isset($args1) && $args1!=''){
					  
					$datas = array('name' => $name,'emirate_sub_location_id' => $emirate_sub_location_id,'status' => $status); 
					$res = $this->emirate_sub_location_areas_model->update_emirate_sub_location_area_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					} 
					
					redirect("emirate_sub_location_areas/index");
				}	 
				
			}else{
				$this->load->view('emirate_sub_location_areas/update',$data);
			}
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}
	
	/* end of emirate sub location areas */ 
} ?>