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
		 
		<section class="panel panel-flat" >  
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
			<?php 
				$vs_user_type_id = $this->session->userdata('us_role_id'); ?> 
			<div class="panel-body"> 
			<form name="datas_form" id="datas_form" action="" method="post">
			<div class="row">
				<div class="col-md-12"> 
					<div class="form-group mb-md">   
					<?php 
					$vs_user_type_id = $this->session->userdata('us_role_id');
					if($vs_user_type_id==1 || $vs_user_type_id==2){ ?>
					<div class="col-md-3">   
						<select name="assigned_to_id" id="assigned_to_id" data-plugin-selectTwo class="form-control select2" onChange="operate_property_meetings_views_reports();">
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
					 
					<div class="col-md-3">  
						<input name="from_date" id="from_date" type="text" class="form-control" value="<?php echo $from_date_val; ?>" style="text-align:center;" placeholder="From Date...">      
					</div>
					<div class="col-md-3">   
					   <input name="to_date" id="to_date" type="text" class="form-control" value="<?php echo $to_date_val; ?>" style="text-align:center;" placeholder="To Date..."> 
					</div>
					<div class="col-md-3 pull-right">
						<!--<button type="submit" name="search" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button> -->
						
						<a class="mb-xs mr-xs btn btn-sm btn-primary" href="<?= site_url('reports/meetings_viewing_report'); ?>" title="Clear Filters"> <i class="fa fa-refresh"></i> Clear</a>
						 
						 <a id="print_button2" href="javascript:void(0);" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-print"></i> &nbsp; Print </a> 
						 
						<!--<a href="<?php echo site_url('reports/property_meetings_views_report_detail'); ?>" target="_blank" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-arrows-alt"></i> &nbsp; Print Preview</a> -->  
					</div> 
					</div>
				</div>
			</div>  
		</form>
	 
			 
		  <hr class="cstms"> <br>
		  <style>
			 #datatable-default_filter{
				display:none !important;
			 }
			 .table-responsive {
				overflow-x:visible !important;
			 }
			 </style>
				 
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
					  <!-- Flot: Pie -->
					  <!--<div class="chart chart-md" id="flotPie"></div> -->
					  <div class="chart chart-md" id="morrisBar" style="width:100%; height:450px;">
						Select From & To Date for Result! 
					  </div>
					  
					  </div>
				  </section>
				</div>
			  </div> 
			 <hr class="cstms"> <br>  
			 
			  <table class="table table-bordered table-striped mb-none" <?php echo (isset($records) && count($records)>0) ? 'id="datatable-default"':''; ?>>
				<thead>
				  <tr>
					<th>#</th> 
					<th class="center">Dated </th> 
					<th class="center">Number of Meetings </th>
					<th class="center">Number of Viewing</th>
				  </tr>
				</thead>
				<tbody id="fetch_tbl_data">   
				<?php   
				$frmt_arrs =''; 
				 
				if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){ ?>
				<tr class="gradeX">
					<td> </td>
					<td class="center"> <strong>
					<?php echo date('d-M-Y',strtotime($from_date_val)).' to '.date('d-M-Y',strtotime($to_date_val));   ?></strong></td>
					<td class="center">
					<strong><?php echo ($total_nos_meetings >0)? $total_nos_meetings : 0; ?></strong></td> 
					 
					 <td class="center">
					<strong><?php echo ($total_nos_views >0)? $total_nos_views : 0; ?></strong></td> 
				</tr>
					
				<?php   
				$sr = $seps = 1; 
				$date_diff ='';  
				$nw_from_date = $from_date_val; 
				
				if(strlen($to_date_val)>0 && strlen($nw_from_date)>0){	
					$date_diff = (strtotime($to_date_val)- strtotime($nw_from_date))/24/3600; 
					$seps = round($date_diff/20);
				}
				
				$tmps_dated_frmt = '';
				$tmps_total_dated_nos_meetings = $tmps_total_dated_nos_views = 0;
				$tmp_str = 0;
				$tmp_str_dt = '';
	  
				while($nw_from_date <= $to_date_val ) { 
					$nw_from_date2 = date('d-M-Y',strtotime($nw_from_date));  
					 
					$total_dated_nos_meetings = $this->admin_model->get_total_dated_meetings_nums($assigned_to_id_val,$nw_from_date); 
					$total_dated_nos_views = $this->admin_model->get_total_dated_views_nums($assigned_to_id_val,$nw_from_date); 
					
					
					$total_dated_nos_meetings = ( $total_dated_nos_meetings >0) ? $total_dated_nos_meetings : 0;
					
					$total_dated_nos_views = ( $total_dated_nos_views >0) ? $total_dated_nos_views : 0;
					 ?> 
					<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
						<td><?= $sr; ?></td>
						<td class="center"><?= $nw_from_date2; ?></td> 
						<td class="center"> <?php echo $total_dated_nos_meetings; ?></td> 
						<td class="center"> <?php echo $total_dated_nos_views; ?></td>
					</tr>
				 <?php  
					if($tmp_str==0){ 
						$tmp_str_dt_arr = explode('-',$nw_from_date2);
						$tmp_str_dt = $tmp_str_dt_arr[0];
					}
					
					if($date_diff >25){ 
						
						if($sr % $seps==0){
							$tmps_total_dated_nos_meetings += $total_dated_nos_meetings;
							$tmps_total_dated_nos_views += $total_dated_nos_views; 
							
							$tmp_str_frmt_dt = $tmp_str_dt.'-'.$nw_from_date2;
							
							$frmt_arrs .= '{ y: "'.$tmp_str_frmt_dt.'", a: '.$tmps_total_dated_nos_meetings.', b: '.$tmps_total_dated_nos_views.' },';
							
							$tmps_total_dated_nos_meetings = 0;
							$tmps_total_dated_nos_views = 0; 
							$tmp_str =0;
							
						}else{
							$tmp_str++;
							$tmps_total_dated_nos_meetings += $total_dated_nos_meetings;
							$tmps_total_dated_nos_views += $total_dated_nos_views; 
						}
						
					}else{
						$frmt_arrs .= '{ y: "'.$nw_from_date2.'", a: '.$total_dated_nos_meetings.', b: '.$total_dated_nos_views.' },'; 
					}
				  
					 $nw_from_date = strtotime(date("Y-m-d", strtotime($nw_from_date))." +1 day");
					 $nw_from_date = date("Y-m-d",$nw_from_date);  
					 $sr++; 
				}
						
					if(strlen($frmt_arrs ) >0){
						$frmt_arrs = substr($frmt_arrs,0,-1);
					}
						
				}else{ ?>	
				<tr class="gradeX"> 
					<td colspan="4" class="center"> <strong> Select From & To Date for Result! </strong> </td>
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
	  	  
		$(document).ready(function(){   
			$('#from_date').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_property_meetings_views_reports();
			}); 
			
			$('#to_date').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_property_meetings_views_reports();
			});  
		}); 
			 
			
		function operate_property_meetings_views_reports(){ 	  
			$(document).ready(function(){ 
				var from_date = document.getElementById("from_date").value;
				var to_date = document.getElementById("to_date").value; 
					 
				var sel_assigned = document.getElementById("assigned_to_id");
				var sel_assigned_to_id = sel_assigned.options[sel_assigned.selectedIndex].value;
				
				if(from_date!='' && to_date!=''){
						  
					$.ajax({
						method: "POST",
						url: "<?php echo site_url('/reports/property_meetings_views_report_tbl/'); ?>",
						data: { sel_assigned_to_val: sel_assigned_to_id, from_date: from_date, to_date: to_date },
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
						url: "<?php echo site_url('/reports/property_meetings_views_report_chart/'); ?>",
						data: { sel_assigned_to_val: sel_assigned_to_id, from_date: from_date, to_date: to_date },
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
								ykeys: ['a', 'b'],
								labels: ['Number of Meetings', 'Number of Views'], 	
								hideHover: true,
								barColors: ['#0088cc', '#2baab1']
							});  
						}
					});  
				} 
			}); 
		}
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
		(function( $ ) { 
			'use strict'; 
			(function() { 
			
				if(morrisBarData!=''){ 
					Morris.Bar({
						resize: true,
						element: 'morrisBar',
						data: morrisBarData,
						xLabelAngle: 20,
						xkey: 'y',
						ykeys: ['a', 'b'],
						labels: ['Number of Meetings', 'Number of Views'], 	
						hideHover: true,
						barColors: ['#0088cc', '#2baab1']
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
