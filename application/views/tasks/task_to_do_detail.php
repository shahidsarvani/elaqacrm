<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/meta_tags'); ?>
<!--<link rel="stylesheet" href="<?= asset_url();?>stylesheets/jquery-ui.css">
<script src="<?= asset_url();?>javascripts/jquery-ui.js"></script> -->
</head>
<body class="sidebar-xs pace-done">

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
				<div class="form-group">
				  <label class="col-md-3 control-label" for="property_ref"> Property Ref No.  </label>
				  <div class="col-md-8">
					 <?php echo stripslashes($record->property_ref); ?>
				  </div> 
				</div>		
				<div class="form-group">
				  <label class="col-md-3 control-label" for="lead_ref"> Lead Ref No.  </label>
				  <div class="col-md-8">
					 <?php echo stripslashes($record->lead_ref); ?>
				  </div> 
				</div>
				
				<div class="form-group">
				  <label class="col-md-3 control-label" for="title"> Task Detail </label>
				  <div class="col-md-8">
					<?php echo stripslashes($record->title); ?> 
				  </div> 
				</div>  
				<div class="form-group">
				  <label class="col-md-3 control-label" for="assigned_to">Assigned To </label>
				  <div class="col-md-8">
					<?php  
					$assigned_to_nm ='';
					if($record->assigned_to >0){
						$temp_usr_arr = $this->general_model->get_user_info_by_id($record->assigned_to);
						if(isset($temp_usr_arr)){
							$assigned_to_nm = stripslashes($temp_usr_arr->name); 
						}
					}
					echo $assigned_to_nm;  ?> 
				  </div> 
				</div>	
				
				<div class="form-group">
				  <label class="col-md-3 control-label" for="due_date">Due Date </label>
				  <div class="col-md-8">
					<?php echo date('d-M-Y',strtotime($record->due_date)); ?>  
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-3 control-label" for="due_timing">Due Timing </label>
					<div class="col-md-8"> 
					<?php echo stripslashes($record->due_timing); ?>  
					</div>
				</div>
				  
				<div class="form-group">
				  <label class="col-md-3 control-label" for="created_on">Task Added </label>
					<div class="col-md-8"> 
					<?= date('d-M-Y',strtotime($record->created_on)); ?> 
					</div>
				</div> 
						
				<div class="form-group">
				  <label class="col-md-3 control-label" for="status">  Status </label>
				  <div class="col-md-8">
				   <?php
						if(isset($record) && $record->status==0){ 
							echo '<span class="badge label-info"> Pending </span>';
						} 
						if(isset($record) && $record->status==1){ 
							echo '<span class="badge label-success"> Completed </span>';
						}
						if(isset($record) && $record->status==2){
							echo '<span class="badge label-primary"> In Progress </span>';
						}
						if(isset($record) && $record->status==3){
							echo '<span class="badge label-warning"> Rejected </span>';
						} 
						if(isset($record) && $record->status==4){
							echo '<span class="badge label-danger"> Over Due </span>';
						} ?>   
				  </div> 
				</div>  
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