<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/login_meta_tags'); ?>
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
        <!-- Simple login form -->
        <form name="datas_form" id="datas_form" action="<?php echo site_url('login/index'); ?>" method="post">
          <div class="panel panel-body login-form">
          
          	 <?php if(isset($_SESSION['success_msg'])){ ?>    
            	<div class="alert alert-success no-border">
                	<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                 <?php echo $this->session->flashdata('success_msg'); ?>
             	 </div> 
		<?php }
			if(isset($_SESSION['error_msg'])){ ?>  
                <div class="alert alert-danger no-border">
                <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                 <?php echo $this->session->flashdata('error_msg'); ?>
              </div>    
		<?php } ?>  
        
            <div class="text-center">
              <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
              <h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
            </div>
            <div class="form-group has-feedback has-feedback-left"> 
             <input name="email" id="email" type="text" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="Email-ID" data-error="#email1"> 
              <div class="form-control-feedback"> <i class="icon-envelop text-muted"></i> </div>
              <span id="email1" class="text-danger"><?php echo form_error('email'); ?></span> 
            </div>
            <div class="form-group has-feedback has-feedback-left"> 
              <input name="password" id="password" type="password" class="form-control" value="<?php echo set_value('password'); ?>" placeholder="Password" data-error="#password1">
              <div class="form-control-feedback"> <i class="icon-lock2 text-muted"></i> </div>
              <span id="password1" class="text-danger"><?php echo form_error('password'); ?></span> 
            </div>
            <div class="form-group">
              <button type="submit" name="submit_sign_in" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
            </div>
            <div class="text-center"> <a href="<?php echo site_url('login/forgot_password'); ?>">Forgot password?</a> </div>
          </div>
        </form>
        <script type="text/javascript">  
                $(document).ready(function(){ 
                    var validator = $('#datas_form').validate({
                    rules: {   
                        email: {
                            required: true, 
                            email: true
                        },
						password: {
                            required: true 
                        } 
                    },
                    messages: { 
                        email: {
                            required: "This is required field" , 
                            email: "Please enter a valid Email address!" 
                        },
						password: {
                            required: "This is required field"  
                        }    
                    },
                    errorPlacement: function(error, element) {
                      var placement = $(element).data('error');
                      if (placement) {
                        $(placement).append(error)
                      } else {
                        error.insertAfter(element);
                      }
                    },  
                    submitHandler: function(){ 
                        document.forms["datas_form"].submit();
                    }  
                  });
                }); 
            </script>
        <!-- /simple login form --> 
        
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