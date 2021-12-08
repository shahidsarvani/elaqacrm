<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/meta_tags'); ?>
<!-- Theme JS files -->
<script type="text/javascript" src="<?= asset_url(); ?>js/plugins/ui/prism.min.js"></script>
<script type="text/javascript" src="<?= asset_url(); ?>js/pages/sidebar_dual.js"></script>
<script src="<?= asset_url();?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- /theme JS files -->
<?php 
$view_res_nums =  $this->general_model->check_controller_method_permission_access('Leads','view',$this->dbs_role_id,'1'); 
 
$add_res_nums =  $this->general_model->check_controller_method_permission_access('Leads','add',$this->dbs_role_id,'1'); 	
		
$update_res_nums =  $this->general_model->check_controller_method_permission_access('Leads','update',$this->dbs_role_id,'1');   

$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Leads','trash',$this->dbs_role_id,'1');

if($add_res_nums>0 && $trash_res_nums>0){ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_add_del.js"></script>
<?php 
}else if($add_res_nums>0){ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_add.js"></script>
<?php  
}else if($trash_res_nums>0){ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_del.js"></script>
<?php 
}else{ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom.js"></script>
<?php 
} ?>
<script>
	function operate_leads_properties(){ 	 	  
		$(document).ready(function(){  
			  
			var refer_no = $("#refer_no").val(); 
			var price = $("#price").val(); 
			var to_price = $("#to_price").val();
						 
		 	var inquiry_from_date = $("#inquiry_from_date").val(); 
			var inquiry_to_date = $("#inquiry_to_date").val(); 
			 
			var sel_per_page_val = $("#per_page option:selected").val(); 
				
			var sel_leads_type_val = $("#lead_type option:selected").val(); 
				 
			var sel_leads_status_val = $("#lead_status option:selected").val();
			 
			var sel_prioritys_val = $("#priority option:selected").val();
			 
			var selMulti = $.map($("#contact_ids option:selected"), function(el, i){ return $(el).val(); }); 
			var sel_contact_id_val = selMulti.join(",");
			
			var selMulti = $.map($("#category_ids option:selected"), function(el, i){ return $(el).val(); }); 
			var category_id = selMulti.join(",");
			  
			var selMulti = $.map($("#assigned_to_ids option:selected"), function(el, i){ return $(el).val(); }); 
			var sel_assigned_to_id_val = selMulti.join(",");
						 
			var selMulti = $.map($("#emirate_location_ids option:selected"), function(el, i){ return $(el).val(); }); 
			var sel_emirate_location_id_val = selMulti.join(",");

			
			var selMulti = $.map($("#no_of_beds_ids option:selected"), function (el, i) { return $(el).val(); }); 
			var sel_no_of_beds_id_val = selMulti.join(",");       
				
			$.ajax({ 
				method: "POST",
				url: "<?php echo site_url('/leads/index2/'); ?>",
				data: { page: 0, sel_per_page_val:sel_per_page_val, refer_no: refer_no, leads_type_val: sel_leads_type_val, leads_status_val: sel_leads_status_val, prioritys_val: sel_prioritys_val, contact_id_val: sel_contact_id_val, assigned_to_id_val: sel_assigned_to_id_val, sel_emirate_location_id_val: sel_emirate_location_id_val, price: price, to_price: to_price, sel_no_of_beds_id_val: sel_no_of_beds_id_val,category_id: category_id,inquiry_from_date: inquiry_from_date, inquiry_to_date: inquiry_to_date },
				beforeSend: function(){
					$('.loading').show();    
				},
				success: function(data){
					$('.loading').hide();
					$('#dyns_list').html(data);
					
					/*$( '[data-toggle=popover]' ).popover();
					
					$('.simple-ajax-modal').magnificPopup({
						type: 'ajax',
						modal: true
					});*/
				}
			});
		}); 
	}
</script>
<script type="text/javascript" src="<?= asset_url(); ?>js/custom_multiselect.js"></script>

