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
       
    <!-- Password recovery -->
    <form name="datas_form" id="datas_form" action="<?php echo site_url('login/reset_password/'.$vs_id.'/'.$rand_numbs); ?>" method="post">
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
      <div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
      <h5 class="content-group">Reset your Account Password</h5>
    </div>
         
     <div class="form-group has-feedback has-feedback-left"> 
      <input name="new_password" id="new_password" type="password" class="form-control" value="<?php echo set_value('new_password'); ?>" placeholder="New Password" data-error="#new_password1"> 
      <div class="form-control-feedback"> <i class="icon-lock2 text-muted"></i> </div>
      <span id="new_password1" class="text-danger"><?php echo form_error('new_password'); ?></span> 
    </div> 
    
    <div class="form-group has-feedback has-feedback-left"> 
      <input name="conf_password" id="conf_password" type="password" class="form-control" value="<?php echo set_value('conf_password'); ?>" placeholder="Confirm Password" data-error="#conf_password1"> 
      <div class="form-control-feedback"> <i class="icon-lock2 text-muted"></i> </div>
      <span id="conf_password1" class="text-danger"><?php echo form_error('conf_password'); ?></span> 
    </div>  
  
    <button type="submit" name="submit_reset" id="submit_reset" class="btn bg-blue btn-block">Reset password <i class="icon-arrow-right14 position-right"></i></button>
    <br> 
    <div class="text-center"> <a href="<?php echo site_url('login/index'); ?>">Sign-In?</a> </div>
  </div>
  
</form>

	<script type="text/javascript">  
        $(document).ready(function(){ 
            var validator = $('#datas_form').validate({
            rules: {    
                new_password: {
                    required: true,
                    minlength:5
                },
                conf_password: {
                    required: true,
                    equalTo: "#new_password"
                } 
            },
            messages: {  
                new_password: {
                    required: "This is required field",
                    minlength: "Enter at-least 5 characters"
                },
                conf_password: {
                    required: "This is required field",
                    equalTo: "Confirm your Password!"
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
                
    <!-- /password recovery --> 
        
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
