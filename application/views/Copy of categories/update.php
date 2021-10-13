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
            $form_act = "categories/update/".$args1;
        } ?>
        <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">
          <div class="form-group">
            <label class="col-md-2 control-label" for="name">Category Name <span class="reds">*</span></label>
              <div class="col-md-6">
                <input name="name" id="name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->name): set_value('name'); ?>" data-error="#name1"> 
                <span id="name1" class="text-danger" generated="true"><?php echo form_error('name'); ?></span>
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
                <span id="sort_order1" class="text-danger" generated="true"><?php echo form_error('sort_order'); ?></span> 
              </div> 
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label" for="description">Description <span class="reds">*</span></label>
              <div class="col-md-6">
              <textarea name="description" id="description" class="form-control" rows="5" data-error="#description1"><?php echo (isset($record)) ? stripslashes($record->description): set_value('description'); ?></textarea>   
                <span id="description1" class="text-danger" generated="true"><?php echo form_error('description'); ?></span>
              </div> 
            </div>  
            <div class="form-group">
              <label class="col-md-2 control-label" for="property_type"> Property Type </label>
              <div class="col-md-6">
              <select name="property_type" id="property_type" class="form-control select" data-error="#property_type1">
                    <option value="0">Select</option>
                    <option value="1" <?php echo ( (isset($_POST['property_type']) && $_POST['property_type']==1) || (isset($record) && $record->property_type==1)) ? 'selected="selected"':''; ?>> Residential </option>
                    <option value="2" <?php echo ( (isset($_POST['property_type']) && $_POST['property_type']==2) || (isset($record) && $record->property_type==2)) ? 'selected="selected"':''; ?>> Commercial </option>
              </select>  
                <span id="property_type1" class="text-danger" generated="true"><?php echo form_error('property_type'); ?></span>
              </div> 
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label" for="show_in_sale">Show in Sale </label>
              <div class="col-md-6">
                <div class="checkbox">
                    <label for="show_in_sale"> <input type="checkbox" name="show_in_sale" id="show_in_sale" value="1" <?php if((isset($_POST['show_in_sale']) && $_POST['show_in_sale']==1) || (isset($record) && $record->show_in_sale==1)){ echo 'checked="checked"'; } ?> class="styled"> Yes? </label>
                </div> 
              </div> 
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label" for="show_in_rent">Show in Rent </label>
              <div class="col-md-6">
                <div class="checkbox">
                    <label for="show_in_rent">
                    <input type="checkbox" name="show_in_rent" id="show_in_rent" value="1" <?php if((isset($_POST['show_in_rent']) && $_POST['show_in_rent']==1) || (isset($record) && $record->show_in_rent==1)){ echo 'checked="checked"'; } ?> class="styled"> Yes?</label>
                </div> 
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
            <?php 
                $portal_arrs = $this->portals_model->get_all_portals();
                if(isset($portal_arrs) && count($portal_arrs)>0){
                    foreach($portal_arrs as $portal_arr){
                        $portal_id = $portal_arr->id; 
                        $portal_name = stripslashes($portal_arr->name);
                        $insrt_abrv_val = '';
                        if(isset($_POST["cate_portal_abbr_{$portal_id}"]) && strlen($_POST["cate_portal_abbr_{$portal_id}"])){
                            $insrt_abrv_val = $_POST["cate_portal_abbr_{$portal_id}"];	
                        }else if(isset($record) && $record->id >0){ 
                            $cate_prtl_arr = $this->general_model->get_category_portal_abbrevations_data($record->id,$portal_id);
                            if(isset($cate_prtl_arr)){
                                $insrt_abrv_val = $cate_prtl_arr->abbrevations;	
                            }
                        } ?>
                                                   
                     <div class="form-group">
                      <label class="col-md-2 control-label" for="cate_portal_abbr_<?php echo $portal_id; ?>"><?php echo $portal_name; ?> Abbrevation </label>
                      <div class="col-md-6">
                        <input name="cate_portal_abbr_<?php echo $portal_id; ?>" id="cate_portal_abbr_<?php echo $portal_id; ?>" type="text" class="form-control" value="<?php echo $insrt_abrv_val; ?>">
                        <span class="text-danger"><?php //echo form_error("cate_portal_abbr_{$portal_id}"); ?></span> 
                        
                      </div> 
                    </div>  
                                         
                <?php 
                    } 
                }  ?>  
                    
      <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-6">
        
      <?php if(isset($record)){	?>
              <input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>"> 
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="updates" id="updates"><i class="glyphicon glyphicon-ok position-left"></i>Update</button>   
      <?php } ?>
          &nbsp;
          <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('categories/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button> 
          
        </div>
      </div>
    </form> 
    <script type="text/javascript">  
        $(document).ready(function(){ 
            var validator = $('#datas_form').validate({
            rules: {
                name: {
                    required: true 
                }, 
				sort_order: {
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
				sort_order: {
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