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
				 $this->load->model('general_model');
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
						$cstm_sess_data = array('us_login' => TRUE,'us_id' => $result->id,'us_role_id' => $result->role_id,'us_name' => ucfirst($result->name),'us_email' => $result->email);
						 
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
		 
		 
	function forgot_password(){ 
		if(isset($_POST) && !empty($_POST)){
			$this->load->model('general_model');
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
					$this->load->model('general_model');
					
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