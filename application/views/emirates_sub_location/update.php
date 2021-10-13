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
			    $form_act = '';
				if(isset($args1) && $args1>0){
					$form_act = "emirates_sub_location/update/".$args1;
				} ?> 
                  <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">  
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="emirate_location_id">Emirate Location(s) <span class="reds">*</span></label>
                      <div class="col-md-6" id="fetch_emirate_location"> 
                      <select name="emirate_location_id" id="emirate_location_id" class="form-control select" data-error="#emirate_location_id1">
                         <option value="">Select Location Name</option>  
                        <?php  
                        if(isset($emirate_arrs) && count($emirate_arrs)>0){
                            foreach($emirate_arrs as $emirate_arr){ ?>
                             <optgroup label="<?= stripslashes($emirate_arr->name); ?>">
                                <?php 
                                $emrt_id = $emirate_arr->id;
                                $emirate_location_arrs=$this->general_model->get_emirate_locations_info_by_id($emrt_id);			
                                if(isset($emirate_location_arrs) && count($emirate_location_arrs)>0){
                                    foreach($emirate_location_arrs as $emirate_location_arr){
                                    
                                    $sel_1 = '';
                                    if(isset($_POST['emirate_location_id']) && $_POST['emirate_location_id']==$emirate_location_arr->id){
                                        $sel_1 = 'selected="selected"';
                                    }else if(isset($record) && $record->emirate_location_id==$emirate_location_arr->id){
                                        $sel_1 = 'selected="selected"';
                                    } ?>
                                        <option value="<?= $emirate_location_arr->id; ?>" <?php echo $sel_1; ?>> <?= stripslashes($emirate_location_arr->name); ?></option>
                                <?php 
                                    } 
                                } ?>	 
                                </optgroup>  		
                            <?php 
                                }
                            } ?> 
                            </select> 
                             <span id="emirate_location_id1" class="text-danger" generated="true"><?php echo form_error('emirate_location_id'); ?></span>  
                      </div> 
                    </div>
                    
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="name">Sub Location Name <span class="reds">*</span></label>
                      <div class="col-md-6">
                        <input name="name" id="name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->name): set_value('name'); ?>" data-error="#name1"> 
                        
                        <span id="name1" class="text-danger" generated="true"><?php echo form_error('name'); ?></span> 
                      </div> 
                    </div>   
                     
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="status">Status </label>
                      <div class="col-md-6">
                        <div class="checkbox">
                            <label for="status"> <input type="checkbox" name="status" id="status" value="1" <?php if((isset($_POST['status']) && $_POST['status']==1) || (isset($record) && $record->status==1)){ echo 'checked="checked"'; } ?> class="styled"> Active</label>
                        </div> 
                      </div> 
                    </div>   
                
            <div class="form-group">
              <label class="col-md-2 control-label"></label>
              <div class="col-md-6">

	  <?php if(isset($record)){	?>
              <input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>"> 
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="updates" id="updates"><i class="glyphicon glyphicon-ok position-left"></i>Update</button>   
      <?php } ?>
          &nbsp;
          <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('emirates_sub_location/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button> 
          
        </div> 
        </div>
      </form> 
		<script type="text/javascript"> 
        //jQuery.noConflict()(function($){ 
            $(document).ready(function(){ 
                var validator = $('#datas_form').validate({
                rules: { 
                    emirate_location_id: {
                        required: true 
                    },
                    name: {
                        required: true 
                    }
                },
                messages: {  
                    emirate_location_id: {
                        required: "This is required field"
                    },
                    name: {
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
        //}); 
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