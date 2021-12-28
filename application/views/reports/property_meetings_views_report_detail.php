<?php $this->load->view('widgets/meta_tags'); ?>
<body style="background:none;">
<section class="body">
 <style> 	
		.photos_cls input, .other_medias_cls, .documents_cls {
			margin: 7px 0px 7px 0px; 
		}
		
		.photos_cls input[type=file], .other_medias_cls input[type=file], .documents_cls  input[type=file] {
			display:inline; 
		} 
		
		.nieghbourhood_info_cls, .nb_fields_cls {
			margin:6px 0px 6px 0px;
		}
		.nb_fields_cls input[type="text"]{
			width:95%;
			display:inline;				
		} 
		img.mini-img{
			width:240px;
			height:260px;
			padding:2px;
			margin:5px;
			border:1px solid #999999;
		}
		ul.list li{
			float:left;
			width:50%;
			list-style:none;
		}
	</style>
      <div class="row">
        <div class="col-md-12">
          <section class="panel">
            <header class="panel-heading">
              <div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> </div>
              <h2 class="panel-title text-semibold"> <?php echo $page_headings; ?> </h2>
            </header>  
			<?php 
				$vs_user_type_id = $this->session->userdata('us_role_id'); 
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
						<?php
						if($vs_user_type_id==1 || $vs_user_type_id==2){ ?>
						<div class="col-md-3">   
							<select name="assigned_to_id" id="assigned_to_id" data-plugin-selectTwo class="form-control populate">
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
							<input name="from_date" id="from_date" type="text" class="form-control" value="<?php echo $from_date; ?>" style="text-align:center;" readonly>      
						</div>
						<div class="col-md-3">   
						   <input name="to_date" id="to_date" type="text" class="form-control" value="<?php echo $to_date; ?>" style="text-align:center;" readonly> 
						</div>
						<div class="col-md-3 pull-right">
							<button type="submit" name="search" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button>      
						</div> 
						</div>
					</div>
				</div> 
				<hr class="cstms"> <br>
				</form>
                <script> 
					$(document).ready(function(){   
						$('#from_date').datepicker({
							format: "yyyy-mm-dd"
							}).on('change', function(){
								$('.datepicker').hide();
								operate_leads_properties();
						}); 
						
						$('#to_date').datepicker({
							format: "yyyy-mm-dd"
							}).on('change', function(){
								$('.datepicker').hide();
								operate_leads_properties();
						});  
					}); 
				</script> 
				 
				 <style>
				 #datatable-default_filter{
					display:none !important;
				 }
				 .table-responsive {
					overflow-x:visible !important;
				 }
				 </style>
				  <table class="table table-bordered table-striped mb-none" <?php echo (isset($records) && count($records)>0) ? 'id="datatable-default"':''; ?>>
					<thead>
					  <tr>
						<th>#</th> 
						<th>Dated </th> 
						<th class="center">Number of Meetings </th>
						<th class="center">Number of Viewing</th>
					  </tr>
					</thead>
					<tbody>   
					<?php   
					$frmt_arrs = $assigned_to_id_val =''; 
					if(isset($_POST['assigned_to_id']) && ($_POST['assigned_to_id'])>0){
						$assigned_to_id_val = $_POST['assigned_to_id'];
					}
					if((isset($from_date) && strlen($from_date)>0) && (isset($to_date) && strlen($to_date)>0)){ ?>
					<tr class="gradeX">
						<td> </td>
						<td class="center"> <strong>
						<?php echo date('d-M-Y',strtotime($from_date)).' to '.date('d-M-Y',strtotime($to_date));   ?></strong></td>
						<td class="center">
						<strong><?php $total_nos_meetings = $this->admin_model->get_total_custom_meetings_nums($assigned_to_id_val,$from_date,$to_date); 
						echo ($total_nos_meetings >0)? $total_nos_meetings : 0; ?></strong></td> 
						 
						 <td class="center">
						<strong><?php $total_nos_views = $this->admin_model->get_total_custom_views_nums($assigned_to_id_val,$from_date,$to_date); 
						echo ($total_nos_views >0)? $total_nos_views : 0; ?></strong></td> 
					</tr>
						
					<?php  
					$sr=1;  
					$nw_from_date = $from_date; 
					while($nw_from_date <= $to_date ) { 
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
						
						$frmt_arrs .= "{ y: \" $nw_from_date2 \", a: $total_dated_nos_meetings, b: $total_dated_nos_views },";
					  
						 $nw_from_date = strtotime(date("Y-m-d", strtotime($nw_from_date))." +1 day");
						 $nw_from_date = date("Y-m-d",$nw_from_date);  
						 $sr++; 
					}
							
						if(strlen($frmt_arrs ) >0){
							$frmt_arrs = substr($frmt_arrs,0,-1);
						}
							
					}else{ ?>	
					<tr class="gradeX"> 
						<td colspan="3" class="center"> <strong> Select From & To Data for Result! </strong> </td>
					</tr>
					<?php 
					} ?>  
					</tbody>
				  </table> 
				  
				  <hr class="cstms"> <br>
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
						  <div class="chart chart-md" id="morrisBar"></div>
						  <?php  
							if(strlen($frmt_arrs )>0){ ?> 
							<script type="text/javascript"> 
								var morrisBarData = [<?php echo $frmt_arrs; ?>]; 
							</script> 			
						 <?php } ?>
						</div>
					  </section>
					</div>
				  </div> 
				  
				</div>
          </section>
        </div>
      </div>   
