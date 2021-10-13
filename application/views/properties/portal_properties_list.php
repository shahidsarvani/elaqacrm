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
$view_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','view',$this->dbs_role_id,'1'); 
 
$add_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','add',$this->dbs_role_id,'1'); 	
		
$update_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','update',$this->dbs_role_id,'1');   

$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','trash',$this->dbs_role_id,'1');

if($add_res_nums>0 && $trash_res_nums>0){ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_add_del.js"></script>
<?php 
}else
if($add_res_nums>0){ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_add.js"></script>
<?php  
}else
if($trash_res_nums>0){ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_del.js"></script>
<?php 
}else{ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom.js"></script>
<?php 
} ?>   
<script> 
	function operate_properties(){   
		$(document).ready(function(){ 
					  
			var sel_per_page = document.getElementById("per_page");
			var sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value; 
			  
			var portal_id_vals = document.getElementById("portal_ids").value;
			portal_id_vals = portal_id_vals.trim();  
			 
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('/properties/portal_properties_list2/'); ?>",   
				data: { page: 0, sel_per_page_val:sel_per_page_val, portal_id_vals:portal_id_vals },
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(data){
					$('.loading').hide();
					$('#dyns_list').html(data);
					
					$('.select').select2({
						minimumResultsForSearch: Infinity
					}); 
				}
			});
		}); 
	} 
</script>
<script type="text/javascript" src="<?= asset_url(); ?>js/custom_multiselect.js"></script>        
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
                            
    <!-- Sidebars overview -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"> <?php //echo $page_headings; ?> 
			<?php    
				if(isset($paras1) && $paras1>0){
					$pp_arr = $this->portals_model->get_portal_by_id($paras1);
					if(isset($pp_arr)){ 
						echo stripslashes($pp_arr->name);
					}
				} ?> Properties
             </h5>
            <div class="heading-elements">
                 
            </div>
        </div> 
        
		<input type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('properties/add'); ?>">
       <input type="hidden" name="cstm_frm_name" id="cstm_frm_name" value="datas_list_forms">
       
    <form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('properties/trash_multiple'); ?>" method="post">   
        <div class="panel-body"> 
            <div class="row">
            <div class="col-md-12"> 
                <div class="form-group mb-md">   
                  <div class="col-md-2">    
                  <select name="per_page" id="per_page" class="form-control input-sm mb-md  select" onChange="operate_properties();">
                  <option value="25"> Pages</option>
                  <option value="25"> 25 </option>
                  <option value="50"> 50 </option>
                  <option value="100"> 100 </option> 
                </select> 
                  </div> 
                    <div class="col-md-5">   
                    </div>    
                    
                    <div class="col-md-3 pull-right"> 
                    <div class="dt-buttons"> 
                     <?php if($trash_res_nums>0){ ?>
                     	<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="javascript:void(0);" onClick="return operate_multi_deletions('datas_list_forms');"> <span><i class="glyphicon glyphicon-remove-circle position-left"></i>Delete</span></a> 
                     
                    <?php } if($add_res_nums>0){ ?> 
                         	<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="<?= site_url('properties/add'); ?>"><span><i class="glyphicon glyphicon-plus position-left"></i>New</span></a>
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
		function view_property(paras1){  
			if(paras1>0){			
				$(document).ready(function(){    
				<?php
					$prpty_dtl_popup_url = 'properties/property_detail/';
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
                        <h5 class="modal-title">Property Detail</h5>
                    </div>

                    <div class="modal-body"></div>

                    <div class="modal-footer">
                        <button id="close_users_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>
                                  
      <table class="table table-bordered table-striped table-hover">  
          <thead>
            <tr>
              <th>#</th>
              <th class="text-center">Ref No.</th>
              <th>Title</th>
              <th>Category </th>
              <th>Assigned To </th>
              <th class="text-center">Status</th>
              <th class="text-center">Price</th>
              <th class="text-center">Added On</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody id="dyns_list"> 	
	  <?php    
        $sr=1; 
        if(isset($records) && count($records)>0){
            foreach($records as $record){ 
                $operate_url = 'properties/update/'.$record->id;
                $operate_url = site_url($operate_url); 
                
                $trash_url = 'properties/trash_aj/'.$record->id;
                $trash_url = site_url($trash_url); ?>
                
                <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
                  <td>
				  <div class="checkbox">
                	<label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                	</div> 
				  <?php //echo ($record->is_new==1) ? 'new' : ''; ?> </td> 	
                  <td class="text-center"><?= stripslashes($record->ref_no); ?></td>
                  <td><?= stripslashes($record->title); ?></td>
                  <td><?= stripslashes($record->cate_name); ?></td>
                  <td>
                    <?php 
					if($record->assigned_to_id>0){
						$usr_arr =  $this->general_model->get_user_info_by_id($record->assigned_to_id);
						echo stripslashes($usr_arr->name);
					} ?> 
                  </td>
                  <td class="text-center"> 
                    <?php  
					if(isset($record) && $record->property_status==1){ 
						echo '<span class="label label-info"> Sold </span>';
					} 
					if(isset($record) && $record->property_status==2){ 
						echo '<span class="label label-success"> Rented </span>';
					}
					if(isset($record) && $record->property_status==3){
						echo '<span class="label label-primary"> Available </span>';
					}
					if(isset($record) && $record->property_status==4){
						echo '<span class="label label-warning"> Upcoming </span>';
					} ?>
                  </td> 
                 <td class="text-center"><?php echo number_format($record->price,0,".",","); /*CRM_CURRENCY.' '.*/ ?></td>  
                  <td class="text-center"><?php echo date('d-M-Y H:i:s',strtotime($record->created_on)); ?></td>   
                  <td class="text-center">  
                     <ul class="icons-list">
                     <?php if($view_res_nums>0){ ?>  
                      	<li class="text-primary-600"><a href="javascript:void(0);" onClick="return view_property('<?php echo $record->id; ?>');" data-toggle="modal" data-target="#modal_remote_property_detail"><i class="glyphicon glyphicon-search"></i></a></li>  
                        
                   <?php } if($update_res_nums>0){ ?> 
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
               <td colspan="9">
               <div style="float:left;"> <select name="per_page" id="per_page" class="form-control input-sm mb-md populate select" onChange="operate_properties();">
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
                  <td colspan="9" align="center"><strong> No Record Found! </strong></td>
                </tr>
                <?php } ?>
              </tbody>
            </table> 
          						 
<div class="loading" style="display: none;">
    <div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div>
    </div>   
</div>  
     </form>
        </div>
        <!-- /sidebars overview --> 

     


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
