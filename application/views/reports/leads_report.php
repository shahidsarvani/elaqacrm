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
				<div class="col-md-3">   
					<select name="assigned_to_id" id="assigned_to_id" data-plugin-selectTwo class="form-control populate" onChange="operate_property_leads_reports();">
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
     <select name="lead_type" id="lead_type" data-plugin-selectTwo class="form-control populate"  onChange="operate_property_leads_reports();">
      <option value="">Select Type </option>
      <option value="Tenant" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Tenant'){ echo 'selected="selected"'; } ?>> Tenant </option>
      <option value="Buyer" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Buyer'){ echo 'selected="selected"'; } ?>> Buyer </option>
      <option value="Landlord" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Landlord'){ echo 'selected="selected"'; } ?>> Landlord </option>
      <option value="Seller" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Seller'){ echo 'selected="selected"'; } ?>> Seller </option>
      <option value="Landlord+Seller" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Landlord+Seller'){ echo 'selected="selected"'; } ?>> Landlord+Seller </option>
      <option value="Not Specified" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Not Specified'){ echo 'selected="selected"'; } ?>> Not Specified </option>
      <option value="Investor" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Investor'){ echo 'selected="selected"'; } ?>> Investor </option>
      <option value="Agent" <?php if(isset($_POST['lead_type']) && $_POST['lead_type']=='Agent'){ echo 'selected="selected"'; } ?>> Agent </option>
    </select>
	</div>
				 
   <div class="col-md-2"> 
     <input name="from_date" id="from_date" type="text" class="form-control input-sm" value="<?php echo set_value('from_date'); ?>" placeholder="From Date" style="text-align:center;">
   </div>
    
    <div class="col-md-2"> 
        <input name="to_date" id="to_date" type="text" class="form-control input-sm" value="<?php echo set_value('to_date'); ?>" placeholder="To Date"  style="text-align:center;"> 
   </div>
                
    <div class="col-md-2 pull-right"> 
        <a class="mb-xs mr-xs btn btn-sm btn-primary" href="<?= site_url('reports/leads_report'); ?>" title="Clear Filters"> <i class="fa fa-refresh"></i> Clear</a>  
         <a id="print_button1" href="javascript:void(0);" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-print"></i> &nbsp; Print </a>  
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
      
      <div id="printing_area1">
      <div class="row"> 
        <div class="col-md-12">
          <section class="panel">
            <header class="panel-heading">
              <div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> </div>
              <h2 class="panel-title"><?php echo $page_headings; ?></h2>
              <p class="panel-subtitle">Pie Chart</p>
            </header>
            <div class="panel-body">
              <!-- Flot: Pie -->
              <div class="chart chart-md" id="flotPie" style="height:450px;"></div> 
              
              
            </div>
          </section>
        </div>
      </div> 
           
			<hr class="cstms"> <br>
		 <table class="table table-bordered table-striped mb-none" <?php //echo (isset($records) && count($records)>0) ? 'id="datatable-default"':''; ?>>
            <thead>
              <tr>
                <th width="6%">#</th> 
                <th width="20%">Type</th>
                <th width="25%" class="center">Number of Leads </th>
                <th width="25%" class="center">Distribution of Leads </th>
              </tr>
            </thead>
            <tbody id="fetch_tbl_data">    
			<?php  
			if($row){ ?>
				<tr class="gradeX">
					<td colspan="2"> <strong><u> Total Leads : </u> </strong></td>
					<td class="center"><?php echo $total_nums = $row->NUMS;   ?></td>
					<td class="center"><?php echo ($total_nums >0) ? '100.00%' : '00.00%'; ?></td>
				</tr>
			<?php 
			}
			
			$sr=1; 
			$frmt_arrs ='';
			if($records){
				foreach($records as $record){ ?>
					<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
					<td><?= $sr; ?></td>
					<td><?php echo $propty_typ = $record->lead_type; ?></td>
					<td class="center"><?= stripslashes($record->NUMS); ?></td>
					<td class="center"><?php  
						$total_nums = $row->NUMS;  
						$curr_nums = $record->NUMS; 
						
						if($total_nums>0 && $curr_nums>0){
							
							$percet_nums = ($curr_nums/$total_nums)*100;
							$percet_nums = number_format($percet_nums,2,".",",");
							echo $percet_nums1 = $percet_nums.'%';
							
							$clr_code = $this->general_model->get_gen_colors($sr);
							 
							$cate_name = $propty_typ;
							
							$frmt_arrs .= "{ label: \" $cate_name \", data:[ [1, $percet_nums] ], color: \"$clr_code\" },";
							
							
							
						}else{
							echo '0.00 %';
						} ?></td>
					</tr>
			<?php 
					$sr++;
				}
				
				if(strlen($frmt_arrs ) >0){
					$frmt_arrs = substr($frmt_arrs,0,-1);
				}
				
			}else{ ?>	
			<tr class="gradeX"> 
				<td colspan="4" class="center"> <strong> No Record Found! </strong> </td>
			</tr>
			<?php 
			} ?>  
            </tbody>
          </table>
            
         </div>
         
        </div>
        
        
        <br>
        <div class="panel-body"> 
        
		<form name="datas_form2" id="datas_form2" action="" method="post">
		<div class="row">
			<div class="col-md-12"> 
				<div class="form-group mb-md"> 
				<?php  
				if($vs_user_type_id==1 || $vs_user_type_id==2){ ?>
				<div class="col-md-3">   
					<select name="assigned_to_id2" id="assigned_to_id2" data-plugin-selectTwo class="form-control populate" onChange="operate_property_leads_source_reports();">
                      <option value="">Select Agent...</option>
                      <?php  
						if($user_arrs){
							foreach($user_arrs as $user_arr){ ?>
                      			<option value="<?= $user_arr->id; ?>" <?php echo (isset($_POST['assigned_to_id']) && $_POST['assigned_to_id']==$user_arr->id) ? 'selected="selected"':''; ?>>
                     			<?= stripslashes($user_arr->name); ?>
                      </option>
                      <?php 
							}
						} ?>
                    </select>   mm                                              
				</div>
				<?php } ?>  
				   
	<div class="col-md-3">  
    <select name="source_of_listing" id="source_of_listing" data-plugin-selectTwo class="form-control populate" onChange="operate_property_leads_source_reports();">
      <option value="">Select Source of Received Leads...</option>
    <?php  
	$source_of_listing_arrs = $this->admin_model->get_all_leads_source_of_listings(); 
    if($source_of_listing_arrs){
        foreach($source_of_listing_arrs as $source_of_listing_arr){
            $sel_1 = '';
            if(isset($_POST['source_of_listing']) && $_POST['source_of_listing']==$source_of_listing_arr->id){
                $sel_1 = 'selected="selected"';
            } ?>
          <option value="<?= $source_of_listing_arr->id; ?>" <?php echo $sel_1; ?>>  <?= stripslashes($source_of_listing_arr->title); ?> </option>
          <?php 
        }
    } ?> </select> 
	</div>
				 
   <div class="col-md-2"> 
     <input name="from_date2" id="from_date2" type="text" class="form-control input-sm" value="<?php echo set_value('from_date2'); ?>" placeholder="From Date" style="text-align:center;">
   </div>
    
    <div class="col-md-2"> 
        <input name="to_date2" id="to_date2" type="text" class="form-control input-sm" value="<?php echo set_value('to_date2'); ?>" placeholder="To Date"  style="text-align:center;"> 
   </div>
                
    <div class="col-md-2 pull-right">  
        
        <a class="mb-xs mr-xs btn btn-sm btn-primary" href="<?= site_url('reports/leads_report'); ?>" title="Clear Filters"> <i class="fa fa-refresh"></i> Clear</a>  
         <a id="print_button2" href="javascript:void(0);" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-print"></i> &nbsp; Print </a>  
    </div> 
				</div>
			</div>
		</div>   
		</form> 
     <hr class="cstms"> <br>
      
      <div id="printing_area2">
      <div class="row"> 
        <div class="col-md-12">
          <section class="panel">
            <header class="panel-heading">
              <div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> </div>
              <h2 class="panel-title"><?php echo $page_sub_headings; ?></h2>
              <p class="panel-subtitle">Pie Chart</p>
            </header>
            <div class="panel-body">
              <!-- Flot: Pie -->
              <div class="chart chart-md" id="flotPie2" style="height:450px;"> </div>  
            </div>
          </section>
        </div>
      </div> 
           
			<hr class="cstms"> <br>
		 <table class="table table-bordered table-striped mb-none" <?php //echo (isset($records) && count($records)>0) ? 'id="datatable-default"':''; ?>>
            <thead>
              <tr>
                <th width="6%">#</th> 
                <th width="20%">Type</th>
                <th width="25%" class="center">Number of Leads </th>
                <th width="25%" class="center">Distribution of Leads </th>
              </tr>
            </thead>
            <tbody id="fetch_tbl_data2">    
			<?php 
			$total_nums1 =''; 
			if($row1){ ?>
				<tr class="gradeX">
					<td colspan="2"> <strong><u> Total Leads : </u> </strong></td>
					<td class="center"><?php echo $total_nums1 = $row1->NUMS; ?></td>
					<td class="center"><?php echo ($total_nums1 >0) ? '100.00%' : '00.00%';?></td>
				</tr>
			<?php 
			}
			
			$sr=1; 
			$frmt_arrs2 ='';
			if($record1s){
				foreach($record1s as $record1){ ?>
					<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
					<td><?= $sr; ?></td>
					<td><?php  
					$propty_source_of_listing_nm =''; 
					$propty_source_of_listing = $record1->source_of_listing;
					if($propty_source_of_listing>0){  
						$propty_source_of_listing_arr = $this->admin_model->get_source_of_listing_by_id($propty_source_of_listing);
						if(isset($propty_source_of_listing_arr)){
							echo $propty_source_of_listing_nm = stripslashes($propty_source_of_listing_arr->title);

						}
					} ?></td>
					<td class="center"><?= stripslashes($record1->NUMS); ?></td>
					<td class="center"><?php  
						 
						$curr_nums1 = $record1->NUMS;
						if($total_nums1>0 && $curr_nums1>0){
							
							$percet_nums1 = ($curr_nums1/$total_nums1)*100;
							$percet_nums1 = number_format($percet_nums1,2,".",",");
							echo $percet_nums2 = $percet_nums1.'%';
							
							$clr_code2 = $this->general_model->get_gen_colors($sr);
							 
							$cate_name = $propty_source_of_listing_nm;
							
							$frmt_arrs2 .= "{ label: \" $cate_name \", data:[ [1, $percet_nums1] ], color: \"$clr_code2\" },";
							
							
							
						}else{
							echo '0.00 %';
						} ?></td>
					</tr>
			<?php 
					$sr++;
				}
				
				if(strlen($frmt_arrs2 ) >0){
					$frmt_arrs2 = substr($frmt_arrs2,0,-1);
				}
				
			}else{ ?>	
			<tr class="gradeX"> 
				<td colspan="4" class="center"> <strong> No Record Found! </strong> </td>
			</tr>
			<?php 
			} ?>  
            <tr class="gradeX"> 
				<td colspan="4" class="center"> <hr>   </td>
			</tr> 
           	 <tr class="gradeX">
                <td colspan="2"> <strong><u> Conversion: </u> </strong></td>
                <td class="center"> <strong><?php 
				if(isset($row2)){
					$sum_nos_of_views = $row2->sum_nos_of_views;
					
					if($total_nums1>0 && $sum_nos_of_views>0){
						$conversion = ($total_nums1/$sum_nos_of_views)*100; 
						echo $conversion = number_format($conversion,2,".",",").' %';
					}
				}  ?> </strong></td> 
                <td class="center"> </td>
           	 </tr>
            
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
		 var flotPieData = '';
		 var flotPieData2 = '';
		<?php  
			if(strlen($frmt_arrs)>0){ ?>
				flotPieData = [<?php echo $frmt_arrs; ?>];
		<?php } 
			if(strlen($frmt_arrs2)>0){ ?>
				flotPieData2 = [<?php echo $frmt_arrs2; ?>];
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
	 function operate_property_leads_reports(){   
		$(document).ready(function(){
					 
			var from_date = document.getElementById("from_date").value;
			var to_date = document.getElementById("to_date").value;  	     
				 
			var sel_assigned = document.getElementById("assigned_to_id");
			var sel_assigned_to_id = sel_assigned.options[sel_assigned.selectedIndex].value;
			   
			var sel_lead_type = document.getElementById("lead_type");
			var sel_lead_type_id = sel_lead_type.options[sel_lead_type.selectedIndex].value;
					
			 
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('/reports/property_leads_report_tbl/'); ?>",
				data: { sel_assigned_to_val: sel_assigned_to_id, sel_lead_type_val: sel_lead_type_id, from_date: from_date, to_date: to_date },
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
				url: "<?php echo site_url('/reports/property_leads_report_chart/'); ?>",
				data: { sel_assigned_to_val: sel_assigned_to_id, sel_lead_type_val: sel_lead_type_id, from_date: from_date, to_date: to_date },
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(restss){
					$('.loading').hide();
					
					$('#flotPie').html('');  
					var data = '';
					var eventlist = JSON.stringify(restss); 
					eventlist = JSON.parse(eventlist); 
					data = eval(eventlist);
					
					var options = {
							series: {
								pie: {
									show: true, 
									label: {
										 show: true,
										 // Added custom formatter here...
										 formatter: function(label,point){
											 return(point.percent.toFixed(2) + '%');
										 }
									 } 
								}
							},
							legend: {
								show: true
							},
							grid: {
								hoverable: true,
								clickable: true
							}
						 };
				
					$.plot($("#flotPie"), data, options); 
					 
				}
			}); 
		}); 
	}
 
	function operate_property_leads_source_reports(){  	  
		$(document).ready(function(){
					 
			var from_date2 = document.getElementById("from_date2").value;
			var to_date2 = document.getElementById("to_date2").value;  	     
				 
			var sel_assigned2 = document.getElementById("assigned_to_id2");
			var sel_assigned_to_id2 = sel_assigned2.options[sel_assigned2.selectedIndex].value;
			   
			var sel_source_of_listing = document.getElementById("source_of_listing");
			var sel_source_of_listing_id = sel_source_of_listing.options[sel_source_of_listing.selectedIndex].value;
					
			 
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('/reports/property_leads_report_tbl2/'); ?>",
				data: { sel_assigned_to_val2: sel_assigned_to_id2, sel_source_of_listing_val: sel_source_of_listing_id, from_date2: from_date2, to_date2: to_date2 },
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(data){
					$('.loading').hide();
					$('#fetch_tbl_data2').html(data);
					  
				}
			}); 
			
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('/reports/property_leads_report_chart2/'); ?>",
				data: { sel_assigned_to_val2: sel_assigned_to_id2, sel_source_of_listing_val: sel_source_of_listing_id, from_date2: from_date2, to_date2: to_date2 },
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(restsss){
					$('.loading').hide();
					
					$('#flotPie2').html('');  
					var data2 = '';
					var eventlist2 = JSON.stringify(restsss); 
					eventlist2 = JSON.parse(eventlist2); 
					data2 = eval(eventlist2);
					
					var options = {
							series: {
								pie: {
									show: true, 
									label: {
										 show: true,
										 // Added custom formatter here...
										 formatter: function(label,point){
											 return(point.percent.toFixed(2) + '%');
										 }
									 } 
								}
							},
							legend: {
								show: true
							},
							grid: {
								hoverable: true,
								clickable: true
							}
						 };
				
					$.plot($("#flotPie2"), data2, options); 
					 
					}
				});
			}); 
		}
 
