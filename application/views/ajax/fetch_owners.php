 <select name="owner_id" id="owner_id" class="form-control select" data-error="#owner_id1">
 <option value="">Select Owner Name </option>
<?php  
	$owner_arrs = $this->owners_model->get_all_owners();
    if(isset($owner_arrs) && count($owner_arrs)>0){
        foreach($owner_arrs as $owner_arr){
        $sel_1 = '';
        if(isset($sel_owrid) && $sel_owrid==$owner_arr->id){
            $sel_1 = 'selected="selected"';
        } ?>
        <option value="<?= $owner_arr->id; ?>" <?php echo $sel_1; ?>>
            <?= stripslashes($owner_arr->name); ?>
        </option>
        <?php 
        }
    } ?>
    </select> 