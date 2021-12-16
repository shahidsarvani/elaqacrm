<?php 
	$this->ajax_base_paging = 1; ?> 
  <style>
	  label.control-label{
		font-weight:bold;
	  }
	  
	  table td {
		word-wrap: break-word;
		word-break: break-all;
		white-space: normal;
	 }
	 label.control-label{
		font-size:11px;	 
		font-weight:normal;
	 } 
  </style> 

<div class="panel-body"> 
<form name="datasformchk" id="datasformchk" method="post" action=""> 
<script> 

	function sls_chk_box_vals(sl_leads_id_val){   
		if(sl_leads_id_val >0){ 
			window.parent.clickeds_leads(sl_leads_id_val); 
		}
	} 
			  
	function operate_leads_list(){
		$(document).ready(function(){ 
			var sel_per_page_val =0;   
			var q_val = document.getElementById("q_val").value;  
			var sel_per_page = document.getElementById("per_page");
			sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value; 
			   
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('/leads/leads_popup_list2/'); ?>",
				data: { page: 0, sel_per_page_val: sel_per_page_val, q_val: q_val},
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(data){
					$('.loading').hide();
					$('#fetch_dyn_list').html(data); 
					//$( '[data-toggle=popover]' ).popover(); 
				}
			}); 
		});
	} 
</script>
    
    <div class="row">
        <div class="form-group">
            <div class="col-md-2"> 
            <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control select" onChange="operate_leads_list();">
              <option value="25">Per Page</option>
              <option value="25"> 25 </option>
              <option value="50"> 50 </option>
              <option value="100"> 100 </option> 
            </select>
            </div>
            <div class="col-md-4"> 
            <input name="q_val" id="q_val" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('q_val'); ?>" placeholder="Search..." onKeyUp="operate_leads_list();">
            </div>
            <div class="col-md-3"> </div> 
         </div>  
    </div>
	<br /> 
<div id="fetch_dyn_list">
	<table class="table table-bordered table-striped table-hover">
		<thead>  
			<tr>
				<th width="6%" class="text-center"> # </th>
				<th width="9%" class="text-center">111111111 Ref No.</th> 
				<th width="12%"> Enquiry Date </th>
				<th width="12%"> Enquiry Time </th>
				<th width="9%"> Lead type</th>
				<th width="8%"> Contact Name </th>
				<th width="10%"> Phone No </th> 
				<th width="12%"> Agent Name</th>
				<th width="8%"> Agent Phone No</th> 
				<th width="11%" class="text-center">Updated On </th>
			</tr>   
		</thead>
		<tbody>  
		<?php 
			$sr=1;
			if(isset($records)){
				 foreach($records as $record){ ?>  
				<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
					<td><input type="radio" name="sel_leads_id_val" id="sel_leads_id_val_<?= $sr; ?>" value="<?= $record->id; ?>" onClick="sls_chk_box_vals('<?= $record->id; ?>');"> </td>
					<td><label for="sel_leads_id_val_<?= $sr; ?>"><?= stripslashes($record->ref_no); ?></label></td> 
					<td><?= stripslashes($record->enquiry_date); ?></td>
					<td><?= stripslashes($record->enquiry_time); ?></td>
					<td><?= stripslashes($record->lead_type); ?></td>
					<td><?= stripslashes($record->cnt_name); ?></td>
					<td><?= stripslashes($record->cnt_phone_no); ?></td> 
					<td><?= stripslashes($record->agent_name); ?></td>
					<td><?= stripslashes($record->agent_phone_no); ?></td>  
					<td class="text-center"><?= date('d-M-Y',strtotime($record->updated_on));?></td>
				</tr>
			<?php 
				$sr++;
				} ?>
					 <tr class="gradeX"> 
						<td colspan="10" class="center" style="text-align:center"> 
							<?php echo $this->ajax_pagination->create_links(); ?> 
						</td>
					</tr>	
				<?php 
			}else{ ?>	
				<tr class="gradeX"> 
					<td colspan="10" class="center"> <strong> No Record Found! </strong> </td>
				</tr>
			<?php } ?>  
			</tbody>
	  </table> 
 </div>
 <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div> 
</form>
</div>  