<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/meta_tags'); ?> 
<!--<script type="text/javascript" src="<?= asset_url(); ?>js/plugins/uploaders/dropzone.min.js"></script>-->
<!--<script type="text/javascript" src="<?= asset_url(); ?>js/pages/uploader_dropzone.js"></script>--> 
<link rel="stylesheet" href="<?= asset_url(); ?>vendor/dropzone/css/basic.css" />
<link rel="stylesheet" href="<?= asset_url(); ?>vendor/dropzone/css/dropzone.css" /> 
<script src="<?= asset_url(); ?>vendor/dropzone/dropzone.js"></script> 

<script type="text/javascript" src="<?= asset_url(); ?>js/plugins/forms/inputs/duallistbox.min.js"></script>
<script type="text/javascript" src="<?= asset_url(); ?>js/pages/form_dual_listboxes.js"></script>
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
		<form name="datas_form" id="datas_form" method="post" action="<?php echo site_url('properties/add/'.$args0); ?>" class="form-horizontal" onSubmit="return operate_custom_validation();">
		  <div class="panel panel-flat">
			<div class="panel-heading">
			  <h5 class="panel-title"> 
				<!--<?= $page_headings; ?>
			  Form--> Properties Address & Details</h5>
			</div>
	<div class="panel-body">
	  <div class="form-group">
			  
		<div class="col-md-4">
		  <div class="form-group">
			<label class="col-md-3 control-label" for="title">Title <span class="reds">*</span></label>
			<div class="col-md-9">
			  <input name="title" id="title" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->title) : set_value('title'); ?>" data-error="#title1">   <span id="title1" class="text-danger"><?php echo form_error('title'); ?></span> </div>  </div>
		  <div class="form-group">
			<label class="col-md-3 control-label" for="description">Description <span class="reds"> *</span></label>
			<div class="col-md-9">
			  <textarea name="description" id="description" class="form-control" rows="5" data-error="#description1"><?php echo (isset($record)) ? stripslashes($record->description): set_value('description'); ?></textarea>
			  <span id="description1" class="text-danger"><?php echo form_error('description'); ?></span> </div>
		  </div>
		  <div class="form-group">
			<label class="col-md-3 control-label" for="property_type">Property Type <span class="reds">*</span></label>
			<div class="col-md-9"> 
				<label class="radio-inline" for="property_type1">
					<input type="radio" name="property_type" id="property_type1" class="styled" <?php echo ((isset($_POST['property_type']) && $_POST['property_type']==1) || (isset($record) && $record->property_type==1)) ? 'checked="checked"':'' ?> value="1" data-error="#property_type0" onClick="opereate_ref_no('1');"> Sale </label>
					
				<label class="radio-inline" for="property_type2">
					<input type="radio" name="property_type" id="property_type2" class="styled" <?php echo ((isset($_POST['property_type']) && $_POST['property_type']==2) || (isset($record) && $record->property_type==2)) ? 'checked="checked"':'' ?> value="2" data-error="#property_type0" onClick="opereate_ref_no('2');"> Rent </label>         
			  <span id="property_type0" class="text-danger" style="clear:both; display:block;"><?php echo form_error('property_type'); ?></span> </div>
		  </div>
		  <div class="form-group">
			<label class="col-md-3 control-label" for="category_id"> Category <span class="reds">*</span></label>
			<div class="col-md-9"> 
			  <select name="category_id" id="category_id" class="form-control select2" data-error="#category_id1">
				<option value="">Select Category Name</option>
				<?php  
				$category_arrs = $this->categories_model->get_all_categories();       
				if(isset($category_arrs) && count($category_arrs)>0){
					foreach($category_arrs as $category_arr){
						$sel_1 = '';
						if(isset($_POST['category_id']) && $_POST['category_id']==$category_arr->id){
							$sel_1 = 'selected="selected"';
						}else if(isset($record) && $record->category_id==$category_arr->id){
							$sel_1 = 'selected="selected"';
						} ?>
						<option value="<?= $category_arr->id; ?>" <?php echo $sel_1; ?>>
							<?= stripslashes($category_arr->name); ?>
						</option>
					<?php 
					}
				} ?>
			  </select> 
			  <span id="category_id1" class="text-danger"><?php echo form_error('category_id'); ?></span> </div>
		  </div>
			
		   
		   <div class="tabbable">
			<ul class="nav nav-tabs nav-tabs-highlight">
			  <li class="active"><a href="#portal_tab" data-toggle="tab"><i class="icon-menu7 position-left"></i> Portals </a></li> 
			  <li><a href="#amenities_tab" data-toggle="tab"><i class="icon-menu7 position-left"></i> Amenities </a></li> 
			</ul>
	<div class="tab-content">
	  <div class="tab-pane active" id="portal_tab"> 
		  <div class="form-group"> 
			<div class="col-md-10">
						
			   <div class="row">
			   <div class="col-md-6">    
				<?php  
					$p=1;
					$portal_arrs = $this->portals_model->get_all_portals();
					$portal_nums = count($portal_arrs);
					
					if(isset($portal_arrs) && $portal_nums>0){
						$portal_nums_avg = round($portal_nums/2);
						
						if(isset($_POST['show_on_portal_ids']) && count($_POST['show_on_portal_ids'])>0){ 
							$db_portal_id_arrs = $_POST['show_on_portal_ids'];   
						}else if(isset($record) && strlen($record->show_on_portal_ids)>0){
							$db_portal_ids = $record->show_on_portal_ids;
							$db_portal_id_arrs = explode(',',$db_portal_ids); 
						}
						
						foreach($portal_arrs as $portal_arr){ 
						 
							$chks_1 = '';
							if(isset($db_portal_id_arrs) && count($db_portal_id_arrs)>0){
								if(in_array($portal_arr->id, $db_portal_id_arrs)){
									$chks_1 = 'checked="checked"';
								}
							}  ?>
						
							<div class="checkbox">
							  <label for="show_on_portal_ids_<?php echo $p; ?>">
								<input name="show_on_portal_ids[]" id="show_on_portal_ids_<?php echo $p; ?>" type="checkbox" class="styled" value="<?= stripslashes($portal_arr->id); ?>" <?php echo $chks_1; ?>> <?= stripslashes($portal_arr->name); ?> </label>
							</div>
					 
						 <?php 
						 if($p == $portal_nums_avg){
							echo '</div> <div class="col-md-6">'; 
						 }
						  
						$p++;
						}
					} ?> 
					 
				  </div> 
				</div>            
			</div>
		  </div> 
	  </div>
		  <div class="tab-pane" id="amenities_tab">
			<div class="form-group"> 
				<div class="col-md-10" align="center">  
			<br>
			 <?php 
				$total_amenities_nums = 0;  
				//$sel_private_amenities_data = $sel_private_amenities_nums = ''; 
				//$sel_commercial_amenities_data = $sel_commercial_amenities_nums = ''; 
				$sel_private_amenities_data = $sel_private_amenities_nums = 0; 
				$sel_commercial_amenities_data = $sel_commercial_amenities_nums = 0; 
				
				if(isset($_POST['private_amenities_data']) && strlen($_POST['private_amenities_data'])>0){ 
					$sel_private_amenities_data = $_POST['private_amenities_data']; 
					$sel_private_amenities_nums = count(explode(',',$sel_private_amenities_data));     
				}  
				
				if(isset($_POST['commercial_amenities_data']) && strlen($_POST['commercial_amenities_data'])>0){ 
					$sel_commercial_amenities_data = $_POST['commercial_amenities_data']; 
					$sel_commercial_amenities_nums = count(explode(',',$sel_commercial_amenities_data));  
				} 
				 
				$total_amenities_nums = $sel_private_amenities_nums + $sel_commercial_amenities_nums; ?> 
				
				<button class="btn bg-teal change-to-ak-co" type="button" data-toggle="modal" data-target="#modal_remote_amenities"><span class="badge bg-warning-400" id="fetch_amenities_nums"><?php echo $total_amenities_nums; ?></span> Assign / De-Assign Amenities</button> 
								
				<input type="hidden" name="private_amenities_data" id="private_amenities_data" value="<?php echo $sel_private_amenities_data; ?>" />
				
				<input type="hidden" name="commercial_amenities_data" id="commercial_amenities_data" value="<?php echo $sel_commercial_amenities_data; ?>" />   
			  </div> 
		  </div>  
	  </div>
		  
		</div>
	  </div> 
	</div> 
	<?php 
		if(isset($_POST['ref_no']) && strlen($_POST['ref_no'])>0){
			$temp_ref_no = $_POST['ref_no']; 
		}else if(isset($record) && strlen($record->ref_no)>0){
			$temp_ref_no = stripslashes($record->ref_no); 
		}else{
			$temp_ref_no = $auto_ref_no;
			
			$pos1 = strpos($temp_ref_no, "BSO-S");
			$pos2 = strpos($temp_ref_no, "BSO-R");
			 
			if($pos1 === false && $pos2 === false){
				$temp_ref_no = 	$conf_sale_inititals.$temp_ref_no;
			}
		} ?>
		
		<script type="text/javascript">
		
			function opereate_ref_no(sel_vls){
				var pre_ref_val = document.getElementById('ref_no').value;
				if(pre_ref_val!=''){ 
					pre_ref_val = pre_ref_val.replace(/BSO-S/g,''); 
					pre_ref_val = pre_ref_val.replace(/BSO-R/g,''); 
					
					pre_ref_val = pre_ref_val.replace(/S/g,''); 
					pre_ref_val = pre_ref_val.replace(/R/g,''); 
					
					pre_ref_val = pre_ref_val.replace(/L-/g,''); 
				} 
				
				if(sel_vls==2){ 
					var nw_pre_ref_val = "<?php echo $conf_rent_inititals; ?>"+pre_ref_val;
					document.getElementById('ref_no').value = nw_pre_ref_val;
				}else{
					var nw_pre_ref_val = "<?php echo $conf_sale_inititals; ?>"+pre_ref_val;
					document.getElementById('ref_no').value = nw_pre_ref_val;	
				} 
			} 
					
			$(function() { 
			<?php
				$usr_popup_url = 'users/users_popup_list/3/';
				$usr_popup_url = site_url($usr_popup_url); ?> 
				 
				$('#modal_remote_user').on('show.bs.modal', function() {
					$(this).find('.modal-body').load('<?php echo $usr_popup_url; ?>', function() {
			 
						$('.select').select2({
							minimumResultsForSearch: Infinity
						});
					});
				});
	 
			<?php
				$ownr_popup_url = 'owners/owners_popup_list';
				$ownr_popup_url = site_url($ownr_popup_url); ?> 
				 
				$('#modal_remote_owner').on('show.bs.modal', function() {
					$(this).find('.modal-body').load('<?php echo $ownr_popup_url; ?>', function() {
			 
						$('.select').select2({
							minimumResultsForSearch: Infinity
						});
					});
				});   
				
			<?php
				$prpty_amenities_popup_url = 'property_features/amenities_popup_list/';
				$prpty_amenities_popup_url = site_url($prpty_amenities_popup_url); ?> 
				
				$('#modal_remote_amenities').on('show.bs.modal', function() {
			
					var private_amenities_data_val = document.getElementById("private_amenities_data").value;  	
					var commercial_amenities_data_val = document.getElementById("commercial_amenities_data").value;  	 			
					
					var amenities_data_url =  "<?php echo $prpty_amenities_popup_url; ?>"+private_amenities_data_val+"__"+commercial_amenities_data_val;
					
					var repls = "_";
					amenities_data_url = amenities_data_url.replace(/,/g,repls);
					   
					$(this).find('.modal-body').load(amenities_data_url, function() {
			 
						$('.select').select2({
							minimumResultsForSearch: Infinity
						});
					});
				});  
			});   
			
			function clickeds_users(sels_vals) {  
				$(document).ready(function(){  
				<?php  
					$tmp_usr_pth1 = '/users/fetch_assign_users_list/';
					$tmp_usr_pth1 = site_url($tmp_usr_pth1);	?>
					
					$.ajax({
						url: '<?php echo $tmp_usr_pth1; ?>'+sels_vals,
						cache: false,
						type: 'POST', 
						data: { 'submits':1 },
						success: function (result,status,xhr) { 
							document.getElementById("fetch_users").innerHTML = result; 
							$('.select2').select2({
								minimumResultsForSearch: Infinity
							}); 
						}
					});    
				}); 
			}  
			
			function clickeds(sels_vals) {  
				$(document).ready(function(){
				<?php  
					$tmp_ownr_pth1 = '/owners/fetch_owners_list/';
					$tmp_ownr_pth1 = site_url($tmp_ownr_pth1);	?>
					
					$.ajax({
						url: '<?php echo $tmp_ownr_pth1; ?>'+sels_vals,
						cache: false,
						type: 'POST', 
						data: { 'submits':1 },
						success: function (result,status,xhr) { 
							document.getElementById("fetch_owners").innerHTML = result; 
							$('.select').select2({
								minimumResultsForSearch: Infinity
							}); 
						}
					});    
				}); 
			}  
			
			function operate_amenities_datas(sels_vals1,sels_vals2) {
				if(sels_vals1!='' || sels_vals2!=''){
					document.getElementById("private_amenities_data").value = sels_vals1;
					document.getElementById("commercial_amenities_data").value = sels_vals2;
					
					var private_ame_nums = sels_vals1.length;
					var commercial_ame_nums = sels_vals2.length;
					private_ame_nums = private_ame_nums * 1;
					commercial_ame_nums = commercial_ame_nums * 1;
					
					var total_nums = private_ame_nums + commercial_ame_nums;
					 
					document.getElementById("fetch_amenities_nums").innerHTML = total_nums;
				}
			}  
		</script> 

	<div id="modal_remote_user" class="modal fade" data-backdrop="false"> 
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Users List</h5>
				</div>

				<div class="modal-body"></div>

				<div class="modal-footer">
					<button id="close_users_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
				</div>
			</div>
		</div>
	</div>
	
	<div id="modal_remote_owner" class="modal fade" data-backdrop="false"> 
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Owners List</h5>
				</div>

				<div class="modal-body"></div>

				<div class="modal-footer">
					<button id="close_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
				</div>
			</div>
		</div>
	</div>
	
	<div id="modal_remote_amenities" class="modal" data-backdrop="false"> 
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Amenities List</h5>
				</div>

				<div class="modal-body"></div>

				<div class="modal-footer">
					<button id="close_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
				</div>
			</div>
		</div>
	</div>    
		
	<div class="col-md-4">
	  <div class="form-group">
		<label class="col-md-3 control-label" for="ref_no">Ref # <span class="reds"> *</span></label>
		<div class="col-md-9">
		  <input name="ref_no" id="ref_no" type="text" class="form-control" value="<?php echo $temp_ref_no; ?>" readonly title="Read only - system created">
		  <span class="text-danger"><?php echo form_error('ref_no'); ?></span> </div>
	  </div>
	  
	  <div class="form-group">
		<label class="col-md-3 control-label" for="assigned_to_id">Assigned To <span class="reds">*</span></label>
		<div class="col-md-9"> 
			<span id="fetch_users">
			  <select name="assigned_to_id" id="assigned_to_id" class="form-control select2" data-error="#assigned_to_id1">
				<option value="">Select Assigned To Name</option>
				<?php  
					if(isset($user_arrs) && count($user_arrs)>0){
						foreach($user_arrs as $user_arr){
						$sel_1 = '';
						if(isset($_POST['assigned_to_id']) && $_POST['assigned_to_id']==$user_arr->id){
							$sel_1 = 'selected="selected"';
						}else if(isset($record) && $record->assigned_to_id==$user_arr->id){
							$sel_1 = 'selected="selected"';
						} ?>
						<option value="<?= $user_arr->id; ?>" <?php echo $sel_1; ?>>
						<?= stripslashes($user_arr->name); ?>
						</option>
						<?php 
						}
					} ?>
				 </select> 
				</span>
			 <a data-toggle="modal" data-target="#modal_remote_user"><i class="glyphicon glyphicon-plus position-left"></i> Add Assigned To</a> 
			 
			 <span id="assigned_to_id1" class="text-danger"><?php echo form_error('assigned_to_id'); ?></span> </div>
	  </div>
	   
	  <div class="form-group">
		<label class="col-md-3 control-label" for="owner_id">Owners <span class="reds">*</span></label>
		<div class="col-md-9">
			<span id="fetch_owners">
			 <select name="owner_id" id="owner_id" class="form-control select2" data-error="#owner_id1">
			 <option value="">Select Owner Name </option>
			<?php  
				if(isset($owner_arrs) && count($owner_arrs)>0){
					foreach($owner_arrs as $owner_arr){
					$sel_1 = '';
					if(isset($_POST['owner_id']) && $_POST['owner_id']==$owner_arr->id){
						$sel_1 = 'selected="selected"';
					}else if(isset($record) && $record->owner_id==$owner_arr->id){
						$sel_1 = 'selected="selected"';
					} ?>
					<option value="<?= $owner_arr->id; ?>" <?php echo $sel_1; ?>>
						<?= stripslashes($owner_arr->name); ?>
					</option>
					<?php 
					}
				} ?>
				</select>  
			</span> 
			<a data-toggle="modal" data-target="#modal_remote_owner"><i class="glyphicon glyphicon-plus position-left"></i> Add Owners</a>   
		  <span id="owner_id1" class="text-danger"><?php echo form_error('assigned_to_id'); ?></span> </div>
	  </div> 
	  
	  <div class="form-group">
		<label class="col-md-3 control-label" for="no_of_beds_id">Bedrooms <span class="reds">*</span> </label>
		<div class="col-md-9">
		  <select name="no_of_beds_id" id="no_of_beds_id" class="form-control select2" data-error="#no_of_beds_id1" >
			<option value="">Select No. of Bedrooms</option>
			<?php   
			for($b=1; $b<=10; $b++){ 
				$sel_1 = '';
				if(isset($_POST['no_of_beds_id']) && $_POST['no_of_beds_id']==$b){
					$sel_1 = 'selected="selected"';
				}else if(isset($record) && $record->no_of_beds_id==$b){
					$sel_1 = 'selected="selected"';
				} ?>
			<option value="<?= $b; ?>" <?php echo $sel_1; ?>>
			<?= ($b==10) ? $b.'+' : $b; ?>
			</option>
			<?php } ?>
		  </select>
		  <span id="no_of_beds_id1" class="text-danger"><?php echo form_error('no_of_beds_id'); ?></span> </div>
	  </div>
	  <div class="form-group">
		<label class="col-md-3 control-label" for="no_of_baths">Bathrooms <span class="reds">*</span></label>
		<div class="col-md-9">
		  <select name="no_of_baths" id="no_of_baths" class="form-control select2" data-error="#no_of_baths1">
			<option value="">Select No. of Bathrooms</option>
			<?php   
				for($b=1; $b<=10; $b++){ 
					$sel_1 = '';
					if(isset($_POST['no_of_baths']) && $_POST['no_of_baths']==$b){
						$sel_1 = 'selected="selected"';
					}else if(isset($record) && $record->no_of_baths==$b){
						$sel_1 = 'selected="selected"';
					} ?>
			<option value="<?= $b; ?>" <?php echo $sel_1; ?>>
			<?= ($b==10) ? $b.'+' : $b; ?>
			</option>
			<?php } ?>
		  </select>
		  <span id="no_of_baths1" class="text-danger"><?php echo form_error('no_of_baths'); ?></span> </div>
	  </div>
	  
	  <div class="form-group">
		<label class="col-md-3 control-label" for="is_furnished1">Is Furnished ?</label> 
		<div class="col-md-9">     
		 <select name="is_furnished" id="is_furnished" class="form-control select2" data-error="#is_furnished1">
			<option value="">Select Is Furnished </option>
			<option value="1" <?php if(isset($_POST['is_furnished']) && $_POST['is_furnished']==1){ echo 'selected="selected"'; } ?>> Furnished </option> 
			 <option value="2" <?php if(isset($_POST['is_furnished']) && $_POST['is_furnished']==2){ echo 'selected="selected"'; } ?>> SemiFurnished </option> 
			<option value="3" <?php if(isset($_POST['is_furnished']) && $_POST['is_furnished']==3){ echo 'selected="selected"'; } ?>> UnFurnished </option>        
		  </select>    
		  <span id="is_furnished1" class="text-danger" style="clear:both; display:block;"><?php echo form_error('is_furnished'); ?></span> </div> 
	  </div>
		   
	  <div class="form-group">
		<label class="col-md-3 control-label" for="source_of_listing">Source of Listing </label>
		<div class="col-md-9">
		  <select name="source_of_listing" id="source_of_listing" class="form-control select2" data-error="#source_of_listing1">
			<option value="">Select Source of Listing </option>
		<?php  
			if(isset($source_of_listing_arrs) && count($source_of_listing_arrs)>0){
				foreach($source_of_listing_arrs as $source_of_listing_arr){
					$sel_1 = '';
					if(isset($_POST['source_of_listing']) && $_POST['source_of_listing']==$source_of_listing_arr->id){
						$sel_1 = 'selected="selected"';
					}else if(isset($record) && $record->source_of_listing==$source_of_listing_arr->id){
						$sel_1 = 'selected="selected"';
					} ?>
					<option value="<?= $source_of_listing_arr->id; ?>" <?php echo $sel_1; ?>>
					<?= stripslashes($source_of_listing_arr->title); ?>
					</option>
					<?php 
				}
			} ?>
		  </select>
		  <span id="source_of_listing1" class="text-danger"><?php echo form_error('source_of_listing'); ?></span> </div>
		  </div> 	
	</div>
		
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-3 control-label" for="property_address">Address <span class="reds"> *</span></label>
			<div class="col-md-9">
			  <textarea name="property_address" id="property_address" class="form-control" rows="3" data-error="#property_address1"><?php echo (isset($record)) ? stripslashes($record->property_address): set_value('property_address'); ?></textarea>
			  <span id="property_address1" class="text-danger"><?php echo form_error('property_address'); ?></span> </div>
		  </div>
		  
		<div class="form-group">
		<label class="col-md-3 control-label" for="plot_area">Plot Area <span class="reds"> *</span></label>
		<div class="col-md-9">
		  <input name="plot_area" id="plot_area" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->plot_area) : set_value('plot_area'); ?>" data-error="#plot_area1">
		  <span id="plot_area1" class="text-danger"><?php echo form_error('plot_area'); ?></span> </div>
	  </div>
	  
	  <div class="form-group">
		<label class="col-md-3 control-label" for="property_ms_unit">Measuring Unit <span class="reds"> *</span></label>
		<div class="col-md-9">
		<select name="property_ms_unit" id="property_ms_unit" class="form-control select2" data-error="#property_ms_unit1">
			 <option value=""> Select Measuring Unit </option>
			<option value="1" <?php if((isset($_POST['property_ms_unit']) && $_POST['property_ms_unit']==1) || (isset($record) && $record->property_ms_unit==1)){ echo 'selected="selected"'; } ?>> Square Feet (ft2) </option>
			<option value="2" <?php if((isset($_POST['property_ms_unit']) && $_POST['property_ms_unit']==2) || (isset($record) && $record->property_ms_unit==2)){ echo 'selected="selected"'; } ?>> Square Centimetres (cm2) </option>
			<option value="3" <?php if((isset($_POST['property_ms_unit']) && $_POST['property_ms_unit']==3) || (isset($record) && $record->property_ms_unit==3)){ echo 'selected="selected"'; } ?>> Square Metres (m2) </option>
			<option value="4" <?php if((isset($_POST['property_ms_unit']) && $_POST['property_ms_unit']==4) || (isset($record) && $record->property_ms_unit==4)){ echo 'selected="selected"'; } ?>> Square Millimetres (mm2) </option>
			<option value="5" <?php if((isset($_POST['property_ms_unit']) && $_POST['property_ms_unit']==5) || (isset($record) && $record->property_ms_unit==5)){ echo 'selected="selected"'; } ?>> Square Kilometres (km2) </option>
			<option value="6" <?php if((isset($_POST['property_ms_unit']) && $_POST['property_ms_unit']==6) || (isset($record) && $record->property_ms_unit==6)){ echo 'selected="selected"'; } ?>> Square Yards (yd2) </option>
			<option value="7" <?php if((isset($_POST['property_ms_unit']) && $_POST['property_ms_unit']==7) || (isset($record) && $record->property_ms_unit==7)){ echo 'selected="selected"'; } ?>> Square Miles (mi2) </option>
		</select> 
		 <span id="property_ms_unit1" class="text-danger"><?php echo form_error('property_ms_unit'); ?></span> </div>
	  </div>
	  
	  <div class="form-group">
		<label class="col-md-3 control-label" for="price">Price (<?php echo $conf_currency_symbol; ?>) <span class="reds"> *</span></label>
		<div class="col-md-9">
		  <input name="price" id="price" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->price) : set_value('price'); ?>" data-error="#price1">
		  <span id="price1" class="text-danger"><?php echo form_error('price'); ?></span> </div>
	  </div> 
	 <?php $def_sels = 3; ?>      
	  <div class="form-group">
		<label class="col-md-3 control-label" for="property_status"> Property Status </label>
		<div class="col-md-9">
		  <select name="property_status" id="property_status" class="form-control select2" data-error="#property_status1">
			<option value="">Select Property Status</option>
			<option value="1" <?php if((isset($_POST['property_status']) && $_POST['property_status']==1) || (isset($record) && $record->property_status==1)){ echo 'selected="selected"'; } ?>> Sold </option> 
			 <option value="2" <?php if((isset($_POST['property_status']) && $_POST['property_status']==2) || (isset($record) && $record->property_status==2)){ echo 'selected="selected"'; } ?>> Rented </option> 
			<option value="3" <?php if((isset($_POST['property_status']) && $_POST['property_status']==3) || (isset($record) && $record->property_status==3)){ echo 'selected="selected"'; }else{ echo $def_sels; } ?>> Available </option>           
			<option value="4" <?php if((isset($_POST['property_status']) && $_POST['property_status']==4) || (isset($record) && $record->property_status==4)){ echo 'selected="selected"'; } ?>> Upcoming </option>  
		  </select>
		  <span id="property_status1" class="text-danger"><?php echo form_error('property_status'); ?></span> </div>
	  </div>
	  
	  <div class="form-group">
		<label class="col-md-3 control-label" for="youtube_video_link">Youtube Video Link </label>
		<div class="col-md-9">
		  <input name="youtube_video_link" id="youtube_video_link" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->youtube_video_link) : set_value('youtube_video_link'); ?>">
		  <span class="text-danger"><?php echo form_error('youtube_video_link'); ?></span> </div>
	  </div>
	  <style>
		.radio-inline {
			padding-left:27px;	
		} 
	  </style> 
	</div>
  </div>
