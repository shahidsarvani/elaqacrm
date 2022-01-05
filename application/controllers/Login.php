<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Login extends CI_Controller{
	
		public function __construct(){
			parent::__construct(); 
			$vs_user_role_id = $this->session->userdata('us_role_id');
			
		 	if($vs_user_role_id >0){
				redirect("dashboard/index");
			}
			
			$this->load->model('users_model');
			$this->load->model('general_model');
		}
		
		function index(){	
			if(isset($_POST) && !empty($_POST)){ 
				// get form input
				$email = $this->input->post("email");
				$password = $this->input->post("password");
		
				// form validation
				$this->form_validation->set_rules("email","Email-ID",'required|trim|xss_clean|valid_email');
				$this->form_validation->set_rules("password","Password",'required|trim|xss_clean');
	
				if($this->form_validation->run() == FALSE){
					// validation fail
					if(isset($_SESSION['error_msg'])){
						unset($_SESSION['error_msg']);
					}
					$this->load->view('login');
				}else{ 
					// check for user credentials
					/*$password = md5($password);*/
					$password = $this->general_model->encrypt_data($password);
					$result = $this->users_model->get_user($email,$password);
					if(isset($result->id) && $result->id >0){  
						if($result->status==1){  
					
						$last_login_on = date('Y-m-d H:i:s');
						$ip_address = $_SERVER['REMOTE_ADDR'];
						
						$update_array = array('last_login_on' => $last_login_on,'ip_address' => $ip_address); 
						$rec = $this->users_model->update_user_data($result->id,$update_array);
						// set session
						$cstm_sess_data = array('us_login' => TRUE,'us_id' => $result->id,'us_parent_id' => $result->parent_id, 'us_role_id' => $result->role_id,'us_name' => ucfirst($result->name),'us_email' => $result->email);
						 
						$this->session->set_userdata($cstm_sess_data);
						
						if($result->role_id >0){
							redirect("dashboard/index");
						}  
						
					}else{ 
						$this->session->set_flashdata('error_msg', 'Your account is Inactive, please contact Admin!');
						$this->load->view('login'); 
					}
					 
				}else{ 
					$this->session->set_flashdata('error_msg', 'Invalid Email-ID or Password!');
					$this->load->view('login'); 
				}
			}
		
		}else{
			$this->load->view('login');
		} 
	}
	
	function signup(){	
		$this->load->model('packages_model'); 
		$datas["packages_arrs"] = $this->packages_model->get_all_active_packages();
		$datas['conf_currency_symbol'] = $currency = $this->general_model->get_gen_currency_symbol();
		if(isset($_POST) && !empty($_POST)){ 
			// get form input
			$name = $this->input->post("name");
			$email = $this->input->post("email");
			$password = $this->input->post("password"); 
			$phone_no = $this->input->post("phone_no");
			$mobile_no = $this->input->post("mobile_no");
			$company_name = $this->input->post("company_name");
			$no_of_employees = $this->input->post("no_of_employees");
			$package_id = $this->input->post("sel_package_id");
			$payment_gateway = ''; // $this->input->post("payment_gateway");   
			
			//name  email  password  conf_password  phone_no  mobile_no company_name  no_of_employees  payment_gateway 
			// form validation 
			$this->form_validation->set_rules("name","Name",'required|trim|xss_clean'); 
			$this->form_validation->set_rules("email", "Email", "trim|required|xss_clean|valid_email|is_unique[users_tbl.email]");
			$this->form_validation->set_rules("password","Password",'required|trim|xss_clean');
			$this->form_validation->set_rules("mobile_no","Mobile No",'required|trim|xss_clean');
			$this->form_validation->set_rules("company_name","Company Name",'required|trim|xss_clean');
			//$this->form_validation->set_rules("payment_gateway","Payment Gateway",'required|trim|xss_clean');
			
			if($this->form_validation->run() == FALSE){
				// validation fail 
				$this->load->view('signup', $datas);
			}else{
				
				$created_on = date('Y-m-d H:i:s');  
				$ip_address = $_SERVER['REMOTE_ADDR']; 
				
				$password = $this->general_model->encrypt_data($password); 
				$random_password = $this->general_model->random_string('7');
				
				$package_price = 0;
				$package_start_date = $package_end_date = date('Y-m-d');
				
				$row1 = $this->packages_model->get_package_by_id($package_id);
				if($row1){
					$package_name = $row1->name;
					$package_price =  $row1->price;
					$package_package_type = $row1->package_type;
					$package_duration =  $row1->duration;  
					
					if($package_package_type == 1){
						$package_end_date = date('Y-m-d', strtotime($package_start_date. " +{$package_duration} days"));
					}else if($package_package_type == 2){
						$package_end_date = date('Y-m-d', strtotime($package_start_date. " +{$package_duration} months"));
					}else if($package_package_type == 3){
						$package_end_date = date('Y-m-d', strtotime($package_start_date. " +{$package_duration} years"));
					}
				}
 				//package_id	package_start_date	package_end_date	package_status
				 
				$datas = array('name' => $name, 'email' => $email, 'password' => $password, 'mobile_no' => $mobile_no, 'phone_no' => $phone_no, 'company_name' => $company_name, 'no_of_employees' => $no_of_employees, 'status' => '1', 'parent_id' => '0', 'role_id' => '2', 'random_password' => $random_password, 'ip_address' => $ip_address, 'created_on' => $created_on, 'package_id' => $package_id, 'package_start_date' => $package_start_date, 'package_end_date' => $package_end_date, 'package_status' => '1'); 
				 
				$insert_data = $this->users_model->insert_user_data($datas); 
				if(isset($insert_data)){  
					$last_member_id = $this->db->insert_id();
					
					//users_packages_plans_subscription_tbl
					/*  transaction_id transaction_datetime amount  currency  ip_address added_on  updated_on       */
						 
					/*$package_datas = array('user_id' => $last_member_id, 'package_id' => $package_id, 'subscripton_start_date' => $package_start_date, 'subscripton_end_date' => $package_end_date, 'status' => '0', 'name' => $name, 'email' => $email, 'payment_status' => '0', 'transaction_datetime' => $created_on, 'amount' => $package_price, 'currency' => $currency, 'ip_address' => $ip_address, 'added_on' => $created_on, 'updated_on' => $created_on ); 
					$this->packages_model->insert_package_subscription_data($package_datas); */
				
					
					$this->load->library('email'); 
					/*$reset_link = "login/signup/{$last_member_id}/"; 
					$reset_link = site_url($reset_link);   */
					
					$site_name = 'ilaqa-CRM'; 
					/*'https://elaqacrm.digitalpoin8.com/'; //$this->config->item('custom_site_name');  */
					
					$mailtext = "<table width='90%' border='0' align='center' cellpadding='7' cellspacing='7' style='color:#000000; font-size:12px; font-family:tahoma;'> <tbody> <tr> <td> <h4> Welcome for Joining us at ".$site_name."</h4> </td> </tr>"; 
					$mailtext .= "<tr> <td> Dear ".$name.", <br> <br>Thanks for joining us at ".$site_name.", by creating a new registration account on our platform. <br> <br> You can access your ilaqa CRM account to avail our CRM features.<br> <br> <br> The ".$site_name." Team </td> </tr> </tbody> </table>";  
					
					$configs_arr = $this->general_model->get_configuration();
					$from_email = $configs_arr->email; 
					
					$config['mailtype'] = 'html';  
					$this->email->initialize($config); 
					$this->email->to($email); 
					$this->email->from($from_email); 
					$this->email->subject("Welcome for Joining us at ".$site_name );
					$this->email->message($mailtext);  
					
					//$this->email->send();  
					  
					$this->session->set_flashdata('success_msg', 'Your account has been created successfully, please login to access your account!');
					
					redirect("login/index");  
					 
				}else{ 
					$this->session->set_flashdata('error_msg', 'An error has been generated while creating an account, please try again!');
					$this->load->view('signup', $datas); 
				} 
		}
	
	}else{
			$this->load->view('signup', $datas);
		} 
	}
		 
	function check_email_existance(){
		if(isset($_POST["email"]) && strlen($_POST["email"])>0){ 
			$email = $this->input->post("email");
			$result = $this->users_model->get_user_by_email($email);
			
			//print_r($result);
			if($result){
				echo "false";
			}else{
				echo "true"; 
			} 
			
		}else{ 
			echo "true";	
		}
		
		die();
	}  
	
			 
	function forgot_password(){ 
		if(isset($_POST) && !empty($_POST)){ 
			$email = $this->input->post("email");
			 
			// form validation
			$this->form_validation->set_rules("email","Email-ID",'required|trim|xss_clean|valid_email');
			 
			if($this->form_validation->run() == FALSE){
				// validation fail
				if(isset($_SESSION['error_msg'])){
					unset($_SESSION['error_msg']);
				}
				$this->load->view('forgot_password');
			}else{ 
				// check for user credentials
				$result = $this->users_model->get_user_by_email($email);
				if(count($result) > 0){
					//Load email library 
					$this->load->library('email'); 
					$vs_id = $result->id;  
					//$vs_id = base64_encode($db_vs_id); 
					
					$vs_name = $result->name;
					$vs_email = $result->email;
					//$vs_password = $result->password;  
				
					$this->load->helper('string');
					$random_password = random_string('alnum',20);  
					$update_array = array('random_password' => $random_password); 
					$result = $this->users_model->update_user_data($vs_id,$update_array);
					$reset_link = "login/reset_password/{$vs_id}/{$random_password}/"; 
					$reset_link = site_url($reset_link);   
					
					$mailtext = "<table width='90%' border='0' align='center' cellpadding='7' cellspacing='7' style='color:#000000; font-size:12px; font-family:tahoma;'> <tbody> <tr> <td> <h4> ilaqa CRM: Reset your ilaqa CRM Password</h4> </td> </tr>"; 
				
					$mailtext .= "<tr> <td> Dear ".$vs_name.", <br> <br> Someone recently requested a password change for your ilaqa CRM account. If this was you, you can set a new password by clicking the link below: <br> <br> <a href=\"$reset_link\" target=\"_blank\" title=\"Click here to Reset Your ilaqa CRM Password\"><strong><u>Reset Your ilaqa CRM Password</u></strong></a> <br> <br> If you don't want to change your password or didn't request this, just ignore and delete this message. <br> <br> To keep your account secure, please don't forward this email to anyone. <br> <br> The ilaqa CRM Team </td> </tr> </tbody> </table>";  
				 
					  $configs_arr = $this->general_model->get_configuration();
					  $from_email = $configs_arr->email; 
					  
					  $config['mailtype'] = 'html';  
					  $this->email->initialize($config); 
					  $this->email->to($vs_email); 
					  $this->email->from($from_email); 
					  $this->email->subject("Reset your ilaqa CRM Account Password");
					  $this->email->message($mailtext);  
				   
					  if($this->email->send()){
						$this->session->set_flashdata('success_msg', 'Please check your Email-ID, We have sent your account info!'); 
					  }else{
						 $this->session->set_flashdata('error_msg', 'Unable to sent mail, please check configuration!');
					  }     
					  $this->load->view('forgot_password'); 
					 
				}else{
					if(isset($_SESSION['success_msg'])){
						unset($_SESSION['success_msg']);
					}
					$this->session->set_flashdata('error_msg', 'This Email-ID doesn\'t exists in our record!');
					$this->load->view('forgot_password'); 
				}
			}
			
		}else{
			if(isset($_SESSION['error_msg'])){
				unset($_SESSION['error_msg']);
			}
			
			if(isset($_SESSION['success_msg'])){
				unset($_SESSION['success_msg']);
			}
			
			$this->load->view('forgot_password');
		}
	} 
		
		function reset_password($vs_id,$rand_numbs){  
			//$vs_id = base64_decode($vs_id);
			$vs_id = $vs_id;
			$rand_numbs = $rand_numbs;
			$this->session->set_flashdata('temp_vs_id', $vs_id);
			$data['vs_id'] = $vs_id;
			$data['rand_numbs'] = $rand_numbs;
			
			$data_arr = array('id'=> $vs_id,'random_password'=> $rand_numbs);
			$result = $this->users_model->get_user_custom_data($data_arr);
			if($result){
				if(isset($_POST) && !empty($_POST)){ 
					
					$new_password = $this->input->post("new_password");
					$conf_password = $this->input->post("conf_password");
					
					// form validation
					$this->form_validation->set_rules("new_password","New Password",'required|trim|xss_clean|matches[conf_password]');
					$this->form_validation->set_rules("conf_password","Confirm Password",'required|trim|xss_clean');
					if($this->form_validation->run() == FALSE){
						$this->load->view('reset_password',$data);
					}else{ 
						$tmp_vs_id = $this->session->flashdata('temp_vs_id');
						$this->load->helper('string');
						$random_password = random_string('alnum',20);  
						/*$new_password = md5($new_password);*/ 
						$new_password = $this->general_model->encrypt_data($new_password);
						$update_array = array('password' => $new_password,'random_password' => $random_password); 
						$result = $this->users_model->update_user_data($tmp_vs_id,$update_array);
						
						 if(isset($result)){
							$this->session->set_flashdata('success_msg', 'Your Account Password has been changed successfully!');  
							redirect('login/index');
						 }else{
							$this->session->set_flashdata('error_msg', 'Unable to change your Account, please try again!');
						} 
					}  
				}else{
					if(isset($_SESSION['error_msg'])){
						unset($_SESSION['error_msg']);
					}
					
					if(isset($_SESSION['success_msg'])){
						unset($_SESSION['success_msg']);
					}	
				}
			 
				$this->load->view('reset_password',$data); 
			}else{
				$this->session->set_flashdata('error_msg', 'Unable to reset your account password, please try again!');
				$this->load->view('forgot_password',$data); 
			}
		} 	
} ?>