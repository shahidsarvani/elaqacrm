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
		<?php $form_act = "permissions/add"; ?>
        <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal form-bordered">
          <div class="form-group">
            <label class="col-md-2 control-label" for="module_id">Module(s) <span class="reds">*</span></label>
            <div class="col-md-6">   
            <select name="module_id" id="module_id" class="form-control input-sm mb-md select2" data-error="#module_id1">
                <option value="">Select Module...</option>
                <?php  	
                $par_modules_arrs = $this->admin_model->get_all_parent_modules('0'); 			  
                if(isset($par_modules_arrs) && count($par_modules_arrs)>0){
                    foreach($par_modules_arrs as $par_modules_arr){
                        $sel_1 = ''; 
                        if(isset($_POST['module_id']) && $_POST['module_id']==$par_modules_arr->id){
                            $sel_1 = 'selected="selected"';
                        }else if(isset($record) && $record->module_id==$par_modules_arr->id){
                            $sel_1 = 'selected="selected"';
                        }   ?>
                        <option value="<?= $par_modules_arr->id; ?>" <?php echo $sel_1; ?>>
                       &nbsp; <?= stripslashes($par_modules_arr->name); ?>
                        </option>
                    <?php  
                    $chd_modules_arrs = $this->admin_model->get_all_parent_modules($par_modules_arr->id); 			  
                    if(isset($chd_modules_arrs) && count($chd_modules_arrs)>0){
                        foreach($chd_modules_arrs as $chd_modules_arr){ 
                            $sel_2 = '';
                            if(isset($_POST['parent_id']) && $_POST['parent_id']==$chd_modules_arr->id){
                                $sel_2 = 'selected="selected"';
                            }else if(isset($record) && $record->module_id==$chd_modules_arr->id){
                                $sel_2 = 'selected="selected"';
                            }  ?>
                            <option value="<?= $chd_modules_arr->id; ?>" <?php echo $sel_2; ?>>
                            &nbsp; &nbsp; - &nbsp;  <?= stripslashes($chd_modules_arr->name); ?>
                            </option>
                        <?php  
                        } 
                    }  
                }
            } ?> 
         	</select>
         	<span id="module_id1" class="text-danger" generated="true"><?php echo form_error('module_id'); ?></span>
          </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="role_id">Role Name(s) <span class="reds">*</span></label>
        <div class="col-md-6">
          <select name="role_id" id="role_id" class="form-control select2" data-error="#role_id1">
            <option value="">Select Role Name</option>
            <?php  
            if(isset($role_arrs) && count($role_arrs)>0){
                foreach($role_arrs as $role_arr){ 
                    $sel_1 = '';
                    if(isset($_POST['role_id']) && $_POST['role_id']==$role_arr->id){
                        $sel_1 = 'selected="selected"';
                    }else if(isset($record) && $record->role_id==$role_arr->id){
                        $sel_1 = 'selected="selected"';
                    }?>
                 <option value="<?= $role_arr->id; ?>" <?php echo $sel_1; ?>>
                     <?= stripslashes($role_arr->name); ?>
                 </option>
            <?php 
                }
            } ?>
          </select>
          <span id="role_id1" class="text-danger" generated="true"><?php echo form_error('role_id'); ?></span>
         </div>
      </div>
        
       
      <div class="form-group">
        <label class="col-md-2 control-label" for="is_add_permission">Add Permission </label>
        <div class="col-md-1">
          <div class="checkbox">
            <label for="is_add_permission"> <input type="checkbox" name="is_add_permission" id="is_add_permission" value="1" <?php if((isset($_POST['is_add_permission']) && $_POST['is_add_permission']==1) || (isset($record) && $record->is_add_permission==1)){ echo 'checked="checked"'; } ?> class="styled"> Yes ?
           </label>
          </div>
        </div>    
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="is_update_permission">Update Permission </label>
        <div class="col-md-1">
          <div class="checkbox">
           <label for="is_update_permission">
            <input type="checkbox" name="is_update_permission" id="is_update_permission" value="1" <?php if((isset($_POST['is_update_permission']) && $_POST['is_update_permission']==1) || (isset($record) && $record->is_update_permission==1)){ echo 'checked="checked"'; } ?> class="styled">
           Yes ?</label>
          </div>
        </div>   
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="is_delete_permission">Delete Permission </label>
        <div class="col-md-1">
          <div class="checkbox">
          <label for="is_delete_permission">
            <input type="checkbox" name="is_delete_permission" id="is_delete_permission" value="1" <?php if((isset($_POST['is_delete_permission']) && $_POST['is_delete_permission']==1) || (isset($record) && $record->is_delete_permission==1)){ echo 'checked="checked"'; } ?> class="styled">
            Yes ?</label>
          </div>
        </div>  
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="is_view_permission">View Permission</label>
        <div class="col-md-1">
          <div class="checkbox">
            <label for="is_view_permission">
            <input type="checkbox" name="is_view_permission" id="is_view_permission" value="1" <?php if((isset($_POST['is_view_permission']) && $_POST['is_view_permission']==1) || (isset($record) && $record->is_view_permission==1)){ echo 'checked="checked"'; } ?> class="styled">
           Yes ?</label>
          </div>
        </div>   
      </div>
      <br>
      <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-6">
        
      <?php if(isset($record)){	?>
              <input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>"> 
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="updates" id="updates"><i class="glyphicon glyphicon-ok position-left"></i>Update</button>   
      <?php }else{	?>  
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves" id="saves"><i class="glyphicon glyphicon-ok position-left"></i>Save</button>  
              &nbsp;
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves_and_new" id="save_and_new"><i class="glyphicon glyphicon-repeat position-left"></i>Save & New</button>  
              &nbsp;
              <button type="reset" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button>
    <?php }	?>
          &nbsp;
          <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('permissions/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button> 
          
        </div>
      </div>
       
    </form> 
		<script type="text/javascript">  
            $(document).ready(function(){ 
                var validator = $('#datas_form').validate({
                rules: {
                    module_id: {
                        required: true 
                    },
                    role_id: {
                        required: true 
                    },
                    controller_name: {
                        required: true 
                    }  
                },
                messages: { 
                    module_id: {
                        required: "This is required field" 
                    },
                    role_id: {
                        required: "This is required field" 
                    },
                    controller_name: {
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