</div>
</div>
 
	<style>
		.parent_location_box0 {
			width:24%;
			height:300px;
			border:1px solid #ccc;
			border-radius:3px; 
			padding:0px;
			float:left;
			margin-right:10px;
			margin-bottom:10px; 
		}
		
		.parent_location_box0 label.bolder {
			font-weight:bold;
			padding:4px;
		}
				
		.parent_box_area0{ 
			overflow-y:auto; 
			height:270px;
			border-top:1px solid #ddd; 
		}
																			
		.parent_location_box0 ul.ul_location_cls {
			list-style:none;
			padding:5px;
		}
		
		.parent_location_box0 ul.ul_location_cls li {
			list-style:none; 
			padding-top:3px;
			padding-bottom:0px;
			border-bottom:1px dashed #999999;
		}
		
		.parent_location_box0 ul.ul_location_cls li label { 
			padding-left:2px;
			cursor:pointer;
		}
		
		.parent_location_box0 ul.ul_location_cls li:hover {
			background:#d3d1d1;
			cursor:pointer;
		} 
		
		.disable_cls { 
			pointer-events:none;
			background:#eee;
			opacity: 0.7; 
		}
		
		.mini-form-control {
			display: inline !important;
			width: 66% !important;
			height: 23px !important;
			padding: 5px 8px !important;
			font-size: 11px !important;
		}									
	</style> 	

	<script> 
		function operate_property_locations(sl_item_id){	
			$(document).ready(function(){
				//$(".chk_location_cls").click(function() {
				var data_item_parent_id = $("#parent_loc_id"+sl_item_id).attr("data-item-parent-id");
				var data_item_parent_inc_id = $("#parent_loc_id"+sl_item_id).attr("data-item-parent-inc-id");
				 
				var data_item_id = $("#parent_loc_id"+sl_item_id).attr("data-item-id");
				var data_item_label = $("#parent_loc_id"+sl_item_id).attr("data-item-label"); 
				
				//if(data_item_parent_id == 0){
					//$("#fetch_parent_location_box01").addClass("disable_cls"); 
					
				//} 
	
				if( ($("#fetch_parent_location_box" + data_item_parent_inc_id).length >0)){
					$("#fetch_parent_location_box" + data_item_parent_inc_id).remove();	
				}
				
				var fth_sub_loations_url = "<?php echo site_url('/locations/fetch_sub_loations/'); ?>"+data_item_id+"/"+data_item_parent_inc_id;
				var rnd_no = Math.floor(Math.random() * 101);
				
				$.ajax({
					method: "POST",
					url: fth_sub_loations_url,
					data: { rand_no: rnd_no },
					beforeSend: function(){
						$('.loading').show();
					},
					success: function(resp_data){
						$('.loading').hide();  
						resp_data = resp_data.trim();
						if(resp_data != ''){
							$("#parent_loc_id"+sl_item_id).parents('.parent_location_box0').addClass('disable_cls');
							 
							$("#fetch_dyna_locations").append(resp_data);	 
							$("#fetch_parent_location_lbl" + data_item_id).html( data_item_label ); 
						}
					}
				});
				//});
			});
		} 
		
		function remove_sel_location(sl_para1, sl_para2){
			$(document).ready(function(){
				if( $("#fetch_parent_location_box"+sl_para1).length >0 ){  
					$("#parent_loc_id"+sl_para2).parents('.parent_location_box0').removeClass('disable_cls'); 
					$("#fetch_parent_location_box"+sl_para1).remove();	
				}
			});
		}
		
		/*document.querySelector('input[name=location_searcher]').addEventListener('change', function(event){
			alert( '11111' );
		});*/
		//operate_search_filters('location_searcher1', 'selectable1');

		 function operate_search_filters(location_elmnt, selectable_cls){ 
			$(document).ready(function(){  
				var location_searcher = $(location_elmnt).val().toLowerCase(); 
				document.querySelectorAll(selectable_cls).forEach(
					function(li_item) {
					  let item = li_item.firstChild.textContent;
					  
					  if (item.toLowerCase().indexOf(location_searcher) != -1) {
						li_item.style.display = 'block';
					  } else {
						li_item.style.display = 'none';
					  } 
					}
				); 
			});
		}
		
		
		
		///document.querySelector('location_searcher').addEventListener('keyup', filterItems);
		
	//	function filterItems(e) { alert( '11111' );
		  /*const texts = e.target.value.toLowerCase();  alert( texts );
		  document.querySelectorAll('.selectable').forEach(
			function(li_item) {
			  let item = li_item.firstChild.textContent;
			  alert( item );
			  
			  if (item.toLowerCase().indexOf(texts) != -1) {
				li_item.style.display = 'block';
			  } else {
				li_item.style.display = 'none';
			  }
			}
		  );*/
		//}
	</script>
	 	              
 <div class="row">
  <div class="col-md-12">
	<div class="panel panel-flat">
	  <div class="panel-heading">
		<h6 class="panel-title">Locaion Management</h6>
	  </div>
	  <div class="panel-body">  
		 <div class="row">
			<div class="col-md-12" id="fetch_dyna_locations">  
				<div class="parent_location_box0" id="fetch_parent_location_box01">
					<label class="control-label bolder" for="parent_location_id">Cities: </label> <span class="filter_cls"><input type="text" name="location_searcher1" id="location_searcher1" class="form-control mini-form-control" placeholder="Search..." onKeyUp="operate_search_filters('#location_searcher1', '.selectable1');" /></span>	
					<div class="parent_box_area0"> 
						<ul class="ul_location_cls"> 			
						<?php  /* _<?= $chk; ?> */
							$chk = 0;
							if($locations_arrs){
								foreach($locations_arrs as $locations_arr){  ?>  
									<li class="selectable1"><label for="parent_loc_id<?= $locations_arr->id; ?>"> <input type="radio" name="parent_loc_id" id="parent_loc_id<?= $locations_arr->id; ?>" value="<?= $locations_arr->id; ?>" data-item-id="<?= $locations_arr->id; ?>" data-item-label="<?= $locations_arr->name; ?>" data-item-parent-id="<?= $locations_arr->parent_id; ?>" data-item-parent-inc-id="<?= $locations_arr->parent_id+1; ?>" class="chk_location_cls" onClick="operate_property_locations('<?= $locations_arr->id; ?>');" /> <?= stripslashes($locations_arr->name); ?> </label> </li>
									<?php  
									$chk++; 
								}
							} ?>
						</ul>
					</div>
				</div>    			 
			</div> 
		</div>			  
				  
		<!--<div id="fetch_dyna_locations" style="clear:both;"></div>-->	  
	  </div> 
	</div>  
  </div>  
