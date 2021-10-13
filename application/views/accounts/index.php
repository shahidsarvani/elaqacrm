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
                 <?php echo $this->session->flashdata('success_msg'); ?>
             	 </div> 
		<?php } 
			if($this->session->flashdata('error_msg')){ ?>  
                <div class="alert alert-danger no-border">
                <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                 <?php echo $this->session->flashdata('error_msg'); ?>
              </div>    
		<?php } ?>  
        
     	 <div class="dt-buttons"><a class="dt-button buttons-pdf buttons-html5 btn bg-teal-400" tabindex="0" aria-controls="DataTables_Table_1" href="<?= site_url('accounts/operate_user'); ?>"><span><i class="icon-printer position-left"></i> Add User</span></a></div>
        <table class="table datatable-basic table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>User Type</th>
              <th class="center">Assigned To </th>
              <th class="center">Status</th>
              <th class="center">Action</th>
            </tr>
          </thead>
          <tbody>
		<?php 
        $sr=1; 
        if(isset($records) && count($records)>0){
            foreach($records as $record){ 
                $operate_url = 'accounts/operate_user/'.$record->id;
                $operate_url = site_url($operate_url);
                
                $trash_url = 'accounts/trash_user/'.$record->id;
                $trash_url = site_url($trash_url);	?>
                <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
                  <td><?= $sr; ?></td>
                  <td><?= stripslashes($record->name); ?></td>
                  <td><?= stripslashes($record->email); ?></td>
                  <td><?= stripslashes($record->role_name); ?></td>
                  <td class="center">
				  <?php 
					if($record->parent_id >0){
						$dbs_parent_id = $record->parent_id;
						$tmp_arrs = $this->general_model->get_user_info_by_id($dbs_parent_id);
						if($tmp_arrs){
							echo $tmp_arrs->name;
						}
					} ?></td>
                  <td class="center">
				  <?php 
					$bg_cls ='';
					if($record->status==1){
						$bg_cls = 'label-success';
					}else{
						$bg_cls = 'label-danger';
					} ?>
                    <span class="label <?php echo $bg_cls; ?>"> <?php echo ($record->status==1) ? 'Active' : 'Inactive'; ?> </span></td>
                  <td class="text-center"><ul class="icons-list">
                      <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-menu9"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                          <li><a href="<?php echo $operate_url; ?>" title="Edit"><i class="icon-file-excel"></i> Edit</a></li>
                          <li><a href="<?php echo $trash_url; ?>" title="Delete" onClick="return confirm('Do you want to delete this?');"><i class="icon-file-word"></i> Delete</a></li>
                        </ul>
                      </li>
                    </ul></td>
                </tr>
                <?php 
                        $sr++;
                        }
                    }?>
              </tbody> 
            </table>
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