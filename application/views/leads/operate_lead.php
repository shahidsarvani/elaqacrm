<!DOCTYPE html>
<html lang="en">
<head>
<?php 
	$this->load->view('widgets/meta_tags');
	$chk_add_contact_permission =  $this->general_model->check_controller_method_permission_access('Contacts','add',$this->dbs_role_id,'1'); ?>
	<script src="<?= asset_url();?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?= asset_url();?>vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	
	
	
</head>
<body class="pace-done sidebar-xs">
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
			  <script>
				$(document).ready(function(){ 
				<?php
					$cnt_popup_url = 'contacts/contacts_popup_list';
					$cnt_popup_url = site_url($cnt_popup_url); ?>
					$('#modal_remote_contacts').on('show.bs.modal', function() {
						$(this).find('.modal-body').load("<?php echo $cnt_popup_url; ?>", function() {
							 $('.select2').select2({
								  minimumResultsForSearch: Infinity
							  });
						});
					}); 
				});    
				</script>
			  
			<div id="modal_remote_contacts" class="modal fade" role="dialog" tabindex="-1" data-backdrop="true"> 
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h5 class="modal-title">Contacts List</h5>
						</div>
			
						<div class="modal-body"> </div>
			
						<div class="modal-footer">
							<button id="close_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
						</div>
					</div>
				</div>
			</div> 	
					  
                <?php 
					if(isset($args1) && $args1>0){
						$form_act = "leads/operate_lead/".$args1;
					}else{
						$form_act = "leads/operate_lead";
					} ?>
                <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal form-bordered" enctype="multipart/form-data" onSubmit="return operate_custom_validate();">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="lead_ref"> Ref No. <span class="reds">*</span> </label>
                        <div class="col-md-8">
                          <input name="lead_ref" id="lead_ref" type="text" class="form-control" value="<?php if(isset($_POST['lead_ref'])){ echo $_POST['lead_ref']; }else if(isset($record)){ echo stripslashes($record->ref_no); }else{ echo $auto_ref_no; } ?>" readonly>
                          <span class="text-danger"><?php echo form_error('lead_ref'); ?></span> </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="contact_id">Contact <span class="reds">*</span> </label>
                        <div class="col-md-8"> 
						<select name="contact_id" id="contact_id" class="form-control select2-search" data-error="#contact_id1">
							<option value="">Select Contact</option>
							<?php  
								if(isset($contact_arrs)){
									foreach($contact_arrs as $contact_arr){
									$sel_1 = '';
									if(isset($_POST['contact_id']) && $_POST['contact_id']==$contact_arr->id){
										$sel_1 = 'selected="selected"';
									}else if(isset($record) && $record->contact_id==$contact_arr->id){
										$sel_1 = 'selected="selected"';
									} ?>
									<option value="<?= $contact_arr->id; ?>" <?php echo $sel_1; ?>>
									<?= stripslashes($contact_arr->name); ?>
									</option>
									<?php 
									}
								} ?>
						 </select> 
					     <span id="contact_id1" class="text-danger"> <?php echo form_error('contact_id'); ?> </span>
                          
                        </div>
                      </div>
                      <?php 
					if($this->login_vs_user_role_id != 3){ ?>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="assigned_to_id">Agent <span class="reds">*</span></label>
                        <div class="col-md-8">
                          <select name="assigned_to_id" id="assigned_to_id" data-plugin-selectTwo class="form-control select2">
                            <option value="">Select Agent </option>
                            <?php
								$usrid = $this->session->userdata('us_id');     
								if(isset($user_arrs) && count($user_arrs)>0){
									foreach($user_arrs as $user_arr){
									$sel_1 = '';
									if(isset($_POST['assigned_to_id']) && $_POST['assigned_to_id']==$user_arr->id){
										$sel_1 = 'selected="selected"';
									}else if(isset($record) && $record->agent_id==$user_arr->id){
										$sel_1 = 'selected="selected"';
									}else if(isset($usrid) && $usrid==$user_arr->id){
										$sel_1 = 'selected="selected"';
									} ?>
                            <option value="<?= $user_arr->id; ?>" <?php echo $sel_1; ?>>
                            <?= stripslashes($user_arr->name); ?>
                            </option>
                            <?php 
									}
								} ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('assigned_to_id'); ?></span> </div>
                      </div>
                      <?php } ?>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="enquiry_date">Enquiry Date </label>
                        <div class="col-md-4">
                          <?php 
						$enquiry_date = '';
						if(isset($_POST['enquiry_date'])){
							$enquiry_date = $_POST['enquiry_date'];
						}else if(isset($record) && $record->enquiry_date!='0000-00-00'){
							$enquiry_date = $record->enquiry_date;
						}else{
								$enquiry_date = date('Y-m-d');
							}
							
						$enquiry_time = '';
						if(isset($_POST['enquiry_time']) && $_POST['enquiry_time']!=''){
							$enquiry_time = $_POST['enquiry_time'];
						}else if(isset($record) && $record->enquiry_time!=''){
							$enquiry_time = $record->enquiry_time;
						}else{
							$enquiry_time = date("g:i A");
						} ?>
                          <input name="enquiry_date" placeholder="Adjust Enquiry Date" id="enquiry_date" type="text" class="form-control" value="<?php echo $enquiry_date; ?>" style="text-align:center;" readonly>
                          <span class="text-danger"><?php echo form_error('enquiry_date'); ?></span> </div>
                        <div class="col-md-4">
                          <input class="form-control timepicker" placeholder="Adjust Enquiry Time" id="enquiry_time" name="enquiry_time" value="<?php echo $enquiry_time; ?>" style="text-align:center;" readonly>
                          <span class="text-danger"><?php echo form_error('enquiry_time'); ?></span> </div>
                      </div>
					  
					  <script> 
					  	 $(document).ready(function(){   
							$('#enquiry_date').datepicker({
								format: "yyyy-mm-dd"
								}).on('change', function(){
									$('.datepicker').hide();
									//operate_properties();
							});
							
							$('#remind_date_1').datepicker({
								format: "yyyy-mm-dd"
								}).on('change', function(){
									$('.datepicker').hide();
									//operate_properties();
							});
							
							$('#enquiry_time').timepicker();
							
							//$('#enquiry_time').datetimepicker({
								//format: "hh:mm:ss"
								//}).on('change', function(){
									//$('.datepicker').hide();
									//operate_properties();
							//});    
							
							 
							
							
							
							/*$('#to_date').datepicker({
								format: "yyyy-mm-dd"
								}).on('change', function(){
								$('.datepicker').hide();
								//operate_properties();
							});  */
						});
					  </script>
					  
					  
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="lead_type">Lead Type <span class="reds">*</span></label>
                        <div class="col-md-8">
                          <select name="lead_type" id="lead_type" data-plugin-selectTwo class="form-control select2">
                            <option value="">Select </option>
                            <option value="Tenant" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Tenant') || (isset($record) && $record->lead_type=='Tenant')){ echo 'selected="selected"'; } ?>> Tenant </option>
                            <option value="Buyer" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Buyer') || (isset($record) && $record->lead_type=='Buyer')){ echo 'selected="selected"'; } ?>> Buyer </option>
                            <option value="Landlord" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Landlord') || (isset($record) && $record->lead_type=='Landlord')){ echo 'selected="selected"'; } ?>> Landlord </option>
                            <option value="Seller" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Seller') || (isset($record) && $record->lead_type=='Seller')){ echo 'selected="selected"'; } ?>> Seller </option>
                            <option value="Landlord+Seller" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Landlord+Seller') || (isset($record) && $record->lead_type=='Landlord+Seller')){ echo 'selected="selected"'; } ?>> Landlord+Seller </option>
                            <option value="Not Specified" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Not Specified') || (isset($record) && $record->lead_type=='Not Specified')){ echo 'selected="selected"'; } ?>> Not Specified </option>
                          </select>
                          <span class="text-danger"><?php echo form_error('lead_type'); ?></span> </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="lead_status">Status <span class="reds">*</span></label>
                        <div class="col-md-8">
                          <select name="lead_status" id="lead_status" data-plugin-selectTwo class="form-control select2">
                            <option value="">Select </option>
                            <option value="Closed" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Closed') || (isset($record) && $record->lead_status=='Closed')){ echo 'selected="selected"'; } ?>> Closed </option>
                            <option value="Not yet contacted" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Not yet contacted') || (isset($record) && $record->lead_status=='Not yet contacted')){ echo 'selected="selected"'; } ?>> Not yet contacted </option>
                            <option value="Called no reply" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Called no reply') || (isset($record) && $record->lead_status=='Called no reply')){ echo 'selected="selected"'; } ?>> Called no reply </option>
                            <option value="Client not reachable" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Client not reachable') || (isset($record) && $record->lead_status=='Client not reachable')){ echo 'selected="selected"'; } ?>> Client not reachable </option>
                            <option value="Follow up" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Follow up') || (isset($record) && $record->lead_status=='Follow up')){ echo 'selected="selected"'; } ?>> Follow up </option>
                            <option value="Viewing arranged" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Viewing arranged') || (isset($record) && $record->lead_status=='Viewing arranged')){ echo 'selected="selected"'; } ?>> Viewing arranged </option>
                            <option value="Searching for options" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Searching for options') || (isset($record) && $record->lead_status=='Searching for options')){ echo 'selected="selected"'; } ?>> Searching for options </option>
                            <option value="Offer made" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Offer made') || (isset($record) && $record->lead_status=='Offer made')){ echo 'selected="selected"'; } ?>> Offer made </option>
                            <option value="Incorrect contact details" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Incorrect contact details') || (isset($record) && $record->lead_status=='Incorrect contact details')){ echo 'selected="selected"'; } ?>> Incorrect contact details </option>
                            <option value="Invalid inquiry" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Invalid inquiry') || (isset($record) && $record->lead_status=='Invalid inquiry')){ echo 'selected="selected"'; } ?>> Invalid inquiry </option>
                            <option value="Unsuccessful" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Unsuccessful') || (isset($record) && $record->lead_status=='Unsuccessful')){ echo 'selected="selected"'; } ?>> Unsuccessful </option>
                          </select>
                          <span class="text-danger"><?php echo form_error('lead_status'); ?></span> </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="priority">Priority <span class="reds">*</span></label>
                        <div class="col-md-8">
                          <select name="priority" id="priority" data-plugin-selectTwo class="form-control select2">
                            <option value="">Select </option>
                            <option value="Urgent" <?php if((isset($_POST['priority']) && $_POST['priority']=='Urgent') || (isset($record) && $record->priority=='Urgent')){ echo 'selected="selected"'; } ?>> Urgent </option>
                            <option value="High" <?php if((isset($_POST['priority']) && $_POST['priority']=='High') || (isset($record) && $record->priority=='High')){ echo 'selected="selected"'; } ?>> High </option>
                            <option value="Low" <?php if((isset($_POST['priority']) && $_POST['priority']=='Low') || (isset($record) && $record->priority=='Low')){ echo 'selected="selected"'; } ?>> Low </option>
                            <option value="Normal" <?php if((isset($_POST['priority']) && $_POST['priority']=='Normal') || (isset($record) && $record->priority=='Normal')){ echo 'selected="selected"'; } ?>> Normal </option>
                          </select>
                          <span class="text-danger"><?php echo form_error('priority'); ?></span> </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="source_of_listing">Source <span class="reds">*</span> </label>
                        <div class="col-md-8">
                          <select name="source_of_listing" id="source_of_listing" data-plugin-selectTwo class="form-control select2">
                            <option value="">Select </option>
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
                          <span class="text-danger"><?php echo form_error('source_of_listing'); ?></span> </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="no_of_views">Property View </label>
                        <div class="col-md-8">
                          <input name="no_of_views" id="no_of_views" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->no_of_views): set_value('no_of_views'); ?>">
                          <span class="text-danger"><?php echo form_error('no_of_views'); ?></span> </div>
                      </div>
                       
                        <div class="form-group"> 
                          <label class="col-md-3 control-label" for="property_id_1">Property 1 </label>
                          <div class="col-md-8"> 
							<select name="property_id_1" id="property_id_1" class="form-control select2-search" data-error="#property_id_11">
							<option value="">Select Property 1...</option>
							<?php  
								if(isset($properties_arrs)){
									foreach($properties_arrs as $properties_arr){
									$sel_1 = '';
									if(isset($_POST['property_id_1']) && $_POST['property_id_1']==$properties_arr->id){
										$sel_1 = 'selected="selected"';
									}else if(isset($record) && $record->property_id_1==$properties_arr->id){
										$sel_1 = 'selected="selected"';
									}
									 
									$pp_type_1 = ($properties_arr->property_type==1) ? 'Sale: ' : 'Rent: ';
									
									$property_title1 = $pp_type_1 . stripslashes($properties_arr->title).' ('.stripslashes($properties_arr->ref_no).') AED '.number_format($properties_arr->price,2,".",","); ?>
									<option value="<?= $properties_arr->id; ?>" <?php echo $sel_1; ?>> <?= $property_title1; ?> </option>
								<?php 
									}
								} ?>
						 	</select>
						  	<span id="property_id_11" class="text-danger"><?php echo form_error('property_id_1'); ?></span>  
                          </div>
                        </div>
 
 						<div class="form-group"> 
                          <label class="col-md-3 control-label" for="property_id_2">Property 2 </label>
                          <div class="col-md-8"> 
							<select name="property_id_2" id="property_id_2" class="form-control select2-search" data-error="#property_id_21">
							<option value="">Select Property 2...</option>
							<?php  
								if(isset($properties_arrs)){
									foreach($properties_arrs as $properties_arr){
									$sel_1 = '';
									if(isset($_POST['property_id_2']) && $_POST['property_id_2']==$properties_arr->id){
										$sel_1 = 'selected="selected"';
									}else if(isset($record) && $record->property_id_2==$properties_arr->id){
										$sel_1 = 'selected="selected"';
									}
									 
									$pp_type_1 = ($properties_arr->property_type==1) ? 'Sale: ' : 'Rent: ';
									
									$property_title1 = $pp_type_1 . stripslashes($properties_arr->title).' ('.stripslashes($properties_arr->ref_no).') AED '.number_format($properties_arr->price,2,".",","); ?>
									<option value="<?= $properties_arr->id; ?>" <?php echo $sel_1; ?>> <?= $property_title1; ?> </option>
								<?php 
									}
								} ?>
						 	</select>
						  	<span id="property_id_21" class="text-danger"><?php echo form_error('property_id_2'); ?></span>  
                          </div>
                        </div>
						
						<div class="form-group"> 
                          <label class="col-md-3 control-label" for="property_id_3">Property 3 </label>
                          <div class="col-md-8"> 
							<select name="property_id_3" id="property_id_3" class="form-control select2-search" data-error="#property_id_31">
							<option value="">Select Property 3...</option>
							<?php  
								if(isset($properties_arrs)){
									foreach($properties_arrs as $properties_arr){
									$sel_1 = '';
									if(isset($_POST['property_id_3']) && $_POST['property_id_3']==$properties_arr->id){
										$sel_1 = 'selected="selected"';
									}else if(isset($record) && $record->property_id_3==$properties_arr->id){
										$sel_1 = 'selected="selected"';
									}
									
									$pp_type_1 = ($properties_arr->property_type==1) ? 'Sale: ' : 'Rent: ';
									
									$property_title3 = $pp_type_1 . stripslashes($properties_arr->title).' ('.stripslashes($properties_arr->ref_no).') AED '.number_format($properties_arr->price,2,".",","); ?>
									<option value="<?= $properties_arr->id; ?>" <?php echo $sel_1; ?>> <?= $property_title3; ?> </option>
								<?php 
									}
								} ?>
						 	</select>
						  	<span id="property_id_31" class="text-danger"><?php echo form_error('property_id_3'); ?></span>  
                          </div>
                        </div>
						
						<div class="form-group"> 
                          <label class="col-md-3 control-label" for="property_id_4">Property 4 </label>
                          <div class="col-md-8"> 
							<select name="property_id_4" id="property_id_4" class="form-control select2-search" data-error="#property_id_41">
								<option value="">Select Property 4...</option>
								<?php  
									if(isset($properties_arrs)){
										foreach($properties_arrs as $properties_arr){
											$sel_1 = '';
											if(isset($_POST['property_id_4']) && $_POST['property_id_4']==$properties_arr->id){
												$sel_1 = 'selected="selected"';
											}else if(isset($record) && $record->property_id_4==$properties_arr->id){
												$sel_1 = 'selected="selected"';
											}
										 
											$pp_type_1 = ($properties_arr->property_type==1) ? 'Sale: ' : 'Rent: ';
										
											$property_title4 = $pp_type_1 . stripslashes($properties_arr->title).' ('.stripslashes($properties_arr->ref_no).') AED '.number_format($properties_arr->price,2,".",","); ?>
											<option value="<?= $properties_arr->id; ?>" <?php echo $sel_1; ?>> <?= $property_title4; ?> </option>
									<?php 
										}
									} ?>
						 	</select>
						  	<span id="property_id_41" class="text-danger"><?php echo form_error('property_id_4'); ?></span>  
                          </div>
                        </div>  
	  
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="reminds">Remind </label>
                        <div class="col-md-8">
                          <select name="reminds" id="reminds" data-plugin-selectTwo class="form-control select2" onChange="operate_remind_area(this.value);">
                            <option value="0" <?php if((isset($_POST['reminds']) && $_POST['reminds']==0) || (isset($record) && $record->reminds==0)){ echo 'selected="selected"'; } ?>> Never </option>
                            <option value="1" <?php if((isset($_POST['reminds']) && $_POST['reminds']==1) || (isset($record) && $record->reminds==1)){ echo 'selected="selected"'; } ?>> Yes </option>
                          </select>
                          <span class="text-danger"><?php echo form_error('reminds'); ?></span> </div>
                      </div>
                      <script>
					function operate_remind_area(valss){
						if(valss==1){ 
							document.getElementById('remind_area').style.display='';
						}else{
							document.getElementById('remind_area').style.display='none';
						} 
					} 
				</script>
                      <?php 
						if((isset($_POST['reminds']) && $_POST['reminds']==1) || (isset($record) && $record->reminds==1)){ 
							$remd_style ='style="display: ;"';
						}else{
							$remd_style ='style="display:none;"';
						} ?>
                      <span id="remind_area" <?php echo $remd_style; ?>> <br>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="remind_date">Date </label>
                        <div class="col-md-4">
                          <?php 
							 $remind_date_1 = '';
							if(isset($record) && $record->remind_date_1!='0000-00-00'){
								$remind_date_1 = $record->remind_date_1;
							}else if(isset($_POST['remind_date_1'])){
									$remind_date_1 = $_POST['remind_date_1'];
								} ?>
                          <input name="remind_date_1" id="remind_date_1" placeholder="Adjust Reminder Date" type="text" class="form-control" value="<?php echo $remind_date_1; ?>" style="text-align:center;">
                          <span class="text-danger"><?php echo form_error('remind_date_1'); ?></span> </div>
                        <div class="col-md-4">
                          <input class="form-control" placeholder="Adjust Reminder Time" id="remind_time_1" name="remind_time_1" data-plugin-timepicker value="<?php echo (isset($record) && $record->remind_time_1!='') ? $record->remind_time_1 : set_value('remind_time_1'); ?>" style="text-align:center;">
                          <span class="text-danger"><?php echo form_error('remind_time_1'); ?></span> </div>
                      </div>
                      <br>
                      </span>
                      
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="notes">Notes </label>
                        <div class="col-md-8">
                          <textarea name="notes" id="notes" class="form-control" rows="6"><?php echo (isset($record)) ? stripslashes($record->notes): set_value('notes'); ?></textarea>
                          <span class="text-danger"><?php echo form_error('notes'); ?></span> </div>
                      </div>
                    </div>
                  </div>
                  <!--data-error="#email1"  id="email1"	-->
		 	 <br>
		  <div class="form-group">
			<label class="col-md-2 control-label"></label>
			<div class="col-md-6">
			  <?php if(isset($record)){	?>
			  <input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>">
			  <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="updates" id="updates"><i class="glyphicon glyphicon-ok position-left"></i>Update</button>
			  <?php }else{	?>
			  <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves" id="saves"><i class="glyphicon glyphicon-ok position-left"></i>Save</button>
			   
			  <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves_and_new" id="save_and_new"><i class="glyphicon glyphicon-repeat position-left"></i>Save & New</button>
			   
			  <button type="reset" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button>
			  <?php }	?>
			  &nbsp;
			  <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('leads/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button>
			</div>
		  </div>
		</form> 		
	<script type="text/javascript">	
	function operate_custom_validate(){	
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
	}
			 
		function operate_remind_area(valss){
			if(valss==1){ 
				document.getElementById('remind_area').style.display='';
			}else{
				document.getElementById('remind_area').style.display='none';
			} 
		} 
        		  
		/*$(document).ready(function(){   
			$('#remind_date_1').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_leads_properties();
			});   
		}); */
			
	<?php 
		$get_contact_info_url = 'contacts/operate_contact_info/';
		$get_contact_info_url = site_url($get_contact_info_url); ?>
			
		function operate_contact_info(sels_vals){
			$(document).ready(function(){
				$.ajax({
					url: '<?php echo $get_contact_info_url; ?>'+sels_vals,
					cache: false,
					type: 'POST',
					data: { 'submits':1 },
					success: function (result,status,xhr) { 
						document.getElementById("fetch_contacts_info").innerHTML = result;  
					}
				});
			});
		}     		
		<?php 
			if(strlen($remind_date_1)>0){
				/* ok */
			}else{ ?> 
			$(document).ready(function(){ 
				document.getElementById("remind_date_1").value ='';
				document.getElementById("remind_time_1").value ='';
			});
		<?php 
			}   
			if(strlen($enquiry_date)>0){
				/* ok */
			}else{ ?>
		 
			/* $(document).ready(function(){ 
				document.getElementById("enquiry_date").value ='';
				document.getElementById("enquiry_time").value ='';
			});	 */
			 
		<?php } ?>
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