</section>


<!-- Vendor --> 
<script src="<?= asset_url();?>vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?= asset_url();?>vendor/nanoscroller/nanoscroller.js"></script> 
<script src="<?= asset_url();?>vendor/magnific-popup/magnific-popup.js"></script>
<!-- Specific Page Vendor -->
<script src="<?= asset_url();?>vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?= asset_url();?>vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
<script src="<?= asset_url();?>vendor/jquery-appear/jquery.appear.js"></script>
<script src="<?= asset_url();?>vendor/morris/morris.js"></script>
<?php $cstm_curr_page_name = $this->uri->segment(2); ?>
<script src="<?= asset_url();?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
 
<script src="<?= asset_url();?>vendor/select2/select2.js"></script>
<script src="<?= asset_url();?>vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
  
<?php //if($cstm_curr_page_name=="property_meetings_views_report_list" && strlen($frmt_arrs )>0){ ?> 
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
 <?php //} ?> 

<!-- Theme Base, Components and Settings -->
<script src="<?= asset_url();?>vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?= asset_url();?>vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="<?= asset_url();?>vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?= asset_url();?>javascripts/theme.js"></script>
<!-- Theme Custom -->
<script src="<?= asset_url();?>javascripts/theme.custom.js"></script>
<!-- Theme Initialization Files -->
<script src="<?= asset_url();?>javascripts/theme.init.js"></script>
<script src="<?= asset_url();?>javascripts/forms/examples.advanced.form.js"></script>
<!-- Examples -->
<script src="<?= asset_url();?>javascripts/tables/examples.datatables.default.js"></script> 
<script src="<?= asset_url();?>javascripts/ui-elements/examples.modals.js"></script> 
<!--<script src="<?= asset_url();?>javascripts/ui-elements/examples.charts.js"></script>-->
<script>
(function( $ ) { 
	'use strict'; 
	(function() { 
		Morris.Bar({
			resize: true,
			element: 'morrisBar',
			data: morrisBarData,
			xLabelAngle: 50,
			xkey: 'y',
			ykeys: ['a', 'b'],
			labels: ['Number of Meetings', 'Number of Views'], 	
			hideHover: true,
			barColors: ['#0088cc', '#2baab1']
		}); 
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
</script>
	 
 </body>
 </html>
<?php //$this->load->view('widgets/footer'); ?>
