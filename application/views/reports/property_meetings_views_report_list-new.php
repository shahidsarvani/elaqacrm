<?php $this->load->view('widgets/meta_tags'); ?>
<body>
<section class="body">
  <?php $this->load->view('widgets/header'); ?>
  <div class="inner-wrapper"> 
	<?php $this->load->view('widgets/left_sidebar'); ?>
    <section role="main" class="content-body"> 
	<?php $this->load->view('widgets/breadcrumbs'); ?>
    <!-- start: page -->
	<?php  
		if($this->session->flashdata('success_msg')){ ?>
			<div class="row">
				<div class="col-lg-12">
				<div class="alert alert-success">
				  <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Success!</strong> <?php echo $this->session->flashdata('success_msg'); ?> </div>
		   </div>
		 </div>
	<?php } if($this->session->flashdata('error_msg')){ ?>
		 	<div class="row">
         	 <div class="col-lg-12">
            	<div class="alert alert-danger">
              		<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Error!</strong> <?php echo $this->session->flashdata('error_msg'); ?> </div>
			   </div>
       		 </div>
     <?php } if($this->session->flashdata('photo_error_msg')){ ?>
		 	<div class="row">
         	 <div class="col-lg-12">
            	<div class="alert alert-danger">
              		<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Error!</strong> <?php echo $this->session->flashdata('photo_error_msg'); ?> </div>
			   </div>
       		 </div>
     <?php } if($this->session->flashdata('other_medias_error_msg')){ ?>
		 	<div class="row">
         	 <div class="col-lg-12">
            	<div class="alert alert-danger">
              		<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Error!</strong> <?php echo $this->session->flashdata('other_medias_error_msg'); ?> </div>
			   </div>
       		 </div>
     <?php } if($this->session->flashdata('documents_error_msg')){ ?>
		 	<div class="row">
         	 <div class="col-lg-12">
            	<div class="alert alert-danger">
              		<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Error!</strong> <?php echo $this->session->flashdata('documents_error_msg'); ?> </div>
			   </div>
       		 </div>
     <?php }  ?> 
	<section class="panel">  
        <header class="panel-heading">
          <div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> </div>
          <h2 class="panel-title"><?php echo $page_headings; ?></h2>
        </header>
		<?php $vs_user_type_id = $this->session->userdata('us_user_type_id'); ?>
        <div class="panel-body"> 
        
		<form name="datas_form" id="datas_form" action="" method="post">
		<div class="row">
			<div class="col-md-12"> 
				<div class="form-group mb-md"> 
				<?php 
				$vs_user_type_id = $this->session->userdata('us_user_type_id');
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
                 <input name="from_date" id="from_date" type="text" class="form-control input-sm" value="<?php echo set_value('from_date'); ?>" placeholder="From Date" style="text-align:center;"> -
                      <input name="to_date" id="to_date" type="text" class="form-control input-sm" value="<?php echo set_value('to_date'); ?>" placeholder="To Date"  style="text-align:center;"> 
               </div>
                
                
                
				<div class="col-md-3 pull-right">
					<!--<button type="submit" name="search" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button>--> 
                    
                    <a class="mb-xs mr-xs btn btn-sm btn-primary" href="<?= site_url('reports/property_meetings_views_report_list'); ?>" title="Clear Filters"> <i class="fa fa-refresh"></i> Clear</a>  
                     <a id="print_button2" href="javascript:void(0);" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-print"></i> &nbsp; Print </a> 
					 
                    <!--<a href="<?php echo site_url('reports/property_leads_report_detail'); ?>" target="_blank" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-arrows-alt"></i> &nbsp; Print Preview</a>--> 
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
            
         </div>
         
        </div>
      </section> 
      
      <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
  <!--  class="simple-ajax-modal"  end: page -->
  </section>
  </div> 
</section>

<?php  
	if(strlen($frmt_arrs )>0){ ?>
	<script type="text/javascript"> 
		var flotPieData = [<?php echo $frmt_arrs; ?>];  
	</script>
 <?php } ?>
 
 
 
 
