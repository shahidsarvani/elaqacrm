<table class="table table-bordered table-striped table-hover">
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
    <tbody id="fetch_owners_popup_add_list">
<?php 
	$sr=1; 
	if(isset($page) && $page >0){
		$sr = $page+1;
	} 
	if(isset($records) && count($records)>0){ 
		foreach($records as $record){ ?> 
		<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
            <td><input type="radio" name="sel_user_id_val" id="sel_user_id_val_<?= $sr; ?>" value="<?= $record->id; ?>" onclick="sels_chk_box_vals(this.value);"> </td>
            <td><label for="sel_user_id_val_<?= $sr; ?>"><?= stripslashes($record->name); ?></label></td>
            <td><?= stripslashes($record->email); ?></td>
            <td class="text-center"><?php echo stripslashes($record->mobile_no); ?> </td>  
            <td class="text-center">
			<?php 
			if($record->role_id>0){  
				$role_arr = $this->roles_model->get_role_by_id($record->role_id);
				if(isset($role_arr)){
					echo stripslashes($role_arr->name);
				} 
			} ?> </td> 
            <td class="text-center"><?= date('d-M-Y',strtotime($record->created_on));?></td>
        </tr> 
		<?php 
            $sr++;
            }    
        }else{ ?>	
            <tr class="gradeX"> 
                <td colspan="6" class="center"> <strong> No Record Found! </strong> </td>
            </tr>
        <?php } ?>  
        </tbody>
      </table> 
      <br />
  	<?php echo $this->ajax_pagination->create_links(); ?> 