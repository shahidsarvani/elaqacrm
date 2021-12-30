<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/login_meta_tags'); ?>
 
<script type="text/javascript" src="<?= asset_url();?>js/plugins/forms/wizards/steps.min.js"></script>
<script type="text/javascript" src="<?= asset_url();?>js/plugins/forms/selects/select2.min.js"></script> 
<!--<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script> 
<script type="text/javascript" src="<?= asset_url();?>js/core/app.js"></script> -->
<script type="text/javascript" src="<?= asset_url();?>js/pages/wizard_steps.js"></script>
 
</head>
<body class="login-container">
<!-- Main navbar -->
 <?php $this->load->view('widgets/login_header'); ?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
  <!-- Page content -->
  <div class="page-content">
    <!-- Main content -->
    <div class="content-wrapper">
      <!-- Content area -->
      <div class="content">
	  	 
        <!-- Registration form --> 
          <div class="row">
            <div class="col-lg-6 col-lg-offset-3"> 
			<?php if(isset($_SESSION['success_msg'])){ ?>    
					<div class="alert alert-success no-border">
						<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button> <?php echo $this->session->flashdata('success_msg'); ?>
					 </div> 
			<?php }
				if(isset($_SESSION['error_msg'])){ ?>  
					<div class="alert alert-danger no-border">
					<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button> <?php echo $this->session->flashdata('error_msg'); ?>
				  </div>    
			<?php } ?> 
			
              <div class="panel registration-form">
                <div class="panel-body">
                  <div class="text-center">
                    <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                    <h5 class="content-group-lg">Create account <small class="display-block"> ilaqa CRM </small></h5>
                  </div> 
				  <form name="datas_form" id="datas_form" class="steps-validation" method="post" action="">
					<h6>Personal info</h6>
					<fieldset> 
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="name">Name: <span class="text-danger">*</span></label>
						  <input type="text" name="name" id="name" class="form-control required" placeholder="Name" data-error="#name1"> <span id="name1" class="text-danger"><?php echo form_error('name'); ?></span> 
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="email">Email: <span class="text-danger">*</span></label>
						  <input type="email" name="email" id="email" class="form-control required" placeholder="Email Address" data-error="#email1"> <span id="name1" class="text-danger"><?php echo form_error('email'); ?></span> 
						</div>
					  </div>
					</div>
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="password">Password: <span class="text-danger">*</span></label>
						  <input type="password" name="password" id="password" class="form-control required" placeholder="Password" data-error="#password1"> <span id="password1" class="text-danger"><?php echo form_error('password'); ?></span> 
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="conf_password">Confirm Password: <span class="text-danger">*</span></label>
						  <input type="password" name="conf_password" id="conf_password" class="form-control required" placeholder="Confirm Password" data-rule-equalTo="#password" data-error="#password2"> <span id="password2" class="text-danger"><?php echo form_error('conf_password'); ?></span>
						</div>
					  </div>
					</div>
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="phone_no">Phone Number:</label>
						  <input type="text" name="phone_no" id="phone_no" class="form-control required" placeholder="Phone #" />
						</div>
					  </div>
					  
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="mobile_no">Mobile Number: <span class="text-danger">*</span></label>
						  <input type="text" name="mobile_no" id="mobile_no" class="form-control required" placeholder="Mobile #" data-error="#mobile_no1"> <span id="mobile_no1" class="text-danger"><?php echo form_error('mobile_no'); ?></span>
						</div>
					  </div> 
					</div>
					</fieldset>
					<h6>Company Info</h6>
					<fieldset>
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="company_name">Company Name: <span class="text-danger">*</span></label>
						  <input type="text" name="company_name" id="company_name" placeholder="Company Name" class="form-control required" data-error="#company_name1"> <span id="company_name1" class="text-danger"><?php echo form_error('company_name'); ?></span>
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="form-group">
						  <label>No. of Employees: <span class="text-danger"></span></label>
						    <input type="text" name="no_of_employees" id="no_of_employees" placeholder="No. of Employees" class="form-control required"  onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" />
						</div>
					  </div>
					</div> 
					</fieldset>
					 
					<h6>Process Payment</h6>
					<fieldset> 
					<div class="row"> 
					  <div class="col-md-8 col-md-pull-0">
						 <div class="form-group">
						  <label for="package_id">Packages: <span class="text-danger">*</span></label>
						  <select name="package_id" id="package_id" class="form-control required select" data-error="#package_id1">
						  	<option value=""> Select Package </option>
							<option value="1"> Basic 1 @ Rs 300 </option>
							<option value="2"> Regular @ Rs 600 </option>
							<option value="3"> Premium @ Rs 1000 </option>  
						  </select> 
					  <span id="package_id1" class="text-danger"><?php echo form_error('package_id'); ?></span>
						</div>           
					  </div> 
					  
					  <div class="col-md-12">
						<div class="form-group">
						  <label>Payment Gateway: <span class="text-danger">*</span></label>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled required" value="Payoneer"> Payoneer </label>
						  </div>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled required" value="JazzCash"> JazzCash </label>
						  </div>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled required" value="EasyPaisa"> EasyPaisa </label>
						  </div>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled required" value="FonePay"> FonePay </label>
						  </div>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled required" value="Keenu Wallet" /> Keenu Wallet </label>
						  </div>
						  
						  <span class="text-danger"><?php echo form_error('payment_gateway'); ?></span>
						</div>           
					  </div> 
					</div>
					</fieldset>
				  </form>  
				  
				  
				  <div class="text-left"> 
				   <a href="<?php echo site_url('login/forgot_password'); ?>">Forgot password?</a>  &nbsp; | &nbsp;
				  <a href="<?php echo site_url('login/signup'); ?>">SignIn</a>  
				  
				  </div>
				  
                </div>
              </div>
            </div>
          </div> 
        <!-- /registration form -->
        <!-- Footer -->
         <?php $this->load->view('widgets/login_footer'); ?>
        <!-- /footer -->
      </div>
      <!-- /content area -->
    </div>
    <!-- /main content -->
  </div>
  <!-- /page content -->
</div>
<!-- /page container -->
</body>
</html>