</script>

	 <script type="text/javascript"> 	  
		$(document).ready(function(){
			 var data = [<?php echo $frmt_arrs; ?>];
				var options = {
						series: {
							pie: {
								show: true, 
								label: {
									 show: true,
									 // Added custom formatter here...
									 formatter: function(label,point){
										 return(point.percent.toFixed(2) + '%');
									 }
								 } 
							}
						},
						legend: {
							show: true
						},
						grid: {
							hoverable: true,
							clickable: true
						}
					 };
			
				$.plot($("#flotPie"), data, options);  
			
				$("#flotPie").bind("plothover", function(event, pos, obj){
					if (!obj){return;}
					percent = parseFloat(obj.series.percent).toFixed(2);
			
					var html = [];
					html.push("<div style=\"flot:left;width:105px;height:20px;text-align:center;border:1px solid black;background-color:", obj.series.color, "\">", "<span style=\"font-weight:bold;color:white\">", obj.series.label, " (", percent, "%)</span>", "</div>");
					$("#showInteractive").html(html.join(''));        
				});
				$("#flotPie").bind("plotclick", function(event, pos, obj){
					if (!obj){return;}
					alert(obj.series.label + " ("+ percent+ "%)");
				});
				
				function legendClicker(info) {
				  // Do what you want
				  alert("legend click / " + info);
				}
				
				var data2 = [<?php echo $frmt_arrs2; ?>];
				var options = {
						series: {
							pie: {
								show: true, 
								label: {
									 show: true,
									 // Added custom formatter here...
									 formatter: function(label,point){
										 return(point.percent.toFixed(2) + '%');
									 }
								 } 
							}
						},
						legend: {
							show: true
						},
						grid: {
							hoverable: true,
							clickable: true
						}
					 };
			
				$.plot($("#flotPie2"), data2, options);  
			
				$("#flotPie2").bind("plothover", function(event, pos, obj){
					if (!obj){return;}
					percent = parseFloat(obj.series.percent).toFixed(2);
			
					var html = [];
					html.push("<div style=\"flot:left;width:105px;height:20px;text-align:center;border:1px solid black;background-color:", obj.series.color, "\">", "<span style=\"font-weight:bold;color:white\">", obj.series.label, " (", percent, "%)</span>", "</div>");
			
					$("#showInteractive").html(html.join(''));        
				});
				$("#flotPie2").bind("plotclick", function(event, pos, obj){
					if (!obj){return;}
					alert(obj.series.label + " ("+ percent+ "%)");
				});
				 
		
			$('#from_date').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_property_leads_reports();
			}); 
			
			$('#to_date').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_property_leads_reports();
			});
			 
			$('#from_date2').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_property_leads_source_reports();
			}); 
			
			$('#to_date2').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_property_leads_source_reports();
			});
		});
		 	 	  
		$(document).ready(function(){    
			 $("#print_button1").click(function(){
				var mode = 'iframe'; // popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : false};
				$("#printing_area1").printArea( options );
			}); 
			
			$("#print_button2").click(function(){
				var mode = 'iframe'; // popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : false};
				$("#printing_area2").printArea( options );
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
