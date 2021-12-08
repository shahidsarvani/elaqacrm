<!--<table class="table table-bordered table-striped table-hover">
    <thead>  
      <tr> 
        <th width="6%">#</th>
        <th width="20%"> Name</th>
        <th width="20%">Email</th>
        <th width="15%" class="text-center">Mobile No</th> 
        <th width="15%" class="text-center">Created By </th>
        <th width="15%" class="text-center">Listed</th> 
      </tr>  
    </thead>
    <tbody id="fetch_contacts_popup_add_list">-->
<?php 
	$sr=1; 
	if(isset($page) && $page >0){
		$sr = $page+1;
	} 
	if(isset($records) && count($records)>0){ 
		foreach($records as $record){ 
			$operate_url = 'contacts/edit/'.$record->id;
			$operate_url = site_url($operate_url);
			
			$trash_url = 'contacts/trash_contact/'.$record->id;
			$trash_url = site_url($trash_url);
			
			$temp_usr_arr = $this->general_model->get_user_info_by_id($record->created_by);
			$created_by_nm = stripslashes($temp_usr_arr->name);  ?>  
		<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
			<td><input type="radio" name="sel_contact_id_val" id="sel_contact_id_val_<?= $sr; ?>" value="<?= $record->id; ?>" onclick="sels_chk_box_vals(this.value);"> </td>
			<td><label for="sel_contact_id_val_<?= $sr; ?>"><?= stripslashes($record->name); ?></label></td>
			<td><?= stripslashes($record->email); ?></td>
			<td class="text-center"><?php echo $record->mobile_no; ?></td>  
			<td class="text-center"><?= $created_by_nm; ?></td>
			<td class="text-center"><?= date('d-M-Y',strtotime($record->created_on)); ?></td> 
		</tr>
		<?php 
            $sr++;
            }    
        }else{ ?>	
            <tr class="gradeX"> 
                <td colspan="6" class="center"> <strong> No Record Found! </strong> </td>
            </tr>
        <?php } ?>  
       <!-- </tbody>
      </table> -->
      <br />
  	<?php echo $this->ajax_pagination->create_links(); ?> 