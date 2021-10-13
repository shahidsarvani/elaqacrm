
<div class="form-group">
  <label class="col-md-3 control-label" for="unit_no">Unit No </label>
  <div class="col-md-8">
    <input name="unit_no" id="unit_no" type="text" class="form-control" value="<?php echo (isset($rec)) ? stripslashes($rec->unit_no): set_value('unit_no'); ?>">
    <span class="text-danger"><?php echo form_error('unit_no'); ?></span> </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="category_id"> Category </label>
  <div class="col-md-8" id="fetch_cates_list">
    <select name="category_id" id="category_id" data-plugin-selectTwo class="form-control populate">
      <option value="">Category Name</option>
      <?php   			  
        if(isset($category_arrs) && count($category_arrs)>0){
        foreach($category_arrs as $category_arr){
        $sel_1 = '';
        if(isset($_POST['category_id']) && $_POST['category_id']==$category_arr->id){
        $sel_1 = 'selected="selected"';
        }else if(isset($rec) && $rec->category_id==$category_arr->id){
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
    <select name="no_of_beds_id" id="no_of_beds_id" data-plugin-selectTwo class="form-control populate">
      <option value="">Select No. of Bedrooms</option>
      <?php  
        if(isset($beds_arrs) && count($beds_arrs)>0){
        foreach($beds_arrs as $beds_arr){
        $sel_1 = '';
        if(isset($_POST['no_of_beds_id']) && $_POST['no_of_beds_id']==$beds_arr->id){
        $sel_1 = 'selected="selected"';
        }else if(isset($rec) && $rec->no_of_beds_id==$beds_arr->id){
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
        if(isset($rec) && $rec->emirate_id >0){
        $sel_emirate_ids = $rec->emirate_id;
        }else{
        $sel_emirate_ids = 3;
        } ?>
    <select name="emirate_id" id="emirate_id" data-plugin-selectTwo class="form-control populate" onChange="get_emirate_location(this.value,'<?php echo site_url('properties/fetch_emirate_locations'); ?>','fetch_emirate_locations');">
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
  <label class="col-md-3 control-label" for="location_id">Location(s) </label>
  <div class="col-md-8"> <span id="fetch_emirate_locations">
    <select name="location_id" id="location_id" data-plugin-selectTwo class="form-control populate" onChange="get_emirate_sub_location(this.value,'<?php echo site_url('properties/fetch_emirate_sub_locations'); ?>','fetch_emirate_sub_locations');">
      <option value="">Select Emirate Location </option>
      <?php  
        $emirate_location_arrs = $this->admin_model->fetch_emirate_locations($sel_emirate_ids);
        if(isset($emirate_location_arrs) && count($emirate_location_arrs)>0){
        foreach($emirate_location_arrs as $emirate_location_arr){
        $sel_1 = '';
        if(isset($_POST['location_id']) && $_POST['location_id']==$emirate_location_arr->id){
            $sel_1 = 'selected="selected"';
        }else if(isset($rec) && $rec->location_id==$emirate_location_arr->id){
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
  <label class="col-md-3 control-label" for="sub_location_id">Sub Location(s) </label>
  <div class="col-md-8"> <span id="fetch_emirate_sub_locations">
    <select name="sub_location_id" id="sub_location_id" data-plugin-selectTwo class="form-control populate">
      <option value="">Select Emirate Sub Location </option>
      <?php 
        $tmps_location_id='';
        if(isset($_POST['location_id']) && strlen($_POST['location_id'])>0){
        $tmps_location_id = $_POST['location_id'];
        }else if(isset($rec->location_id) && $rec->location_id>0){
        $tmps_location_id = $rec->location_id;
        }
        
        $emirate_sub_location_arrs = $this->admin_model->fetch_emirate_sub_locations($tmps_location_id);
        if(isset($emirate_sub_location_arrs) && is_array($emirate_sub_location_arrs)){
        foreach($emirate_sub_location_arrs as $emirate_sub_location_arr){ 
        $sel_1 = '';
        if(isset($_POST['sub_location_id']) && $_POST['sub_location_id']==$emirate_sub_location_arr->id){
            $sel_1 = 'selected="selected"';
        }else if(isset($rec) && $rec->sub_location_id==$emirate_sub_location_arr->id){
            $sel_1 = 'selected="selected"';
        } ?>
      <option value="<?= $emirate_sub_location_arr->id; ?>" <?php echo $sel_1; ?>>
      <?= stripslashes($emirate_sub_location_arr->name); ?>
      </option>
      <?php 
        }
        } 
        ?>
    </select>
    </span> <span class="text-danger"><?php echo form_error('sub_location_id'); ?></span> </div>
</div>
  <br>