</div>
		<script> //operate_search_filters('location_searcher1', 'selectable1'); </script>
		
		     
         <div class="row">
          <div class="col-md-4">
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h6 class="panel-title">Photo(s)</h6>
              </div>
              <div class="panel-body">  
                <div id="mediaimages" class="dropzone dropzone-previews"></div>
                <br>
              </div> 
            </div>  
          </div>
          <div class="col-md-4">
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h6 class="panel-title">Documents </h6> 
              </div>
              <div class="panel-body">
              		<div id="documentsfiles" class="dropzone dropzone-previews"></div> 
					<br>
              </div>
            </div> 
          </div>    
          <div class="col-md-4">
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h6 class="panel-title">Notes </h6> 
              </div>
              <div class="panel-body">   
               <div class="panel panel-flat timeline-content"> 
                <div class="panel-body">
              	<ul class="media-list chat-list content-group" id="fetch_properties_notes_list">    			<?php 
                    $nt_arrs = $this->properties_model->get_temp_property_notes(); 
                    if(isset($nt_arrs) && count($nt_arrs)>0){
                        foreach($nt_arrs as $nt_arr){ ?> 	  
                            <li class="media">
                              <div class="media-left"> 
							  <u><i> <?php 
							  		$dbs_user_id = $nt_arr->user_id;
									if($dbs_user_id>0){
										$usr_arr =  $this->general_model->get_user_info_by_id($dbs_user_id);
										echo stripslashes($usr_arr->name);
									}  ?> </i> </u>   </div>
                              <div class="media-body">
                                <div class="media-content"><?= stripslashes($nt_arr->notes); ?></div>
                                <span class="media-annotation display-block mt-10"><?php echo date('d F, Y',strtotime($nt_arr->datatimes)); ?> </span> </div>
                            </li> 
                        <?php 
                        }
                    } ?> 
                  </ul>
                  <textarea placeholder="Enter your notes..." cols="1" rows="3" class="form-control content-group" name="notes" id="notes"></textarea>
                  <div class="row">
                    <div class="col-xs-6">
                       
                    </div>
                    <div class="col-xs-6 text-right">
                      <button class="btn bg-teal-400 btn-labeled btn-labeled-right" type="button" onClick="operate_property_notes();" ><b><i class="icon-circle-right2"></i></b> Noted</button>
                    </div>
                  </div>
                </div>
              </div>  
                    
          </div>
        </div> 
      </div>
    	</div> 
      
       <div class="row">   
          <div class="form-group"> 
            <div class="col-md-12" align="center">
          
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves" id="saves"><i class="glyphicon glyphicon-ok position-left"></i>Save</button>  
              &nbsp;
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves_and_new" id="save_and_new"><i class="glyphicon glyphicon-repeat position-left"></i>Save & New</button>  
              &nbsp;
              <button type="reset" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button> 
              &nbsp;
			  <?php
				if(isset($args0) && $args0==1){
					$cancel_url = site_url("properties/archived_listings");	
				}else if(isset($args0) && $args0==2){
					//$cancel_url = site_url("properties/dealt_properties_list");
					$cancel_url = site_url("deals/sales_listing/");
				}else if(isset($args0) && $args0==3){
					$cancel_url = site_url("properties/sales_listings");
				}else if(isset($args0) && $args0==4){   
					$cancel_url = site_url("properties/rent_listings");
				}else if(isset($args0) && $args0 ==5){ 
					//$cancel_url = site_url("properties/leads_properties_list");
					$cancel_url = site_url("leads/index");  
				}else if(isset($args0) && $args0==6){   
					$cancel_url = site_url("properties/portal_properties_list");	
				}else{ 
					$cancel_url = site_url("properties/sales_listings");
				} ?> 
              <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo $cancel_url; ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button>  
            </div>
        </div>
     </div>
    </form> 

