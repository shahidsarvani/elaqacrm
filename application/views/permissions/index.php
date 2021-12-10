<!DOCTYPE html>
<html lang="en">
<head>
<?php 
	$this->load->view('widgets/meta_tags');

	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Permissions','add',$this->dbs_role_id,'1'); 
	
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Permissions','update',$this->dbs_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Permissions','trash',$this->dbs_role_id,'1');  ?>
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
        <?php if($this->session->flashdata('success_msg')){ ?>    
            	<div class="alert alert-success no-border">
                	<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                 <?php echo $this->session->flashdata('success_msg'); ?>
             	</div> 
		<?php } 
			if($this->session->flashdata('error_msg')){ ?>  
                <div class="alert alert-danger no-border">
                	<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                 <?php echo $this->session->flashdata('error_msg'); ?>
                </div>    
		<?php } ?> 
        <script>
        function operate_permission_list(){
           // jQuery.noConflict()(function($){	 	  
				$(document).ready(function(){
				
					var sel_per_page_val =0;  
					var sel_module_id_val =0;
					var sel_user_type_id_val =0; 
					
					var sel_per_page = document.getElementById("per_page");
					sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value;
					  
					var sel_module_id = document.getElementById("module_id");
					sel_module_id_val = sel_module_id.options[sel_module_id.selectedIndex].value;
					
					var sel_user_type_id = document.getElementById("user_type_id");
					sel_user_type_id_val = sel_user_type_id.options[sel_user_type_id.selectedIndex].value; 
					
					$.ajax({
						method: "POST",
						url: "<?php echo site_url('/permissions/index2/'); ?>",
						data: { page: 0, sel_per_page_val:sel_per_page_val, module_id: sel_module_id_val, user_type_id: sel_user_type_id_val},
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
			//});
		}
    	</script>
         
        
        <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"><?php echo $page_headings; ?></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <!--<li><a data-action="close"></a></li>-->
                </ul>
            </div>
        </div>   
      <div class="panel-body">  
    <!-- <form name="datas_form" id="datas_form" action="" method="post">-->
     
     
     <input type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('permissions/add'); ?>">
     <input type="hidden" name="cstm_frm_name" id="cstm_frm_name" value="datas_list_forms">
       
   	 <form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('permissions/trash_multiple'); ?>" method="post">  
     
     <div class="row">
        <div class="col-md-12"> 
            <div class="form-group mb-md">   
              <div class="col-md-1">    
              <select name="per_page" id="per_page" class="form-control input-sm mb-md select2" onChange="operate_permission_list();">
              <option value="25"> Pages</option>
              <option value="25"> 25 </option>
              <option value="50"> 50 </option>
              <option value="100"> 100 </option> 
            </select> 
            </div> 
            <div class="col-md-3"> 
            	<select name="module_id" id="module_id" class="form-control input-sm mb-md select2" onChange="operate_permission_list();">
                    <option value="">Select Module...</option>
                    <?php  	
                    $par_modules_arrs = $this->admin_model->get_all_parent_modules('0'); 			  
                    if(isset($par_modules_arrs) && count($par_modules_arrs)>0){
                        foreach($par_modules_arrs as $par_modules_arr){
                            $sel_1 = ''; 
                            if(isset($_POST['parent_id']) && $_POST['parent_id']==$par_modules_arr->id){
                                $sel_1 = 'selected="selected"';
                            }  ?>
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
            </div>
            
            <div class="col-md-3"> 
            	 <select name="user_type_id" id="user_type_id" class="form-control input-sm mb-md select2" onChange="operate_permission_list();">
                 <option value="">Select Role Name...</option> 
                 <?php  
                    $role_arrs = $this->admin_model->get_all_roles();
                    if(isset($role_arrs) && count($role_arrs)>0){
                        foreach($role_arrs as $role_arr){ ?>
                            <option value="<?= $role_arr->id; ?>" <?php echo (isset($_POST['user_type_id']) && $_POST['user_type_id']==$role_arr->id) ? 'selected="selected"':'';; ?>> <?= stripslashes($role_arr->name); ?></option> 	
                    <?php 
                        }
                    } ?> 
              </select>  
            </div>    
                
                <div class="col-md-3 pull-right"> 
                <div class="dt-buttons"> 
                 <?php if($trash_res_nums>0){ ?>
                    <a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="javascript:void(0);" onClick="return operate_multi_deletions('datas_list_forms');"> <span><i class="glyphicon glyphicon-remove-circle position-left"></i>Delete</span></a> 
                 
                <?php } if($add_res_nums>0){ ?> 
                        <a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="<?= site_url('permissions/add'); ?>"><span><i class="glyphicon glyphicon-plus position-left"></i>New</span></a>
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
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th width="6%">#</th>
                  <th width="12%">Module</th>
                  <th width="10%">Role Name</th>
                  <th width="13%" class="text-center">Add Permission </th>
                  <th width="13%" class="text-center">Update Permission </th>
                  <th width="13%" class="text-center">Delete Permission </th>
                  <th width="13%" class="text-center">View Permission </th>
                  <th width="10%" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody id="dyns_list">
                <?php    
                    $sr=1; 
                    if(isset($records) && count($records)>0){
                        foreach($records as $record){ 
                            $operate_url = 'permissions/update/'.$record->id;
                            $operate_url = site_url($operate_url); 
							
							$trash_url = 'permissions/trash_aj/'.$record->id;
                            $trash_url = site_url($trash_url); ?>
                        <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>"> 
                          <td>
                          	<div class="checkbox">
                           		<label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                            </div>   
                          </td>
                          <td><?= stripslashes($record->module_name); ?></td>
                          <td><?= stripslashes($record->role_name); ?></td>
                          <td class="text-center"><?php echo ($record->is_add_permission==1) ? 'Yes':'No'; ?></td>
                          <td class="text-center"><?php echo ($record->is_update_permission==1) ? 'Yes':'No';  ?></td>
                          <td class="text-center"><?php echo ($record->is_delete_permission==1) ? 'Yes':'No'; ?></td>
                          <td class="text-center"><?php echo ($record->is_view_permission==1) ? 'Yes':'No'; ?></td> 
                          <td class="text-center"> 
                             <ul class="icons-list">
                           <?php if($update_res_nums>0){ ?> 
                                	<li class="text-primary-600"><a href="<?php echo $operate_url; ?>"><i class="icon-pencil7"></i></a></li> 
                         	<?php } 
								if($trash_res_nums>0){ ?> 
                               		<li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');"><i class="icon-trash"></i></a></li> 
                          <?php } ?> 
                            </ul>  
                          </td> 
                        </tr>
                        <?php 
                        $sr++;
                        } ?> 
                       <tr>
                       <td colspan="8">
                       <div style="float:left;">  <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate select" onChange="operate_permission_list();">
                          <option value="25"> Pages</option>
                          <option value="25"> 25 </option>
                          <option value="50"> 50 </option>
                          <option value="100"> 100 </option> 
                        </select>  </div>
                        <div style="float:right;">  <?php echo $this->ajax_pagination->create_links(); ?>  </div> </td>  
                      </tr> 
                  <?php 
                    }else{ ?>
                <tr>
                  <td colspan="8" align="center"><strong> No Record Found! </strong></td>
                </tr>
                <?php } ?>
              </tbody>
            </table> 
            
            </form>
          </div>
           <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
        </form>
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