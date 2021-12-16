<table class="table table-bordered table-striped table-hover">
	<thead>  
		<tr>
			<th width="6%" class="text-center"> # </th>
			<th width="9%" class="text-center"> Ref No.</th> 
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
		if(isset($page) && $page >0){
			$sr = $page+1;
		}
		if(isset($records) && count($records)>0){
			 foreach($records as $record){ ?>  
			 <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
				<td><input type="radio" name="sel_leads_id_val" id="sel_leads_id_val_<?= $sr; ?>" value="<?= $record->id; ?>" onclick="sels_chk_box_vals(this.value);"> </td>
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