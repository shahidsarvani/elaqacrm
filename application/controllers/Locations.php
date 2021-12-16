<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Locations extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$vs_id = $this->session->userdata('us_id');
			$this->vs_usr_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($this->vs_usr_role_id) && $this->vs_usr_role_id>=1)){
				/* ok */ 
				$res_nums = $this->general_model->check_controller_permission_access('Locations',$this->vs_usr_role_id,'1');
				if($res_nums>0){
					/* ok */ 
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			} 
			$this->load->model('locations_model');
			$this->load->model('admin_model'); 
			$this->load->model('general_model'); 
			$this->load->library('Ajax_pagination');
			$this->perPage = 25;
		} 
		   
		  
		/* locations operations starts */
		function index(){
		
			$res_nums =  $this->general_model->check_controller_method_permission_access('Locations','index',$this->vs_usr_role_id,'1'); 
			if($res_nums>0){
			
				$paras_arrs = array();	
				$paras_arrs = array_merge($paras_arrs, array("parentid_val" => '0'));
				 
				if($this->input->post('sel_per_page_val')){
					$per_page_val = $this->input->post('sel_per_page_val'); 
					$_SESSION['tmp_per_page_val'] = $per_page_val;  
					
				}else if(isset($_SESSION['tmp_per_page_val'])){
						unset($_SESSION['tmp_per_page_val']);
					}  
				
				if($this->input->post('q_val')){
					$q_val = $this->input->post('q_val'); 
					$_SESSION['tmp_q_val'] = $q_val;
					$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val));
					
				}else if(isset($_SESSION['tmp_q_val'])){
						unset($_SESSION['tmp_q_val']);
					}  
				
				if(isset($_SESSION['tmp_per_page_val'])){
					$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
				}else{
					$show_pers_pg = $this->perPage;
				}
				 
				//total rows count
				$totalRec = count($this->locations_model->get_all_filter_locations($paras_arrs));
				
				//pagination configuration
				$config['target']      = '#dyns_list';
				$config['base_url']    = site_url('/locations/index2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $show_pers_pg; //$this->perPage;
				
				$this->ajax_pagination->initialize($config); 
				
				$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
				
				$records = $data['records'] = $this->locations_model->get_all_filter_locations($paras_arrs);
				 
				$data['page_headings'] = "Locations List";
				$this->load->view('locations/index',$data); 
				
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		}
	 
		function index2(){
			$data['page_headings'] = "Locations List"; 
			$paras_arrs = array();	
			$paras_arrs = array_merge($paras_arrs, array("parentid_val" => '0'));
			$page = $this->input->post('page');
			if(!$page){
				$offset = 0;
			}else{
				$offset = $page;
			} 
			
			$data['page'] = $page; 
			 
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					$per_page_val = $_SESSION['tmp_per_page_val'];
				} 	  
				
			if(isset($_POST['q_val'])){
				$q_val = $this->input->post('q_val'); 
				if(strlen($q_val)>0){
					$_SESSION['tmp_q_val'] = $q_val;
					$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val)); 
				}else{
					unset($_SESSION['tmp_q_val']);
				}
				
			}else if(isset($_SESSION['tmp_q_val'])){
				$q_val = $_SESSION['tmp_q_val']; 
				$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val));
			}  
			
			
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			 
			//total rows count
			$totalRec = count($this->locations_model->get_all_filter_locations($paras_arrs)); 
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/locations/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start' => $offset, 'limit'=> $show_pers_pg));
			
			$data['records'] = $this->locations_model->get_all_filter_locations($paras_arrs); 
			 
			$this->load->view('locations/index2',$data); 
		
		} 
		
	function trash_aj(){  
		 $res_nums =  $this->general_model->check_controller_method_permission_access('Locations','trash',$this->vs_usr_role_id,'1'); 
		if($res_nums>0){
		
			 if(isset($_POST["args1"]) && $_POST["args1"]>1){
				$args1 = $this->input->post("args1"); 
				$this->locations_model->trash_location($args1);
			 }  
			 
			 $this->index2();
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	} 
	  
	function trash_multiple(){
		$res_nums =  $this->general_model->check_controller_method_permission_access('Locations','trash',$this->vs_usr_role_id,'1');  
		if($res_nums>0){ 
			$data['page_headings'] = "Locations";
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args1){  
					if($args1>0){
						$this->locations_model->trash_location($args1); 
					} 
				}
			 } 
			 $this->index2();
			 
		}else{
			$this->load->view('no_permission_access'); 
		}
	}   
	 
	 function add(){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Locations','add',$this->vs_usr_role_id,'1'); 
		if($res_nums>0){ 
		
		$data['page_headings'] = 'Add Location';   
		$data['locations_arrs'] = $this->locations_model->get_parent_chaild_locations('0');
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$name = $this->input->post("name");  
			$parent_id = $this->input->post("parent_id");  
			$description = $this->input->post("description");   
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");    
			$this->form_validation->set_rules("parent_id", "Parent Location", "trim|required|xss_clean");
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('locations/add',$data);
			}else{
					 
				$datas = array('parent_id' => $parent_id, 'name' => $name, 'description' => $description, 'status' => $status); 
				$res = $this->locations_model->insert_location_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
					
					if(isset($_POST['saves_and_new'])){
						redirect("locations/add");
					}else{
						redirect("locations/index");	
					} 
				} 	 
				
			}else{
				$this->load->view('locations/add',$data);
			}
			
		 }else{ 
			$this->load->view('no_permission_access'); 
		 }
	 } 
	 
	  function update($args1=''){   
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Locations','update',$this->vs_usr_role_id,'1'); 
		if($res_nums>0){
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;
			$data['page_headings'] = 'Update Location';
			$data['record'] = $this->locations_model->get_location_by_id($args1);
		}else{
			$data['page_headings'] = 'Add Location';
		}  
		
		$data['locations_arrs'] = $this->locations_model->get_parent_chaild_locations('0');
		
		if(isset($_POST) && !empty($_POST)){ 
			// get form input
			$name = $this->input->post("name"); 
			$parent_id = $this->input->post("parent_id");  
			$description = $this->input->post("description");
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");    
			$this->form_validation->set_rules("parent_id", "Parent Location", "trim|required|xss_clean");
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('locations/update',$data);
			}else if(isset($args1) && $args1!=''){
				  
				$datas = array('parent_id' => $parent_id, 'name' => $name, 'description' => $description, 'status' => $status); 
				$res = $this->locations_model->update_location_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				} 
				
					redirect("locations/index");
				} 	 
				
			}else{
				$this->load->view('locations/update',$data);
			}
			
		 }else{ 
			$this->load->view('no_permission_access'); 
		 }
	 }
	
	/* end of locations */
	 
	  
	}
?>
