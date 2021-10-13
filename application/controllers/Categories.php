<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Categories extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				  
				$res_nums = $this->general_model->check_controller_permission_access('Categories',$vs_user_role_id,'1');
				if($res_nums>0){
					 
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			}
			 
			$this->load->model('categories_model');
			$this->load->model('portals_model'); 
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}   
		 
		/* categories operations starts */
		function index(){   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Categories','index',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				$data['page_headings']="Categories List";
				$data['records'] = $this->categories_model->get_all_categories(); 
				$this->load->view('categories/index',$data);  
			}else{ 
				$this->load->view('no_permission_access'); 
			}
		 }     
		 
		 function trash($args2=''){    
			$res_nums =  $this->general_model->check_controller_method_permission_access('Categories','trash',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				
				$data['page_headings']="Categories List";
				$this->categories_model->trash_category($args2);
				
				$this->general_model->trash_category_portal_abbrevations_data($args2);
				redirect('categories/index');  
				
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
			
		 }
		 
		 
		 function trash_aj(){  
			$res_nums =  $this->general_model->check_controller_method_permission_access('Categories','trash',$this->dbs_user_role_id,'1');
			if($res_nums>0){
				
				if(isset($_POST["args1"]) && $_POST["args1"]>0){
					$args1 = $this->input->post("args1");  
					$this->categories_model->trash_category($args1); 
					$this->general_model->trash_category_portal_abbrevations_data($args1);
				 } 
				  
				 $data['records'] = $this->categories_model->get_all_categories(); 
				 $this->load->view('categories/index_aj',$data); 
				  
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		 }  
		 
		 function trash_multiple(){ 
			$res_nums =  $this->general_model->check_controller_method_permission_access('Categories','trash',$this->dbs_user_role_id,'1'); 
			if($res_nums>0){
				
				if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
					$del_checks = $_POST["multi_action_check"]; 
					foreach($del_checks as $args2){   
						$this->categories_model->trash_category($args2); 
						$this->general_model->trash_category_portal_abbrevations_data($args2); 
					}  
				}  
				 
				$data['records'] = $this->categories_model->get_all_categories(); 
				$this->load->view('categories/index_aj',$data); 
				  
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		 }
		   
		 
	 function add(){   
	 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Categories','add',$this->dbs_user_role_id,'1');  
		if($res_nums>0){ 
			 
			$data['page_headings'] = 'Add Category';
			 
			$data['max_sort_val'] = $this->categories_model->get_max_categories_sort_val();
			
			if(isset($_POST) && !empty($_POST)){
				// get form input
				$name = $this->input->post("name");
				$sort_order = $this->input->post("sort_order");
				$description = $this->input->post("description");
				$property_type = $this->input->post("property_type");
				$show_in_sale = isset($_POST['show_in_sale']) ? 1 : 0;
				$show_in_rent = isset($_POST['show_in_rent']) ? 1 : 0;
				$status = isset($_POST['status']) ? 1 : 0; 
				 
				// form validation
				$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");
				$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("description", "description", "trim|xss_clean");  
				
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('categories/add',$data);
				}else if(isset($args1) && $args1!=''){
					  
					$datas = array('name' => $name,'sort_order' => $sort_order,'show_in_sale' => $show_in_sale,'show_in_rent' => $show_in_rent,'description' => $description,'property_type' => $property_type,'status' => $status); 
					$res = $this->categories_model->update_category_data($args1,$datas); 
					if(isset($res)){
						
						//$last_cate_id = $this->db->insert_id();
						 
							
				$portal_arrs = $this->portals_model->get_all_portals();
				if(isset($portal_arrs) && count($portal_arrs)>0){
					foreach($portal_arrs as $portal_arr){
						$db_portals_id = $portal_arr->id; 
				
						$this->general_model->trash_categories_portal_abbrevations_data($args1,$db_portals_id);  
						if(isset($_POST["cate_portal_abbr_{$db_portals_id}"]) && strlen($_POST["cate_portal_abbr_{$db_portals_id}"])>0){
							$cate_portal_abbrs = $_POST["cate_portal_abbr_{$db_portals_id}"];
								
							$datas3 = array('category_id' => $args1,'portal_id' => $db_portals_id,'abbrevations' => $cate_portal_abbrs);
							$this->general_model->insert_categories_portal_abbrevations_data($datas3);		 
						} 
					}
				} 
						
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("categories/index");
				}else{ 
					$datas = array('name' => $name,'sort_order' => $sort_order,'show_in_sale' => $show_in_sale,'show_in_rent' => $show_in_rent,'description' => $description,'property_type' => $property_type,'status' => $status); 
					$res = $this->categories_model->insert_category_data($datas); 
					if(isset($res)){
								
				$last_cate_id = $this->db->insert_id();
						
				$portal_arrs = $this->portals_model->get_all_portals();
				if(isset($portal_arrs) && count($portal_arrs)>0){
					foreach($portal_arrs as $portal_arr){
						$db_portals_id = $portal_arr->id; 
				 
						if(isset($_POST["cate_portal_abbr_{$db_portals_id}"]) && strlen($_POST["cate_portal_abbr_{$db_portals_id}"])>0){
							$cate_portal_abbrs = $_POST["cate_portal_abbr_{$db_portals_id}"];
							 
							$datas3 = array('category_id' => $last_cate_id,'portal_id' => $db_portals_id,'abbrevations' => $cate_portal_abbrs);
							$this->general_model->insert_categories_portal_abbrevations_data($datas3);		
						} 
					}
				}	
						
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					 
					
					if(isset($_POST['saves_and_new'])){
						redirect("categories/add");
					}else{
						redirect("categories/index");	
					} 
				} 	 
				
			}else{
				$this->load->view('categories/add',$data);
			}
			
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		} 
		
		function update($args1=''){  
			
			$res_nums =  $this->general_model->check_controller_method_permission_access('Categories','update',$this->dbs_user_role_id,'1'); 
			if($res_nums>0){ 
				
				if(isset($args1) && $args1!=''){ 
					$data['args1'] = $args1;
					$data['page_headings'] = 'Update Category';
					$data['record'] = $this->categories_model->get_category_by_id($args1);
				}
				
				$data['max_sort_val'] = $this->categories_model->get_max_categories_sort_val();
				
				if(isset($_POST) && !empty($_POST)){
					// get form input
					$name = $this->input->post("name");
					$sort_order = $this->input->post("sort_order");
					$description = $this->input->post("description");
					$property_type = $this->input->post("property_type");
					$show_in_sale = isset($_POST['show_in_sale']) ? 1 : 0;
					$show_in_rent = isset($_POST['show_in_rent']) ? 1 : 0;
					$status = isset($_POST['status']) ? 1 : 0; 
					 
					// form validation
					$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");
					$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
					$this->form_validation->set_rules("description", "description", "trim|xss_clean");  
					
					if($this->form_validation->run() == FALSE){
					// validation fail
						$this->load->view('categories/update',$data);
					}else if(isset($args1) && $args1!=''){
						  
						$datas = array('name' => $name,'sort_order' => $sort_order,'show_in_sale' => $show_in_sale,'show_in_rent' => $show_in_rent,'description' => $description,'property_type' => $property_type,'status' => $status); 
						$res = $this->categories_model->update_category_data($args1,$datas); 
						if(isset($res)){
							  
							//$last_cate_id = $this->db->insert_id();
							 
								
					$portal_arrs = $this->portals_model->get_all_portals();
					if(isset($portal_arrs) && count($portal_arrs)>0){
						foreach($portal_arrs as $portal_arr){
							$db_portals_id = $portal_arr->id; 
					
							$this->general_model->trash_categories_portal_abbrevations_data($args1,$db_portals_id);  
							if(isset($_POST["cate_portal_abbr_{$db_portals_id}"]) && strlen($_POST["cate_portal_abbr_{$db_portals_id}"])>0){
								$cate_portal_abbrs = $_POST["cate_portal_abbr_{$db_portals_id}"];
									
								$datas3 = array('category_id' => $args1,'portal_id' => $db_portals_id,'abbrevations' => $cate_portal_abbrs);
								$this->general_model->insert_categories_portal_abbrevations_data($datas3);		 
							} 
						}
					} 
							
							$this->session->set_flashdata('success_msg','Record updated successfully!');
						}else{
							$this->session->set_flashdata('error_msg','Error: while updating record!');
						}
						
							redirect("categories/index");
					}	 
					
				}else{
					$this->load->view('categories/update',$data);
				}
				
				}else{ 
					$this->load->view('no_permission_access'); 
				} 
			}
		/* end of categories */   
		 
	  
	}
?>
