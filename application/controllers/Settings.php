<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Settings extends CI_Controller{
	
		public function __construct(){
			parent::__construct();
			$vs_id = $this->session->userdata('us_id');
			$vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id >=1)){
				/* ok */
				$res_nums = $this->general_model->check_controller_permission_access('Settings',$vs_user_role_id,'1');
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
		}
		
		function my_profile(){    
			 //$vs_user_type_id = $this->session->userdata('us_user_type_id');
			$this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			
			if(isset($vs_user_role_id) && ($vs_user_role_id==1 || $vs_user_role_id==2 || $vs_user_role_id==3)){
				/* ok */
			}else{
				redirect('login/');
			}
			
			$datas["page_headings"] = "My Profile"; 
			$vs_id = $this->session->userdata('us_id');   
			$result = $this->users_model->get_user_by_id($vs_id);
			if(count($result) > 0){  
				$datas['vs_name']= $result->name; 
				$datas['vs_email']= $result->email; 
				$datas['vs_phone_no']= $result->phone_no;
				$datas['vs_mobile_no']= $result->mobile_no;  
				$datas['vs_image']= $result->image;
				$datas['vs_address']= $result->address; 
				$datas['vs_company_name']= $result->company_name;
				$datas['vs_rera_no']= $result->rera_no;	
			}
			
			if(isset($_POST) && !empty($_POST)){
		
				// get form input
				$name = $this->input->post("name");
				$phone_no = $this->input->post("phone_no");
				$mobile_no = $this->input->post("mobile_no"); 
				$address = $this->input->post("address");
				
				$company_name = $this->input->post("company_name"); 
				$rera_no = $this->input->post("rera_no");
				   
				$prf_img_error = ''; 		
				$alw_typs = array('image/jpg','image/jpeg','image/png','image/gif');
				$imagename = (isset($_POST['old_image']) && $_POST['old_image']!='') ? $_POST['old_image']:''; 
				if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!=''){ 
					if(!(in_array($_FILES['image']['type'],$alw_typs))) {
						$tmp_img_type = "'".($_FILES['image']['type'])."'";
						$prf_img_error .= "Profile image type: $tmp_img_type not allowed!<br>";
					}
					
					if($prf_img_error==''){
						@unlink("downloads/profile_pictures/thumbs/$imagename");
						$imagename = $this->general_model->fileExists($_FILES['image']['name'],"downloads/profile_pictures/thumbs/");
						
						$extension = $this->general_model->get_custom_file_extension($imagename);
						$extension = strtolower($extension);
						$uploadedfile = $_FILES['image']['tmp_name']; 
						$file_to_upload = "downloads/profile_pictures/thumbs/";   
						$this->general_model->genernate_thumbnails($imagename,$extension,$uploadedfile,$file_to_upload,36,36);
					}
				}   
		
				// form validation
				$this->form_validation->set_rules("name","Name",'required|trim|xss_clean');
				$this->form_validation->set_rules("phone_no","Phone No",'required|trim|xss_clean');
				$this->form_validation->set_rules("address","Address",'required|trim|xss_clean');
		
				if($this->form_validation->run() == FALSE){
					// validation fail
					/*if(isset($_SESSION['error_msg'])){
						unset($_SESSION['error_msg']);
					}
					if(isset($_SESSION['prof_img_error'])){
						unset($_SESSION['prof_img_error']);
					}*/
					$this->load->view('my_profile',$datas);
				}else 
				if(strlen($prf_img_error)>0){  
					$this->session->set_flashdata('prof_img_error',$prf_img_error);
					$this->load->view('my_profile',$datas);
				}else{
				
					if(isset($_SESSION['prof_img_error'])){
						unset($_SESSION['prof_img_error']);
					} 
					$vs_id = $this->session->userdata('us_id');
					$data = array('name' => $name,'phone_no' => $phone_no,'mobile_no' => $mobile_no,'address' => $address,'image' => $imagename,'company_name' => $company_name,'rera_no' => $rera_no); 
					$res = $this->users_model->update_user_data($vs_id,$data); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg', 'Your profile has been updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg', 'Oops, there is some error while updating your profile!');
					}
					redirect('settings/my_profile');
					//$this->load->view('my_profile_view',$datas); 
				}
				
			}else{
				/*if(isset($_SESSION['error_msg'])){
					unset($_SESSION['error_msg']);
				}
				if(isset($_SESSION['success_msg'])){
					unset($_SESSION['success_msg']);
				} 
				if(isset($_SESSION['prof_img_error'])){
					unset($_SESSION['prof_img_error']);
				} */
				$this->load->view('my_profile',$datas);
			}
		
		}
		
		function config(){  
			$this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			
			if(isset($vs_user_role_id) && $vs_user_role_id==1){
				/* ok */
			}else{
				redirect('login/');
			}
			
			$datas["page_headings"] = "Configuration"; 
			$config_id = 1;   
			$result = $this->users_model->get_config_by_id($config_id);
			if(count($result) > 0){    
				$datas['vs_company_name']= $result->company_name; 
				$datas['vs_sale_inititals']= $result->sale_inititals; 
				$datas['vs_rent_inititals']= $result->rent_inititals; 
				$datas['vs_summary']= $result->summary; 
				$datas['vs_disclaimer']= $result->disclaimer;
				$datas['vs_address_1']= $result->address_1;  
				$datas['vs_address_2']= $result->address_2;
				$datas['vs_website']= $result->website; 
				$datas['vs_email']= $result->email;
				$datas['vs_phone_no']= $result->phone_no;
				$datas['vs_copyrights']= $result->copyrights; 
				$datas['vs_image']= $result->image;   
			}
			
			if(isset($_POST) && !empty($_POST)){
		
				// get form input
				$company_name = $this->input->post("company_name");
				$summary = $this->input->post("summary");
				$disclaimer = $this->input->post("disclaimer"); 
				$address_1 = $this->input->post("address_1"); 
				$address_2 = $this->input->post("address_2"); 
				$website = $this->input->post("website");
				$email = $this->input->post("email"); 
				$phone_no = $this->input->post("phone_no");
				$copyrights = $this->input->post("copyrights"); 
				$sale_inititals = $this->input->post("sale_inititals"); 
				$rent_inititals = $this->input->post("rent_inititals"); 
				 
				  
				$prf_img_error = ''; 		
				$alw_typs = array('image/jpg','image/jpeg','image/png','image/gif');
				$imagename = (isset($_POST['old_image']) && $_POST['old_image']!='') ? $_POST['old_image']:''; 
				if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!=''){ 
					if(!(in_array($_FILES['image']['type'],$alw_typs))) {
						$tmp_img_type = "'".($_FILES['image']['type'])."'";
						$prf_img_error .= "Logo image type: $tmp_img_type not allowed!<br>";
					}
					
					if($prf_img_error==''){
						@unlink("downloads/site_logo/thumbs/$imagename");
						$imagename = $this->general_model->fileExists($_FILES['image']['name'],"downloads/site_logo/thumbs/");
						
						$extension = $this->general_model->get_custom_file_extension($imagename);
						$extension = strtolower($extension);
						$uploadedfile = $_FILES['image']['tmp_name']; 
						$file_to_upload = "downloads/site_logo/thumbs/";   
						$this->general_model->genernate_thumbnails($imagename,$extension,$uploadedfile,$file_to_upload,206,32);
					}
				}       
		
				// form validation
				$this->form_validation->set_rules("company_name","Company Name",'required|trim|xss_clean');
				$this->form_validation->set_rules("sale_inititals","Sale Inititals",'required|trim|xss_clean');
				$this->form_validation->set_rules("rent_inititals","Rent Inititals",'required|trim|xss_clean');
				$this->form_validation->set_rules("summary","summary",'required|trim|xss_clean');
				$this->form_validation->set_rules("disclaimer","disclaimer",'required|trim|xss_clean');
				$this->form_validation->set_rules("address_1","Address 1",'required|trim|xss_clean');
				$this->form_validation->set_rules("address_2","Address 2",'required|trim|xss_clean');
				$this->form_validation->set_rules("website","Website",'required|trim|xss_clean');
				$this->form_validation->set_rules("email","Email",'required|trim|xss_clean');
				$this->form_validation->set_rules("phone_no","Phone No",'required|trim|xss_clean');
				$this->form_validation->set_rules("copyrights","Copyrights",'required|trim|xss_clean');
				if($this->form_validation->run() == FALSE){
					// validation fail 
					$this->load->view('config',$datas);
				}else 
				if(strlen($prf_img_error)>0){  
					$this->session->set_flashdata('prof_img_error',$prf_img_error);
					$this->load->view('config',$datas);
				}else{
				
					/*if(isset($_SESSION['prof_img_error'])){
						unset($_SESSION['prof_img_error']);
					} */ 
					$vs_id = 1;  
					$data = array('company_name' => $company_name,'sale_inititals' => $sale_inititals,'rent_inititals' => $rent_inititals,'summary' => $summary,'disclaimer' => $disclaimer,'address_1' => $address_1,'address_2' => $address_2,'website' => $website,'email' => $email,'phone_no' => $phone_no,'copyrights' => $copyrights,'image' => $imagename); 
					$res = $this->users_model->update_config_data($vs_id,$data); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg', 'Your Site Configuration has been updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg', 'Oops, there is some error while updating Site Configuration!');
					}
					redirect('settings/config');
					//$this->load->view('my_profile_view',$datas); 
				}
				
			}else{ 
				$this->load->view('config',$datas);
			} 
		}
		
		
		
		function property_settings(){  
			$vs_user_type_id = $this->session->userdata('us_user_type_id');
			
			if(isset($vs_user_type_id) && $vs_user_type_id==1){
				/* ok */
			}else{
				redirect('login/');
			}
			
			$datas["page_heading"] = "Property Settings"; 
			$config_id = 1;   
			$result = $this->users_model->get_config_by_id($config_id);
			if(count($result) > 0){    
				$datas['vs_property_desc_heading']= $result->property_desc_heading; 
				$datas['vs_property_desc_footer']= $result->property_desc_footer;  
				$datas['vs_generic_sale_location_desc']= $result->generic_sale_location_desc; 
				$datas['vs_generic_rent_location_desc']= $result->generic_rent_location_desc;  
				$datas['vs_generic_location_desc']= $result->generic_location_desc; 
				
			}
			
			if(isset($_POST) && !empty($_POST)){
				 
				$property_desc_heading = $this->input->post("property_desc_heading");
				$property_desc_footer = $this->input->post("property_desc_footer");
				$generic_sale_location_desc = $this->input->post("generic_sale_location_desc");
				$generic_rent_location_desc = $this->input->post("generic_rent_location_desc");
				$generic_location_desc = $this->input->post("generic_location_desc");
					
				// form validation
				$this->form_validation->set_rules("property_desc_heading","Description Heading",'required|trim|xss_clean');
				$this->form_validation->set_rules("property_desc_footer","Description Footer",'required|trim|xss_clean'); 
				$this->form_validation->set_rules("generic_location_desc","Generic Location Description",'required|trim|xss_clean');
				
				$this->form_validation->set_rules("generic_sale_location_desc","Generic Sale Location Description",'required|trim|xss_clean'); 
				$this->form_validation->set_rules("generic_rent_location_desc","Generic Rent Location Description",'required|trim|xss_clean'); 
				
		
				if($this->form_validation->run() == FALSE){
					// validation fail 
					$this->load->view('property_settings',$datas);
				}else{  
					$vs_id = 1;  
					$data = array('property_desc_heading' => $property_desc_heading,'property_desc_footer' => $property_desc_footer,'generic_location_desc' => $generic_location_desc,'generic_sale_location_desc' => $generic_sale_location_desc,'generic_rent_location_desc' => $generic_rent_location_desc); 
					$res = $this->users_model->update_config_data($vs_id,$data); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg', 'Property Configuration has been updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg', 'Oops, there is some error while updating Property Configuration!');
					}
					redirect('settings/property_settings');
					//$this->load->view('my_profile_view',$datas); 
				}
				
			}else{ 
				$this->load->view('property_settings',$datas);
			}
		
		}
		
		
		
		
		function change_password(){ 
			
			$vs_user_role_id = $this->session->userdata('us_role_id');
			
			if(isset($vs_user_role_id) && ($vs_user_role_id==1 || $vs_user_role_id==2 || $vs_user_role_id==3)){
				/* ok */
			}else{
				redirect('login/');
			}
			
			$datas["page_headings"] = "Change Password"; 
			if(isset($_POST) && !empty($_POST)){
		
				// get form input
				$old_password = $this->input->post("old_password"); 
				$new_password = $this->input->post("new_password"); 
				$conf_password = $this->input->post("conf_password"); 
				// form validation
				$this->form_validation->set_rules("old_password","Old Password",'required|trim|xss_clean');
				$this->form_validation->set_rules("new_password","New Password",'required|trim|xss_clean|matches[conf_password]');
				$this->form_validation->set_rules("conf_password","Confirm Password",'required|trim|xss_clean');
				 
				if($this->form_validation->run() == FALSE){ 
					$this->load->view('change_password',$datas);
				}else{ 
					// check for user credentials
					
					$vs_id = $this->session->userdata('us_id');   
					$result = $this->users_model->get_user_by_id($vs_id);
					if(count($result) > 0){  
						$db_password = $result->password;
						/*$old_password = md5($old_password);*/
						$old_password = $this->general_model->encrypt_data($old_password);
						if($old_password!=$db_password){
							$this->session->set_flashdata('old_password', 'Old Password doesn\'t match!');
						}else{
							if(isset($_SESSION['old_password'])){
								unset($_SESSION['old_password']);
							}
							
							$vs_id = $this->session->userdata('us_id');
							/*$new_password = md5($new_password);*/
							$new_password = $this->general_model->encrypt_data($new_password);
							$data = array('password' => $new_password); 
							$res = $this->users_model->update_user_data($vs_id,$data); 
							
							if(isset($res)){
								$this->session->set_flashdata('success_msg', 'Your account password has been changed successfully!');
							}else{
								$this->session->set_flashdata('error_msg', 'Oops, there is some error while changing account password!');
							}
						} 
						
						$this->load->view('change_password',$datas); 
						 
					}else{
						if(isset($_SESSION['success_msg'])){
							unset($_SESSION['success_msg']);
						}
						$this->session->set_flashdata('error_msg', "This Email-ID doesn't exists in our record!");
						$this->load->view('change_password',$datas); 
					}
				}
				
			}else{
				if(isset($_SESSION['error_msg'])){
					unset($_SESSION['error_msg']);
				}
				
				if(isset($_SESSION['success_msg'])){
					unset($_SESSION['success_msg']);
				}
				
				$this->load->view('change_password',$datas);
			}
		
		}
		 
		public function logoff(){
			$this->session->sess_destroy();
			redirect('login');
		} 
}
?>
