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
				/*$res_nums = $this->general_model->check_controller_permission_access('Locations',$this->vs_usr_role_id,'1');
				if($res_nums>0){
					 
				}else{
					redirect('/');
				} */
				
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
				//$totalRec = count($this->locations_model->get_all_filter_locations($paras_arrs));
				$totalRec = $this->locations_model->count_location_nums($paras_arrs);
				 
				//pagination configuration
				$config['target']      = '#dyns_list';
				$config['base_url']    = site_url('/locations/index2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $show_pers_pg; //$this->perPage;
				
				$this->ajax_pagination->initialize($config); 
				
				$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
				
				$paras_arrs = array_merge($paras_arrs, array("parentid_val" => '0'));
				
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
			///$totalRec = count($this->locations_model->get_all_filter_locations($paras_arrs)); 
			$totalRec = $this->locations_model->count_location_nums($paras_arrs);
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/locations/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start' => $offset, 'limit'=> $show_pers_pg));
			
			$paras_arrs = array_merge($paras_arrs, array("parentid_val" => '0'));
			
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
		$data['locations_arrs'] = $this->locations_model->get_parent_child_locations('0');
		
		if(isset($_POST) && !empty($_POST)){
			// get form input
			$name = $this->input->post("name");  
			$level = 0;
			if($_POST['parent_id'] == 0){
				$parent_id = $this->input->post("parent_id");
			}else{
				$parent_id_arr = explode('__', $_POST['parent_id']);
				if($parent_id_arr){
					$parent_id = $parent_id_arr[0];
					$level = $parent_id_arr[1]; 
				} 
			}
			$description = $this->input->post("description");   
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");    
			$this->form_validation->set_rules("parent_id", "Parent Location", "trim|required|xss_clean");
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('locations/add',$data);
			}else{ 
				$datas = array('parent_id' => $parent_id, 'level' => $level, 'name' => $name, 'description' => $description, 'status' => $status); 
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
		
		$data['locations_arrs'] = $this->locations_model->get_parent_child_locations('0');
		
		if(isset($_POST) && !empty($_POST)){ 
			// get form input
			$name = $this->input->post("name");
			$level = 0;
			if($_POST['parent_id'] == 0){
				$parent_id = $this->input->post("parent_id");   
			}else{
				$parent_id_arr = explode('__', $_POST['parent_id']);
				if($parent_id_arr){
					$parent_id = $parent_id_arr[0];
					$level = $parent_id_arr[1]; 
				} 
			}
			
			/*echo $parent_id;
			echo $level;
			exit;*/
			
			$description = $this->input->post("description");
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");    
			$this->form_validation->set_rules("parent_id", "Parent Location", "trim|required|xss_clean");
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('locations/update',$data);
			}else if(isset($args1) && $args1!=''){
				  
				$datas = array('parent_id' => $parent_id, 'level' => $level, 'name' => $name, 'description' => $description, 'status' => $status); 
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
	 
	 
		function fetch_sub_loations($paras1='', $paras2=''){
			$ret_txt = '';
			$loc_arrs = $this->locations_model->get_parent_child_locations($paras1);
			
			if($loc_arrs){
				$fst_parentid = $loc_arrs[0]->parent_id;
				$fst_levelno = $loc_arrs[0]->level;
				$searchable_elmnt = '#location_searcher'.$fst_parentid;
				$sortable_elmnt = '.selectable'.$fst_parentid;
				$parent_level_box_cls = "parent_level_box".$fst_levelno;
				
				$ret_txt .= '<div class="parent_location_box0 '.$parent_level_box_cls.'" id="fetch_parent_location_box'.$paras2.'" data-level-box-elmnt="'.$fst_levelno.'"> <label class="control-label bolder" for="parent_location_id" id="fetch_parent_location_lbl'.$paras1.'">Cities </label>  <span class="filter_cls"><input type="text" name="location_searcher'.$fst_parentid.'" id="location_searcher'.$fst_parentid.'" class="form-control mini-form-control" placeholder="Search..." onKeyUp="operate_search_filters(\''.$searchable_elmnt .'\', \''.$sortable_elmnt.'\');" /></span> <a href="javascript:javascript:void(0);" onClick="remove_sel_location(\''.$paras2.'\', \''.$fst_parentid.'\');"> x </a> <div class="parent_box_area0"> <ul class="ul_location_cls">'; /// 
				$chk = 0;
				foreach($loc_arrs as $loc_arr){   
					$loc_parent_id = $loc_arr->parent_id+1;
					
					$ret_txt .= '<li class="selectable'.$fst_parentid.'"><label for="parent_loc_id'.$loc_arr->id.'"> <input type="radio" name="parent_loc_id'.$loc_arr->parent_id.'" id="parent_loc_id'.$loc_arr->id.'" value="'.$loc_arr->id.'" data-item-id="'.$loc_arr->id.'" data-item-label="'.$loc_arr->name.'" data-item-parent-id="'.$loc_arr->parent_id.'" data-item-parent-inc-id="'.$loc_parent_id.'" data-item-level-no="'.$loc_arr->level.'" class="chk_location_cls" onClick="operate_property_locations(\''.$loc_arr->id.'\',\''.$loc_parent_id.'\');" /> '.stripslashes($loc_arr->name).' </label> </li>';  
					$chk++;	
				}  
			 	
				$ret_txt .= '</ul> </div> </div>';
			}
			
			echo $ret_txt;
			die();
		}
	/* end of locations */
	 
	  
	}
?>
