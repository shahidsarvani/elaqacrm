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
			 <?php 
				if(isset($args1) && $args1>0){
					$form_act = "agent/operate_meetings_views/".$args1;
				}else{
					$form_act = "agent/operate_meetings_views";
				} ?> 
			  <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal form-bordered">
				<div class="form-group"> 
				  <label class="col-md-2 control-label" for="nos_of_meetings">No. of Meetings <span class="reds">*</span></label>
				  <div class="col-md-6">
					<input name="nos_of_meetings" id="nos_of_meetings" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->nos_of_meetings): set_value('nos_of_meetings'); ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')">
					<span class="text-danger"><?php echo form_error('nos_of_meetings'); ?></span> 
				  </div> 
				</div>  
				<div class="form-group"> 
				  <label class="col-md-2 control-label" for="nos_of_views">No. of Views <span class="reds">*</span></label>
				  <div class="col-md-6">
					<input name="nos_of_views" id="nos_of_views" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->nos_of_views): set_value('nos_of_views'); ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')">
					<span class="text-danger"><?php echo form_error('nos_of_views'); ?></span> 
				  </div> 
				</div>
				<div class="form-group">
				  <label class="col-md-2 control-label"></label>  
				  <div class="col-md-6">
				  <?php if(isset($record)){	?>
						<input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>">
						<button type="submit" name="updates" id="updates" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-ok position-left"></i> Update </button>    
				  <?php }else{	?>
						<button type="submit" name="adds" id="adds" class="btn border-slate text-slate-800 btn-flat"> <i class="glyphicon glyphicon-ok position-left"></i> Add </button> &nbsp; <button type="reset" class="btn border-slate text-slate-800 btn-flat"> <i class="glyphicon glyphicon-refresh position-left"></i> Clear </button>   
				  <?php }	?>
				 <!-- &nbsp; <button type="button" class="btn btn-default" onClick="window.location='<?php //echo site_url('agent/operate_meetings_views'); ?>';">Cancel</button> -->  
					
				  </div>
				</div>
			  </form>
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