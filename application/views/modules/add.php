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
      <?php $form_act = "modules/add"; ?>
		<form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">
       
        <div class="form-group">
            <label class="col-md-2 control-label" for="parent_id">Parent Module </label>
        <div class="col-md-6">
          <select name="parent_id" id="parent_id" class="form-control select"  data-error="#parent_id1">
            <option value="0">Select Parent Module...</option>
			<?php  	
            $par_modules_arrs = $this->admin_model->get_all_parent_modules('0'); 			  
            if(isset($par_modules_arrs) && count($par_modules_arrs)>0){
                foreach($par_modules_arrs as $par_modules_arr){
                    $sel_1 = '';
					
					if(isset($args1) && $args1==$par_modules_arr->id){
						continue;
					}
                    if(isset($_POST['parent_id']) && $_POST['parent_id']==$par_modules_arr->id){
                        $sel_1 = 'selected="selected"';
                    }else if(isset($record) && $record->parent_id==$par_modules_arr->id){
                        $sel_1 = 'selected="selected"';
                    } ?>
                    <option value="<?= $par_modules_arr->id; ?>" <?php echo $sel_1; ?>>
                   &nbsp; <?= stripslashes($par_modules_arr->name); ?>
                    </option>
                <?php  
				$chd_modules_arrs = $this->admin_model->get_all_parent_modules($par_modules_arr->id); 			  
				if(isset($chd_modules_arrs) && count($chd_modules_arrs)>0){
					foreach($chd_modules_arrs as $chd_modules_arr){
						if(isset($args1) && $args1==$chd_modules_arr->id){
							continue;
						}
						$sel_2 = '';
						if(isset($_POST['parent_id']) && $_POST['parent_id']==$chd_modules_arr->id){
							$sel_2 = 'selected="selected"';
						}else if(isset($record) && $record->parent_id==$chd_modules_arr->id){
							$sel_2 = 'selected="selected"';
						} ?>
						<option value="<?= $chd_modules_arr->id; ?>" <?php echo $sel_2; ?>>
						&nbsp; &nbsp; - &nbsp;  <?= stripslashes($chd_modules_arr->name); ?>
						</option>
					<?php  
					} 
				}  
			}
		} ?> 
           </select>
               <span id="parent_id1" class="text-danger" generated="true"><?php echo form_error('parent_id'); ?></span>
              </div>
          </div>
                  
		  <div class="form-group">
			<label class="control-label col-md-2" for="name"> Module Name <span class="reds"> *</span></label>
			<div class="col-md-6">
			  <input name="name" id="name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->name): set_value('name'); ?>" data-error="#name1"> 
              <span id="name1" class="text-danger" generated="true"><?php echo form_error('name'); ?></span> 
               </div>
		  </div>  
           
          <div class="form-group">
			<label class="control-label col-md-2" for="icon_name">Icon </label>
			<div class="col-md-6">
			  <input name="icon_name" id="icon_name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->icon_name): set_value('icon_name'); ?>" data-error="#icon_name1"> 
              <span id="icon_name1" class="text-danger" generated="true"><?php echo form_error('icon_name'); ?></span> 
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
					$max_sort_val = $this->admin_model->get_max_modules_sort_val();
                    $temp_sort_order = $max_sort_val+1;
                  } ?>
                  <input name="sort_order" id="sort_order" type="text" class="form-control" value="<?php echo $temp_sort_order; ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" data-error="#sort_order1"> 
                <span id="sort_order1" class="text-danger" generated="true"><?php echo form_error('sort_order'); ?></span> 
              </div> 
            </div>
            
          <div class="form-group">
            <label class="col-md-2 control-label" for="controller_name">Controller Name </label> 
            <div class="col-md-6">
                  <input name="controller_name" id="controller_name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->controller_name): set_value('controller_name'); ?>" data-error="#controller_name1"> 
                  <span id="controller_name1" class="text-danger" generated="true"><?php echo form_error('controller_name'); ?></span> 
              </div>  
          </div>
		   
		  <div class="form-group">
            <label class="col-md-2 control-label" for="method_name">Method Name </label> 
            <div class="col-md-6">
			  <input name="method_name" id="method_name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->method_name): set_value('method_name'); ?>" data-error="#method_name1"> 
			  <span id="method_name1" class="text-danger" generated="true"><?php echo form_error('method_name'); ?></span> 
              </div>  
          </div>
              
          <div class="form-group">
            <label class="col-md-2 control-label"></label>
            <div class="col-md-6">
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves" id="saves"><i class="glyphicon glyphicon-ok position-left"></i>Save</button>  
              &nbsp;
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves_and_new" id="save_and_new"><i class="glyphicon glyphicon-repeat position-left"></i>Save & New</button>  
              &nbsp;
              <button type="reset" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button>
       
              &nbsp;
              <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('modules/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button>  
            </div> 
          </div>
        
   		 </form> 
            
		<script type="text/javascript">  
            $(document).ready(function(){ 
                var validator = $('#datas_form').validate({
                rules: {
                    parent_id: {
                        required: true 
                    },
					name: {
                        required: true 
                    }, 
					sort_order: {
                        required: true 
                    }   
                },
                messages: {
					parent_id: {
                        required: "This is required field"  
                    },
					name: {
                        required: "This is required field"  
                    }, 
					sort_order: {
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