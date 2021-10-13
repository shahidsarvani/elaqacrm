<!DOCTYPE html>
<html lang="en">
<head>
<?php 
$this->load->view('widgets/meta_tags');  

$add_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','add',$this->dbs_user_role_id,'1'); 	
		
$update_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','update',$this->dbs_user_role_id,'1');   

$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','trash',$this->dbs_user_role_id,'1');

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
		/* $(document).ready(function(){
			$('.daterange-single').datepicker({ 
				autoUpdateInput: false,
				singleDatePicker: true,
				locale: {
					format: 'YYYY-MM-DD',
					cancelLabel: 'Clear'
				}  
			}); 
		 }); */
		  
		 
		 
	  $(document).ready(function(){	 
		 $('#task_detail_modal').on('show.bs.modal', function() {
			$(this).find('.task_detail_body_modal').load("http://localhost/ilaqacrm/tasks/task_to_do_detail/11", function() {
			
					// Init Select2 when loaded
					$('.select').select2({
						minimumResultsForSearch: Infinity
					});
				});
			});
		}); 
		 
		 
		 
		 
		 
		 
		 
	function operate_task_detail(urls){ 	  
		//$(document).ready(function(){	 
		 /*$('#task_detail_modal').on('show.bs.modal', function() {
			$(this).find('.task_detail_body_modal').load("http://localhost/ilaqacrm/tasks/task_to_do_detail/11", function() {
		
				// Init Select2 when loaded
				$('.select').select2({
					minimumResultsForSearch: Infinity
				});
			});
		});*/
			 	
			
	/*$('#modal_remote').on('show.bs.modal', function() {
		$(this).find('.modal-body').load('http://localhost/ilaqacrm/assets/demo_data/wizard/education.html', function() {

			// Init Select2 when loaded
			$('.select').select2({
				minimumResultsForSearch: Infinity
			});
		});
	});*/

	//}); 
}
		 
        function operate_table_datas(){
           // jQuery.noConflict()(function($){	 	  
				$(document).ready(function(){
				
					var sel_per_page_val =0;  
			
					var sel_per_page = document.getElementById("per_page");
					sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value;
					  
					var sel_assigned_to_id = document.getElementById("assigned_to_id");
					var sel_assigned_to_val = sel_assigned_to_id.options[sel_assigned_to_id.selectedIndex].value;
					
					var sel_status_id = document.getElementById("status");
					var sel_status_val = sel_status_id.options[sel_status_id.selectedIndex].value; 
					
					var sel_from_date_val = document.getElementById("from_date").value;
					var sel_to_date_val = document.getElementById("to_date").value;
					
					$.ajax({
						method: "POST",
						url: "<?php echo site_url('/tasks/tasks_list2/'); ?>",
						data: { page: 0, sel_per_page_val:sel_per_page_val, sel_assigned_to_val: sel_assigned_to_val, sel_status_val: sel_status_val, sel_from_date_val: sel_from_date_val, sel_to_date_val: sel_to_date_val },
						beforeSend: function(){
							$('.loading').show();
						},
						success: function(data){
							$('.loading').hide();
							$('#fetch_dya_list').html(data);
							
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
        <?php 
			$vs_user_role_id = $this->session->userdata('us_role_id'); 
			$from_date = $to_date = '';	
			if(isset($_POST['from_date'])){
				$from_date = $_POST['from_date'];
			}  
			if(isset($_POST['to_date'])){
				$to_date = $_POST['to_date'];
			} ?> 
          <div class="panel-body">  
		 <form name="datas_form" id="datas_form" action="" method="post">
            <div class="row">
                <div class="col-md-12"> 
                    <div class="form-group mb-md">  		
							 
                    <div class="col-md-3">   
                        <select name="assigned_to_id" id="assigned_to_id" data-plugin-selectTwo class="form-control select" onChange="operate_table_datas();">
                          <option value="">Select Agent...</option>
                          <?php  
                            if(isset($user_arrs) && count($user_arrs)>0){
                                foreach($user_arrs as $user_arr){ ?>
                                    <option value="<?= $user_arr->id; ?>" <?php echo (isset($_POST['assigned_to_id']) && $_POST['assigned_to_id']==$user_arr->id) ? 'selected="selected"':''; ?>>
                                    <?= stripslashes($user_arr->name); ?>
                          </option>
                          <?php 
                                }
                            } ?>
                        </select>   
                    </div>  
                        
                    <div class="col-md-3"> 
                        <select name="status" id="status" class="form-control select" onChange="operate_table_datas();">
                         <option value="-1">Select Status </option>
                         <option value="0" <?php echo (isset($_POST['status']) && $_POST['status']==0) ? 'selected="selected"' : ''; ?>> Pending </option>
                         <option value="1" <?php echo (isset($_POST['status']) && $_POST['status']==1) ? 'selected="selected"' : ''; ?>> Completed </option> 
                         <option value="2" <?php echo (isset($_POST['status']) && $_POST['status']==2) ? 'selected="selected"' : ''; ?>> In Progress </option> 
                         <option value="3" <?php echo (isset($_POST['status']) && $_POST['status']==3) ? 'selected="selected"' : ''; ?>> Rejected </option>  
                         <option value="4" <?php echo (isset($_POST['status']) && $_POST['status']==4) ? 'selected="selected"' : ''; ?>> Over Due </option>  
                        </select> 
                    </div>	 
                    <div class="col-md-2">  
                        <input name="from_date" id="from_date" type="text" class="form-control daterange-single" value="<?php //echo $from_date; ?>" data-plugin-datepicker data-plugin-options='{"format": "yyyy-mm-dd"}' style="text-align:center;" placeholder="From Date...">      
                    </div>
                    <div class="col-md-2">   
                       <input name="to_date" id="to_date" type="text" class="form-control daterange-single" value="<?php //echo $to_date; ?>" data-plugin-datepicker data-plugin-options='{"format": "yyyy-mm-dd"}'  style="text-align:center;" placeholder="To Date..."> 
                    </div>
								 
						   
                    <div class="col-md-2 pull-right"> 
                   		<div class="dt-buttons"> <a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="<?= site_url('properties/add/'); ?>"><span><i class="glyphicon glyphicon-plus position-left"></i>New</span></a></div>
                        <!--<button type="submit" name="search" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button>-->
                           
                    </div> 
                </div>
            </div>
        </div>
		 </form>
		 <style>
			 #datatable-default_filter{
				display:none !important;
			 }
		 </style> 
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th width="7%">#</th>
              <th class="text-center">Ref No.</th>
              <th class="text-center">Title</th>
              <th class="text-center">Category </th>
              <th class="text-center">Location</th>                
              <th class="text-center">Assigned To </th>
              <th class="text-center">Owner</th>
              <th class="text-center">Added On</th>
              <th class="center">Status</th>
              <th width="12%" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody id="fetch_dya_list">
		<?php 
            $sr=1; 
            if(isset($records) && count($records)>0){
                foreach($records as $record){  
                    $operate_url = 'properties/update/'.$record->id; 
                    $operate_url = site_url($operate_url);
                    
                    $trash_url = 'properties/trash_aj/'.$record->id;
                    $trash_url = site_url($trash_url);
                    
                    $detail_url = 'properties/task_to_do_detail/'.$record->id;
                    $detail_url = site_url($detail_url);
                                
                    $temp_usr_arr = $this->general_model->get_user_info_by_id($record->created_by);
                    $created_by_nm = stripslashes($temp_usr_arr->name); 
                    
                    $assigned_to_nm ='';
                    if($record->assigned_to >0){
                        $temp_usr_arr = $this->general_model->get_user_info_by_id($record->assigned_to);
                        if(isset($temp_usr_arr)){
                            $assigned_to_nm = stripslashes($temp_usr_arr->name); 
                        }
                    } ?>
                <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
                  <td class="text-center"><?= $sr; ?></td>
                  <td class="text-center"><?= stripslashes($record->property_ref); ?></td>
                  <td class="text-center"><?= stripslashes($record->lead_ref); ?></td>
                  <td class="text-center"><?= stripslashes($record->title); ?></td>
                  <td class="text-center"><?= $assigned_to_nm; ?></td>
                  <td class="text-center"><?= date('d-M-Y',strtotime($record->due_date)); ?></td>
                  <td class="text-center"><?= stripslashes($record->due_timing); ?></td>
                  <td class="text-center"><?= date('d-M-Y',strtotime($record->created_on));?></td>
                  <td class="text-center">
				  <?php  
						if(isset($record) && $record->status==0){ 
							echo '<span class="label label-info"> Pending </span>';
						} 
						if(isset($record) && $record->status==1){ 
							echo '<span class="label label-success"> Completed </span>';
						}
						if(isset($record) && $record->status==2){
							echo '<span class="label label-primary"> In Progress </span>';
						}
						if(isset($record) && $record->status==3){
							echo '<span class="label label-warning"> Rejected </span>';
						} 
						if(isset($record) && $record->status==4){
							echo '<span class="label label-danger"> Over Due </span>';
						} ?></td>
                  <td class="text-center">  
                    <ul class="icons-list">
                    <!--<button data-target="#modal_remote" data-toggle="modal" class="btn btn-default btn-sm" type="button">Launch <i class="icon-play3 position-right"></i></button>-->
                     <!--onClick="return operate_task_detail('<?php echo $detail_url; ?>');"-->
                          
                     <li class="text-primary-600"><a href="javascript:void(0);" data-target="#task_detail_modal" data-toggle="modal"><i class="icon-zoomin3"></i></a></li>  
                      <li class="text-primary-600"><a href="<?php echo $operate_url; ?>"><i class="icon-pencil7"></i></a></li> 
                      <li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','fetch_dya_list');"><i class="icon-trash"></i></a></li>  
                    </ul>  
                  </td> 
                </tr>
                <?php 
					$sr++;
					} ?> 
				   <tr>
				   <td colspan="10">
				   <div style="float:left;">  <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate select" onChange="operate_table_datas();">
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
			  <td colspan="10" align="center"><strong> No Record Found! </strong></td>
			</tr>
			<?php } ?>
		  </tbody>
		</table> 
          </div>
           <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
        </form>
        </div> 
        
     <!--<div id="modal_remote" class="modal">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Remote source</h5>
                </div>

                <div class="modal-body"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>-->
        
        
        <div id="task_detail_modal" class="modal">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Remote source</h5>
                    </div>
    
                    <div class="task_detail_body_modal"></div>
    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
                    </div>
                </div>
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