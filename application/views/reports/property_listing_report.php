<!DOCTYPE html>
<html lang="en">
<head>
<?php 
	$this->load->view('widgets/meta_tags');  
	
 	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Manager','add',$this->dbs_role_id,'1');
	
	$view_res_nums =  $this->general_model->check_controller_method_permission_access('Manager','view',$this->dbs_role_id,'1'); 
	  
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Manager','update',$this->dbs_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Manager','trash',$this->dbs_role_id,'1'); ?>
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
        	function operate_agents_list(){  	  
				$(document).ready(function(){ 
					var sel_per_page_val =0;   
					
					var sel_per_page = document.getElementById("per_page");
					sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value;
					  
					var q_val = document.getElementById("q_val").value;
					q_val = q_val.trim();
					 
					$.ajax({
						method: "POST",
						url: "<?php echo site_url('/manager/agents_list2/'); ?>",
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
                    <!--<li><a data-action="collapse"></a></li>-->
                    <li><a data-action="reload" onClick="window.location.reload();" ></a></li>
                    <!--<li><a data-action="close"></a></li>-->
                </ul>
            </div>
        </div>   
      <div class="panel-body">   
     
		<input type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('manager/add'); ?>">
		<input type="hidden" name="cstm_frm_name" id="cstm_frm_name" value="datas_list_forms">
		
		<form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('manager/trash_multiple'); ?>" method="post">
        <div class="row" style="margin-bottom:8px;">
            <div class="col-md-12"> 
             
            	<div class="form-group mb-md">   
                  <div class="col-md-1">    
                  <select name="per_page" id="per_page" class="form-control input-sm select2" onChange="operate_agents_list();">
                  <option value="25"> Pages</option>
                  <option value="25"> 25 </option>
                  <option value="50"> 50 </option>
                  <option value="100"> 100 </option> 
                </select> 
                  </div> 
                  
                  <div class="col-md-3">  
                  <input name="q_val" id="q_val" onKeyUp="operate_agents_list();" placeholder="Search..." type="text" class="form-control input-sm mb-md">   
            	  </div> 
                  <div class="col-md-3">   
                  </div>    
                    
                  <div class="col-md-3 pull-right"> 
                     
                    </div> 
                </div> 
                
            </div>
        </div>
		 
		 <style>
			 #datatable-default_filter{
				display:none !important;
			 }
		 </style> 
            <div class="table-responsive">
			<table class="table table-bordered table-striped table-hover"> 
              <thead>
                <tr>
                  <th width="6%">#</th>
                  <th width="17%">Name</th>
                  <th width="25%">Email</th>
                  <th width="17%">Phone No </th>
                  <th width="17%">Mobile No </th>  
                </tr>
              </thead>
              <tbody id="dyns_list">
                <?php  
                    $sr=1; 
                    if(isset($records) && count($records)>0){
                        foreach($records as $record){  ?>
                        <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
                          <td> <?php echo $sr; ?> </td> 	
                          <td><?= stripslashes($record->name); ?></td>
                          <td><?= stripslashes($record->email); ?></td>
                          <td><?= stripslashes($record->phone_no); ?></td>
                          <td><?= stripslashes($record->mobile_no); ?></td>  
                        </tr>
                        <?php 
                        $sr++;
                        } ?> 
                       <tr>
                       <td colspan="5">
                       <div style="float:left;">  <select name="per_page" id="per_page" class="form-control input-sm select2" onChange="operate_agents_list();">
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
                  <td colspan="5" align="center"><strong> No Record Found! </strong></td>
                </tr>
                <?php } ?>
              </tbody>
            </table> 
			</div>
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