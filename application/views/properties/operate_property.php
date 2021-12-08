<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/meta_tags'); ?>
<!--<script type="text/javascript" src="<?= asset_url(); ?>js/plugins/uploaders/dropzone.min.js"></script>-->
<script type="text/javascript" src="<?= asset_url(); ?>js/pages/uploader_dropzone.js"></script>
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
            <?php 
            if(isset($args1) && $args1>0){
                $form_act = "properties/operate_property/".$args1;
            }else{
                $form_act = "properties/operate_property";
            } ?>
            <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">
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
                <label class="col-md-3 control-label" for="desscription">Description <span class="reds"> *</span></label>
                <div class="col-md-9">
                  <textarea name="description" id="description" class="form-control" rows="5" data-error="#description1"><?php echo (isset($record)) ? stripslashes($record->description): set_value('description'); ?></textarea>
                  <span id="description1" class="text-danger"><?php echo form_error('description'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="property_type">Property Type <span class="reds">*</span></label>
                <div class="col-md-9">
                  <select name="property_type" id="property_type" class="form-control select2">
                    <option value="">Select </option>
                    <option value="1" <?php echo ((isset($_POST['property_type']) && $_POST['property_type']==1) || (isset($record) && $record->property_type==1)) ? 'selected="selected"':'' ?>> Sale </option>
                    <option value="2"  <?php echo ((isset($_POST['property_type']) && $_POST['property_type']==2) || (isset($record) && $record->property_type==2)) ? 'selected="selected"':'' ?>> Rent </option>
                  </select>
                  <span class="text-danger"><?php echo form_error('property_type'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="category_id"> Category <span class="reds">*</span></label>
                <div class="col-md-9"> <span id="fetch_cates_list">
                  <select name="category_id" id="category_id" class="form-control select2">
                    <option value="">Category Name</option>
                    <?php   
                if($tmps_sel_prop_type>0){    
                    $category_arrs = $this->admin_model->fetch_property_type_cates($tmps_sel_prop_type);
                    }		  		  
                              
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
                  </span> <span class="text-danger"><?php echo form_error('category_id'); ?></span> </div>
              </div>
               
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-md-3 control-label" for="ref_no">Ref # <span class="reds"> *</span></label>
                <div class="col-md-9">
                  <input name="ref_no" id="ref_no" type="text" class="form-control" value="<?php //echo $temp_ref_no; ?>" readonly title="Read only - system created">
                  <span class="text-danger"><?php echo form_error('ref_no'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="assigned_to_id">Assigned To <span class="reds">*</span></label>
                <div class="col-md-9">
                  <select name="assigned_to_id" id="assigned_to_id" class="form-control select2">
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
                  <span class="text-danger"><?php echo form_error('assigned_to_id'); ?></span> </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-3 control-label" for="owner_id">Owner <span class="reds">*</span> </label>
                <div class="col-md-9">
                  <div id="fetch_new_owners">
                    <select name="owner_id" id="owner_id" class="form-control select2">
                      <option value="">Select Owner Name </option>
                      <?php 
                       /* $tmps_location_id='';
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
                              <option value="<?= $emirate_sub_location_arr->id; ?>" <?php echo $sel_1; ?>> <?= stripslashes($emirate_sub_location_arr->name); ?> </option>
                        <?php 
                            }
                        } */
                      ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('owner_id'); ?></span> </div>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-3 control-label" for="no_of_beds_id">No. of Bedrooms <span class="reds">*</span> </label>
                <div class="col-md-9">
                  <select name="no_of_beds_id" id="no_of_beds_id" class="form-control select2">
                    <option value="">Select No. of Bedrooms</option>
                    <?php   
                    for($b=1; $b<=9; $b++){ 
                        $sel_1 = '';
                        if(isset($_POST['no_of_beds_id']) && $_POST['no_of_beds_id']==$b){
                            $sel_1 = 'selected="selected"';
                        }else if(isset($record) && $record->no_of_beds_id==$b){
                            $sel_1 = 'selected="selected"';
                        } ?>
                    <option value="<?= $b; ?>" <?php echo $sel_1; ?>>
                    <?= ($b==9) ? $b.'+' : $b; ?>
                    </option>
                    <?php } ?>
                  </select>
                  <span class="text-danger"><?php echo form_error('no_of_beds_id'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="no_of_baths">No. of Baths <span class="reds">*</span></label>
                <div class="col-md-9">
                  <select name="no_of_baths" id="no_of_baths" class="form-control select2">
                    <option value="">Select No. of Baths</option>
                    <?php   
                        for($b=1; $b<=9; $b++){ 
                            $sel_1 = '';
                            if(isset($_POST['no_of_baths']) && $_POST['no_of_baths']==$b){
                                $sel_1 = 'selected="selected"';
                            }else if(isset($record) && $record->no_of_baths==$b){
                                $sel_1 = 'selected="selected"';
                            } ?>
                    <option value="<?= $b; ?>" <?php echo $sel_1; ?>>
                    <?= ($b==9) ? $b.'+' : $b; ?>
                    </option>
                    <?php } ?>
                  </select>
                  <span class="text-danger"><?php echo form_error('no_of_baths'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="emirate_id">Emirates <span class="reds">*</span></label>
                <div class="col-md-9">
                  <?php 
                        if(isset($_POST['emirate_id']) && $_POST['emirate_id']>0){
                            $sel_emirate_ids = $_POST['emirate_id'];
                        }else if(isset($record) && $record->emirate_id >0){
                            $sel_emirate_ids = $record->emirate_id;
                        }else{
                            $sel_emirate_ids = 3;
                        }  ?>
                  <select name="emirate_id" id="emirate_id" data-plugin-selectTwo class="form-control select2" onChange="get_property_emirate_location(this.value,'<?php echo site_url('properties/fetch_emirate_locations'); ?>','fetch_emirate_locations');">
                    <option value="">Select Emirate </option>
                    <?php  
                        if(isset($emirate_arrs) && count($emirate_arrs)>0){
                            foreach($emirate_arrs as $emirate_arr){
                            $sel_1 = '';
                            if(isset($sel_emirate_ids) && $sel_emirate_ids==$emirate_arr->id){
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
                <label class="col-md-3 control-label" for="location_id">Locations <span class="reds">*</span></label>
                <div class="col-md-9"> <span id="fetch_emirate_locations">
                  <select name="location_id" id="location_id" data-plugin-selectTwo class="form-control select2" onChange="get_property_emirate_sub_location(this.value,'<?php echo site_url('properties/fetch_property_emirate_sub_locations'); ?>','fetch_emirate_sub_locations');">
                    <option value="">Select Emirate Location </option>
                    <?php  
                        /*$emirate_location_arrs = $this->admin_model->fetch_emirate_locations($sel_emirate_ids);
                        if(isset($emirate_location_arrs) && count($emirate_location_arrs)>0){
                            foreach($emirate_location_arrs as $emirate_location_arr){
                                $sel_1 = '';
                                if(isset($_POST['location_id']) && $_POST['location_id']==$emirate_location_arr->id){
                                    $sel_1 = 'selected="selected"';
                                }else if(isset($record) && $record->location_id==$emirate_location_arr->id){
                                    $sel_1 = 'selected="selected"';
                                }  ?>
                                <option value="<?= $emirate_location_arr->id; ?>" <?php echo $sel_1; ?>> <?= stripslashes($emirate_location_arr->name); ?> </option>
                         <?php 
                            }
                        } */ ?>
                  </select>
                  </span> <span class="text-danger"><?php echo form_error('location_id'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="sub_location_id">Sub Locations <span class="reds">*</span></label>
                <div class="col-md-9"> <span id="fetch_emirate_sub_locations">
                  <select name="sub_location_id" id="sub_location_id" data-plugin-selectTwo class="form-control select2" onChange="get_property_emirate_sub_location_area(this.value,'<?php echo site_url('properties/fetch_property_emirate_sub_location_areas'); ?>','fetch_emirate_sub_location_areas');" >
                    <option value="">Select Emirate Sub Location </option>
                    <?php 
                   /* $tmps_location_id='';
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
                          <option value="<?= $emirate_sub_location_arr->id; ?>" <?php echo $sel_1; ?>> <?= stripslashes($emirate_sub_location_arr->name); ?> </option>
                    <?php 
                        }
                    } */
                  ?>
                  </select>
                  </span> <span class="text-danger"><?php echo form_error('sub_location_id'); ?></span> </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-3 control-label" for="property_address">Address <span class="reds"> *</span></label>
                <div class="col-md-9">
                  <textarea name="property_address" id="property_address" class="form-control" rows="5" data-error="#property_address"><?php echo (isset($record)) ? stripslashes($record->property_address): set_value('property_address'); ?></textarea>
                  <span class="text-danger"><?php echo form_error('property_address'); ?></span> </div>
              </div>
                    
            </div>
            
       	<div class="col-md-4">
            <div class="form-group">
            <label class="col-md-3 control-label" for="plot_area">Plot Area <span class="reds"> *</span></label>
            <div class="col-md-9">
              <input name="plot_area" id="plot_area" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->plot_area) : set_value('plot_area'); ?>">
              <span class="text-danger"><?php echo form_error('plot_area'); ?></span> </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 control-label" for="property_ms_unit">Measuring Unit <span class="reds"> *</span></label>
            <div class="col-md-9">
              <select name="property_ms_unit" id="property_ms_unit" class="form-control select2">
                <option value="">Select </option>
                <option value="1" <?php echo ((isset($_POST['property_ms_unit']) && $_POST['property_ms_unit']==1) || (isset($record) && $record->property_ms_unit==1)) ? 'selected="selected"':'' ?>> 1 </option>
                <option value="2"  <?php echo ((isset($_POST['property_ms_unit']) && $_POST['property_ms_unit']==2) || (isset($record) && $record->property_ms_unit==2)) ? 'selected="selected"':'' ?>> 2 </option>
              </select>
             <span class="text-danger"><?php echo form_error('property_ms_unit'); ?></span> </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 control-label" for="price">Price <span class="reds"> *</span></label>
            <div class="col-md-9">
              <input name="price" id="price" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->price) : set_value('price'); ?>">
              <span class="text-danger"><?php echo form_error('price'); ?></span> </div>
          </div>
          
              <div class="form-group">
                <label class="col-md-3 control-label" for="is_published">Is Published ? </label>
                <div class="col-md-9">
                  <select name="is_published" id="is_published" class="form-control select2">
                    <option value="">Select </option>
                    <option value="1" <?php echo ((isset($_POST['is_published']) && $_POST['is_published']==1) || (isset($record) && $record->is_published==1)) ? 'selected="selected"':'' ?>> Yes </option>
                    <option value="0" <?php echo ((isset($_POST['is_published']) && $_POST['is_published']==0) || (isset($record) && $record->is_published==0)) ? 'selected="selected"':'' ?>> No </option>
                  </select>
                  <span class="text-danger"><?php echo form_error('is_published'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="property_status"> Property Status </label>
                <div class="col-md-9">
                  <select name="property_status" id="property_status" class="form-control select2">
                    <option value="">Select </option>
                    <option value="1" <?php echo ((isset($_POST['property_status']) && $_POST['property_status']==1) || (isset($record) && $record->property_status==1)) ? 'selected="selected"':'' ?>> 1 </option>
                    <option value="0" <?php echo ((isset($_POST['property_status']) && $_POST['property_status']==0) || (isset($record) && $record->property_status==0)) ? 'selected="selected"':'' ?>> 2 </option>
                  </select>
                  <span class="text-danger"><?php echo form_error('property_status'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="youtube_video_link">Youtube Video Link </label>
                <div class="col-md-9">
                  <input name="youtube_video_link" id="youtube_video_link" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->youtube_video_link) : set_value('youtube_video_link'); ?>">
                  <span class="text-danger"><?php echo form_error('youtube_video_link'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="floor_plans">Floor Plans </label>
                <div class="col-md-9">
                  <input name="floor_plans" id="floor_plans" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->floor_plans) : set_value('floor_plans'); ?>">
                  <span class="text-danger"><?php echo form_error('floor_plans'); ?></span> </div>
              </div> 
              <div class="form-group">
                <label class="col-md-3 control-label" for="is_furnished">Is Furnished ?</label>
                <div class="col-md-9">
                  <select name="is_furnished" id="is_furnished" class="form-control select2">
                    <option value="">Select </option>
                    <option value="1" <?php echo ((isset($_POST['is_furnished']) && $_POST['is_furnished']==1) || (isset($record) && $record->is_furnished==1)) ? 'selected="selected"':'' ?>> Furnished </option>
                    <option value="2"  <?php echo ((isset($_POST['is_furnished']) && $_POST['is_furnished']==2) || (isset($record) && $record->is_furnished==2)) ? 'selected="selected"':'' ?>> Semi Furnished </option>
                    <option value="2"  <?php echo ((isset($_POST['is_furnished']) && $_POST['is_furnished']==3) || (isset($record) && $record->is_furnished==3)) ? 'selected="selected"':'' ?>> Un-Furnished </option>
                  </select>
                  <span class="text-danger"><?php echo form_error('is_furnished'); ?></span> </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-3 control-label" for="is_parking">Is Parking ?</label>
                <div class="col-md-9">
                  <input name="is_parking" id="is_parking" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->is_parking) : set_value('is_parking'); ?>">
                  <span class="text-danger"><?php echo form_error('is_parking'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="parking_price">Parking Price </label>
                <div class="col-md-9">
                  <input name="parking_price" id="parking_price" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->parking_price) : set_value('parking_price'); ?>">
                  <span class="text-danger"><?php echo form_error('parking_price'); ?></span> </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="source_of_listing">Source of Listing </label>
                <div class="col-md-9">
                  <select name="source_of_listing" id="source_of_listing" class="form-control select2">
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
          <span class="text-danger"><?php echo form_error('source_of_listing'); ?></span> </div>
          </div>
        </div>
      </div>
    </div>
		 </div>
              
              
              
         <div class="row">
          <div class="col-md-4">
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h6 class="panel-title">Photo(s)</h6>
              </div>
              <div class="panel-body"> 
              		<div class="dropzone" id="dropzone_file_limits"> </div>
              </div>
            </div>  
          </div>
          <div class="col-md-4">
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h6 class="panel-title">Documents </h6> 
              </div>
              <div class="panel-body">
              		<div class="dropzone" id="dropzone_file_limits1"> </div>
              </div>
            </div> 
          </div> 
          <div class="col-md-4">
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h6 class="panel-title">Notes </h6> 
              </div>
              <div class="panel-body"> 
              		<!--<div class="dropzone" id="dropzone_file_limits2"> </div>-->
                     
               <div class="panel panel-flat timeline-content">
                <div class="panel-heading"> 
                  <div class="heading-elements">
                    <ul class="icons-list">
                      <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-circle-down2"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                          <li><a href="#"><i class="icon-user-lock"></i> Hide user posts</a></li>
                          <li><a href="#"><i class="icon-user-block"></i> Block user</a></li>
                          <li><a href="#"><i class="icon-user-minus"></i> Unfollow user</a></li>
                          <li class="divider"></li>
                          <li><a href="#"><i class="icon-embed"></i> Embed post</a></li>
                          <li><a href="#"><i class="icon-blocked"></i> Report this post</a></li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="panel-body">
                  <ul class="media-list chat-list content-group">
                    <li class="media date-step"> <span>Today</span> </li>
                    <li class="media reversed">
                      <div class="media-body">
                        <div class="media-content">Thus superb the tapir the wallaby blank frog execrably much since dalmatian by in hot. Uninspiringly arose mounted stared one curt safe</div>
                        <span class="media-annotation display-block mt-10">Tue, 8:12 am <a href="#"><i class="icon-pin-alt position-right text-muted"></i></a></span> </div>
                      <div class="media-right"> <a href="assets/images/placeholder.jpg"> <img alt="" class="img-circle" src="assets/images/placeholder.jpg"> </a> </div>
                    </li>
                    <li class="media">
                      <div class="media-left"> <a href="assets/images/placeholder.jpg"> <img alt="" class="img-circle" src="assets/images/placeholder.jpg"> </a> </div>
                      <div class="media-body">
                        <div class="media-content">Tolerantly some understood this stubbornly after snarlingly frog far added insect into snorted more auspiciously heedless drunkenly jeez foolhardy oh.</div>
                        <span class="media-annotation display-block mt-10">Wed, 4:20 pm <a href="#"><i class="icon-pin-alt position-right text-muted"></i></a></span> </div>
                    </li>
                    <li class="media reversed">
                      <div class="media-body">
                        <div class="media-content">Satisfactorily strenuously while sleazily dear frustratingly insect menially some shook far sardonic badger telepathic much jeepers immature much hey.</div>
                        <span class="media-annotation display-block mt-10">2 hours ago <a href="#"><i class="icon-pin-alt position-right text-muted"></i></a></span> </div>
                      <div class="media-right"> <a href="assets/images/placeholder.jpg"> <img alt="" class="img-circle" src="assets/images/placeholder.jpg"> </a> </div>
                    </li>
                    <li class="media">
                      <div class="media-left"> <a href="assets/images/placeholder.jpg"> <img alt="" class="img-circle" src="assets/images/placeholder.jpg"> </a> </div>
                      <div class="media-body">
                        <div class="media-content">Grunted smirked and grew less but rewound much despite and impressive via alongside out and gosh easy manatee dear ineffective yikes.</div>
                        <span class="media-annotation display-block mt-10">13 minutes ago <a href="#"><i class="icon-pin-alt position-right text-muted"></i></a></span> </div>
                    </li>
                    <li class="media reversed">
                      <div class="media-body">
                        <div class="media-content"><i class="icon-menu display-block"></i></div>
                      </div>
                      <div class="media-right"> <a href="assets/images/placeholder.jpg"> <img alt="" class="img-circle" src="assets/images/placeholder.jpg"> </a> </div>
                    </li>
                  </ul>
                  <textarea placeholder="Enter your message..." cols="1" rows="3" class="form-control content-group" name="enter-message"></textarea>
                  <div class="row">
                    <div class="col-xs-6">
                      <ul class="icons-list icons-list-extended mt-10">
                        <li><a data-container="body" title="" data-popup="tooltip" href="#" data-original-title="Send photo"><i class="icon-file-picture"></i></a></li>
                        <li><a data-container="body" title="" data-popup="tooltip" href="#" data-original-title="Send video"><i class="icon-file-video"></i></a></li>
                        <li><a data-container="body" title="" data-popup="tooltip" href="#" data-original-title="Send file"><i class="icon-file-plus"></i></a></li>
                      </ul>
                    </div>
                    <div class="col-xs-6 text-right">
                      <button class="btn bg-teal-400 btn-labeled btn-labeled-right" type="button"><b><i class="icon-circle-right2"></i></b> Send</button>
                    </div>
                  </div>
                </div>
              </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
              </div>
            </div> 
          </div>
        </div>     
               
	  <script>  
        /* $(document).ready(function(){	
            Dropzone.autoDiscover = false; 
            $("#dropzone_accepted_files").dropzone({
                paramName: "file", // The name that will be used to transfer the file
                dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
                maxFilesize: 1, // MB
                acceptedFiles: 'image/*'
             });  
        }); */
 
	   /* var data='';
		var key='';
		var value='';
		var i =0;
		var fileList = new Array;
		jQuery.noConflict()(function($){
			$(document).ready(function(){ 
			  
			Dropzone.options.mediaimages = { 
				<?php if(isset($record) && $record->id >0){ ?>
				sending: function(file, xhr, formData){
					formData.append('proprtyid', '<?php echo $record->id; ?>');
				},
				url: "<?php echo site_url('/properties/property_media_photos_upload'); ?>",
				<?php }else{ ?>
				url: "<?php echo site_url('/properties/temp_property_media_photos_upload'); ?>",
				<?php } ?>
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
				   /* });  
					<?php if((isset($record) && $propty_dropzone_photos_nums >0) || (isset($_SESSION['Temp_IP_Address']) && isset($_SESSION['Temp_DATE_Times']))){ 
					 
					if(isset($record) && $propty_dropzone_photos_nums >0){
						$tmp_pth = '/properties/get_property_dropzone_photos_by_id/'.$record->id;
						$tmp_loc = site_url($tmp_pth);
					}else if( (isset($_SESSION['Temp_IP_Address']) && isset($_SESSION['Temp_DATE_Times']))){
						$tmp_pth = '/properties/get_temp_post_property_dropzone_photos';
						$tmp_loc = site_url($tmp_pth);
					} ?>
					$.get('<?php echo $tmp_loc; ?>', function(data) {
					$.each(data, function(key,value){
						var mockFile = { name: value.name, size: value.size };
						thisDropzone.options.addedfile.call(thisDropzone, mockFile);
						thisDropzone.options.thumbnail.call(thisDropzone, mockFile,"<?php echo base_url(); ?>downloads/property_photos/"+value.name);
						});
					 });<?php } ?> 
					 
					this.on("removedfile", function(file) {  		 
					<?php if(isset($record) && $record->id >0){  
						$tmp_d_pth = '/properties/delete_property_dropzone_photos';
						$tmp_d_loc = site_url($tmp_d_pth);	?> 
						$.post("<?php echo $tmp_d_loc; ?>", { proprtyid:<?php echo $record->id; ?>, flename: file.name } );
					<?php }else{ 
						$tmp_d_pth = '/properties/delete_temp_property_dropzone_photos';
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
				
				 
			
			$("#mediaimages").sortable({
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
					 <?php 
						if(isset($record) && $record->id >0){
							$pp_propertyid = $record->id;
						}else{
							$pp_propertyid = -1;
						} ?>
					 
					 $.ajax({ 
						url : '<?php echo site_url('/properties/property_media_photos_order_settings'); ?>',
						type       : 'POST',                                              
						data       : { 'data' : JSON.stringify(images_order_arrs), 'propertyid' : <?php echo $pp_propertyid; ?>},
						success    : function(){ }
					 });  
			
				}
			});
		} 
		
	}   
		   
		   });
		});*/   
        </script>
              <div class="panel panel-flat">
                <div class="panel-heading">
                  <h6 class="panel-title"> Portals </h6>
                  <div class="heading-elements">
                    <ul class="icons-list">
                      <li><a data-action="collapse"></a></li>
                      <li><a data-action="reload"></a></li>
                    </ul>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                      <li class="active"><a href="#portal_amenities_tab" data-toggle="tab"><i class="icon-menu7 position-left"></i> Portal Amenities </a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="portal_amenities_tab"> Portal Amenities Here </div>
                    </div>
                  </div>
                  <br>
                  <br>
                </div>
              </div>
            </form>
            <script type="text/javascript">  
			/*$(document).ready(function(){ 
				var validator = $('#datas_form').validate({
				rules: {
					title: {
						required: true 
					},
					assigned_to: {
						required: true 
					},
					due_date: {
						required: true 
					},
					due_timing: {
						required: true 
					},
					status: {
						required: true 
					}  
				},
				messages: {
					title: {
						required: "This is required field" 
					},
					assigned_to: {
						required: "This is required field" 
					},
					due_date: {
						required: "This is required field" 
					},
					due_timing: {
						required: "This is required field" 
					},
					status: {
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
			}); */
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