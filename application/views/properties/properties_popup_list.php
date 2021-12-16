 
<?php $this->ajax_base_paging = 1; ?> 
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
function sels_chk_box_vals(sl_property_id_val){   
	if(sl_property_id_val >0){ 
	<?php 
		if($paras1 == 0){ ?>
			window.parent.clickeds_properties(sl_property_id_val);  
		<?php 
		}else{?>
			window.parent.clickeds_properties(sl_property_id_val, <?php echo $paras1; ?>);  
		<?php 
		} ?>  
	}
}      
     
function operate_properties_list(){
    $(document).ready(function(){ 
        var sel_per_page_val =0;   
        var q_val = document.getElementById("q_val").value;  
        var sel_per_page = document.getElementById("per_page");
        sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value; 
           
        $.ajax({
            method: "POST",
            url: "<?php echo site_url('/properties/properties_popup_list2/'); ?>",
            data: { page: 0, sel_per_page_val: sel_per_page_val, q_val: q_val, paras1: <?php echo $paras1; ?> },
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
            <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control select" onChange="operate_properties_list();">
              <option value="25">Per Page</option>
              <option value="25"> 25 </option>
              <option value="50"> 50 </option>
              <option value="100"> 100 </option> 
            </select>
            </div>
            <div class="col-md-4"> 
            <input name="q_val" id="q_val" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('q_val'); ?>" placeholder="Search..." onKeyUp="operate_properties_list();">
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
				<th width="9%" class="text-center"> Ref No.</th> 
				<th width="12%"> Title </th>
				<th width="12%"> Sub Location </th>
				<th width="9%"> No of Beds</th>
				<th width="8%"> Price </th>
				<th width="10%"> Property Status </th> 
				<th width="12%"> Property address</th>
				<th width="8%"> Created By</th>
				<th width="8%"> Owner </th>   
				<th width="11%" class="text-center">Updated On </th>
			</tr> 
		</thead>
		<tbody>  
		<?php 
			$sr=1;  //p_description
			if(isset($records) && count($records)>0){
				 foreach($records as $record){ ?>  
				<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
					<td><input type="radio" name="sel_property_id_val" id="sel_property_id_val_<?= $sr; ?>" value="<?= $record->id; ?>" onclick="sels_chk_box_vals(this.value);"> </td>
					<td><label for="sel_property_id_val_<?= $sr; ?>"><?= stripslashes($record->ref_no); ?></label></td> 
					<td><?= stripslashes($record->p_title); ?></td>
					<td><?= stripslashes($record->sub_loc_name); ?></td>
					<td><?= stripslashes($record->bed_title); ?></td>
					<td><?= stripslashes($record->price); ?></td>
					<td><?= stripslashes($record->property_status); ?></td> 
					<td><?= stripslashes($record->property_address); ?></td>
					<td><?= stripslashes($record->crt_usr_name); ?></td>
					<td><?= stripslashes($record->ownr_name); ?></td>   
					<td class="text-center"><?= date('d-M-Y',strtotime($record->updated_on));?></td>
				</tr>
			<?php 
				$sr++;
				} ?>
					 <tr class="gradeX"> 
						<td colspan="11" class="center" style="text-align:center"> 
							<?php echo $this->ajax_pagination->create_links(); ?> 
						</td>
					</tr>	
				<?php 
			}else{ ?>	
				<tr class="gradeX"> 
					<td colspan="11" class="center"> <strong> No Record Found! </strong> </td>
				</tr>
			<?php } ?>  
			</tbody>
	  </table> 
 </div>
 <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div> 
</form>
</div>  
   
   