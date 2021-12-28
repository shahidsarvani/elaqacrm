<!DOCTYPE html>
<html lang="en">
<head>
<?php 
	$this->load->view('widgets/meta_tags');
	
 	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Reports','add',$this->dbs_role_id,'1');
	
	$view_res_nums =  $this->general_model->check_controller_method_permission_access('Reports','view',$this->dbs_role_id,'1'); 
	  
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Reports','update',$this->dbs_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Reports','trash',$this->dbs_role_id,'1'); ?>
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
          <?php echo $this->session->flashdata('success_msg'); ?> </div>
        <?php } 
			if($this->session->flashdata('error_msg')){ ?>
        <div class="alert alert-danger no-border">
          <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
          <?php echo $this->session->flashdata('error_msg'); ?> </div>
        <?php } ?>  
		 
		 <section class="panel panel-flat">   
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
			<?php $vs_user_type_id = $this->session->userdata('us_role_id'); ?>
			<div class="panel-body">  
			<form name="datas_form" id="datas_form" action="" method="post">
				<div class="row">
					<div class="col-md-12"> 
						<div class="form-group mb-md">
						<?php 
						$vs_user_type_id = $this->session->userdata('us_role_id');
						if($vs_user_type_id==1 || $vs_user_type_id==2){ ?>
						<div class="col-md-2">   
							<select name="assigned_to_id" id="assigned_to_id" data-plugin-selectTwo class="form-control select2" onChange="operate_property_deals_reports();">
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
						<?php } ?>   
						   
						<div class="col-md-2">   
						<select name="types" id="types" data-plugin-selectTwo class="form-control select2" onChange="operate_property_deals_reports();">
						  <option value="">Select Type... </option>
						  <option value="1" <?php if(isset($_POST['types']) && $_POST['types']=='1'){ echo 'selected="selected"'; } ?>> Sales </option>
						  <option value="2" <?php if(isset($_POST['types']) && $_POST['types']=='2'){ echo 'selected="selected"'; } ?>> Rental </option> 
						 <!-- <option value="0" <?php //if(isset($_POST['types']) && $_POST['types']=='Not Specified'){ echo 'selected="selected"'; } ?>> Not Specified </option>-->
						</select>
						</div>
						<div class="col-md-2">    
						<select name="status" id="status" data-plugin-selectTwo class="form-control select2" onChange="operate_property_deals_reports();">
						  <option value="">Select Status... </option>
						  <option value="Pending" <?php if(isset($_POST['status']) && $_POST['status']=='Pending'){ echo 'selected="selected"'; } ?>> Pending </option>
						  <option value="Close" <?php if(isset($_POST['status']) && $_POST['status']=='Close'){ echo 'selected="selected"'; } ?>> Close </option>
						  <option value="Cancelled" <?php if(isset($_POST['status']) && $_POST['status']=='Cancelled'){ echo 'selected="selected"'; } ?>> Cancelled </option>
						</select>   
						</div>
						
						<div class="col-md-2">  
							<input name="from_date" id="from_date" type="text" class="form-control" value="<?php echo (isset($from_date) && strlen($from_date)>0) ? $from_date: ''; ?>" style="text-align:center;" placeholder="From Date...">      
						</div>
						<div class="col-md-2">   
						   <input name="to_date" id="to_date" type="text" class="form-control" value="<?php echo (isset($to_date) && strlen($to_date)>0) ? $to_date: ''; ?>" style="text-align:center;" placeholder="To Date..."> 
						</div>
						
						<div class="col-md-2 pull-right">  
							 <a class="btn border-slate text-slate-800 btn-flat" href="<?= site_url('reports/deals_reports '); ?>" title="Clear Filters"> <i class="glyphicon glyphicon-refresh position-left"></i> Clear </a> 
							<a id="print_button2" href="javascript:void(0);" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-print position-left"></i> &nbsp; Print </a>
						</div> 
						</div>
					</div>
				</div> 
			</form>
		 <style>
			 #datatable-default_filter{
				display:none !important;
			 }
			 .table-responsive {
				overflow-x:visible !important;
			 }
		 </style>
		 <hr class="cstms"> <br>
		  
		  <div id="printing_area">
		  <div class="row"> 
			<div class="col-md-12">
			  <section class="panel">
				<header class="panel-heading">
				  <div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> </div>
				  <h2 class="panel-title"><?php echo $page_headings; ?></h2>
				  <p class="panel-subtitle">Bar Chart</p>
				</header>
				<div class="panel-body">  
				  <div class="chart chart-md" id="morrisBar" style="width:100%; height:600px;">
					Select From & To Date for Result! 
				  </div>
				</div>
			  </section>
			</div>
		  </div> 
			   
		  <hr class="cstms"> <br>
		  <table class="table table-bordered table-striped mb-none" <?php echo (isset($records) && count($records)>0) ? '':''; /* 'id="datatable-default"':''; */?>>
			<thead>
			  <tr>
				<th width="6%">#</th> 
				<th width="15%">Type</th>
				<th width="15%">Status</th>
				<th width="20%" class="center">Number of Deals </th>
				<th width="20%" class="center">Distribution of Deals </th>
				<th width="20%" class="center">Budget (<?php echo $conf_currency_symbol; ?>)</th>
				</tr>
			</thead>
			<tbody id="fetch_tbl_data">   
			<?php  
			if($row){ ?>
				<tr class="gradeX"> 
					<td colspan="3"> <strong><u> Total Deals : </u> </strong></td>
					<td class="center"><?php echo $total_nums = $row->NUMS;   ?></td>
					<td class="center"><?php echo ($total_nums >0) ? '100.00%' : '00.00%'; ?></td>
					<td><?php echo number_format($row->deal_price_vals,0,".",","); ?> </td> 
				</tr> 
			<?php 
			}
			
			$sr=1; 
			$frmt_arrs ='';
			if(isset($records) && count($records)>0){
				foreach($records as $record){ ?>
					<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
					<td><?= $sr; ?></td>
					<td><?php echo $propty_typ = ($record->types==2) ? 'Rental':'Sale'; ?> </td>
					<td><?php echo stripslashes($record->status); ?></td>
					<td class="center"><?= stripslashes($record->NUMS); ?></td>
					<td class="center"><?php  
						$total_nums = $row->NUMS;  
						$curr_nums = $record->NUMS; 
						
						if($total_nums>0 && $curr_nums>0){
							
							$percet_nums = ($curr_nums/$total_nums)*100;
							$percet_nums = number_format($percet_nums,2,".",",");
							echo $percet_nums1 = $percet_nums.'%';
							
							$clr_code = $this->general_model->get_gen_colors($sr);
							
							$propty_sts = $record->status;
							$cate_name = $propty_typ.' - '.$propty_sts;
							 
							// $frmt_arrs .= "{ label: \" $cate_name \", data:[ [1, $percet_nums] ], color: \"$clr_code\" },";     
							 
							 $frmt_arrs .= '{ y: "'.$cate_name.'", a: '.$curr_nums.' },';
							
						}else{
							echo '0.00 %';
						} ?></td>
						<td><?php echo number_format($record->deal_price_vals,0,".",","); ?> </td>  
					</tr>
			<?php 
					$sr++;
				}
				
				if(strlen($frmt_arrs ) >0){
					$frmt_arrs = substr($frmt_arrs,0,-1);
				}
				
			}else{ ?>	
			<tr class="gradeX"> 
				<td colspan="6" class="center"> <strong> No Record Found! </strong> </td>
			</tr>
			<?php 
			} ?>  
			</tbody>
		  </table> 
		 </div> 
		</div>
	  </section>  
	 <div class="loading" style="display: none;">
		<div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div>
	 </div>
	<!-- end of content -->
	<!-- Footer -->
