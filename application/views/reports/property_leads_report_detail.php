<?php $this->load->view('widgets/meta_tags'); ?>
<body style="background:none;" onLoad="window.print();">
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
			<?php $vs_user_type_id = $this->session->userdata('us_user_type_id'); ?> 
			<div class="panel-body"> 
			<form name="datas_form" id="datas_form" action="" method="post">
			<div class="row">
				<div class="col-md-12"> 
					<div class="form-group mb-md"> 
					<?php 
					$vs_user_type_id = $this->session->userdata('us_user_type_id');  ?>  
					   
					<div class="col-md-3">   
                 <select name="lead_type" id="lead_type" data-plugin-selectTwo class="form-control populate">
                  <option value="">Select </option>
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
                    
                     <div class="col-md-3">  
                        <input name="from_date" id="from_date" type="text" class="form-control" value="<?php echo (isset($from_date) && strlen($from_date)>0) ? $from_date: ''; ?>" style="text-align:center;" readonly>      
                    </div>
                    <div class="col-md-3">   
                       <input name="to_date" id="to_date" type="text" class="form-control" value="<?php echo (isset($to_date) && strlen($to_date)>0) ? $to_date: ''; ?>" style="text-align:center;" readonly> 
                    </div> 
					 
					<div class="col-md-3 pull-rightss">
						<button type="submit" name="search" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button>   
					</div> 
					</div>
				</div>
			</div> 
			<hr class="cstms"> <br>
			</form>
            <script>
				jQuery.noConflict()(function($){	 	  
					$(document).ready(function(){   
						$('#from_date').datepicker({
							format: "yyyy-mm-dd"
							}).on('change', function(){
								$('.datepicker').hide();
								//operate_leads_properties();
						}); 
						
						$('#to_date').datepicker({
							format: "yyyy-mm-dd"
							}).on('change', function(){
								$('.datepicker').hide();
								//operate_leads_properties();
						});  
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
                    <th width="6%">#</th> 
                    <th width="20%">Type</th>
                    <th width="25%" class="center">Number of Leads </th>
                    <th width="25%" class="center">Distribution of Leads </th>
                  </tr>
				</thead>
				<tbody>   
				<?php  
				if(isset($row) && count($row->NUMS)>0){ ?>
					<tr class="gradeX">
						<td colspan="2"> <strong><u> Total Leads : </u> </strong></td>
						<td class="center"><?php echo $total_nums = $row->NUMS;   ?></td>
						<td class="center"><?php echo ($total_nums >0) ? '100.00%' : '00.00%'; ?></td>
					</tr>
				<?php 
				}
				
				$sr=1; 
				$frmt_arrs ='';
				if(isset($records) && count($records)>0){
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
			  
			  <hr class="cstms"> <br>
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
					  
					  <?php  
						if(strlen($frmt_arrs )>0){ ?>
						<script type="text/javascript"> 
							var flotPieData = [<?php echo $frmt_arrs; ?>];  
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
  
<!-- Theme Base, Components and Settings --> 
<script src="<?= asset_url();?>javascripts/theme.js"></script>
<!-- Theme Custom -->
<script src="<?= asset_url();?>javascripts/theme.custom.js"></script>
<!-- Theme Initialization Files -->
<script src="<?= asset_url();?>javascripts/theme.init.js"></script>
<script src="<?= asset_url();?>javascripts/forms/examples.advanced.form.js"></script>
<!-- Examples -->
 <script type="text/javascript">
/*$(function () { 
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
        html.push("<div style=\"flot:left;width:105px;height:20px;text-align:center;border:1px solid black;background-color:", obj.series.color, "\">",
                  "<span style=\"font-weight:bold;color:white\">", obj.series.label, " (", percent, "%)</span>",
                  "</div>");

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

});*/

 
	jQuery.noConflict()(function($){	 	  
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
					html.push("<div style=\"flot:left;width:105px;height:20px;text-align:center;border:1px solid black;background-color:", obj.series.color, "\">",
							  "<span style=\"font-weight:bold;color:white\">", obj.series.label, " (", percent, "%)</span>",
							  "</div>");
			
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
		
			$('#from_date').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_property_type_categories_reports();
			}); 
			
			$('#to_date').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_property_type_categories_reports();
			}); 
			
			
		});
	});
	</script>  
	  
 </body>
 </html>
<?php //$this->load->view('widgets/footer'); ?>
 

