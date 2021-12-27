<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Property_features extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){ 
				 
				/*$res_nums = $this->general_model->check_controller_permission_access('Property_features',$vs_user_role_id,'1');
				if($res_nums>0){
				  
				}else{
					redirect('/');
				}*/ 
				
			}else{
				redirect('/');
			} 
			$this->load->model('property_features_model');
			$this->load->model('portals_model');
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}  
	
	
	/* property features operations starts */
	function index(){   
		$res_nums =  $this->general_model->check_controller_method_permission_access('Property_features','index',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){ 
			
			$data['records'] = $this->property_features_model->get_all_property_features();
			$data['page_headings']="Property Features List";
			$this->load->view('property_features/index',$data); 
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	}
	 
	function trash($args2=''){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Property_features','trash',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){
			
			$data['page_headings']="Property Features List";
			$this->property_features_model->trash_property_feature($args2); 
			$this->general_model->trash_feature_portal_abbrevation_data($args2);
			redirect('property_features/index'); 
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	}
	
	
	function trash_aj(){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Property_features','trash',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){
			
			 if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1");
				$this->property_features_model->trash_property_feature($args1); 
				$this->general_model->trash_feature_portal_abbrevation_data($args1);
			 } 
			 
			 $data['records'] = $this->property_features_model->get_all_property_features();
			 $this->load->view('property_features/index_aj',$data); 
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }  
	 
	 function trash_multiple(){  
	  	$res_nums =  $this->general_model->check_controller_method_permission_access('Property_features','trash',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args2){   
					$this->property_features_model->trash_property_feature($args2); 
					$this->general_model->trash_feature_portal_abbrevation_data($args2); 
				}  
			} 
		
		 	$data['records'] = $this->property_features_model->get_all_property_features();
			$this->load->view('property_features/index_aj',$data);
		 
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 } 
	 
	 
	 function add(){  
		 $res_nums =  $this->general_model->check_controller_method_permission_access('Property_features','add',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){ 
		
			$data['page_headings'] = 'Add Property Feature'; 
			
			$data['max_sort_val'] = $this->property_features_model->get_max_property_features_sort_val();
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$title = $this->input->post("title"); 
				$short_tag = $this->input->post("short_tag"); 
				$sort_order = $this->input->post("sort_order");
				/*$amenities_type = $this->input->post("amenities_type"); */
				$status = isset($_POST['status']) ? 1 : 0;
				
				$sel_amenities_types = (isset($_POST['amenities_types']) && count($_POST['amenities_types'])>0) ? implode(',',$_POST['amenities_types']) : ''; 
				 
				// form validation
				$this->form_validation->set_rules("title", "Title", "trim|required|xss_clean");
				$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
				 
				if($this->form_validation->run() == FALSE){
				// validation fail 
					$this->load->view('property_features/add',$data);
				}else{ 
					$datas = array('title' => $title,'short_tag' => $short_tag,'sort_order' => $sort_order,'amenities_types' => $sel_amenities_types,'status' => $status); 
					$res = $this->property_features_model->insert_property_feature_data($datas); 
					if(isset($res)){
						
						$last_ftrd_id = $this->db->insert_id();
						$portal_arrs = $this->portals_model->get_all_portals();
						if(isset($portal_arrs) && count($portal_arrs)>0){
							foreach($portal_arrs as $portal_arr){
								$db_portals_id = $portal_arr->id; 
						   
								if(isset($_POST["cate_portal_abbr_{$db_portals_id}"]) && strlen($_POST["cate_portal_abbr_{$db_portals_id}"])>0){
									$cate_portal_abbrs = $_POST["cate_portal_abbr_{$db_portals_id}"];
										
									$datas3 = array('featured_id' => $last_ftrd_id,'portal_id' => $db_portals_id,'abbrevations' => $cate_portal_abbrs);
									$this->general_model->insert_featured_portal_abbrevations_data($datas3);		 
								} 
							}
						} 
						
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					 
					if(isset($_POST['saves_and_new'])){
						redirect("property_features/add");
					}else{
						redirect("property_features/index");	
					}
				} 	 
				
			}else{
				$this->load->view('property_features/add',$data);
			}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}
	 
	
	
	 function update($args1=''){ 
	 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Property_features','update',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){ 
		
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;//
				$data['page_headings'] = 'Update Property Feature';
				$data['record'] = $this->property_features_model->get_property_feature_by_id($args1);
			} 
			
			$data['max_sort_val'] = $this->property_features_model->get_max_property_features_sort_val();
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$title = $this->input->post("title"); 
				$short_tag = $this->input->post("short_tag"); 
				$sort_order = $this->input->post("sort_order");
				/*$amenities_type = $this->input->post("amenities_type"); */
				$status = isset($_POST['status']) ? 1 : 0;
				
				$sel_amenities_types = (isset($_POST['amenities_types']) && count($_POST['amenities_types'])>0) ? implode(',',$_POST['amenities_types']) : ''; 
				 
				// form validation
				$this->form_validation->set_rules("title", "Title", "trim|required|xss_clean");
				$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
				 
				if($this->form_validation->run() == FALSE){
				// validation fail 
					$this->load->view('property_features/update',$data);
				}else if(isset($args1) && $args1!=''){
					 
					$datas = array('title' => $title,'short_tag' => $short_tag,'sort_order' => $sort_order,'amenities_types' => $sel_amenities_types,'status' => $status); 
					$res = $this->property_features_model->update_property_feature_data($args1,$datas); 
					if(isset($res)){
						
			$portal_arrs = $this->portals_model->get_all_portals();
			if(isset($portal_arrs) && count($portal_arrs)>0){
				foreach($portal_arrs as $portal_arr){
					$db_portals_id = $portal_arr->id; 
			
					$this->general_model->trash_featured_portal_abbrevations_data($args1,$db_portals_id);  
					if(isset($_POST["cate_portal_abbr_{$db_portals_id}"]) && strlen($_POST["cate_portal_abbr_{$db_portals_id}"])>0){
						$cate_portal_abbrs = $_POST["cate_portal_abbr_{$db_portals_id}"];
							
						$datas3 = array('featured_id' => $args1,'portal_id' => $db_portals_id,'abbrevations' => $cate_portal_abbrs);
						$this->general_model->insert_featured_portal_abbrevations_data($datas3);		 
					} 
				}
			} 
						
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("property_features/index");
				} 	 
				
			}else{
				$this->load->view('property_features/update',$data);
			}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}
	
	
	
	function amenities_popup_list($paras2=''){   
		$res_nums = $this->general_model->check_controller_method_permission_access('Property_features','index',$this->dbs_user_role_id,'1'); 
		if($res_nums>=0){ 
			$data['paras2'] = $paras2;	
			$data['page_headings']="Amenities Listing";	
			 
			$data['private_amt_recs'] = $this->property_features_model->get_all_property_features_by_type('1');
			$data['commercial_amt_recs'] = $this->property_features_model->get_all_property_features_by_type('2');
			  
			$this->load->view('property_features/amenities_popup_list',$data); 
			  
		}else{
			$this->load->view('no_permission_access'); 
		} 
	}
	
	
	
	/* end of property features */
	  
	}
?>