<?php  
	$this->load->view('widgets/footer');
	$cstm_curr_page_name = $this->uri->segment(2); ?>
	
	<script type="text/javascript">   
		var morrisBarData = '';
		<?php  
		if(strlen($frmt_arrs)>0){ ?> 
			morrisBarData = [<?php echo $frmt_arrs; ?>];  
	<?php } ?>
	</script>	  
	<script src="<?= asset_url();?>vendor/jquery-appear/jquery.appear.js"></script>
	<script src="<?= asset_url();?>vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
	<script src="<?= asset_url();?>vendor/flot/jquery.flot.js"></script>
	<script src="<?= asset_url();?>vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
	<script src="<?= asset_url();?>vendor/flot/jquery.flot.pie.js"></script>
	<script src="<?= asset_url();?>vendor/flot/jquery.flot.categories.js"></script>
	<script src="<?= asset_url();?>vendor/flot/jquery.flot.resize.js"></script>
	<script src="<?= asset_url();?>vendor/jquery-sparkline/jquery.sparkline.js"></script>
	<script src="<?= asset_url();?>vendor/raphael/raphael.js"></script>
	<script src="<?= asset_url();?>vendor/morris/morris.js"></script>
	<script src="<?= asset_url();?>vendor/gauge/gauge.js"></script>
	<script src="<?= asset_url();?>vendor/snap-svg/snap.svg.js"></script>
	<script src="<?= asset_url();?>vendor/liquid-meter/liquid.meter.js"></script> 
	<script src="<?= asset_url();?>js/jquery.PrintArea.js" type="text/javaScript" language="javascript"></script>
 
	<script>
	 function operate_property_deals_reports(){   	  
		$(document).ready(function(){
			
			var sel_assigned = document.getElementById("assigned_to_id");
			var sel_assigned_to_id = sel_assigned.options[sel_assigned.selectedIndex].value;
					 
			var from_date = document.getElementById("from_date").value;
			var to_date = document.getElementById("to_date").value;  	     
				  
			var sel_types = document.getElementById("types");
			var sel_types_id = sel_types.options[sel_types.selectedIndex].value;
			   
			var sel_status = document.getElementById("status");
			var sel_status_id = sel_status.options[sel_status.selectedIndex].value;		
			 
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('/reports/property_deals_report_tbl/'); ?>",
				data: { sel_assigned_to_val: sel_assigned_to_id, sel_types_val: sel_types_id, sel_status_val: sel_status_id, from_date: from_date, to_date: to_date },
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(data){
					$('.loading').hide();
					$('#fetch_tbl_data').html(data); 
				}
			}); 
			
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('/reports/property_deals_report_chart/'); ?>",
				data: { sel_assigned_to_val: sel_assigned_to_id, sel_types_val: sel_types_id, sel_status_val: sel_status_id, from_date: from_date, to_date: to_date },
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(restss){ 
					$('.loading').hide();
					//$('#flotPie').html(data);
					$('#morrisBar').html('');  
					 
					var morrisBarData2 = '';
					var eventlist = JSON.stringify(restss); 
					eventlist = JSON.parse(eventlist); 
					morrisBarData2 = eval(eventlist);    
					
					Morris.Bar({
						resize: true,
						element: 'morrisBar',
						data: morrisBarData2,
						xLabelAngle: 20,
						xkey: 'y',
						ykeys: ['a'],
						labels: ['Type / Status'], 	
						hideHover: true,
						barColors: ['#0088cc']
					});  
					
				}
			}); 
		});
	}
	 
	 
	(function( $ ) { 
		'use strict'; 
		(function() { 
		
			if(morrisBarData!=''){  //alert(morrisBarData);
				Morris.Bar({
					resize: true,
					element: 'morrisBar',
					data: morrisBarData,
					xLabelAngle: 20,
					xkey: 'y',
					ykeys: ['a'],
					labels: ['Type / Status'], 	
					hideHover: true,
					barColors: ['#0088cc']
				});  
			}	
			
			/*var plot = $.plot('#flotPie', flotPieData, {
				series: {
					pie: {
						show: true,
						combine: {
							color: '#999',
							threshold: 0.1
						}
					}
				},
				legend: {
					show: false
				},
				grid: {
					hoverable: true,
					clickable: true
				}
			});*/
		})(); 
	
	}).apply( this, [ jQuery ]);
	 
	   
	$(document).ready(function(){    
		$('#from_date').datepicker({
			format: "yyyy-mm-dd"
			}).on('change', function(){
				$('.datepicker').hide();
				operate_property_deals_reports();
		}); 
		
		$('#to_date').datepicker({
			format: "yyyy-mm-dd"
			}).on('change', function(){
				$('.datepicker').hide();
				operate_property_deals_reports();
		});
	
		 $("#print_button2").click(function(){
			var mode = 'iframe'; // popup
			var close = mode == "popup";
			var options = { mode : mode, popClose : false};
			$("#printing_area").printArea( options );
		});
	}); 
	</script>
		
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
