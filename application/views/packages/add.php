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
              <label class="col-md-2 control-label" for="access_rights">Access Rights <span class="reds">*</span></label>
              <div class="col-md-6">
			 <?php  
				$sel_access_rights_data = '';
				$total_access_rights_nums = 0; 
				if(isset($_POST['access_rights_data']) && strlen($_POST['access_rights_data'])>0){ 
					$sel_access_rights_data = $_POST['access_rights_data'];
					/*
					foreach($_POST['access_rights_data'] as $access_rights_arrs){
						print_r( $access_rights_arrs );
					} */
					$total_access_rights_nums = count(explode(',',$sel_access_rights_data));     
				} ?>
				<button class="btn bg-teal change-to-ak-co" type="button" data-toggle="modal" data-target="#modal_remote_access_rights"><span class="badge bg-warning-400" id="fetch_access_rights_nums"><?php echo $total_access_rights_nums; ?></span> Assign / De-Assign Access Rights</button> 
									
					<input type="hidden" name="access_rights_data" id="access_rights_data" value="<?php //echo $sel_access_rights_data; ?>" /> 
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
			
			
			<input type="hidden" name="sale_properties" id="sale_properties" value="" /> 
			<input type="hidden" name="rental_properties" id="rental_properties" value="" /> 
			
			<input type="hidden" name="archived_properties" id="archived_properties" value="" /> 
			<input type="hidden" name="deleted_properties" id="deleted_properties" value="" /> 
			
			<input type="hidden" name="manage_leads" id="manage_leads" value="" /> 
			<input type="hidden" name="manage_contacts" id="manage_contacts" value="" /> 
			
			<input type="hidden" name="manage_owners" id="manage_owners" value="" /> 
			<input type="hidden" name="manage_tasks" id="manage_tasks" value="" /> 
			
			<input type="hidden" name="manage_users" id="manage_users" value="" /> 
			<input type="hidden" name="manage_reports" id="manage_reports" value="" />    
			      
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
		
		<div id="modal_remote_access_rights" class="modal" data-backdrop="false"> 
			<div class="modal-dialog modal-full">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h5 class="modal-title">Access Rights</h5>
					</div>
	
					<div class="modal-body"></div>
	
					<div class="modal-footer">
						<button id="close_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
					</div>
				</div>
			</div>
		</div>    
		
		
		<script type="text/javascript">   
			function operate_access_rights_datas(access_rights_arrs) { 
				//alert( sels_vals1 );
				$(document).ready(function(){
					var sale_properties_txt = '';
					var rental_properties_txt = '';
					
					var archived_properties_txt = '';
					var deleted_properties_txt = '';
					
					var manage_leads_txt = '';
					var manage_contacts_txt = '';
					
					var manage_owners_txt = '';
					var manage_tasks_txt = '';
					
					var manage_users_txt = '';
					var manage_reports_txt = ''; 
					
					for(var n =0; n < access_rights_arrs.length; n++){  
					
						if(access_rights_arrs[n].fieldName){
							if(access_rights_arrs[n].fieldName == "view_sale_properties"){
								sale_properties_txt += 'view,';
							}
	
							if(access_rights_arrs[n].fieldName == "add_sale_properties"){
								sale_properties_txt += 'add,';
							}
							
							if(access_rights_arrs[n].fieldName == "update_sale_properties"){
								sale_properties_txt += 'update,';
							}
							
							if(access_rights_arrs[n].fieldName == "delete_sale_properties"){
								sale_properties_txt += 'delete,';
							}
							
							
							if(access_rights_arrs[n].fieldName == "view_rental_properties"){
								rental_properties_txt += 'view,';
							}
	
							if(access_rights_arrs[n].fieldName == "add_rental_properties"){
								rental_properties_txt += 'add,';
							}
							
							if(access_rights_arrs[n].fieldName == "update_rental_properties"){
								rental_properties_txt += 'update,';
							}
							
							if(access_rights_arrs[n].fieldName == "delete_rental_properties"){
								rental_properties_txt += 'delete,';
							} 
							
							
							if(access_rights_arrs[n].fieldName == "view_archived_properties"){
								archived_properties_txt += 'view,';
							}
	
							if(access_rights_arrs[n].fieldName == "add_archived_properties"){
								archived_properties_txt += 'add,';
							}
							
							if(access_rights_arrs[n].fieldName == "update_archived_properties"){
								archived_properties_txt += 'update,';
							}
							
							if(access_rights_arrs[n].fieldName == "delete_archived_properties"){
								archived_properties_txt += 'delete,';
							}
							
							
							if(access_rights_arrs[n].fieldName == "view_deleted_properties"){
								deleted_properties_txt += 'view,';
							}
	
							if(access_rights_arrs[n].fieldName == "add_deleted_properties"){
								deleted_properties_txt += 'add,';
							}
							
							if(access_rights_arrs[n].fieldName == "update_deleted_properties"){
								deleted_properties_txt += 'update,';
							}
							
							if(access_rights_arrs[n].fieldName == "delete_deleted_properties"){
								deleted_properties_txt += 'delete,';
							}
							
							
							if(access_rights_arrs[n].fieldName == "view_lead"){
								manage_leads_txt += 'view,';
							}
	
							if(access_rights_arrs[n].fieldName == "add_lead"){
								manage_leads_txt += 'add,';
							}
							
							if(access_rights_arrs[n].fieldName == "update_lead"){
								manage_leads_txt += 'update,';
							}
							
							if(access_rights_arrs[n].fieldName == "delete_lead"){
								manage_leads_txt += 'delete,';
							} 
							
							
							if(access_rights_arrs[n].fieldName == "view_contact"){
								manage_contacts_txt += 'view,';
							}
	
							if(access_rights_arrs[n].fieldName == "add_contact"){
								manage_contacts_txt += 'add,';
							}
							
							if(access_rights_arrs[n].fieldName == "update_contact"){
								manage_contacts_txt += 'update,';
							}
							
							if(access_rights_arrs[n].fieldName == "delete_contact"){
								manage_contacts_txt += 'delete,';
							} 
							
							
							if(access_rights_arrs[n].fieldName == "view_owner"){
								manage_owners_txt += 'view,';
							}
	
							if(access_rights_arrs[n].fieldName == "add_owner"){
								manage_owners_txt += 'add,';
							}
							
							if(access_rights_arrs[n].fieldName == "update_owner"){
								manage_owners_txt += 'update,';
							}
							
							if(access_rights_arrs[n].fieldName == "delete_owner"){
								manage_owners_txt += 'delete,';
							}
							
							
							if(access_rights_arrs[n].fieldName == "view_task"){
								manage_tasks_txt += 'view,';
							}
	
							if(access_rights_arrs[n].fieldName == "add_task"){
								manage_tasks_txt += 'add,';
							}
							
							if(access_rights_arrs[n].fieldName == "update_task"){
								manage_tasks_txt += 'update,';
							}
							
							if(access_rights_arrs[n].fieldName == "delete_task"){
								manage_tasks_txt += 'delete,';
							}
							 
		  					
							if(access_rights_arrs[n].fieldName == "view_user"){
								manage_users_txt += 'view,';
							}
	
							if(access_rights_arrs[n].fieldName == "add_user"){
								manage_users_txt += 'add,';
							}
							
							if(access_rights_arrs[n].fieldName == "update_user"){
								manage_users_txt += 'update,';
							}
							
							if(access_rights_arrs[n].fieldName == "delete_user"){
								manage_users_txt += 'delete,';
							}
							
							
							if(access_rights_arrs[n].fieldName == "view_report"){
								manage_reports_txt += 'view,';
							}
		          
						}  
					}
					
					if(sale_properties_txt != ''){
						sale_properties_txt = sale_properties_txt.slice(0, -1);
					}
					
					if(rental_properties_txt != ''){
						rental_properties_txt = rental_properties_txt.slice(0, -1);
					}
					
					if(archived_properties_txt != ''){
						archived_properties_txt = archived_properties_txt.slice(0, -1);
					}
					
					if(deleted_properties_txt != ''){
						deleted_properties_txt = deleted_properties_txt.slice(0, -1);
					}
					
					if(manage_leads_txt != ''){
						manage_leads_txt = manage_leads_txt.slice(0, -1);
					}
					
					if(manage_contacts_txt != ''){
						manage_contacts_txt = manage_contacts_txt.slice(0, -1);
					}
					
					if(manage_owners_txt != ''){
						manage_owners_txt = manage_owners_txt.slice(0, -1);
					}
					
					if(manage_tasks_txt != ''){
						manage_tasks_txt = manage_tasks_txt.slice(0, -1);
					}
					
					if(manage_users_txt != ''){
						manage_users_txt = manage_users_txt.slice(0, -1);
					}
					
					if(manage_reports_txt != ''){
						manage_reports_txt = manage_reports_txt.slice(0, -1);
					}
					
					$("#sale_properties").val(sale_properties_txt);
					$("#rental_properties").val(rental_properties_txt);
					
					$("#archived_properties").val(archived_properties_txt);
					$("#deleted_properties").val(deleted_properties_txt);
					
					$("#manage_leads").val(manage_leads_txt);
					$("#manage_contacts").val(manage_contacts_txt);
					
					$("#manage_owners").val(manage_owners_txt);
					$("#manage_tasks").val(manage_tasks_txt);
					
					$("#manage_users").val(manage_users_txt);
					$("#manage_reports").val(manage_reports_txt);
					
					//archived_properties  deleted_properties   manage_leads manage_contacts  
					//manage_owners manage_tasks manage_users manage_reports
					
					//document.getElementById("access_rights_data").value = access_rights_arrs;   
					document.getElementById("fetch_access_rights_nums").innerHTML = access_rights_arrs.length;
					
				}); 
			}
			
			$(document).ready(function(){ 
			<?php
				$packages_access_rights_popup_url = 'packages/access_rights_popup_list/';
				$packages_access_rights_popup_url = site_url($packages_access_rights_popup_url); ?> 
				
				$('#modal_remote_access_rights').on('show.bs.modal', function() {
			
					//var access_rights_data_val = document.getElementById("access_rights_data").value; 
					
					var para_val = $("#sale_properties").val()+'__'+ $("#rental_properties").val()+'__'+ $("#archived_properties").val()+'__'+ $("#deleted_properties").val()+'__'+ $("#manage_leads").val()+'__'+ $("#manage_contacts").val()+'__'+ $("#manage_owners").val()+'__'+ $("#manage_tasks").val()+'__'+ $("#manage_users").val()+'__'+ $("#manage_reports").val(); 
					 	
				 
					var access_rights_data_url =  "<?php echo $packages_access_rights_popup_url; ?>"+para_val;
					var repls = "_";
					access_rights_data_url = access_rights_data_url.replace(/,/g,repls);
					   
					$(this).find('.modal-body').load(access_rights_data_url, function() {
			 
						/*$('.select').select2({
							minimumResultsForSearch: Infinity
						});*/
					});
				});  
			 
			 
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