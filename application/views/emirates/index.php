<!DOCTYPE html>
<html lang="en">
<head>
<?php  
$this->load->view('widgets/meta_tags'); 
 
$add_res_nums =  $this->general_model->check_controller_method_permission_access('Emirates','add',$this->dbs_user_role_id,'1'); 

$update_res_nums =  $this->general_model->check_controller_method_permission_access('Emirates','update',$this->dbs_user_role_id,'1'); 
 
$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Emirates','trash',$this->dbs_user_role_id,'1'); 

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
        
        <input type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('emirates/add'); ?>">
       <input type="hidden" name="cstm_frm_name" id="cstm_frm_name" value="datas_list_forms"> 
       
    <!-- Custom button -->
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
         
        <form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('emirates/trash_multiple'); ?>" method="post">
        <div id="dyns_list">   
            <table class="table datatable-button-init-custom">
                 <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th width="50%">Name</th>
                    <th width="15%" class="text-center">Status</th> 
                    <th width="15%" class="text-center">Action </th>  
                  </tr>
                </thead>
                
                <tbody>
			<?php   
				$sr=1; 
				if(isset($records) && count($records)>0){
					foreach($records as $record){ 
						$operate_url = 'emirates/update/'.$record->id;
						$operate_url = site_url($operate_url);
						
						$trash_url = 'emirates/trash_aj/'.$record->id;
						$trash_url = site_url($trash_url); ?>
						<tr>
                        <td>
                            <div class="checkbox">
                            <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                            </div>  
                        </td>
						<td><?= stripslashes($record->name); ?></td>
						<td class="text-center">
						<?php 
							$bg_cls ='';
							if($record->status==1){
								$bg_cls = 'label-success';
							}else{
								$bg_cls = 'label-danger';
							} ?>
							<span class="label <?php echo $bg_cls; ?>"> <?php echo ($record->status==1) ? 'Active' : 'Inactive'; ?> </span> </td>  
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
					}
				}else{ ?>	
					<tr class="gradeX"> 
				    <td colspan="4" class="text-center"> <strong> No Record Found! </strong></td>
					</tr>
				<?php } ?>  
          	  </tbody>  
            </table>
        </div> 
        </form>
        </div>  
        <!-- /custom button -->
        
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