<!-- Vendor --> 
<script src="<?= asset_url();?>vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?= asset_url();?>vendor/nanoscroller/nanoscroller.js"></script> 
<script src="<?= asset_url();?>vendor/magnific-popup/magnific-popup.js"></script>
<!-- Specific Page Vendor -->
<script src="<?= asset_url();?>vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?= asset_url();?>vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
<script src="<?= asset_url();?>vendor/jquery-appear/jquery.appear.js"></script>
<script src="<?= asset_url();?>vendor/morris/morris.js"></script>
<?php 
$cstm_curr_page_name = $this->uri->segment(2);   
//if($cstm_curr_page_name=="operate_property" || $cstm_curr_page_name=="agents_meetings_view_list"){ ?>
<script src="<?= asset_url();?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<?php 
//}

if($cstm_curr_page_name=="properties_list" || $cstm_curr_page_name=="archived_properties_list" || $cstm_curr_page_name=="deleted_properties_list" || $cstm_curr_page_name=="operate_property"){ ?>
<script src="<?= asset_url();?>vendor/select2/select2.js"></script>
<script src="<?= asset_url();?>vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?= asset_url();?>vendor/dropzone/dropzone.js"></script> 
<?php } 

	if($cstm_curr_page_name=="property_leads_report_list" && strlen($frmt_arrs )>0){ ?> 
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
 <?php 
} ?> 

<script>
 function operate_property_leads_reports(){  
	
	jQuery.noConflict()(function($){	 	  
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
			data: {  sel_assigned_to_val: sel_assigned_to_id, sel_lead_type_val: sel_lead_type_id, from_date: from_date, to_date: to_date },
			beforeSend: function(){
				$('.loading').show();
			},
			success: function(data){
				$('.loading').hide();
				$('#fetch_tbl_data').html(data);
				  
			}
		}); 
		
		/*$.ajax({
			method: "POST",
			url: "<?php //echo site_url('/reports/property_type_categories_report_chart/'); ?>",
			data: {  sel_assigned_to_val: sel_assigned_to_id, sel_category_val: sel_category_id, sel_property_type_val: sel_property_type_id, from_date: from_date, to_date: to_date },
			beforeSend: function(){
				$('.loading').show();
			},
			success: function(restss){
				$('.loading').hide();
				//$('#flotPie').html(data);
				//$('#flotPie').html(''); 
				// var flotPieData = [data];  \
				//var flotPieData = data;  
				//operate_pie_charts(data);
				
				/*var data = restss;
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
		});*/
		
		});
	});
}
 
</script>

<!-- Theme Base, Components and Settings -->
<script src="<?= asset_url();?>vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?= asset_url();?>vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="<?= asset_url();?>vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?= asset_url();?>javascripts/theme.js"></script> 
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
					operate_property_leads_reports();
			}); 
			
			$('#to_date').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_property_leads_reports();
			}); 
			
			
		});
	});
	</script>
<!-- Theme Custom -->
<script src="<?= asset_url();?>javascripts/theme.custom.js"></script>
<!-- Theme Initialization Files -->
<script src="<?= asset_url();?>javascripts/theme.init.js"></script>
<script src="<?= asset_url();?>javascripts/forms/examples.advanced.form.js"></script>
<!-- Examples -->
<script src="<?= asset_url();?>javascripts/tables/examples.datatables.default.js"></script> 
<script src="<?= asset_url();?>javascripts/ui-elements/examples.modals.js"></script> 
<!--<script src="<?= asset_url();?>javascripts/ui-elements/examples.charts.js"></script>-->
<script src="<?= asset_url();?>javascripts/jquery.PrintArea.js" type="text/javaScript" language="javascript"></script>

<script>
jQuery.noConflict()(function($){	 	  
	$(document).ready(function(){    
         $("#print_button2").click(function(){
            var mode = 'iframe'; // popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : false};
            $("#printing_area").printArea( options );
        });
    });
});
  </script>
</body>
</html> 