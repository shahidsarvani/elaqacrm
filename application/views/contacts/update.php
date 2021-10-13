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
                <h5 class="panel-title">
                  <?= $page_headings; ?>
                  Form </h5>
              </div>
              <div class="panel-body">
                <?php 
			$form_act = '';
			if(isset($args1) && $args1>0){
				$form_act = "contacts/update/".$args1;
			} ?>
                <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal form-bordered">
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="name">Name <span class="reds">*</span></label>
                    <div class="col-md-6">
                      <input name="name" id="name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->name): set_value('name'); ?>" data-error="#name1">
                      <span id="name1" class="text-danger"><?php echo form_error('name'); ?></span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="email">Email <span class="reds">*</span></label>
                    <div class="col-md-6">
                      <input name="email" id="email" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->email): set_value('email'); ?>" data-error="#email1">
                      <span id="email1" class="text-danger"><?php echo form_error('email'); ?></span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="phone_no">Phone No </label>
                    <div class="col-md-6">
                      <input name="phone_no" id="phone_no" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->phone_no): set_value('phone_no'); ?>" data-error="#phone_no1">
                      <span id="phone_no1" class="text-danger"><?php echo form_error('phone_no'); ?></span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="mobile_no">Mobile No <span class="reds">*</span></label>
                    <div class="col-md-6">
                      <input name="mobile_no" id="mobile_no" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->mobile_no): set_value('mobile_no'); ?>" data-error="#mobile_no1">
                      <span id="mobile_no1" class="text-danger"><?php echo form_error('mobile_no'); ?></span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="company_name">Company Name </label>
                    <div class="col-md-6">
                      <input name="company_name" id="company_name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->company_name): set_value('company_name'); ?>" data-error="#company_name1">
                      <span id="company_name1" class="text-danger"><?php echo form_error('company_name'); ?></span> </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="address">Address <span class="reds"> *</span> </label>
                    <div class="col-md-6">
                      <textarea name="address" id="address" class="form-control" rows="5" data-error="#address1"><?php echo (isset($record)) ? stripslashes($record->address): set_value('address'); ?></textarea>
                      <span id="address1" class="text-danger"><?php echo form_error('address'); ?></span> </div>
                  </div>
                  <br>
                  <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-6">
                      <?php if(isset($record)){	?>
                      <input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>">
                      <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="updates" id="updates"><i class="glyphicon glyphicon-ok position-left"></i>Update</button>
                      <?php }	?>
                      &nbsp;
                      <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('contacts/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button>
                    </div>
                  </div>
                </form>
			  <script type="text/javascript">  
				$(document).ready(function(){ 
					var validator = $('#datas_form').validate({
					rules: {  
						name: {
							required: true 
						},
						email: {
							required: true,
							email:true 
						},
						mobile_no: {
							required: true 
						},
						address: {
							required: true 
						}  
					},
					messages: {
						name: {
							required: "This is required field"  
						},
						email: {
							required: "This is required field" ,
							email:"Please enter a vaild Email Address!"  
						},
						mobile_no: {
							required: "This is required field"  
						},
						address: {
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