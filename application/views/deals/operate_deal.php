<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/meta_tags'); ?> 
<link rel="stylesheet" href="<?= asset_url(); ?>vendor/dropzone/css/basic.css" />
<link rel="stylesheet" href="<?= asset_url(); ?>vendor/dropzone/css/dropzone.css" /> 
<script src="<?= asset_url(); ?>vendor/dropzone/dropzone.js"></script>
<script src="<?= asset_url(); ?>js/jquery-ui.js"></script>
<script src="<?= asset_url();?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
</head>
<body class="pace-running sidebar-xs">
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
			if(isset($args1) && $args1>0){
				$form_act = "deals/operate_deal/{$args0}/".$args1;
			}else if(isset($args0) && $args0>0){
				$form_act = "deals/operate_deal/{$args0}";
			}else{
				$form_act = "deals/operate_deal";
			} ?>
		  <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal form-bordered" enctype="multipart/form-data"> 
		<div class="row">
		  <div class="col-lg-6"> 
		  
		  	<div class="form-group">
				<label class="col-md-3 control-label" for="property_id"> Property <span class="reds"> *</span></label>
				<div class="col-md-8">
					 <span id="fetch_remote_property">
					   <select name="property_id" id="property_id" class="form-control select2-search" data-error="#property_id1">
						<option value="">Select Property...</option>
						<?php  
							if(isset($properties_arrs)){
								foreach($properties_arrs as $properties_arr){
								$sel_1 = '';
								if(isset($_POST['property_id']) && $_POST['property_id']==$properties_arr->id){
									$sel_1 = 'selected="selected"';
								}else if(isset($record) && $record->property_id==$properties_arr->id){
									$sel_1 = 'selected="selected"';
								}
								 
								$pp_type_1 = ($properties_arr->property_type==1) ? 'Sale: ' : 'Rent: ';
								
								$property_title1 = $pp_type_1 . stripslashes($properties_arr->title).' ('.stripslashes($properties_arr->ref_no).') AED '.number_format($properties_arr->price,2,".",","); ?>
								<option value="<?= $properties_arr->id; ?>" <?php echo $sel_1; ?>> <?= $property_title1; ?> </option>
							<?php 
								}
							} ?>
						</select> 
					 </span>
					<a data-toggle="modal" data-target="#show_remote_property_modal"><i class="glyphicon glyphicon-plus position-left"></i> Add Property </a>   
				   <span id="property_id1" class="text-danger"><?php echo form_error('property_id'); ?></span> </div>
			  </div>  
		  
			<div class="form-group">
			  <label class="col-md-3 control-label" for="ref_no"> Ref No. <span class="reds">*</span> </label>
			  <div class="col-md-8">
				<input name="ref_no" id="ref_no" type="text" class="form-control" value="<?php if(isset($_POST['ref_no'])){ echo $_POST['ref_no']; }else if(isset($record)){ echo stripslashes($record->ref_no); }else{ echo $auto_ref_no; } ?>" readonly>
				<span class="text-danger"><?php echo form_error('ref_no'); ?></span> 
			  </div>  
			</div>
			  
			<input type="hidden" name="types" id="types" value="<?php if(isset($record) && $record->types >0){ echo $record->types; }else if(isset($args0) && $args0 >0){ echo $args0; } ?>">
			  
			<input type="hidden" name="owner_id" id="owner_id" class="form-control populate" value="<?php if(isset($_POST['owner_id']) && $_POST['owner_id'] >0){ echo $_POST['owner_id']; }else if(isset($record) && $record->owner_id >0){ echo $record->owner_id; } ?>">
	   <?php
			$cxt = '';
			if(isset($args0) && $args0==2){ 
				$cxt = 'Tenant'; 
			}else{ 
				$cxt = 'Buyer'; 
			}  
			$ld_cnt_name = "Select {$cxt} "; ?>  
			  
			<span class="text-danger" style="clear:both; float:left"><?php //echo form_error('contact_id1'); ?></span>
			<input type="hidden" id="contact_id1" name="contact_id1" value="1">  
		
		<div class="form-group">
			<label class="col-md-3 control-label" for="lead_id"> <?php if(isset($args0) && $args0==2){ echo 'Tenant'; }else{ echo 'Buyer'; } ?> <span class="reds"> *</span></label>
			<div class="col-md-8">
				 <span id="fetch_remote_leads" data-title="<?php echo $cxt; ?>">
				   <select name="lead_id" id="lead_id" class="form-control select2-search" data-error="#lead_id1">
					<option value=""> <?php echo $ld_cnt_name; ?> </option>
					<?php  
						if(isset($lead_arrs)){
							foreach($lead_arrs as $lead_arr){
							$sel_1 = '';
							if(isset($_POST['lead_id']) && $_POST['lead_id']==$lead_arr->id){
								$sel_1 = 'selected="selected"';
							}else if(isset($record) && $record->lead_id==$lead_arr->id){
								$sel_1 = 'selected="selected"';
							}  ?>
							<option value="<?= $lead_arr->id; ?>" <?php echo $sel_1; ?>> <?=  $lead_arr->ref_no; ?> </option>
						<?php 
							}
						} ?>
					</select> 
				 </span>
				<a data-toggle="modal" data-target="#show_remote_lead_modal"><i class="glyphicon glyphicon-plus position-left"></i> Add <?php if(isset($args0) && $args0==2){ echo 'Tenant'; }else{ echo 'Buyer'; } ?> </a>   
			   <span id="lead_id1" class="text-danger"><?php echo form_error('lead_id'); ?></span> </div>
		  </div> 
		  			  			
			<div class="form-group">
			  <label class="col-md-3 control-label" for="status">Status <span class="reds">*</span></label>
			  <div class="col-md-8">  
				<select name="status" id="status" data-plugin-selectTwo class="form-control select2">
				  <option value="">Select </option>
				  <option value="Pending" <?php if((isset($_POST['status']) && $_POST['status']=='Pending') || (isset($record) && $record->status=='Pending')){ echo 'selected="selected"'; } ?>> Pending </option>
				  <option value="Open" <?php if((isset($_POST['status']) && $_POST['status']=='Open') || (isset($record) && $record->status=='Open')){ echo 'selected="selected"'; } ?>> Open </option> 
				  <option value="Closed" <?php if((isset($_POST['status']) && $_POST['status']=='Closed') || (isset($record) && $record->status=='Closed')){ echo 'selected="selected"'; } ?>> Closed </option>
				  <option value="Cancelled" <?php if((isset($_POST['status']) && $_POST['status']=='Cancelled') || (isset($record) && $record->status=='Cancelled')){ echo 'selected="selected"'; } ?>> Cancelled </option>
				</select>
				<span class="text-danger"><?php echo form_error('status'); ?></span> </div>
			</div> 
						
			<div class="form-group">
				<label class="col-md-3 control-label" for="deal_price">Deal Price </label>
				<div class="col-md-8">
				<div class="input-group">
				  <span id="fetch_property_deal_price">
				  <input name="deal_price" id="deal_price" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->deal_price): set_value('deal_price'); ?>" onKeyUp="price_commission_calculate();" onBlur="price_commission_calculate();">
				  </span>
				  <span class="input-group-addon">AED</span> <span class="text-danger"><?php echo form_error('deal_price'); ?></span> </div>
				</div>
			</div>   
			   <?php 
				   $calc_prec = "(0%)";  
				   if((isset($_POST['deal_price']) && $_POST['deal_price']>0) && (isset($_POST['deposit']) && $_POST['deposit']>0)){
					   $deal_price_val = $_POST['deal_price'];
					   $deposit_val = $_POST['deposit'];
					   
					   $calc_prec = $deposit_val / $deal_price_val ; 
					   $calc_prec = $calc_prec * 100; 
					   $calc_prec = number_format("$calc_prec",0);
					   $calc_prec = "(".$calc_prec."%)"; 
					   
				   }else if((isset($record) && $record->deal_price>0) && (isset($record) && $record->deposit>0)){
					   $deal_price_val = $record->deal_price;
					   $deposit_val = $record->deposit;
					   
					   $calc_prec = $deposit_val / $deal_price_val; 
					   $calc_prec = $calc_prec * 100; 
					   $calc_prec = number_format("$calc_prec",0);
					   $calc_prec = "(".$calc_prec."%)";   
					   
				   } 
				   
				   $calc_prec2 = "(0%)";  
				   if((isset($_POST['deal_price']) && $_POST['deal_price']>0) && (isset($_POST['commission']) && $_POST['commission']>0)){
					   $deal_price_val = $_POST['deal_price'];
					   $commission_val = $_POST['commission'];
					   
					   $calc_prec2 = $commission_val / $deal_price_val ; 
					   $calc_prec2 = $calc_prec2 * 100; 
					   
					   $calc_prec2 = number_format("$calc_prec2",0);
					   $calc_prec2 = "(".$calc_prec2."%)"; 
					   
				   }else if((isset($record) && $record->deal_price>0) && (isset($record) && $record->deposit>0)){
					   $deal_price_val = $record->deal_price; 
					   $commission_val = $record->commission;  
						
					   $calc_prec2 = $commission_val / $deal_price_val ; 
					   $calc_prec2 = $calc_prec2 * 100; 
					   
					   $calc_prec2 = number_format("$calc_prec2",0);
					   $calc_prec2 = "(".$calc_prec2."%)"; 
				   }  
					?>  
					<div class="form-group">
					<label class="col-md-3 control-label" for="deposit">Deposit <span id="deposit_txt"><?php echo $calc_prec; ?></span></label>
					<div class="col-md-8">
					<div class="input-group">
					  <input name="deposit" id="deposit" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->deposit): set_value('deposit'); ?>" onKeyUp="deposit_commission_calculate();" onBlur="deposit_commission_calculate();">
					  <span class="input-group-addon">AED</span> 
					  <span class="text-danger"><?php echo form_error('deposit'); ?></span> </div>
					</div>
					</div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="commission">Commission <span id="commission_txt"><?php echo $calc_prec2; ?></span></label>
					<div class="col-md-8">
					<div class="input-group">
					  <input name="commission" id="commission" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->commission): set_value('commission'); ?>" onKeyUp="deposit_commission_calculate();" onBlur="deposit_commission_calculate();">
					  <span class="input-group-addon">AED</span> <span class="text-danger"><?php echo form_error('commission'); ?></span> </div>
					</div>
					</div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="agent1_id">Agent 1 <span class="reds">*</span> </label>
					<div class="col-md-8">
					<select name="agent1_id" id="agent1_id" class="form-control select2">
					  <option value="">Select Agent </option>
					  <?php  
						if(isset($user_arrs) && count($user_arrs)>0){
							foreach($user_arrs as $user_arr){
								$sel_1 = '';
								if(isset($_POST['agent1_id']) && $_POST['agent1_id']==$user_arr->id){
									$sel_1 = 'selected="selected"';
								}else if(isset($record) && $record->agent1_id==$user_arr->id){
									$sel_1 = 'selected="selected"';
								} ?>
							  <option value="<?= $user_arr->id; ?>" <?php echo $sel_1; ?>>
							  <?= stripslashes($user_arr->name); ?>
							  </option>
						  <?php 
							}
						} ?>
					</select>
					<span class="text-danger"><?php echo form_error('agent1_id'); ?></span> </div>
					</div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="agent1_commission_percentage">Commission </label>
					<div class="col-md-4">
					<div class="input-group">
					  <input name="agent1_commission_percentage" id="agent1_commission_percentage" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->agent1_commission_percentage): set_value('agent1_commission_percentage'); ?>" onKeyUp="agent_commission_calculate();" onBlur="agent_commission_calculate();">
					  <span class="input-group-addon">%</span> </div>
					<span class="text-danger"><?php echo form_error('agent1_commission_percentage'); ?></span> </div>
					<div class="col-md-4">
					<div class="input-group">
					  <input name="agent1_commission_value" id="agent1_commission_value" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->agent1_commission_value): set_value('agent1_commission_value'); ?>">
					</div>
					<span class="text-danger"><?php echo form_error('agent1_commission_value'); ?></span> </div>
					</div>
					
	 
				 <div class="form-group">
				  <label class="col-md-3 control-label" for="agent2_id"> Agent 2 </label>
				  <div class="col-md-8">
					<div id="fetch_new_owners">
						<select name="agent2_id" id="agent2_id" class="form-control select2">
						  <option value=""> Select Agent </option>
						  <?php  
							if(isset($user_arrs) && count($user_arrs)>0){
								foreach($user_arrs as $user_arr){
									$sel_1 = '';
									if(isset($_POST['agent2_id']) && $_POST['agent2_id']==$user_arr->id){
										$sel_1 = 'selected="selected"';
									}else if(isset($record) && $record->agent2_id==$user_arr->id){
										$sel_1 = 'selected="selected"';
									} ?>
									<option value="<?= $user_arr->id; ?>" <?php echo $sel_1; ?>>
									<?= stripslashes($user_arr->name); ?>
									</option>
							  <?php 
								}
							} ?>
						</select> 
					</div>
					<span class="text-danger"><?php echo form_error('agent2_id'); ?></span> 
				  </div>
				</div>
				   
					<div class="form-group">
					<label class="col-md-3 control-label" for="agent2_commission_percentage">Commission </label>
					<div class="col-md-4">
					<div class="input-group">
					  <input name="agent2_commission_percentage" id="agent2_commission_percentage" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->agent2_commission_percentage): set_value('agent2_commission_percentage'); ?>" onKeyUp="agent_commission_calculate();" onBlur="agent_commission_calculate();">
					  <span class="input-group-addon">%</span> </div>
					<span class="text-danger"><?php echo form_error('agent2_commission_percentage'); ?></span> </div>
					<div class="col-md-4">
					<div class="input-group">
					  <input name="agent2_commission_value" id="agent2_commission_value" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->agent2_commission_value): set_value('agent2_commission_value'); ?>">
					</div>
					<span class="text-danger"><?php echo form_error('agent2_commission_value'); ?></span> </div>
					</div> 
				  </div>
				  <div class="col-lg-6"> 
					<div class="form-group">
					<label class="col-md-3 control-label" for="est_deal_date">Estimated Date </label>
					<div class="col-md-8">
					<?php 
						if(isset($record) && $record->est_deal_date!='0000-00-00'){
							$est_deal_date = $record->est_deal_date;
						}else if(isset($_POST['est_deal_date'])){
								$est_deal_date = $_POST['est_deal_date'];
							}else{
								$est_deal_date = date('Y-m-d');
							}  ?>
					<input name="est_deal_date" id="est_deal_date" type="text" class="form-control picks-date" value="<?php echo $est_deal_date; ?>" style="text-align:center;" readonly="true" />
					<span class="text-danger"><?php echo form_error('est_deal_date'); ?></span> </div>
					</div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="act_deal_date">Actual Deal Date </label>
					<div class="col-md-8">
					<?php 
						if(isset($record) && $record->act_deal_date!='0000-00-00'){
							$act_deal_date = $record->act_deal_date;
						}else if(isset($_POST['act_deal_date'])){
								$act_deal_date = $_POST['act_deal_date'];
							}else{
								$act_deal_date = date('Y-m-d');
							}  ?>
					<input name="act_deal_date" id="act_deal_date" type="text" class="form-control picks-date" value="<?php echo $act_deal_date; ?>" style="text-align:center;" readonly="true" />
					<span class="text-danger"><?php echo form_error('act_deal_date'); ?></span> </div>
					</div>
					<span id="fetch_prop_brief">
					  <div class="form-group">
						<label class="col-md-3 control-label" for="unit_no">Unit No </label>
						<div class="col-md-8">
						  <input name="unit_no" id="unit_no" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->unit_no): set_value('unit_no'); ?>">
						  <span class="text-danger"><?php echo form_error('unit_no'); ?></span> </div>
					  </div>
					  <div class="form-group">
						<label class="col-md-3 control-label" for="category_id"> Category </label>
						<div class="col-md-8" id="fetch_cates_list">
						  <select name="category_id" id="category_id" class="form-control select2-search">
							<option value="">Category Name</option>
							<?php   			  
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
						  <span class="text-danger"><?php echo form_error('category_id'); ?></span> </div>
					  </div>
					  <div class="form-group">
						<label class="col-md-3 control-label" for="no_of_beds_id">No. of Bedrooms </label>
						<div class="col-md-8">
						  <select name="no_of_beds_id" id="no_of_beds_id" class="form-control select2-search">
							<option value="">Select No. of Bedrooms</option>
							<?php  
								if(isset($beds_arrs) && count($beds_arrs)>0){
									foreach($beds_arrs as $beds_arr){
										$sel_1 = '';
										if(isset($_POST['no_of_beds_id']) && $_POST['no_of_beds_id']==$beds_arr->id){
											$sel_1 = 'selected="selected"';
										}else if(isset($record) && $record->no_of_beds_id==$beds_arr->id){
											$sel_1 = 'selected="selected"';
										} ?>
										<option value="<?= $beds_arr->id; ?>" <?php echo $sel_1; ?>>
											<?= stripslashes($beds_arr->title); ?>
										</option>
										<?php 
									}
								} ?>
						  </select>
						  <span class="text-danger"><?php echo form_error('no_of_beds_id'); ?></span> </div>
					  </div> 
					  <div class="form-group">
						<label class="col-md-3 control-label" for="emirate_id">Emirate(s) </label>
						<div class="col-md-8">
						<?php 
							if(isset($record) && $record->emirate_id >0){
								$sel_emirate_ids = $record->emirate_id;
							}else{
								$sel_emirate_ids = 3;
							} ?>
					  <select name="emirate_id" id="emirate_id" class="form-control select2-search" onChange="get_emirate_location(this.value,'<?php echo site_url('properties/fetch_emirate_locations'); ?>','fetch_emirate_locations');">
						<option value="">Select Emirate </option>
						<?php  
						if(isset($emirate_arrs) && count($emirate_arrs)>0){
							foreach($emirate_arrs as $emirate_arr){
								$sel_1 = '';
								if(isset($_POST['emirate_id']) && $_POST['emirate_id']==$emirate_arr->id){
									$sel_1 = 'selected="selected"';
								}else if(isset($sel_emirate_ids) && $sel_emirate_ids==$emirate_arr->id){
									$sel_1 = 'selected="selected"';
								} ?>
								<option value="<?= $emirate_arr->id; ?>" <?php echo $sel_1; ?>>
								<?= stripslashes($emirate_arr->name); ?>
								</option>
								<?php 
							}
						} ?>
						  </select>
						  <span class="text-danger"><?php echo form_error('emirate_id'); ?></span> </div>
					  </div>
					  <div class="form-group">
						<label class="col-md-3 control-label" for="location_id"> Location(s) </label>
						<div class="col-md-8"> <span id="fetch_emirate_locations">
						  <select name="location_id" id="location_id" class="form-control select2-search" onChange="get_emirate_sub_location(this.value,'<?php echo site_url('properties/fetch_emirate_sub_locations'); ?>','fetch_emirate_sub_locations');">
							<option value="">Select Emirate Location </option>
						<?php  
							$emirate_location_arrs = $this->admin_model->fetch_emirate_locations($sel_emirate_ids);
							if(isset($emirate_location_arrs) && count($emirate_location_arrs)>0){
								foreach($emirate_location_arrs as $emirate_location_arr){
									$sel_1 = '';
									if(isset($_POST['location_id']) && $_POST['location_id']==$emirate_location_arr->id){
										$sel_1 = 'selected="selected"';
									}else if(isset($record) && $record->location_id==$emirate_location_arr->id){
										$sel_1 = 'selected="selected"';
									}  ?>
									<option value="<?= $emirate_location_arr->id; ?>" <?php echo $sel_1; ?>>
									<?= stripslashes($emirate_location_arr->name); ?>
									</option>
									<?php 
								}
							}  ?>
						  </select>
						  </span> <span class="text-danger"><?php echo form_error('location_id'); ?></span> </div>
					  </div>
					  <div class="form-group">
						<label class="col-md-3 control-label" for="sub_location_id"> Sub Location(s) </label>
						<div class="col-md-8"> <span id="fetch_emirate_sub_locations">
						  <select name="sub_location_id" id="sub_location_id" class="form-control select2-search">
							<option value="">Select Emirate Sub Location </option>
							<?php 
							$tmps_location_id='';
							if(isset($_POST['location_id']) && strlen($_POST['location_id'])>0){
								$tmps_location_id = $_POST['location_id'];
							}else if(isset($record->location_id) && $record->location_id>0){
								$tmps_location_id = $record->location_id;
							}
							
							$emirate_sub_location_arrs = $this->admin_model->fetch_emirate_sub_locations($tmps_location_id);
							if(isset($emirate_sub_location_arrs) && is_array($emirate_sub_location_arrs)){
								foreach($emirate_sub_location_arrs as $emirate_sub_location_arr){ 
									$sel_1 = '';
									if(isset($_POST['sub_location_id']) && $_POST['sub_location_id']==$emirate_sub_location_arr->id){
										$sel_1 = 'selected="selected"';
									}else if(isset($record) && $record->sub_location_id==$emirate_sub_location_arr->id){
										$sel_1 = 'selected="selected"';
									} ?>
									<option value="<?= $emirate_sub_location_arr->id; ?>" <?php echo $sel_1; ?>>
									<?= stripslashes($emirate_sub_location_arr->name); ?>
									</option>
								<?php 
								}
							}  ?>
						  </select>
						  </span> <span class="text-danger"><?php echo form_error('sub_location_id'); ?></span> </div>
					  </div>
					  </span> <br>
					  
					<div class="form-group" id="fetch_renewal_date" <?php echo ((isset($_POST['types']) && $_POST['types']==2) || (isset($record) && $record->types==2)) ? '':'style="display:none;"' ?>>
					<label class="col-md-3 control-label" for="renewal_date">Tenancy Renewal Date</label>
					<div class="col-md-8">
				<?php 
					if(isset($record) && $record->renewal_date!='0000-00-00'){
						$renewal_date = $record->renewal_date;
					}else if(isset($_POST['renewal_date'])){
						$renewal_date = $_POST['renewal_date'];
					}else{
						$renewal_date = date('Y-m-d');
					}  ?>
					  <input name="renewal_date" id="renewal_date" type="text" class="form-control" value="<?php	 echo $renewal_date; ?>" style="text-align:center;">
					  <span class="text-danger"><?php echo form_error('renewal_date'); ?></span> </div>
					</div> 
					<div class="form-group" id="fetch_set_reminder" <?php echo ((isset($_POST['types']) && $_POST['types']=='Rental') || (isset($record) && $record->types=='Rental')) ? '':'style="display:none;"' ?>>
					<label class="col-md-3 control-label" for="set_reminder">Set Reminder </label>
					<div class="col-md-8">
					  <select name="set_reminder" id="set_reminder" data-plugin-selectTwo class="form-control select2">
						<option value="">Select </option>
						<option value="Never" <?php if((isset($_POST['set_reminder']) && $_POST['set_reminder']=='Never') || (isset($record) && $record->set_reminder=='Never')){ echo 'selected="selected"'; } ?>> Never </option>
						<option value="1 Day Before" <?php if((isset($_POST['set_reminder']) && $_POST['set_reminder']=='1 Day Before') || (isset($record) && $record->set_reminder=='1 Day Before')){ echo 'selected="selected"'; } ?>> 1 Day Before </option>
						<option value="1 Week Before" <?php if((isset($_POST['set_reminder']) && $_POST['set_reminder']=='1 Week Before') || (isset($record) && $record->set_reminder=='1 Week Before')){ echo 'selected="selected"'; } ?>> 1 Week Before </option>
						<option value="1 Month Before" <?php if((isset($_POST['set_reminder']) && $_POST['set_reminder']=='1 Month Before') || (isset($record) && $record->set_reminder=='1 Month Before')){ echo 'selected="selected"'; } ?>> 1 Month Before </option>
						<option value="2 Months Before" <?php if((isset($_POST['set_reminder']) && $_POST['set_reminder']=='2 Months Before') || (isset($record) && $record->set_reminder=='2 Months Before')){ echo 'selected="selected"'; } ?>> 2 Months Before </option>
						<option value="3 Months Before" <?php if((isset($_POST['set_reminder']) && $_POST['set_reminder']=='3 Months Before') || (isset($record) && $record->set_reminder=='3 Months Before')){ echo 'selected="selected"'; } ?>> 3 Months Before </option>
					  </select>
					  <span class="text-danger"><?php echo form_error('set_reminder'); ?></span> </div>
				  </div> 
			   </div>
			</div>
		
			<div class="panel-heading">
				<h5 class="panel-title"> Other Details </h5>
			</div>			  

			<div class="row">
				<div class="col-lg-12">   
 
					<div class="tabs m-t-40 jui-tabs-basic">
						  <ul class="nav nav-tabs"> 
							<li class="active"> <a href="#w1-notes" data-toggle="tab">Notes</a> </li>
							<li> <a href="#w1-seller-landlord" data-toggle="tab"><?php echo (isset($args0) && $args0==1) ? 'Seller' : 'Landlord'; ?></a> </li>
							<li> <a href="#w1-buyer-tenant" data-toggle="tab"><?php echo (isset($args0) && $args0==1) ? 'Buyer' : 'Tenant'; ?> </a> </li>
							<li> <a href="#w1-deals-documents" data-toggle="tab">Deals documents</a> </li>
							<li> <a href="#w1-new-title-deed" data-toggle="tab">New Title Deed</a> </li>
							<li> <a href="#w1-agency-documents" data-toggle="tab">Agency documents</a> </li>
						  </ul>
						  <div class="tab-content">
							 
							<div class="tab-pane active" id="w1-notes">
							  
							  <div class="form-group">
								<label class="col-md-1 control-label" for="notes">Notes <span class="reds">*</span> </label>
								<div class="col-md-6">
								  <textarea name="notes" id="notes" class="form-control" rows="6"><?php echo (isset($record)) ? stripslashes($record->notes): set_value('notes'); ?></textarea>
								  <span class="text-danger"><?php echo form_error('notes'); ?></span> </div>
							  </div>
							</div>
							
							<div class="tab-pane" id="w1-seller-landlord"> 
							  <div class="form-group">
								<label class="col-md-2 control-label" for="sellerlandlordfiles"><?php echo (isset($args0) && $args0==1) ? 'Seller' : 'Landlord'; ?>  </label>
								<div class="col-md-9">
								  <div id="sellerlandlordfiles" class="dropzone dropzone-previews"></div>
								  <br>
								</div>
							  </div> 
							</div>
							
							<div class="tab-pane" id="w1-buyer-tenant"> 
							  <div class="form-group">
								<label class="col-md-2 control-label" for="buyertenantfiles"><?php echo (isset($args0) && $args0==1) ? 'Buyer' : 'Tenant'; ?> </label>
								<div class="col-md-9">
								  <div id="buyertenantfiles" class="dropzone dropzone-previews"></div>
								  <br>
								</div>
							  </div> 
							</div>
							<div class="tab-pane" id="w1-deals-documents"> 
							  <div class="form-group">
								<label class="col-md-2 control-label" for="documentsfiles">Deals documents </label>
								<div class="col-md-9">
								  <div id="documentsfiles" class="dropzone dropzone-previews"></div>
								  <br>
								</div>
							  </div> 
							</div>
							<div class="tab-pane" id="w1-new-title-deed"> 
							  <div class="form-group">
								<label class="col-md-2 control-label" for="newtitledeedfiles">New Title Deed </label>
								<div class="col-md-9">
								  <div id="newtitledeedfiles" class="dropzone dropzone-previews"></div>
								  <br>
								</div>
							  </div> 
							</div>
							<div class="tab-pane" id="w1-agency-documents"> 
							  <div class="form-group">
								<label class="col-md-2 control-label" for="agencydocumentsfiles">Agency documents </label>
								<div class="col-md-9">
								  <div id="agencydocumentsfiles" class="dropzone dropzone-previews"></div>
								  <br>
								</div>
							  </div> 
							</div> 
							
						  </div>
						</div>
				</div>
			</div>	
					 
			<footer class="panel-footer center">
			 <input type="hidden" name="args0" id="args0" value="<?php echo isset($args0) ? $args0 : ''; ?>"> 
			  <?php if(isset($record)){	?>
			  <input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>">
			  <button type="submit" name="updates" id="operate_deal_submit_form" class="btn btn-primary btn-lg">Update</button>
			  <?php }else{	?>
			  <button type="submit" name="adds" id="operate_deal_submit_form" class="btn btn-primary btn-lg">Add</button>
			  <button type="reset" class="btn btn-default btn-lg">Clear</button>
			  <?php }	?>
			  <button type="button" class="btn btn-default btn-lg" onClick="window.location='<?php echo ($args0 == 1) ? site_url('deals/sales_listing/') : site_url('deals/rental_listing/'); ?>';">Cancel</button>
			</footer>
		  </form>
			  
			  </div>
            </div>
            <!-- /horizotal form -->
          </div>
        </div>
        <!-- /dashboard content -->
		
		<div id="show_remote_property_modal" class="modal fade" data-backdrop="false"> 
			<div class="modal-dialog modal-full">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h5 class="modal-title">Properties List</h5>
					</div>
			
					<div class="modal-body"></div>
			
					<div class="modal-footer"> <!-- id="close_users_modals" -->
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
					</div>
				</div>
			</div>
		</div>
		
		<div id="show_remote_lead_modal" class="modal fade" data-backdrop="false"> 
			<div class="modal-dialog modal-full">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h5 class="modal-title">Leads List</h5>
					</div>
			
					<div class="modal-body"></div>
			
					<div class="modal-footer"> <!-- id="close_users_modals" -->
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
					</div>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">	 
			$(document).ready(function(){ 
			<?php
				$usr_popup_url_1 = 'properties/properties_popup_list/0/';
				$usr_popup_url_1 = site_url($usr_popup_url_1);  ?> 
				 
				$('#show_remote_property_modal').on('show.bs.modal', function() {
					$(this).find('.modal-body').load('<?php echo $usr_popup_url_1; ?>', function() {
			 
						if($('.select2-search').length >0){
							$('.select2-search').select2();
						}
					});
				}); 
				
			<?php
				$lead_popup_url_1 = 'leads/leads_popup_list/';
				$lead_popup_url_1 = site_url($lead_popup_url_1);  ?> 
				 
				$('#show_remote_lead_modal').on('show.bs.modal', function() {
					$(this).find('.modal-body').load('<?php echo $lead_popup_url_1; ?>', function() {
			 
						if($('.select2-search').length >0){
							$('.select2-search').select2();
						}
					});
				}); 				
			}); 
					
			function clickeds_properties(sels_vals) {  
				$(document).ready(function(){
				<?php  
					$tmp_usr_pth1 = '/properties/fetch_properties_list/';
					$tmp_usr_pth1 = site_url($tmp_usr_pth1); ?> 
					$.ajax({
						url: '<?php echo $tmp_usr_pth1; ?>',
						cache: false,
						type: 'POST', 
						data: { 'submits':1, sl_propertyid: sels_vals, paras1: '0' },
						success: function (result, status, xhr){ 
							$("#fetch_remote_property").html(result);
							
							if($('.select2-search').length >0){ 
								$('.select2-search').select2();
							}
						}
					});    
				}); 
			}  
			
			function clickeds_leads(sels_vals) {  
				$(document).ready(function(){ 
				<?php  
					$tmp_usr_pth1 = '/leads/fetch_leads_list/';
					$tmp_usr_pth1 = site_url($tmp_usr_pth1); ?> 
					$.ajax({
						url: '<?php echo $tmp_usr_pth1; ?>',
						cache: false,
						type: 'POST', 
						data: { 'submits':1, sl_leadid: sels_vals },
						success: function (result, status, xhr){
							var lead_tmp_title = $("#fetch_remote_leads").attr("data-title");
						 	result = result.replace(/Select Lead/g, "Select " + lead_tmp_title); 
							$("#fetch_remote_leads").html(result);
							
							if($('.select2-search').length >0){ 
								$('.select2-search').select2();
							}
						}
					});    
				}); 
			}  
	 
			function agent_commission_calculate(){  
				var price_val = document.getElementById('deal_price').value;
				price_val = price_val*1;
				
				var commission1_per_val = document.getElementById('agent1_commission_percentage').value; 
				commission1_per_val = commission1_per_val*1; 
				if(commission1_per_val>0 && price_val>0){
					var commission_per_calc_val = (price_val * commission1_per_val/100); 
					commission_per_calc_val = commission_per_calc_val.toFixed(2) ;
					document.getElementById('agent1_commission_value').value = commission_per_calc_val;
				}else{
					document.getElementById('agent1_commission_value').value = 0;
				} 
				
				var commission2_per_val = document.getElementById('agent2_commission_percentage').value; 
				commission2_per_val = commission2_per_val*1;
				
				if(commission2_per_val>0 && price_val>0){
					var commission2_per_calc_val = (price_val * commission2_per_val/100); 
					commission2_per_calc_val = commission2_per_calc_val.toFixed(2) ;
					document.getElementById('agent2_commission_value').value = commission2_per_calc_val;
				}else{
					document.getElementById('agent2_commission_value').value = 0;
				} 
			}  
				
		<?php 
			/*properties/fetch_property_ref_no/';*/  
			$get_prop_info_url = 'deals/fetch_property_type/'; 
			$get_prop_info_url = site_url($get_prop_info_url); 
			
			$get_prop_info_url1 = 'deals/fetch_property_deal_price/'; 
			$get_prop_info_url1 = site_url($get_prop_info_url1); 
			
			$get_prop_info_url2 = 'deals/fetch_property_brief/';
			$get_prop_info_url2 = site_url($get_prop_info_url2); 
			
			$get_prop_info_url3 = 'deals/fetch_property_ownerid/';
			$get_prop_info_url3 = site_url($get_prop_info_url3);   ?> 
			 
			function operate_property_info(sels_vals) { 
				jQuery.noConflict()(function($){
					$(document).ready(function(){   
						
						$.ajax({
							url: '<?php echo $get_prop_info_url2; ?>'+sels_vals,
							cache: false,
							type: 'POST', 
							data: { 'submits':1 },
							success: function (result,status,xhr) {
								document.getElementById("fetch_prop_brief").innerHTML = result; 
							}   
						});
						
						$.ajax({
							url: '<?php echo $get_prop_info_url3; ?>'+sels_vals,
							cache: false,
							type: 'POST', 
							data: { 'submits':1 },
							success: function (result,status,xhr) { 
								document.getElementById("owner_id").value = result;    
								
						if(sels_vals>0){ 
						<?php 	
							$get_tmp_lead_property_brief = 'properties/get_deal_property_brief/';
							$get_tmp_lead_property_brief = site_url($get_tmp_lead_property_brief);  ?> 
							var tmp_urls = "<?php echo $get_tmp_lead_property_brief; ?>"+sels_vals+'/';
							var tmp_txts ='<a class="simple-ajax-modal" href="'+tmp_urls+'"><i class="fa fa-search-plus"></i> Show Detail</a>';
							document.getElementById("fetch_lead_property_brief").innerHTML = tmp_txts;
							
							$('.simple-ajax-modal').magnificPopup({
								type: 'ajax',
								modal: true
							});  
						}
				
							}
						}); 
						
						$.ajax({
							url: '<?php echo $get_prop_info_url1; ?>'+sels_vals,
							cache: false,
							type: 'POST', 
							data: { 'submits':1 },
							success: function (result,status,xhr) {  
								document.getElementById("deal_price").value = result;
								/*document.getElementById("fetch_property_deal_price").innerHTML = result;*/  
								result = result*1;
								if(result>0){
									//price_commission_calculate();
									
									var sel_types_val = document.getElementById("types").value;
									var deal_price = document.getElementById("deal_price").value;
									deal_price = deal_price * 1;
									 
									console.log("deal");
									if(sel_types_val==2){
										if(deal_price>0){
											var tmp_deposit = deal_price * 0.05; 
											tmp_deposit = tmp_deposit.toFixed(2);
											document.getElementById("deposit").value = tmp_deposit;	
											
											var tmp_commission = deal_price * 0.10; 
											tmp_commission = tmp_commission.toFixed(2);
											document.getElementById("commission").value = tmp_commission;
											document.getElementById("deposit_txt").innerHTML = "(5%)";
											document.getElementById("commission_txt").innerHTML = "(10%)";
											 
										}else{
											document.getElementById("deposit").value='';
											document.getElementById("commission").value=''; 
											document.getElementById("deposit_txt").innerHTML = '';
											document.getElementById("commission_txt").innerHTML = '';
										}
										
										document.getElementById("fetch_renewal_date").style.display='';
										document.getElementById("fetch_set_reminder").style.display='';
										 
									}else if(sel_types_val==1){  
										
										if(deal_price>0){
											var tmp_deposit = deal_price * 0.10; 
											tmp_deposit = tmp_deposit.toFixed(2);
											document.getElementById("deposit").value = tmp_deposit;	 
											
											var tmp_commission = deal_price * 0.02; 
											tmp_commission = tmp_commission.toFixed(2);
											document.getElementById("commission").value = tmp_commission;
											
											document.getElementById("deposit_txt").innerHTML = "(10%)";
											document.getElementById("commission_txt").innerHTML = "(2%)";
										}else{
											document.getElementById("deposit").value='';
											document.getElementById("commission").value='';
											
											document.getElementById("deposit_txt").innerHTML = '';
											document.getElementById("commission_txt").innerHTML = '';
										}
										
										document.getElementById("fetch_renewal_date").style.display='none';
										document.getElementById("fetch_set_reminder").style.display='none';
										
									}else{  
										document.getElementById("deposit").value='';
										document.getElementById("commission").value='';
										
										document.getElementById("fetch_renewal_date").style.display='none';
										document.getElementById("fetch_set_reminder").style.display='none';
										
										document.getElementById("deposit_txt").innerHTML = '';
										document.getElementById("commission_txt").innerHTML = '';
									}  
								}
							}
						});	
					});
				});
			}
			
			function sleep(miliseconds) {
				var currentTime = new Date().getTime();
				while (currentTime + miliseconds >= new Date().getTime()) {
				}
			}
					 
			function price_commission_calculate(){  
				/*var sel_types = document.getElementById("types");
				var sel_types_val = sel_types.options[sel_types.selectedIndex].value;*/
				
				var sel_types_val = document.getElementById("types").value;
				var deal_price = document.getElementById("deal_price").value;
				deal_price = deal_price * 1;
				 
				console.log("deal");
				if(sel_types_val==2){
					if(deal_price>0){
						var tmp_deposit = deal_price * 0.05; 
						tmp_deposit = tmp_deposit.toFixed(2);
						document.getElementById("deposit").value = tmp_deposit;	
						
						var tmp_commission = deal_price * 0.10; 
						tmp_commission = tmp_commission.toFixed(2);
						document.getElementById("commission").value = tmp_commission;
						document.getElementById("deposit_txt").innerHTML = "(5%)";
						document.getElementById("commission_txt").innerHTML = "(10%)";
						 
					}else{
						document.getElementById("deposit").value='';
						document.getElementById("commission").value=''; 
						document.getElementById("deposit_txt").innerHTML = '';
						document.getElementById("commission_txt").innerHTML = '';
					}
					
					document.getElementById("fetch_renewal_date").style.display='';
					document.getElementById("fetch_set_reminder").style.display='';
					 
				}else if(sel_types_val==1){  
					
					if(deal_price>0){
						var tmp_deposit = deal_price * 0.10; 
						tmp_deposit = tmp_deposit.toFixed(2);
						document.getElementById("deposit").value = tmp_deposit;	 
						
						var tmp_commission = deal_price * 0.02; 
						tmp_commission = tmp_commission.toFixed(2);
						document.getElementById("commission").value = tmp_commission;
						
						document.getElementById("deposit_txt").innerHTML = "(10%)";
						document.getElementById("commission_txt").innerHTML = "(2%)";
					}else{
						document.getElementById("deposit").value='';
						document.getElementById("commission").value='';
						
						document.getElementById("deposit_txt").innerHTML = '';
						document.getElementById("commission_txt").innerHTML = '';
					}
					
					document.getElementById("fetch_renewal_date").style.display='none';
					document.getElementById("fetch_set_reminder").style.display='none';
					
				}else{  
					document.getElementById("deposit").value='';
					document.getElementById("commission").value='';
					
					document.getElementById("fetch_renewal_date").style.display='none';
					document.getElementById("fetch_set_reminder").style.display='none';
					
					document.getElementById("deposit_txt").innerHTML = '';
					document.getElementById("commission_txt").innerHTML = '';
				}  
			}
			
			function deposit_commission_calculate(){ 
				var deal_price_val = document.getElementById("deal_price").value;
				var deposit_val = document.getElementById("deposit").value;
				var commission_val = document.getElementById("commission").value;
				 
				deal_price_val = deal_price_val * 1;
				deposit_val = deposit_val * 1;
				commission_val = commission_val * 1;
				
				if(deal_price_val >0 && deposit_val >0){
					
					var calc_prec = deposit_val / deal_price_val ; 
					calc_prec = calc_prec * 100; 
					
					calc_prec = calc_prec.toFixed(0);
					document.getElementById("deposit_txt").innerHTML = "("+calc_prec+"%)"; 
					 
				}else{
					document.getElementById("deposit_txt").innerHTML = '';
				}
				 
				if(deal_price_val >0 && commission_val >0){
					
					var calc_prec1 = commission_val / deal_price_val ; 
					calc_prec1 = calc_prec1 * 100; 
					
					calc_prec1 = calc_prec1.toFixed(0);
					document.getElementById("commission_txt").innerHTML = "("+calc_prec1+"%)"; 
					 
				}else{
					document.getElementById("commission_txt").innerHTML = '';
				} 
				 
			}
			 	 
			$(document).ready(function(){ 
				<?php
					$tmp_agent_pth = '/deals/get_jsoned_agents_list';
					$tmp_agent_pth = site_url($tmp_agent_pth);
					$tmp_sel_agent2_id = 0;
					if(isset($_POST['agent2_id']) && $_POST['agent2_id']>0){  
						$tmp_sel_agent2_id = $_POST['agent2_id']; 
					}else if(isset($record) && $record->agent2_id>0){
						$tmp_sel_agent2_id = $record->agent2_id; 
					} 
					
					$tmp_agnt_pth = '/deals/get_jsoned_agent_by_id/'.$tmp_sel_agent2_id;
					$tmp_agnt_pth = site_url($tmp_agnt_pth);	?> 
					 
					/*$("#agent2_id").select2({
						placeholder: "Search for a Agent 2", 
						ajax: {  
							url: "<?php echo $tmp_agent_pth; ?>",
							dataType: 'json',
							quietMillis: 250,
							data: function (term, page) {
								return {
									q: term,  
									page: page  
								};
							},
							results: function (data, page) {   
								var more = (page * 30) < data.total_count; 
								var myResults = [];
								$.each(data, function (index, item) {
									myResults.push({
										'id': item.id,
										'text': item.name
									});
								});
								return {
									results: myResults, more: more 
								}; 
							},
							cache: false
						}, 
						initSelection: function (element, callback) {
							$.get('<?php echo $tmp_agnt_pth; ?>', function(data) { 
								var txt1 = data[0].id;
								var txt2 = data[0].name;  
								callback({id: txt1, text: txt2 });
								document.getElementById("agent2_id").value = txt1;
							});	 
						},
						//formatResult: repoFormatResult,  
						//formatSelection: repoFormatSelection,   
						dropdownCssClass: "bigdrop",  
						escapeMarkup: function (m) { return m; } 
					}); */ 
				 }); 
			  
			<?php 
			$get_deal_lead_info_url = 'deals/get_deal_lead_property_popup_detail/';
			$get_deal_lead_info_url = site_url($get_deal_lead_info_url);   ?>  
			 
			function dyns_leads(sels_vals) {
				$(document).ready(function(){
					$.ajax({
						url: '<?php echo $get_deal_lead_info_url; ?>'+sels_vals,
						cache: false,
						type: 'POST', 
						data: { 'submits':1 },
						success: function (result,status,xhr) { 
							var db_lead_id = result[0]['id'];
							var lead_ref_no = result[0]['ref_no'];
							var lead_contact_id = result[0]['contact_id'];
							var lead_agent_id = result[0]['agent_id']; 
							
							var lead_cnt_name = result[0]['cnt_name']; 
							var lead_cnt_email = result[0]['cnt_email']; 
							var lead_cnt_phone_no = result[0]['cnt_phone_no'];
							
							document.getElementById("contact_id1").value = lead_contact_id;
							document.getElementById("lead_id").value = db_lead_id;
							 
							var ret_txts = "<strong> Lead Ref #: </strong>"+lead_ref_no+" <br>";
							ret_txts += "<strong> Name : </strong>"+lead_cnt_name+" <br>"; 
							ret_txts += "<strong> Email : </strong>"+lead_cnt_email+" <br>"; 
							ret_txts += "<strong> Contact No: </strong>"+lead_cnt_phone_no+" <br>"; 
							 
							var lead_title_1 = "lead_title_1";
							var lead_detail_1 = "lead_detail_1";
							var lead_link_txt_1 = "lead_link_txt_1"; 	 
								
							  
							document.getElementById(lead_detail_1).innerHTML = ret_txts;  
							
							document.getElementById(lead_title_1).innerHTML = " &nbsp; "+lead_cnt_name; 
							 
							document.getElementById("lead_pencil_link_txt_1").style.display = "inline";
							
							document.getElementById("lead_remove_link_txt_1").style.display = "inline";  
							
			   <?php  
					$lead_prop_update_popup_url_1 = "deals/deals_leads_properties_popup_list/";
					$lead_prop_update_popup_url_1 = site_url($lead_prop_update_popup_url_1);
					 ?>   
					 
					var linkid = '#lead_pencil_link_txt_1'; 					
					var new_lnk = "<?php echo $lead_prop_update_popup_url_1;?>"+db_lead_id+'/';	
					$(linkid).attr('href',new_lnk); 	 
						  
							  
						}
					});  
				}); 
			}  
			
			 			
			var data='';
			var key='';
			var value='';
			var i =0;
			var fileList = new Array;  
			$(document).ready(function(){  
				
				Dropzone.options.sellerlandlordfiles = { 
					<?php if(isset($record) && $record->id >0){ ?>
					sending: function(file, xhr, formData){
						formData.append('proprtyid', '<?php echo $record->id; ?>');
					},
					url: "<?php echo site_url('/deals/property_sellerlandlord_documents_files_upload'); ?>",
					<?php }else{ ?>
					url: "<?php echo site_url('/deals/temp_property_sellerlandlord_documents_files_upload'); ?>",
					<?php } ?>
					autoProcessQueue: true,
					autoDiscover:false, 
					uploadMultiple: true,
					addRemoveLinks: true,   
					parallelUploads: 100,
					maxFiles: 15,
					paramName: "sellerlandlorddocuments",
					dictDefaultMessage: 'Drop files or click here to upload',
					acceptedFiles: ".jpeg, .jpg, .png, .gif, .doc, .docx, .pdf",
					init: function() {
						addRemoveLinks: true,  
						thisDropzoness1 = this;   
						<?php if(isset($_POST['form_tokens']) || (isset($record) && $record->id >0) || (isset($_SESSION['Temp_Sellerlandlord_Documents_IP_Address']) && isset($_SESSION['Temp_Sellerlandlord_Documents_DATE_Times']))){  
						if(isset($record) && $record->id >'0'){  
						 $tmp_pth = '/deals/get_property_dropzone_sellerlandlord_documents_by_id/'.$record->id;
						 $tmp_loc = site_url($tmp_pth);	
						 }else if(isset($_POST['form_tokens']) || (isset($_SESSION['Temp_Sellerlandlord_Documents_IP_Address']) && isset($_SESSION['Temp_Sellerlandlord_Documents_DATE_Times']))){
							$tmp_pth = '/deals/get_temp_post_property_dropzone_sellerlandlord_documents';
							$tmp_loc = site_url($tmp_pth);
						} ?> 
						$.get('<?php echo $tmp_loc; ?>', function(data1) {
						$.each(data1, function(key1,value1){
							var mockFiless1 = { name: value1.name, size: value1.size };
							thisDropzoness1.options.addedfile.call(thisDropzoness1, mockFiless1);
							thisDropzoness1.options.thumbnail.call(thisDropzoness1, mockFiless1,"<?php echo base_url(); ?>downloads/property_sellerlandlord_documents/"+value1.name);
							});
						 });<?php } ?>
							this.on("removedfile", function(file) { 
							<?php if(isset($record) && $record->id >0){  
								$tmp_d_pth = '/deals/delete_property_dropzone_sellerlandlord_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth);	?> 
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid:<?php echo $record->id; ?>, flename: file.name } );
							<?php }else{ 
								$tmp_d_pth = '/deals/delete_temp_property_dropzone_sellerlandlord_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth); ?>
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid: -1, flename: file.name } );
							<?php } ?>  
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
					}
				} 
				
				$("#sellerlandlordfiles").sortable({
					items:'.dz-preview',
					cursor: 'move',
					opacity: 0.5,
					containment: '#sellerlandlordfiles',
					distance: 20,
					tolerance: 'pointer'
				});  
				
				
				var data='';
				var key='';
				var value='';
				Dropzone.options.buyertenantfiles = { 
					<?php if(isset($record) && $record->id >0){ ?>
					sending: function(file, xhr, formData){
						formData.append('proprtyid', '<?php echo $record->id; ?>');
					},
					url: "<?php echo site_url('/deals/property_buyertenant_documents_files_upload'); ?>",
					<?php }else{ ?>
					url: "<?php echo site_url('/deals/temp_property_buyertenant_documents_files_upload'); ?>",
					<?php } ?>
					autoProcessQueue: true,
					autoDiscover:false, 
					uploadMultiple: true,
					addRemoveLinks: true,   
					parallelUploads: 100,
					maxFiles: 15,
					paramName: "buyertenantdocuments",
					dictDefaultMessage: 'Drop files or click here to upload',
					acceptedFiles: ".jpeg, .jpg, .png, .gif, .doc, .docx, .pdf",
					init: function() {
						addRemoveLinks: true,  
						thisDropzoness2 = this;   
						<?php if(isset($_POST['form_tokens']) || (isset($record) && $record->id >0) || (isset($_SESSION['Temp_Buyertenant_Documents_IP_Address']) && isset($_SESSION['Temp_Buyertenant_Documents_DATE_Times']))){  
						if(isset($record) && $record->id >'0'){  
						 $tmp_pth = '/deals/get_property_dropzone_buyertenant_documents_by_id/'.$record->id;
						 $tmp_loc = site_url($tmp_pth);	
						 }else if(isset($_POST['form_tokens']) || (isset($_SESSION['Temp_Buyertenant_Documents_IP_Address']) && isset($_SESSION['Temp_Buyertenant_Documents_DATE_Times']))){
							$tmp_pth = '/deals/get_temp_post_property_dropzone_buyertenant_documents';
							$tmp_loc = site_url($tmp_pth);
						} ?> 
						$.get('<?php echo $tmp_loc; ?>', function(data2) {
						$.each(data2, function(key2,value2){
							var mockFiless2 = { name: value2.name, size: value2.size };
							thisDropzoness2.options.addedfile.call(thisDropzoness2, mockFiless2);
							thisDropzoness2.options.thumbnail.call(thisDropzoness2, mockFiless2,"<?php echo base_url(); ?>downloads/property_buyertenant_documents/"+value2.name);
							});
						 });<?php } ?>
							this.on("removedfile", function(file) { 
							<?php if(isset($record) && $record->id >0){  
								$tmp_d_pth = '/deals/delete_property_dropzone_buyertenant_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth);	?> 
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid:<?php echo $record->id; ?>, flename: file.name } );
							<?php }else{ 
								$tmp_d_pth = '/deals/delete_temp_property_dropzone_buyertenant_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth); ?>
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid: -1, flename: file.name } );
							<?php } ?>  
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
					}
				}
				
				$("#buyertenantfiles").sortable({
					items:'.dz-preview',
					cursor: 'move',
					opacity: 0.5,
					containment: '#buyertenantfiles',
					distance: 20,
					tolerance: 'pointer'
				}); 
				
				
				var data='';
				var key='';
				var value='';		
				Dropzone.options.documentsfiles = { 
					<?php if(isset($record) && $record->id >0){ ?>
					sending: function(file, xhr, formData){
						formData.append('proprtyid', '<?php echo $record->id; ?>');
					},
					url: "<?php echo site_url('/deals/property_deal_documents_files_upload'); ?>",
					<?php }else{ ?>
					url: "<?php echo site_url('/deals/temp_property_deal_documents_files_upload'); ?>",
					<?php } ?>
					autoProcessQueue: true,
					autoDiscover:false, 
					uploadMultiple: true,
					addRemoveLinks: true,   
					parallelUploads: 100,
					maxFiles: 15,
					paramName: "dealdocuments",
					dictDefaultMessage: 'Drop files or click here to upload',
					acceptedFiles: ".jpeg, .jpg, .png, .gif, .doc, .docx, .pdf",
					init: function() {
						addRemoveLinks: true,  
						thisDropzoness3 = this;   
						<?php if(isset($_POST['form_tokens']) || (isset($record) && $record->id >0) || (isset($_SESSION['Temp_Deal_Documents_IP_Address']) && isset($_SESSION['Temp_Deal_Documents_DATE_Times']))){  
						if(isset($record) && $record->id >'0'){  
						 $tmp_pth = '/deals/get_property_dropzone_deal_documents_by_id/'.$record->id;
						 $tmp_loc = site_url($tmp_pth);	
						 }else if(isset($_POST['form_tokens']) || (isset($_SESSION['Temp_Deal_Documents_IP_Address']) && isset($_SESSION['Temp_Deal_Documents_DATE_Times']))){
							$tmp_pth = '/deals/get_temp_post_property_dropzone_deal_documents';
							$tmp_loc = site_url($tmp_pth);
						} ?> 
						$.get('<?php echo $tmp_loc; ?>', function(data3) {
						$.each(data3, function(key3,value3){
							var mockFiless3 = { name: value3.name, size: value3.size };
							thisDropzoness3.options.addedfile.call(thisDropzoness3, mockFiless3);
							thisDropzoness3.options.thumbnail.call(thisDropzoness3, mockFiless3,"<?php echo base_url(); ?>downloads/property_deal_documents/"+value3.name);
							});
						 });<?php } ?>
							this.on("removedfile", function(file) { 
							<?php if(isset($record) && $record->id >0){  
								$tmp_d_pth = '/deals/delete_property_dropzone_deal_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth);	?> 
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid:<?php echo $record->id; ?>, flename: file.name } );
							<?php }else{ 
								$tmp_d_pth = '/deals/delete_temp_property_dropzone_deal_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth); ?>
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid: -1, flename: file.name } );
							<?php } ?>  
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
					}
				}
				
				$("#documentsfiles").sortable({
					items:'.dz-preview',
					cursor: 'move',
					opacity: 0.5,
					containment: '#documentsfiles',
					distance: 20,
					tolerance: 'pointer'
				}); 
				
				
				var data='';
				var key='';
				var value='';
				Dropzone.options.newtitledeedfiles = { 
					<?php if(isset($record) && $record->id >0){ ?>
					sending: function(file, xhr, formData){
						formData.append('proprtyid', '<?php echo $record->id; ?>');
					},
					url: "<?php echo site_url('/deals/property_newtitledeed_documents_files_upload'); ?>",
					<?php }else{ ?>
					url: "<?php echo site_url('/deals/temp_property_newtitledeed_documents_files_upload'); ?>",
					<?php } ?>
					autoProcessQueue: true,
					autoDiscover:false, 
					uploadMultiple: true,
					addRemoveLinks: true,   
					parallelUploads: 100,
					maxFiles: 15,
					paramName: "newtitledeeddocuments",
					dictDefaultMessage: 'Drop files or click here to upload',
					acceptedFiles: ".jpeg, .jpg, .png, .gif, .doc, .docx, .pdf",
					init: function() {
						addRemoveLinks: true,  
						thisDropzoness4 = this;   
						<?php if(isset($_POST['form_tokens']) || (isset($record) && $record->id >0) || (isset($_SESSION['Temp_Newtitledeed_Documents_IP_Address']) && isset($_SESSION['Temp_Newtitledeed_Documents_DATE_Times']))){  
						if(isset($record) && $record->id >'0'){  
						 $tmp_pth = '/deals/get_property_dropzone_newtitledeed_documents_by_id/'.$record->id;
						 $tmp_loc = site_url($tmp_pth);	
						 }else if(isset($_POST['form_tokens']) || (isset($_SESSION['Temp_Newtitledeed_Documents_IP_Address']) && isset($_SESSION['Temp_Newtitledeed_Documents_DATE_Times']))){
							$tmp_pth = '/deals/get_temp_post_property_dropzone_newtitledeed_documents';
							$tmp_loc = site_url($tmp_pth);
						} ?> 
						$.get('<?php echo $tmp_loc; ?>', function(data4) {
						$.each(data4, function(key4,value4){
							var mockFiless4 = { name: value4.name, size: value4.size };
							thisDropzoness4.options.addedfile.call(thisDropzoness4, mockFiless4);
							thisDropzoness4.options.thumbnail.call(thisDropzoness4, mockFiless4,"<?php echo base_url(); ?>downloads/property_newtitledeed_documents/"+value4.name);
							});
						 });<?php } ?>
							this.on("removedfile", function(file) { 
							<?php if(isset($record) && $record->id >0){  
								$tmp_d_pth = '/deals/delete_property_dropzone_newtitledeed_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth);	?> 
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid:<?php echo $record->id; ?>, flename: file.name } );
							<?php }else{ 
								$tmp_d_pth = '/deals/delete_temp_property_dropzone_newtitledeed_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth); ?>
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid: -1, flename: file.name } );
							<?php } ?>  
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
					}
				}
				
				$("#newtitledeedfiles").sortable({
					items:'.dz-preview',
					cursor: 'move',
					opacity: 0.5,
					containment: '#newtitledeedfiles',
					distance: 20,
					tolerance: 'pointer'
				}); 
				
				
				var data='';
				var key='';
				var value='';
				Dropzone.options.agencydocumentsfiles = { 
					<?php if(isset($record) && $record->id >0){ ?>
					sending: function(file, xhr, formData){
						formData.append('proprtyid', '<?php echo $record->id; ?>');
					},
					url: "<?php echo site_url('/deals/property_agency_documents_files_upload'); ?>",
					<?php }else{ ?>
					url: "<?php echo site_url('/deals/temp_property_agency_documents_files_upload'); ?>",
					<?php } ?>
					autoProcessQueue: true,
					autoDiscover:false, 
					uploadMultiple: true,
					addRemoveLinks: true,   
					parallelUploads: 100,
					maxFiles: 15,
					paramName: "agencydocuments",
					dictDefaultMessage: 'Drop files or click here to upload',
					acceptedFiles: ".jpeg, .jpg, .png, .gif, .doc, .docx, .pdf",
					init: function() {
						addRemoveLinks: true,  
						thisDropzoness = this;   
						<?php if(isset($_POST['form_tokens']) || (isset($record) && $record->id >0) || (isset($_SESSION['Temp_Agency_Documents_IP_Address']) && isset($_SESSION['Temp_Agency_Documents_DATE_Times']))){  
						if(isset($record) && $record->id >'0'){  
						 $tmp_pth = '/deals/get_property_dropzone_agency_documents_by_id/'.$record->id;
						 $tmp_loc = site_url($tmp_pth);	
						 }else if(isset($_POST['form_tokens']) || (isset($_SESSION['Temp_Agency_Documents_IP_Address']) && isset($_SESSION['Temp_Agency_Documents_DATE_Times']))){
							$tmp_pth = '/deals/get_temp_post_property_dropzone_agency_documents';
							$tmp_loc = site_url($tmp_pth);
						} ?> 
						$.get('<?php echo $tmp_loc; ?>', function(data) {
						$.each(data, function(key,value){
							var mockFiless = { name: value.name, size: value.size };
							thisDropzoness.options.addedfile.call(thisDropzoness, mockFiless);
							thisDropzoness.options.thumbnail.call(thisDropzoness, mockFiless,"<?php echo base_url(); ?>downloads/property_agency_documents/"+value.name);
							});
						 });<?php } ?>
							this.on("removedfile", function(file) { 
							<?php if(isset($record) && $record->id >0){  
								$tmp_d_pth = '/deals/delete_property_dropzone_agency_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth);	?> 
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid:<?php echo $record->id; ?>, flename: file.name } );
							<?php }else{ 
								$tmp_d_pth = '/deals/delete_temp_property_dropzone_agency_documents_files';
								$tmp_d_loc = site_url($tmp_d_pth); ?>
								$.post("<?php echo $tmp_d_loc; ?>", { proprtyid: -1, flename: file.name } );
							<?php } ?>  
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
					}
				}
				 
				$("#agencydocumentsfiles").sortable({
					items:'.dz-preview',
					cursor: 'move',
					opacity: 0.5,
					containment: '#agencydocumentsfiles',
					distance: 20,
					tolerance: 'pointer'
				});  
			}); 
		 </script> 
		
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