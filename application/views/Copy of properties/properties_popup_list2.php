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
	if(isset($page) && $page >0){
		$sr = $page+1;
	}
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
			<td colspan="11" style="text-align:center"> 
				<?php echo $this->ajax_pagination->create_links(); ?> 
			</td>
		 </tr>	
		<?php 
	}else{ ?>	
		<tr class="gradeX"> 
			<td colspan="11" style="text-align:center"> <strong> No Record Found! </strong> </td>
		</tr>
	<?php } ?>  
	</tbody>
</table>  