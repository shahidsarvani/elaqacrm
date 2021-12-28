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
						<select name="assigned_to_id" id="assigned_to_id" data-plugin-selectTwo class="form-control select2">
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
					<select name="category_id" id="category_id" data-plugin-selectTwo class="form-control select2">
					  <option value="">Select Category...</option>
					  <?php  
						if(isset($category_arrs) && count($category_arrs)>0){
							foreach($category_arrs as $category_arr){ ?>
					  <option value="<?= $category_arr->id; ?>" <?php echo (isset($_POST['category_id']) && $_POST['category_id']==$category_arr->id) ? 'selected="selected"':''; ?>>
					  <?= stripslashes($category_arr->name); ?>
					  </option>
					  <?php 
							}
						} ?>
					</select>
					</div>
					<div class="col-md-3">   
					<select name="property_type" id="property_type" data-plugin-selectTwo class="form-control select2">
					  <option value="">Select Property Type... </option>
					  <option value="1" <?php echo (isset($_POST['property_type']) && $_POST['property_type']=='1') ? 'selected="selected"':''; ?>> Sale </option>
					  <option value="2" <?php echo (isset($_POST['property_type']) && $_POST['property_type']=='2') ? 'selected="selected"':''; ?>> Rent </option>
					</select>   
					</div>
					<div class="col-md-3 pull-right">
						<!--<button type="submit" name="search" class="mb-xs mr-xs btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button>--> 
                         <a class="mb-xs mr-xs btn btn-sm btn-primary" href="<?= site_url('reports/property_type_categories_report_detail'); ?>" title="Clear Filters"> <i class="fa fa-refresh"></i> Clear</a> 
					</div> 
					</div>
				</div>
			</div> 
			<hr class="cstms"> <br>
			</form>
			 
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
					<th>Type</th>
					<th>Category</th>
					<th class="center">Number of Listings </th>
					<th class="center">Distribution of Listings </th>
				  </tr>
				</thead>
				<tbody>   
				<?php  
				if($row){ ?>
					<tr class="gradeX">
						<td> </td>
						<td> </td>
						<td> </td>
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
						<td><?= ($record->property_type==1) ? 'Sale' : 'Rent'; ?></td>
						<td><?php echo  $cate_name = stripslashes($record->cate_name); ?></td>
						<td class="center"><?= stripslashes($record->NUMS); ?></td>
						<td class="center"><?php  
							$total_nums = $row->NUMS;
							$curr_nums = $record->NUMS;
							
							if($total_nums>0 && $curr_nums>0){
								
								$percet_nums = ($curr_nums/$total_nums)*100;
								$percet_nums = number_format($percet_nums,2,".",",");
								echo $percet_nums1 = $percet_nums.'%';
								
								$clr_code = $this->general_model->get_gen_colors($sr);
								
								$propty_typ = ($record->property_type==1) ? 'Sale' : 'Rent';
								$cate_name = $propty_typ.' - '.$cate_name;
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
					<td colspan="5" class="center"> <strong> No Record Found! </strong> </td>
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
    $(function () { 
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
    
    });
    </script>  
	  
 </body>
 </html>
<?php //$this->load->view('widgets/footer'); ?>
 

