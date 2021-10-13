<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/meta_tags'); ?>
</head>
<body> 
<!-- Main navbar -->
<?php $this->load->view('widgets/header'); ?>
<!-- /main navbar --> 

<!-- Page container -->
<div class="page-container"> 
  
  <!-- Page content -->
  <div class="page-content"> 
    
    <!-- Main sidebar -->
    <?php $this->load->view('widgets/left_sidebar'); ?>
    <!-- /main sidebar --> 
    
    <!-- Main content -->
    <div class="content-wrapper"> 
      
      <!-- Page header -->
      <?php $this->load->view('widgets/content_header'); ?>
      <!-- /page header --> 
      
      <!-- Content area -->
      <div class="content"> 
        <!-- Dashboard content -->
        <div class="row">
          <div class="col-lg-12">
            <?php if($this->session->flashdata('success_msg')){ ?>
            <div class="alert alert-success no-border">
              <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
              <?php echo $this->session->flashdata('success_msg'); ?> </div>
            <?php } 
			if($this->session->flashdata('error_msg')){ ?>
            <div class="alert alert-danger no-border">
              <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
              <?php echo $this->session->flashdata('error_msg'); ?> </div>
            <?php } ?>
            
            <!-- Horizontal form -->
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h5 class="panel-title"> <?= $page_headings; ?> Form </h5>
              </div>
              <div class="panel-body">
                 <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url('settings/change_password'); ?>" class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="old_password">Old Password</label>
                      <div class="col-md-6">
                        <input name="old_password" id="old_password" type="password" class="form-control" value="<?php echo set_value('old_password'); ?>" data-error="#old_password1">
                        <span id="old_password1" class="text-danger"> <?php echo form_error('old_password');
                        echo $this->session->flashdata('old_password'); ?></span> 
                      </div> 
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="new_password">New Password</label>
                      <div class="col-md-6">
                        <input name="new_password" id="new_password" type="password" class="form-control" value="<?php echo set_value('new_password'); ?>" data-error="#new_password1">
                         <span id="new_password1" class="text-danger"><?php echo form_error('new_password'); ?></span> 
                      </div> 
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="conf_password">Confirm Password</label>
                      <div class="col-md-6">
                        <input name="conf_password" id="conf_password" type="password" class="form-control" value="<?php echo set_value('conf_password'); ?>" data-error="#conf_password1">
                         <span id="conf_password1" class="text-danger"><?php echo form_error('conf_password'); ?></span> 
                      </div> 
                    </div> 
                      
                  <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-6">  
                    
                      <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="updates" id="updates"><i class="glyphicon glyphicon-ok position-left"></i>Change Password</button>
                       
                      <button type="reset" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('settings/change_password'); ?>';"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button>
                        
                    </div>
                  </div> 
                  </form> 
				  <script type="text/javascript">  
                    $(document).ready(function(){ 
                        var validator = $('#datas_form').validate({
                        rules: {    
                            old_password: {
                                required: true 
                            },  
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
                            old_password: {
                                required: "This is required field" 
                            },
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
        
        
              </div>
            </div>
            <!-- /horizotal form --> 
            
          </div>
        </div>
        <!-- /dashboard content --> 
        
        <!-- Footer -->
        <?php $this->load->view('widgets/footer'); ?>
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