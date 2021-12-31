<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/meta_tags'); ?> 
<script type="text/javascript" src="<?= asset_url(); ?>js/plugins/editors/summernote/summernote.min.js"></script> 
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
            $form_act = "packages/update/".$args1;
        } ?>
        <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">
          <div class="form-group">
            <label class="col-md-2 control-label" for="name"> Name <span class="reds">*</span></label>
              <div class="col-md-6">
                <input name="name" id="name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->name): set_value('name'); ?>" data-error="#name1"> 
                <span id="name1" class="text-danger"><?php echo form_error('name'); ?></span>
              </div> 
            </div> 
		  <div class="form-group">
            <label class="col-md-2 control-label" for="price"> Price <span class="reds">*</span></label>
              <div class="col-md-6">
                <input name="price" id="price" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->price): set_value('price'); ?>" data-error="#price1"> 
                <span id="price1" class="text-danger"><?php echo form_error('price'); ?></span>
              </div> 
            </div> 
		 <div class="form-group">
		  <label class="col-md-2 control-label" for="sort_order">Sort Order <span class="reds">*</span></label>
		  <div class="col-md-6">
		  <?php 
			  if(isset($_POST['sort_order']) && strlen($_POST['sort_order'])>0){
				$temp_sort_order = $_POST['sort_order']; 
			  }else if(isset($record) && strlen($record->sort_order)>0){
				$temp_sort_order = $record->sort_order;  
			  }else{
				$temp_sort_order = $max_sort_val+1;
			  } ?>
			  <input name="sort_order" id="sort_order" type="text" class="form-control" value="<?php echo $temp_sort_order; ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" data-error="#sort_order1"> 
			<span id="sort_order1" class="text-danger"><?php echo form_error('sort_order'); ?></span> 
		  </div> 
		</div>  
		
		<div class="form-group">
		<label class="col-md-2 control-label" for="package_type"> Package Type <span class="reds">*</span></label>
		  <div class="col-md-6">
			<select name="package_type" id="package_type" class="form-control" data-error="#package_type1" onChange="operate_package_type(this.value);">
				<option value=""> Select Package Type </option>
				<option value="1" <?php echo ((isset($_POST['package_type']) && $_POST['package_type']==1) || (isset($record) && $record->package_type==1)) ? 'selected="selected"' : ''; ?>> Daily </option>
				<option value="2" <?php echo ((isset($_POST['package_type']) && $_POST['package_type']==2) || (isset($record) && $record->package_type==2)) ? 'selected="selected"' : ''; ?>> Monthly </option>
				<option value="3" <?php echo ((isset($_POST['package_type']) && $_POST['package_type']==3) || (isset($record) && $record->package_type==3)) ? 'selected="selected"' : ''; ?>> Yearly </option>
			</select> 
			<span id="price1" class="text-danger"><?php echo form_error('price'); ?></span>
		  </div> 
		</div>
			
		<div class="form-group"> 
		<label class="col-md-2 control-label" for="duration"> Duration <span id="fetch_duration_title"> </span> <span class="reds">*</span></label>
		  <div class="col-md-6">
			<input name="duration" id="duration" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->duration): set_value('duration'); ?>" data-error="#duration1"> 
			<span id="duration1" class="text-danger"><?php echo form_error('duration'); ?></span>
		  </div> 
		</div>
            <div class="form-group">
              <label class="col-md-2 control-label" for="description">Description <span class="reds">*</span></label>
              <div class="col-md-10">
              <textarea name="description" id="description" class="form-control" rows="10" style="width:90%; height:450px;" data-error="#description1"><?php echo (isset($record)) ? stripslashes($record->description): set_value('description'); ?></textarea>   
                <span id="description1" class="text-danger"><?php echo form_error('description'); ?></span>
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
				  <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('packages/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button> 
				  
				</div>
			  </div>
			</form> 
			
<script>
	operate_package_type('<?php echo $record->package_type; ?>');
	
	function operate_package_type(vals){
		if(vals == 1){
			document.getElementById("fetch_duration_title").innerHTML = "(No. of Days) ";
		}else if(vals == 2){
			document.getElementById("fetch_duration_title").innerHTML = "(No. of Months) ";
		}else if(vals == 3){
			document.getElementById("fetch_duration_title").innerHTML = "(No. of Years) ";
		} 
	}
	
	$(document).ready(function(){   
		$('#description').summernote();   		
				
		var validator = $('#datas_form').validate({
			rules: {
				name: {
					required: true 
				},
				price: {
					required: true 
				}, 
				sort_order: {
					required: true 
				},
				package_type: {
					required: true 
				},
				duration: {
					required: true 
				},
				description: {
					required: true 
				} 
			},
			messages: { 
				name: {
					required: "This is required field"
				},
				price: {
					required: "This is required field"
				}, 
				sort_order: {
					required: "This is required field"
				},
				package_type: {
					required: "This is required field" 
				},
				duration: {
					required: "This is required field" 
				},
				description: {
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