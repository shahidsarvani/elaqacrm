 
<?php $this->ajax_base_paging =1; ?>
  
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
function sels_chk_box_vals(nw_owner_id_val){  
	//var nw_owner_id_val = document.datasformchk.sel_user_id_val.value;
	if(nw_owner_id_val >0){
		window.parent.clickeds_users(nw_owner_id_val);  
	}
}      
     
function operate_users_list(){ 	 	  
    $(document).ready(function(){ 
        var sel_per_page_val =0;   
        var q_val = document.getElementById("q_val").value;  
        var sel_per_page = document.getElementById("per_page");
        sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value;  
		   
        $.ajax({
            method: "POST",
            url: "<?php echo site_url('/users/users_popup_list2/'); ?>",
            data: { page: 0, sel_per_page_val: sel_per_page_val, q_val: q_val, sl_role_id: <?php echo (isset($sl_role_id) && $sl_role_id >0) ? $sl_role_id: '0'; ?>  },
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
            <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control select" onChange="operate_users_list();">
              <option value="25">Per Page</option>
              <option value="25"> 25 </option>
              <option value="50"> 50 </option>
              <option value="100"> 100 </option> 
            </select>
            </div>
            <div class="col-md-4"> 
            <input name="q_val" id="q_val" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('q_val'); ?>" placeholder="Search by Name, Email or Mobile No..." onKeyUp="operate_users_list();">
            </div>
            <div class="col-md-3"> </div> 
         </div>  
    </div>
	<br /> 
<div id="fetch_dyn_list">
<table class="table table-bordered table-striped table-hover">
<thead> 
  <tr> 
    <th width="6%">#</th>
    <th width="20%"> Name</th>
    <th width="20%">Email</th>
    <th width="15%" class="text-center">Mobile No</th> 
    <th width="15%" class="text-center">Role </th>
    <th width="15%" class="text-center">Listed</th> 
  </tr> 
</thead>
<tbody id="fetch_owners_popup_add_list">
<?php 
    $sr=1; 
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
     </div>
     <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div> 
  </form>
    </div>  
   
   