<script>  	  
	$(document).ready(function(){   
		$('#inquiry_from_date').datepicker({
			format: "yyyy-mm-dd"
			}).on('change', function(){
				$('.datepicker').hide();
				operate_leads_properties();
		}); 
		
		$('#inquiry_to_date').datepicker({
			format: "yyyy-mm-dd"
			}).on('change', function(){
				$('.datepicker').hide();
				operate_leads_properties();
		});
	});	    
	</script>
		
<style>
.cstms_badges .badge-primary{
	margin-bottom:1px;
}
</style>
</head>
<body class="sidebar-xs has-detached-left">
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
        <form name="datas_form" id="datas_form" action="" method="post">
          <!-- Detached sidebar -->
          <div class="sidebar-detached">
            <div class="sidebar sidebar-default">
              <div class="sidebar-content"> 
                <!-- Filter -->
                <div class="sidebar-category">
                  <div class="category-title"> <span>Search</span>
                    <ul class="icons-list">
                      <li><a onClick="window.location='<?= site_url('leads/index'); ?>';" data-action="reload"></a></li>
                      <li><a href="#" data-action="collapse"></a></li>
                    </ul>
                  </div>
			  <div class="category-content">
				<div class="form-group">
				  <div class="row">
					<div class="col-xs-12">   
					  <input name="refer_no" id="refer_no" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('refer_no'); ?>" placeholder="Ref No ..." onKeyUp="operate_leads_properties();">
					</div>
				  </div>
				</div>
				
				<div class="form-group">
				  <div class="row">
					<div class="col-xs-12">
						<select name="lead_type" id="lead_type" data-plugin-selectTwo class="form-control input-sm mb-md select2" onChange="operate_leads_properties();">  
							<option value="">Select Lead Type</option>
							<option value="Tenant" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Tenant'){ echo 'selected="selected"'; } ?>> Tenant </option> 
							
							<option value="Buyer" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Buyer'){ echo 'selected="selected"'; } ?>> Buyer </option> 
							
							<option value="Landlord" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Landlord'){ echo 'selected="selected"'; } ?>> Landlord </option> 
							
							<option value="Seller" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Seller'){ echo 'selected="selected"'; } ?>> Seller </option> 
							
							<option value="Landlord+Seller" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Landlord+Seller'){ echo 'selected="selected"'; } ?>> Landlord+Seller </option>  
							<option value="Not Specified" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Not Specified'){ echo 'selected="selected"'; } ?>> Not Specified </option>  
						</select>
						</div>
					  </div>
					</div> 					
					
					<div class="form-group">
					  <div class="row">
						<div class="col-xs-12">
						 <select name="lead_status" id="lead_status" class="form-control input-sm mb-md select2" onChange="operate_leads_properties();">
							<option value=""> Select Lead Status </option>
							<option value="Closed" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Closed'){ echo 'selected="selected"'; } ?>> Closed </option> 
							
							<option value="Not yet contacted" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Not yet contacted'){ echo 'selected="selected"'; } ?>> Not yet contacted </option> 
							
							<option value="Called no reply" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Called no reply'){ echo 'selected="selected"'; } ?>> Called no reply </option> 
							
							<option value="Client not reachable" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Client not reachable'){ echo 'selected="selected"'; } ?>> Client not reachable </option> 
							
							<option value="Follow up" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Follow up'){ echo 'selected="selected"'; } ?>> Follow up </option> 
							
							<option value="Viewing arranged" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Viewing arranged'){ echo 'selected="selected"'; } ?>> Viewing arranged </option> 
							<option value="Searching for options" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Searching for options'){ echo 'selected="selected"'; } ?>> Searching for options </option> 
							
							<option value="Offer made" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Offer made'){ echo 'selected="selected"'; } ?>> Offer made </option> 
							
							<option value="Incorrect contact details" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Incorrect contact details') || (isset($record) && $record->lead_status=='Incorrect contact details')){ echo 'selected="selected"'; } ?>> Incorrect contact details </option>
							
							<option value="Invalid inquiry" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Invalid inquiry'){ echo 'selected="selected"'; } ?>> Invalid inquiry </option> 
							
							<option value="Unsuccessful" <?php if(isset($_POST['lead_status']) && $_POST['lead_status']=='Unsuccessful'){ echo 'selected="selected"'; } ?>> Unsuccessful </option>
							</select>
						</div>
					  </div>
					</div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-xs-12">
						 <select name="priority" id="priority" data-plugin-selectTwo class="form-control input-sm mb-md select2" onChange="operate_leads_properties();">
						  <option value=""> Select Priority </option>
						  <option value="Urgent" <?php if(isset($_POST['priority']) && $_POST['priority']=='Urgent'){ echo 'selected="selected"'; } ?>> Urgent </option> 
						  <option value="High" <?php if(isset($_POST['priority']) && $_POST['priority']=='High'){ echo 'selected="selected"'; } ?>> High </option> 
						  <option value="Low" <?php if(isset($_POST['priority']) && $_POST['priority']=='Low'){ echo 'selected="selected"'; } ?>> Low </option> 
						  <option value="Normal" <?php if(isset($_POST['priority']) && $_POST['priority']=='Normal'){ echo 'selected="selected"'; } ?>> Normal </option>
						 </select>
						</div>
					  </div>
					</div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-xs-12">
						<select name="contact_ids" id="contact_ids" class="form-control input-sm mb-md populate multiselect-cstm" multiple="multiple" data-placeholder="Select Contacts" onChange="operate_leads_properties();"> 
						  <?php  
							if(isset($contact_arrs) && count($contact_arrs)>0){
								foreach($contact_arrs as $contact_arr){ ?>
									<option value="<?= $contact_arr->id; ?>" <?php echo (isset($_POST['contact_ids']) && $_POST['contact_ids']==$contact_arr->id) ? 'selected="selected"':''; ?>> <?= stripslashes($contact_arr->name).' ( '.stripslashes($contact_arr->email).' - '.stripslashes($contact_arr->phone_no).' )'; ?> </option>
						  	<?php 
								}
							} ?>
						</select>
						</div>
					  </div>
					</div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-xs-12">
						<select name="emirate_location_ids" id="emirate_location_ids" class="form-control input-sm mb-md populate multiselect-cstm" multiple="multiple" data-placeholder="Select Emirate Location" onChange="operate_leads_properties();"> 
						<?php  	
							$emirate_sub_location_arrs = $this->admin_model->get_all_emirate_sub_locations(); 
							if(isset($emirate_sub_location_arrs) && count($emirate_sub_location_arrs)>0){
								foreach($emirate_sub_location_arrs as $emirate_sub_location_arr){
								
								$sel_1 = '';
								if(isset($_POST['emirate_location_id']) && $_POST['emirate_location_id']==$emirate_sub_location_arr->id){
									$sel_1 = 'selected="selected"';
								} ?>
									<option value="<?= $emirate_sub_location_arr->id; ?>" <?php echo $sel_1; ?>> <?= stripslashes($emirate_sub_location_arr->name); ?></option>
							<?php 
								} 
							} ?>       
							</select> 
						</div>
					  </div>
					</div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-xs-12">
							<select name="category_ids" id="category_ids" class="form-control input-sm mb-md populate multiselect-cstm" multiple="multiple" data-placeholder="Select Categories" onChange="operate_leads_properties();"> 
							  <?php  
								$cates_arrs = $this->admin_model->get_all_categories();
								if(isset($cates_arrs) && count($cates_arrs)>0){
									foreach($cates_arrs as $cates_arr){
									$sel_1 = '';
									if(isset($_POST['category_ids']) && $_POST['category_ids']==$cates_arr->id){
										$sel_1 = 'selected="selected"';
									} ?>
								   <option value="<?= $cates_arr->id; ?>" <?php echo $sel_1; ?>>
								 	 <?= stripslashes($cates_arr->name); ?>
								   </option>
								  <?php 
									}
								} ?>
							</select> 
						</div>
					  </div>
					</div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-xs-12">
							<select name="no_of_beds_ids" id="no_of_beds_ids" class="form-control input-sm mb-md populate multiselect-cstm" multiple="multiple" data-placeholder="Select Number of Beds" onChange="operate_leads_properties();">
							  <?php  
								if(isset($beds_arrs) && count($beds_arrs)>0){
									foreach($beds_arrs as $beds_arr){
									$sel_1 = '';
									if(isset($_POST['no_of_beds_id']) && $_POST['no_of_beds_id']==$beds_arr->id){
										$sel_1 = 'selected="selected"';
									} ?>
							  <option value="<?= $beds_arr->id; ?>" <?php echo $sel_1; ?>>
							  <?= stripslashes($beds_arr->title); ?>
							  </option>
							  <?php 
									}
								} ?>
							</select>
						</div>
					  </div>
					</div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-xs-12">
							 <input name="price" id="price" type="text" class="form-control input-sm" value="<?php echo set_value('price'); ?>" placeholder="From Price" onKeyUp="operate_leads_properties();"> - <input name="to_price" id="to_price" type="text" class="form-control input-sm" value="<?php echo set_value('to_price'); ?>" placeholder="To Price" onKeyUp="operate_leads_properties();">
						</div>
					  </div>
					</div> 
					
					<div class="form-group">
					  <div class="row">
						<div class="col-xs-12">
							<input name="inquiry_from_date" id="inquiry_from_date" type="text" class="form-control input-sm" value="<?php echo set_value('inquiry_from_date'); ?>" placeholder="From Date" style="text-align:center;"> -
						    <input name="inquiry_to_date" id="inquiry_to_date" type="text" class="form-control input-sm" value="<?php echo set_value('inquiry_to_date'); ?>" placeholder="To Date"  style="text-align:center;"> 
						</div>
					  </div>
					</div>
					<?php if($this->login_vs_user_role_id==1 || $this->login_vs_user_role_id==2){ ?> 
						<div class="form-group">
						  <div class="row">
							<div class="col-xs-12"> 
							  <select name="assigned_to_ids" id="assigned_to_ids" class="form-control input-sm mb-md populate multiselect-cstm" multiple="multiple" data-placeholder="Select Assigned to" onChange="operate_leads_properties();">
							  <?php  
								if(isset($user_arrs) && count($user_arrs)>0){
									foreach($user_arrs as $user_arr){ ?>
										<option value="<?= $user_arr->id; ?>" <?php echo (isset($_POST['assigned_to_id']) && $_POST['assigned_to_id']==$user_arr->id) ? 'selected="selected"':''; ?>>
										<?= stripslashes($user_arr->name); ?>
							  </option>
							  <?php 
									}
								} ?>
							</select>    
			 
							</div>
						  </div>
						</div>
					<?php } ?> 
					 
                  </div>
                </div>
                <!-- /filter --> 
              </div>
            </div>
          </div>
          <!-- /detached sidebar -->
        </form>
        <!-- Detached content -->
        <div class="container-detached">
          <div class="content-detached">
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
            <!-- Sidebars overview -->
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h5 class="panel-title"> <?php echo $page_headings; ?> </h5>
                <div class="heading-elements"> </div>
              </div>
              <input type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('leads/add'); ?>">
              <input type="hidden" name="cstm_frm_name" id="cstm_frm_name" value="datas_list_forms">
              <form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('leads/trash_multiple'); ?>" method="post">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group mb-md">
                        <div class="col-md-2">
                          <div class="col-md-9">
                            <select name="per_page" id="per_page" class="form-control input-sm mb-md select2" onChange="operate_leads_properties();">
                              <option value="25"> Pages</option>
                              <option value="25"> 25 </option>
                              <option value="50"> 50 </option>
                              <option value="100"> 100 </option>
                            </select>
                          </div>
                          <div class="col-md-3"> </div>
                        </div>
                        <div class="col-md-3"> </div>
                        <div class="col-md-5 pull-right">
                          <div class="dt-buttons">
						  <?php   
							if($this->login_vs_user_role_id==1){ ?> <a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" href="<?= site_url('leads/index/export_excel'); ?>"> <span><i class="glyphicon glyphicon-file position-left"></i> Export Data</span></a>  
						<?php }  
							if($trash_res_nums>0){ ?>
                           	 <a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="javascript:void(0);" onClick="return operate_multi_deletions('datas_list_forms');"> <span><i class="glyphicon glyphicon-remove-circle position-left"></i>Delete</span></a>
                            <?php } if($add_res_nums>0){ ?>
                            <a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="<?= site_url('leads/operate_lead'); ?>"><span><i class="glyphicon glyphicon-plus position-left"></i>New</span></a>
                            <?php }
						
						if($add_res_nums==0 && $trash_res_nums==0){  ?>
                            <a style="visibility:hidden;" class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1"><span><i class="glyphicon glyphicon-plus position-left"></i></span></a>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <style>
					 #datatable-default_filter{
						display:none !important;
					 }
				 </style>
                  <script type="text/javascript"> 
					function view_lead(paras1){  
						if(paras1>0){			
							$(document).ready(function(){    
							<?php
								$prpty_dtl_popup_url = 'leads/property_detail/';
								$prpty_dtl_popup_url = site_url($prpty_dtl_popup_url); ?> 
								
								var cstm_urls = "<?php echo $prpty_dtl_popup_url; ?>"+paras1;
								
								$('#modal_remote_property_detail').on('show.bs.modal', function() {
									$(this).find('.modal-body').load(cstm_urls, function() {
							 
										$('.select').select2({
											minimumResultsForSearch: Infinity
										});
									});
								});   
							});    
						} 
					}  
				 </script>
                  <div id="modal_remote_property_detail" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog modal-full">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h5 class="modal-title">Lead Detail</h5>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                          <button id="close_users_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
			  <div class="table-responsive">
				<table class="table table-bordered table-striped table-hover"> 
				  <thead>
					  <tr>
						<th width="6%">#</th> 
						<th width="8%">Ref No </th>
						<th width="9%">Lead Type </th>
						<th width="8%">Status </th>
						<th width="8%">Priority </th>
						<th width="10%">Contact(s) </th> 
						<th width="10%">Sub Location</th>
						<th width="8%">Category</th>
						<th width="8%">Bedrooms</th>
						<th width="8%">Budget</th>
						<th width="8%">Inquiry Date </th>
						<th width="10%">Agent</th>
						<th width="10%">Updated </th>
						<th width="9%" class="text-center">Action</th>
					  </tr>
					</thead>
					<tbody id="dyns_list">
					<?php  
						if($view_res_nums == 1){ 
							$sr=1; 
							if(isset($records) && count($records)>0){
								foreach($records as $record){ 
									$details_url = 'leads/lead_detail/'.$record->id;
									$details_url = site_url($details_url); 
									
									$operate_url = 'leads/operate_lead/'.$record->id;
									$operate_url = site_url($operate_url);
									
									$trash_url = 'leads/trash/'.$record->id;
									$trash_url = site_url($trash_url); ?>
									<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
									<td><?php echo $sr;  echo ($record->is_new==1) ? ' <span class="badge_mini label-danger">new</span>':'';  ?></td>
									<td><?= stripslashes($record->ref_no); ?></td>
									<td><?php echo stripslashes($record->lead_type); ?> </td>
									<td><?= stripslashes($record->lead_status); ?></td>
									<td><?php echo stripslashes($record->priority); ?> </td>
									<td><?php 
										echo stripslashes($record->cnt_name); 
										 
										if(strlen($record->cnt_phone_no)>0){
											echo ' ( ';
											$cnt_phn_no_arrs = explode(',',$record->cnt_phone_no); 
											if(isset($cnt_phn_no_arrs) && count($cnt_phn_no_arrs)>1){
												echo $cnt_phn_no_arrs[0];
												$n=1; 
												$ph_txt=''; 
												foreach($cnt_phn_no_arrs as $cnt_phn_no_arr){
													/*if($n==1){
														$n++;
														continue;
													}*/
													$ph_txt .= $cnt_phn_no_arr.', '; 
													$n++;
												} 
												$ph_txt = substr($ph_txt,0,-2); ?>
												<a href="javascript:void(0)" data-popup="popover-custom" data-placement="top" title="Contact Nos." data-content="<?php echo $ph_txt; ?>"> more</a>
											<?php 
											}else{ 
												 echo stripslashes($record->cnt_phone_no); 
											} 
											echo ' )';
										} ?> </td> 
									<td><?php   
									 if(isset($record->sub_location_id) && $record->sub_location_id>0){
										$arr_lc = $this->emirates_sub_location_model->get_emirate_sub_location_by_id($record->sub_location_id);  
										if(isset($arr_lc)){
											echo stripslashes($arr_lc->name);
										}
									 }?> </td>
									<td><?php  
									 if(isset($record->category_id) && $record->category_id>0){
										$arr_cate = $this->categories_model->get_category_by_id($record->category_id); 
										if(isset($arr_cate)){
											echo stripslashes($arr_cate->name);
										}
									 } ?> </td>  
									<td><?php  
									 if(isset($record->no_of_beds_id) && $record->no_of_beds_id>0){
										$arr_bd = $this->no_of_bedrooms_model->get_no_of_beds_by_id($record->no_of_beds_id); 
										if(isset($arr_bd)){
											echo stripslashes($arr_bd->title);
										}
									 } ?> </td> 
									<td> <?php echo (isset($record) && $record->price!='') ? CRM_CURRENCY.' '.number_format($record->price,0,".",",") :''; ?> </td>
									<td><?php  
									 if(isset($record->enquiry_date) && $record->enquiry_date!='0000-00-00'){
										echo  date('d-M-Y',strtotime($record->enquiry_date));
									 } ?></td>
									<td><?php 
									if($record->agent_id>0){
										$usr_arr =  $this->general_model->get_user_info_by_id($record->agent_id);
										echo stripslashes($usr_arr->name);
									} ?></td> 
									<td><?php echo ($record->updated_on!='0000-00-00 00:00:00') ? date('d.M.y', strtotime($record->updated_on)):''; /* cnt_updated_on */ ?> </td>  
									<td class="center"> 
										<div class="list-icons">
											<div class="dropdown">  
											<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown"><i class="icon-menu7"></i></a>
											<div class="dropdown-menu dropdown-menu-right"> 
												<a href="<?php echo $details_url; ?>" class="dropdown-item"><i class="icon-search4"></i> Detail </a> 
												<a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a>   
												<a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a>
												 
											</div> 										
										</div>
									  </div> 
									</td>  
								   </tr> 
							<?php 
								$sr++;
								}  ?> 
								   <tr>
								   <td colspan="14">
								   <div style="float:left;">  <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md select2" onChange="operate_leads_properties();">
								  <option value="25"> Pages</option>
								  <option value="25"> 25 </option>
								  <option value="50"> 50 </option>
								  <option value="100"> 100 </option> 
								</select>  </div>
									<div style="float:right;"> <?php echo $this->ajax_pagination->create_links(); ?>  </div> </td>  
								  </tr> 
							  <?php
							}else{ ?>	
								 <tr>
								   <td colspan="14" align="center">
								   <div style="float:left;"> <select name="per_page" id="per_page" class="form-control input-sm mb-md select2" onChange="operate_leads_properties();">
								  <option value="25"> Pages</option>
								  <option value="25"> 25 </option>
								  <option value="50"> 50 </option>
								  <option value="100"> 100 </option> 
								</select>  </div>
								<div>  <strong> No Record Found! </strong> </div>  </td>  
							  </tr>  
								<?php 
								} 
							}else{ ?>	
							<tr class="gradeX"> 
								<td colspan="14" class="center"> <strong> No Permission to access this area! </strong> </td>
							</tr>
						<?php } ?>  
						</tbody> 
                    </table>
                  </div>
                  <div class="loading" style="display: none;">
                    <div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div>
                  </div>
                </div>
              </form>
            </div>
            <!-- /sidebars overview -->
          </div>
        </div>
        <!-- /detached content -->
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
