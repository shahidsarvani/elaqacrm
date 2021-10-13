 <select name="assigned_to_id" id="assigned_to_id" class="form-control select" data-error="#assigned_to_id1">
 <option value="">Select Assigned To Name</option>
<?php  
	$user_arrs = $this->users_model->get_all_users();
    if(isset($user_arrs) && count($user_arrs)>0){
        foreach($user_arrs as $user_arr){
        $sel_1 = '';
        if(isset($sel_usrid) && $sel_usrid==$user_arr->id){
            $sel_1 = 'selected="selected"';
        } ?>
        <option value="<?= $user_arr->id; ?>" <?php echo $sel_1; ?>>
            <?= stripslashes($user_arr->name); ?>
        </option>
        <?php 
        }
    } ?>
    </select> 