<script>
	var data='';
	var key='';
	var value='';
	var i =0;
	var fileList = new Array; 
	$(document).ready(function(){  
		Dropzone.options.mediaimages = { 
			url: "<?php echo site_url('/properties/temp_property_media_photos_upload'); ?>",
			autoProcessQueue: true, 
			autoDiscover:false,
			uploadMultiple: true,
			addRemoveLinks: true,   
			parallelUploads: 100,
			maxFiles: 15,
			paramName: "images",
			dictDefaultMessage: 'Drop files or click here to upload',
			acceptedFiles: ".jpeg, .jpg, .png, .gif, .doc, .docx, .pdf",
			init: function() {
				thisDropzone = this;
				addRemoveLinks: true, 
				this.on("success", function(file, response) {  
					/*obj = JSON.parse(serverFileName); 
					fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i };
					file.previewElement.querySelector("img").src = obj;
					console.log(fileList);
					i++; */  
				});  
				<?php 
				if(isset($_SESSION['Temp_IP_Address']) && isset($_SESSION['Temp_DATE_Times'])){  
					$tmp_pth = '/properties/get_temp_post_property_dropzone_photos';
					$tmp_loc = site_url($tmp_pth); ?>
				$.get('<?php echo $tmp_loc; ?>', function(data) {
				$.each(data, function(key,value){
					var mockFile = { name: value.name, size: value.size };
					thisDropzone.options.addedfile.call(thisDropzone, mockFile);
					thisDropzone.options.thumbnail.call(thisDropzone, mockFile,"<?php echo base_url(); ?>downloads/property_photos/"+value.name);
					});
				 });<?php } ?> 
				 
				this.on("removedfile", function(file) {  		 
			<?php 
				$tmp_d_pth = '/properties/delete_temp_property_dropzone_photos';
				$tmp_d_loc = site_url($tmp_d_pth); ?>
				$.post("<?php echo $tmp_d_loc; ?>", { proprtyid: -1, flename: file.name } ); 
				console.log(file);
				// Create the remove button
				var removeButton=Dropzone.createElement("<button>Remove file</button>");
				// Capture the Dropzone instance as closure.
				var _this = this;
				// Listen to the click event
				removeButton.addEventListener();
				// Add the button to the file preview element.
				file.previewElement.appendChild(removeButton);
			}); 
			
			 
		
		/*$("#mediaimages").sortable({
			items: '.dz-preview',
			cursor: 'move',
			opacity: 0.5,
			containment: '#mediaimages',
			distance: 20,
			tolerance: 'pointer',
			stop: function () {
				var queue = Dropzone.forElement('#mediaimages'); 
				var images_order_arrs = new Array();
				var nbr = 0;
				  
				$('#mediaimages .dz-preview .dz-filename [data-dz-name]').each(function (count, el) {           	
					var image_name = el.innerHTML;
					//var name = el.getAttribute('data-name');
					images_order_arrs[nbr] = new Array();
					images_order_arrs[nbr][0] = nbr;
					images_order_arrs[nbr][1] = image_name; 
					
					nbr++;
				});
				 <?php $pp_propertyid = -1; ?> 
				 $.ajax({ 
					url : '<?php echo site_url('/properties/property_media_photos_order_settings'); ?>',
					type       : 'POST',                                              
					data       : { 'data' : JSON.stringify(images_order_arrs), 'propertyid' : <?php echo $pp_propertyid; ?>},
					success    : function(){ }
				 });   
			}
		});*/
		}  
	}   

	var data = '';
	var key = '';
	var value = '';
	
	Dropzone.options.documentsfiles = { 
	url: "<?php echo site_url('/properties/temp_property_documents_files_upload'); ?>",  
	autoProcessQueue: true,
	autoDiscover:false, 
	uploadMultiple: true,
	addRemoveLinks: true,   
	parallelUploads: 100,
	maxFiles: 15,
	paramName: "documents",
	dictDefaultMessage: 'Drop files or click here to upload',
	acceptedFiles: ".jpeg, .jpg, .png, .gif, .doc, .docx, .pdf",
	init: function() {
		addRemoveLinks: true,  
		thisDropzoness = this;   
		<?php if(isset($_SESSION['Temp_Documents_IP_Address']) && isset($_SESSION['Temp_Documents_DATE_Times'])){  
			$tmp_pth1 = '/properties/get_temp_post_property_dropzone_documents';
			$tmp_loc1 = site_url($tmp_pth1); ?> 
		$.get('<?php echo $tmp_loc1; ?>', function(data) {
		$.each(data, function(key,value){
			var mockFiless = { name: value.name, size: value.size };
			thisDropzoness.options.addedfile.call(thisDropzoness, mockFiless);
			thisDropzoness.options.thumbnail.call(thisDropzoness, mockFiless,"<?php echo base_url(); ?>downloads/property_documents/"+value.name);
			});
		 });<?php } ?>
			this.on("removedfile", function(file) { 
		<?php  
			$tmp_d_pth = '/properties/delete_temp_property_dropzone_documents_files';
			$tmp_d_loc = site_url($tmp_d_pth); ?>
			$.post("<?php echo $tmp_d_loc; ?>", { proprtyid: -1, flename: file.name } ); 
			console.log(file);
			// Create the remove button
			var removeButton=Dropzone.createElement("<button>Remove file</button>");
			// Capture the Dropzone instance as closure.
			var _this = this;
			// Listen to the click event
			removeButton.addEventListener();
			// Add the button to the file preview element.
			file.previewElement.appendChild(removeButton);
		});
	}}  
});  

	function operate_property_notes(){ 
		$(document).ready(function(){ 
			var notes_txt = document.getElementById("notes").value;
			notes_txt = notes_txt.trim(); 
			if(notes_txt.length >1){
				$.ajax({
					method: "POST",
					url: "<?php echo site_url('/properties/operate_property_notes/'); ?>",
					data: { notes_txt: notes_txt, propertyid: -1},
					beforeSend: function(){
						//$('.loading').show();
					},
					success: function(data){
						//$('.loading').hide();
						$('#fetch_properties_notes_list').html(data);
						document.getElementById("notes").value = '';
					}
				}); 
			}  
		});
	} 
	
	
	//operate_custom_validation();
	
	function operate_custom_validation(){ 
		$(document).ready(function(){
		
			var validator = $('#datas_form').validate({
			rules: {
				title: {
					required: true 
				}, 
				description: {
					required: true 
				}, 
				property_type: {
					required: true 
				}, 
				category_id: {
					required: true 
				}, 
				ref_no: {
					required: true 
				}, 
				assigned_to_id: {
					required: true 
				}, 
				owner_id: {
					required: true 
				}, 
				no_of_beds_id: {
					required: true 
				}, 
				no_of_baths: {
					required: true 
				},  
				property_address: {
					required: true 
				}, 
				plot_area: {
					required: true 
				}, 
				property_ms_unit: {
					required: true 
				}, 
				price: {
					required: true 
				}, 
				property_status: {
					required: true 
				}, 
				is_furnished: {
					required: true 
				}, 
				source_of_listing: {
					required: true 
				}
			},
			messages: { 
				title: {
					required: "This is required field" 
				}, 
				description: {
					required: "This is required field" 
				}, 
				property_type: {
					required: "This is required field" 
				}, 
				category_id: {
					required: "This is required field" 
				}, 
				ref_no: {
					required: "This is required field" 
				}, 
				assigned_to_id: {
					required: "This is required field" 
				}, 
				owner_id: {
					required: "This is required field" 
				}, 
				no_of_beds_id: {
					required: "This is required field" 
				}, 
				no_of_baths: {
					required: "This is required field" 
				},   
				property_address: {
					required: "This is required field" 
				}, 
				plot_area: {
					required: "This is required field" 
				}, 
				property_ms_unit: {
					required: "This is required field" 
				}, 
				price: {
					required: "This is required field" 
				}, 
				property_status: {
					required: "This is required field" 
				}, 
				is_furnished: {
					required: "This is required field" 
				}, 
				source_of_listing: {
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
	} 
	</script> 
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