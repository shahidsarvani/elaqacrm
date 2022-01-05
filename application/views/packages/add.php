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
       <?php $form_act = "packages/add"; ?>
        <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">
          <div class="form-group">
            <label class="col-md-2 control-label" for="name"> Name <span class="reds">*</span></label>
              <div class="col-md-6">
                <input name="name" id="name" type="text" class="form-control" value="<?php echo set_value('name'); ?>" data-error="#name1"> 
                <span id="name1" class="text-danger"><?php echo form_error('name'); ?></span>
              </div> 
            </div> 
			<div class="form-group">
            <label class="col-md-2 control-label" for="price"> Price (<?php echo $conf_currency_symbol; ?>) <span class="reds">*</span></label>
              <div class="col-md-6">
                <input name="price" id="price" type="text" class="form-control" value="<?php echo set_value('price'); ?>" data-error="#price1" onKeyUp="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" onBlur="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" /> 
                <span id="price1" class="text-danger"><?php echo form_error('price'); ?></span>
              </div> 
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label" for="sort_order">Sort Order <span class="reds">*</span></label>
              <div class="col-md-6">
              <?php 
                  if(isset($_POST['sort_order']) && strlen($_POST['sort_order'])>0){
                    $temp_sort_order = $_POST['sort_order']; 
                  }else{
                    $temp_sort_order = $max_sort_val+1;
                  } ?>
                  <input name="sort_order" id="sort_order" type="text" class="form-control" value="<?php echo $temp_sort_order; ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" data-error="#sort_order1"> 
                <span id="sort_order1" class="text-danger"><?php echo form_error('sort_order'); ?></span> 
              </div> 
            </div>
			<script>
				function operate_package_type(vals){
					if(vals == 1){
						document.getElementById("fetch_duration_title").innerHTML = "(No. of Days) ";
					}else if(vals == 2){
						document.getElementById("fetch_duration_title").innerHTML = "(No. of Months) ";
					}else if(vals == 3){
						document.getElementById("fetch_duration_title").innerHTML = "(No. of Years) ";
					} 
				} 
			</script>
			
			<div class="form-group">
            <label class="col-md-2 control-label" for="package_type"> Package Type <span class="reds">*</span></label>
              <div class="col-md-6">
			  	<select name="package_type" id="package_type" class="form-control select2" data-error="#package_type1" onChange="operate_package_type(this.value);">
					<option value=""> Select Package Type </option>
					<option value="1" <?php echo (isset($_POST['package_type']) && $_POST['package_type']==1) ? 'selected="selected"' : ''; ?>> Day(s) </option>
					<option value="2" <?php echo (isset($_POST['package_type']) && $_POST['package_type']==2) ? 'selected="selected"' : ''; ?>> Month(s) </option>
					<option value="3" <?php echo (isset($_POST['package_type']) && $_POST['package_type']==3) ? 'selected="selected"' : ''; ?>> Year(s) </option>
				</select> 
                <span id="price1" class="text-danger"><?php echo form_error('price'); ?></span>
              </div> 
            </div>
		
			<div class="form-group">
            <label class="col-md-2 control-label" for="duration"> Duration <span id="fetch_duration_title"> </span> <span class="reds">*</span></label>
              <div class="col-md-6">
                <input name="duration" id="duration" type="text" class="form-control" value="<?php echo set_value('duration'); ?>" data-error="#duration1"> 
                <span id="duration1" class="text-danger"><?php echo form_error('duration'); ?></span>
              </div> 
            </div> 
			
			<div class="form-group">
              <label class="col-md-2 control-label" for="total_properties_nums">Total Properties Nos. <span class="reds">*</span></label>
              <div class="col-md-6"> 
                  <input name="total_properties_nums" id="total_properties_nums" type="text" class="form-control" value="<?php echo set_value('total_properties_nums'); ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" data-error="#total_properties_nums1"> 
                <span id="total_properties_nums1" class="text-danger"><?php echo form_error('total_properties_nums'); ?></span> 
              </div> 
            </div>
			
			<div class="form-group">
              <label class="col-md-2 control-label" for="total_contacts_nums">Total Contact Nos. <span class="reds">*</span></label>
              <div class="col-md-6"> 
                  <input name="total_contacts_nums" id="total_contacts_nums" type="text" class="form-control" value="<?php echo set_value('total_contacts_nums'); ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" data-error="#total_contacts_nums1"> 
                <span id="total_contacts_nums1" class="text-danger"><?php echo form_error('total_contacts_nums'); ?></span> 
              </div> 
            </div>
			
			<div class="form-group">
              <label class="col-md-2 control-label" for="total_owners_nums">Total Owners Nos. <span class="reds">*</span></label>
              <div class="col-md-6"> 
                  <input name="total_owners_nums" id="total_owners_nums" type="text" class="form-control" value="<?php echo set_value('total_owners_nums'); ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" data-error="#total_owners_nums1"> 
                <span id="total_owners_nums1" class="text-danger"><?php echo form_error('total_owners_nums'); ?></span> 
              </div> 
            </div>
			
			<div class="form-group">
              <label class="col-md-2 control-label" for="total_tasks_nums">Total Tasks Nos. <span class="reds">*</span></label>
              <div class="col-md-6"> 
                  <input name="total_tasks_nums" id="total_tasks_nums" type="text" class="form-control" value="<?php echo set_value('total_tasks_nums'); ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" data-error="#total_tasks_nums1"> 
                <span id="total_tasks_nums1" class="text-danger"><?php echo form_error('total_tasks_nums'); ?></span> 
              </div> 
            </div>
			
			
            <div class="form-group">
              <label class="col-md-2 control-label" for="description">Description <span class="reds">*</span></label>
              <div class="col-md-10">
              <textarea name="description" id="description" class="form-control" rows="10" style="width:90%; height:450px;" data-error="#description1"><?php echo set_value('description'); ?></textarea>   
                <span id="description1" class="text-danger"><?php echo form_error('description'); ?></span>
              </div> 
            </div>    
            <div class="form-group">
              <label class="col-md-2 control-label" for="status">Status </label>
              <div class="col-md-6">
                <div class="checkbox">
                    <label for="status"> <input type="checkbox" name="status" id="status" value="1" <?php if(isset($_POST['status']) && $_POST['status']==1){ echo 'checked="checked"'; } ?> class="styled"> Active</label>
                </div> 
              </div> 
            </div>      
			      
			  <div class="form-group">
				<label class="col-md-2 control-label"></label>
				<div class="col-md-6"> 
					<button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves" id="saves"><i class="glyphicon glyphicon-ok position-left"></i>Save</button> &nbsp; 
					<button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves_and_new" id="save_and_new"><i class="glyphicon glyphicon-repeat position-left"></i>Save & New</button> &nbsp; 
					<button type="reset" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button> &nbsp; 
					<button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('packages/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button>  
				</div>
			  </div>
			</form> 
			<script type="text/javascript">  
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
						total_properties_nums: {
							required: true 
						}, 
						total_contacts_nums: {
							required: true 
						},
						total_owners_nums: {
							required: true 
						},
						total_tasks_nums: {
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
						total_properties_nums: {
							required: "This is required field" 
						}, 
						total_contacts_nums: {
							required: "This is required field" 
						},
						total_owners_nums: {
							required: "This is required field" 
						},
						total_tasks_nums: {
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