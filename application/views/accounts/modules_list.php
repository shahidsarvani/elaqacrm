<!DOCTYPE html>
<html lang="en">
<head> 
<?php  
$this->load->view('widgets/meta_tags'); ?>
<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom.js"></script>
</head>
<body class="sidebar-xs has-detached-left pace-done">

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
        
        <input type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('accounts/operate_module'); ?>">
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
         
        <form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('accounts/trash_multiple_modules'); ?>" method="post">
        <div id="dyns_list">   
        <table class="table datatable-button-init-custom">
             <thead>
              <tr>
                <th width="6%">#</th>
                <th width="11%">Name</th>
                <th width="10%">URL</th>
                <th width="10%" class="text-center">Controller</th>
                <th width="11%" class="text-center">Add Method</th>
                <th width="11%" class="text-center">Update Method</th>
                <th width="11%" class="text-center">Delete Method</th>
                <th width="11%" class="text-center">View Method</th>
                <th width="7%" class="text-center">Orders</th>
                <th width="10%" class="text-center">Action </th> 
              </tr>
            </thead> 
            <tbody>
	<?php 
		$sr=1;  
		$par_modules_arrs = $this->admin_model->get_all_parent_modules('0'); 			  
		if(isset($par_modules_arrs) && count($par_modules_arrs)>0){
			foreach($par_modules_arrs as $par_modules_arr){
				$operate_url = 'accounts/operate_module/'.$par_modules_arr->id;
                $operate_url = site_url($operate_url);
                
                $trash_url = 'accounts/trash_module_aj/'.$par_modules_arr->id;
                $trash_url = site_url($trash_url); ?>
				   
                <tr>
                    <td>  
                        <div class="checkbox">
                        <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $par_modules_arr->id; ?>" value="<?php echo $par_modules_arr->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                        </div>  
                    </td>
                    <td><?= stripslashes($par_modules_arr->name); ?></td>
                    <td><?= stripslashes($par_modules_arr->url_address); ?></td>
                    <td class="text-center"><?= stripslashes($par_modules_arr->controller_name); ?></td>
                    <td class="text-center"><?php echo stripslashes($par_modules_arr->add_method_name); ?></td>
                    <td class="text-center"><?php echo stripslashes($par_modules_arr->update_method_name);  ?></td>
                    <td class="text-center"><?php echo stripslashes($par_modules_arr->delete_method_name);  ?></td>
                    <td class="text-center"><?php echo stripslashes($par_modules_arr->view_method_name);  ?></td>
                    <td class="text-center"><?= stripslashes($par_modules_arr->sort_order); ?></td>
                    <td class="text-center"> 
                       <ul class="icons-list">
                            <li class="text-primary-600"><a href="<?php echo $operate_url; ?>"><i class="icon-pencil7"></i></a></li> 
                            <li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $par_modules_arr->id; ?>','dyns_list');"><i class="icon-trash"></i></a></li>  
                        </ul>  
                      </td> 
                    </tr> 
                
			<?php  
			$sr++;
			$chd_modules_arrs = $this->admin_model->get_all_parent_modules($par_modules_arr->id); 			
			if(isset($chd_modules_arrs) && count($chd_modules_arrs)>0){
				foreach($chd_modules_arrs as $chd_modules_arr){
					$operate_url_2 = 'accounts/operate_module/'.$chd_modules_arr->id;
					$operate_url_2 = site_url($operate_url_2);
					
					$trash_url_2 = 'accounts/trash_module_aj/'.$chd_modules_arr->id;
					$trash_url_2 = site_url($trash_url_2);  ?>
					 
                    <tr>
                    <td>  
                        <div class="checkbox">
                        <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $chd_modules_arr->id; ?>" value="<?php echo $chd_modules_arr->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                        </div>  
                    </td>
                    <td> &nbsp; - &nbsp; <?= stripslashes($chd_modules_arr->name); ?></td>
                    <td><?= stripslashes($chd_modules_arr->url_address); ?></td>
                    <td class="text-center"><?= stripslashes($chd_modules_arr->controller_name); ?></td>
                    <td class="text-center"><?php echo stripslashes($chd_modules_arr->add_method_name); ?></td>
                    <td class="text-center"><?php echo stripslashes($chd_modules_arr->update_method_name);  ?></td>
                    <td class="text-center"><?php echo stripslashes($chd_modules_arr->delete_method_name);  ?></td>
                    <td class="text-center"><?php echo stripslashes($chd_modules_arr->view_method_name);  ?></td>
                    <td class="text-center"><?= stripslashes($chd_modules_arr->sort_order); ?></td>
                    <td class="text-center"> 
                       <ul class="icons-list">
                            <li class="text-primary-600"><a href="<?php echo $operate_url_2; ?>"><i class="icon-pencil7"></i></a></li> 
                            <li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url_2; ?>','<?php echo $chd_modules_arr->id; ?>','dyns_list');"><i class="icon-trash"></i></a></li>  
                        </ul>  
                      </td> 
                    </tr>
                    
				<?php  
				$sr++; 
				} 
			} 
		}
	}else{ ?>	
        <tr class="gradeX"> 
        <td colspan="10" class="text-center"> <strong> No Record Found! </strong></td>
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