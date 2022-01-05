<!DOCTYPE html>
<html lang="en">
<head>
<?php 
	$this->load->view('widgets/meta_tags');  
	
 	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','add',$this->dbs_role_id,'1');
	
	$view_res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','view',$this->dbs_role_id,'1'); 
	  
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','update',$this->dbs_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','trash',$this->dbs_role_id,'1'); ?>
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
        	function operate_tasks_list(){  	  
				$(document).ready(function(){ 
					var sel_per_page_val =0;   
					
					var sel_per_page = document.getElementById("per_page");
					sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value;
					  
					var q_val = document.getElementById("q_val").value;
					q_val = q_val.trim();
					 
					$.ajax({
						method: "POST",
						url: "<?php echo site_url('/tasks/index2/'); ?>",
						data: { page: 0, sel_per_page_val:sel_per_page_val, q_val: q_val},
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
	  
	  <script type="text/javascript"> 
		function view_task_detail(paras1){  
			if(paras1>0){			
				$(document).ready(function(){    
				<?php
					$prpty_dtl_popup_url = 'tasks/task_detail/';
					$prpty_dtl_popup_url = site_url($prpty_dtl_popup_url); ?> 
					
					var cstm_urls = "<?php echo $prpty_dtl_popup_url; ?>"+paras1;
					
					$('#modal_remote_task_detail').on('show.bs.modal', function() {
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
    
      
      <div id="modal_remote_task_detail" class="modal fade" data-backdrop="false"> 
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Task Detail</h5>
                    </div>

                    <div class="modal-body"></div>

                    <div class="modal-footer">
                        <button id="close_users_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>
     
		<input type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('tasks/operate_task_to_do/'); ?>">
		<input type="hidden" name="cstm_frm_name" id="cstm_frm_name" value="datas_list_forms">
		
		<form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('tasks/trash_multiple'); ?>" method="post">
        <div class="row">
            <div class="col-md-12"> 
             
            	<div class="form-group mb-md">   
                  <div class="col-md-1">    
                  <select name="per_page" id="per_page" class="form-control input-sm select2" onChange="operate_tasks_list();">
                  <option value="25"> Pages</option>
                  <option value="25"> 25 </option>
                  <option value="50"> 50 </option>
                  <option value="100"> 100 </option> 
                </select> 
                  </div> 
                  
                  <div class="col-md-3">  
                  <input name="q_val" id="q_val" onKeyUp="operate_tasks_list();" placeholder="Search..." type="text" class="form-control input-sm mb-md">   
            	  </div> 
                  <div class="col-md-3">   
                  </div>    
                    
                  <div class="col-md-3 pull-right"> 
                    <div class="dt-buttons"> 
                     <?php if($trash_res_nums>0){ ?>
                     	<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="javascript:void(0);" onClick="return operate_multi_deletions('datas_list_forms');"> <span><i class="glyphicon glyphicon-remove-circle position-left"></i>Delete</span></a> 
                     
                    <?php } if($add_res_nums>0){ ?> 
                         	<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="<?= site_url('tasks/operate_task_to_do/'); ?>"><span><i class="glyphicon glyphicon-plus position-left"></i>New</span></a>
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
			<th>#</th>
			<th class="center">Property Ref No.</th>
			<th class="center">Lead Ref No.</th>
			<th class="center">Task Detail</th>
			<th class="center">Assigned To </th>
			<th class="center">Due Date </th>
			<th class="center">Due Timing</th>
			<th class="center">Task Added</th>
			<th class="center">Status</th>
			<th class="center">Action</th>
		  </tr>
		</thead>
		<tbody id="dyns_list">
	<?php 
		$vs_id = $this->session->userdata('us_id');
		$sr=1; 
		if(isset($records) && count($records)>0){
			foreach($records as $record){
				$operate_url = 'tasks/operate_task_to_do/'.$record->id; 
				$operate_url = site_url($operate_url);
				
				$trash_url = 'tasks/trash_aj/'.$record->id;
				$trash_url = site_url($trash_url);
				
				$detail_url = 'tasks/task_detail/'.$record->id;
				$detail_url = site_url($detail_url);
						
			$temp_usr_arr = $this->general_model->get_user_info_by_id($record->created_by);
			$created_by_nm = stripslashes($temp_usr_arr->name); 
			
			$assigned_to_nm ='';
			if($record->assigned_to >0){
				$temp_usr_arr = $this->general_model->get_user_info_by_id($record->assigned_to);
				if(isset($temp_usr_arr)){
					$assigned_to_nm = stripslashes($temp_usr_arr->name); 
				}
			}   ?>
			<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">  
				<td class="text-center"> <?php echo ($record->is_new==1 && $record->assigned_to==$vs_id) ? ' <span class="badge_mini badge badge-danger">new</span>':'';  ?> <div class="checkbox"> <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?> </label> </div> </td>
				<td><?= stripslashes($record->property_ref); ?></td>
				<td><?= stripslashes($record->lead_ref); ?></td>  
				<td><?= stripslashes($record->title); ?></td>
				<td><?= $assigned_to_nm; ?></td>
				<td class="text-center"><?= date('d-M-Y',strtotime($record->due_date)); ?></td>
				<td class="text-center"><?= stripslashes($record->due_timing); ?></td>
				<td class="text-center"><?= date('d-M-Y',strtotime($record->created_on)); ?></td>
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
					} ?>
				</td>
				<td class="center">   
					<ul class="icons-list">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
							<ul class="dropdown-menu dropdown-menu-right">  	 
						  <?php if($view_res_nums>0){ ?>  
									<li class="text-primary-600"><a href="javascript:void(0);" onClick="return view_task_detail('<?php echo $record->id; ?>');" data-toggle="modal" data-target="#modal_remote_task_detail"><i class="icon-search4"></i> Detail</a></li>   
							<?php }
								if($update_res_nums>0){ ?> 
									<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
							<?php } 
								/*if($trash_res_nums>0 && $this->dbs_user_role_id==1 )*/
								if($trash_res_nums>0){ ?>  
								   <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
						  <?php } ?>  
							</ul>
						</li>
					</ul>
				  </td> 
				 </tr>
				<?php 
					$sr++;
					} ?> 
                    <tr>
                       <td colspan="10">
                       <div style="float:left;">  <select name="per_page" id="per_page" class="form-control input-sm select2" onChange="operate_tasks_list();">
                          <option value="25"> Pages</option>
                          <option value="25"> 25 </option>
                          <option value="50"> 50 </option>
                          <option value="100"> 100 </option> 
                        </select>  </div>
                        <div style="float:right;">  <?php echo $this->ajax_pagination->create_links(); ?>  </div> </td>  
                      </tr> 
                  <?php
				  
				}else{ ?>	
					<tr class="gradeX"> 
						<td colspan="10" style="text-align:center;" class="center"> <strong> No Record Found! </strong> </td>
					</tr>
				<?php } ?>  
            </tbody>
          </table> 
     	</form>
     
      </div>
       <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
        </form>
        </div> 
        <!-- end of content --> 
        
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