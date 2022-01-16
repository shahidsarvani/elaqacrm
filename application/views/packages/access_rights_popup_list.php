 
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
	font-size:12px;	 
	font-weight:normal;
	text-decoration:underline;
 }
 
</style> 
<script>  
	//function operate_access_rights(){  
		$(document).ready(function() {
			var itemsArray = []; 
			$("input[type='checkbox'].styled").click(function(){
			  	itemsArray = []; 
				var i = 0;
				$("input[type='checkbox'].styled:checked").each(function(){
					var field_name = $(this).attr("name");
					var field_val = $(this).val(); 
					///selected_value([i][field_name] = field_val; 
					
					//selected_value.push([field_name =>  ] );
					
 					itemsArray.push({ fieldName : field_name });
					
					i++;
				}); 
				
				window.parent.operate_access_rights_datas(itemsArray); 
			  
			});  
		});  
	//} 
	</script>
	
	<?php 
	  if($paras2){
	  	$paras_arrs = explode('__', $paras2);
		if($paras_arrs){
			$sale_properties_arr = explode('_', $paras_arrs[0]);
			$rental_properties_arr = explode('_', $paras_arrs[1]); 
			$archived_properties_arr = explode('_', $paras_arrs[2]);
			$deleted_properties_arr = explode('_', $paras_arrs[3]);
			
			$manage_leads_arr = explode('_', $paras_arrs[4]);
			$manage_contacts_arr = explode('_', $paras_arrs[5]);
			
			$manage_owners_arr = explode('_', $paras_arrs[6]);      
			$manage_tasks_arr = explode('_', $paras_arrs[7]);
			
			$manage_users_arr = explode('_', $paras_arrs[8]);
			$manage_reports_arr = explode('_', $paras_arrs[9]);
		}
	  }  ?>
	  
<div class="panel-body"> 
<form name="datasformchk" id="datasformchk" method="post" action="" class="form-horizontal">
  <div class="form-group">
      <label class="col-md-2 control-label" for="sale_properties"> Sale Properties </label>
      <div class="col-md-1"> 
        <div class="checkbox">
          <label for="view_sale_properties">
          <input type="checkbox" name="view_sale_properties" id="view_sale_properties" value="1" <?php if((isset($_POST['view_sale_properties']) && $_POST['view_sale_properties']==1) || (isset($sale_properties_arr) && in_array('view', $sale_properties_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="add_sale_properties">
          <input type="checkbox" name="add_sale_properties" id="add_sale_properties" value="1" <?php if((isset($_POST['add_sale_properties']) && $_POST['add_sale_properties']==1) || (isset($sale_properties_arr) && in_array('add', $sale_properties_arr))){ echo 'checked="checked"'; } ?> class="styled"> Add </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="update_sale_properties">
          <input type="checkbox" name="update_sale_properties" id="update_sale_properties" value="1" <?php if((isset($_POST['update_sale_properties']) && $_POST['update_sale_properties']==1) || (isset($sale_properties_arr) && in_array('update', $sale_properties_arr))){ echo 'checked="checked"'; } ?> class="styled">  Update </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="delete_sale_properties">
          <input type="checkbox" name="delete_sale_properties" id="delete_sale_properties" value="1" <?php if((isset($_POST['delete_sale_properties']) && $_POST['delete_sale_properties']==1) || (isset($sale_properties_arr) && in_array('delete', $sale_properties_arr))){ echo 'checked="checked"'; } ?>  class="styled"> Delete </label>
        </div>
      </div>
    </div>
	
  <div class="form-group">
      <label class="col-md-2 control-label" for="rental_properties"> Rental Properties </label>
      <div class="col-md-1"> 
        <div class="checkbox">
          <label for="view_rental_properties">
          <input type="checkbox" name="view_rental_properties" id="view_rental_properties" value="1" <?php if((isset($_POST['view_rental_properties']) && $_POST['view_rental_properties']==1) || (isset($rental_properties_arr) && in_array('view', $rental_properties_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="add_rental_properties">
          <input type="checkbox" name="add_rental_properties" id="add_rental_properties" value="1" <?php if((isset($_POST['add_rental_properties']) && $_POST['add_rental_properties']==1) || (isset($rental_properties_arr) && in_array('add', $rental_properties_arr))){ echo 'checked="checked"'; } ?> class="styled"> Add </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="update_rental_properties">
          <input type="checkbox" name="update_rental_properties" id="update_rental_properties" value="1" <?php if((isset($_POST['update_rental_properties']) && $_POST['update_rental_properties']==1) || (isset($rental_properties_arr) && in_array('update', $rental_properties_arr))){ echo 'checked="checked"'; } ?> class="styled">  Update </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="delete_rental_properties">
          <input type="checkbox" name="delete_rental_properties" id="delete_rental_properties" value="1" <?php if((isset($_POST['delete_rental_properties']) && $_POST['delete_rental_properties']==1) || (isset($rental_properties_arr) && in_array('delete', $rental_properties_arr))){ echo 'checked="checked"'; } ?>  class="styled"> Delete </label>
        </div>
      </div>
    </div>
	
  <div class="form-group">
		  <label class="col-md-2 control-label" for="archived_properties"> Archived Properties </label>
		  <div class="col-md-1"> 
			<div class="checkbox">
			  <label for="view_archived_properties">
			  <input type="checkbox" name="view_archived_properties" id="view_archived_properties" value="1" <?php if((isset($_POST['view_archived_properties']) && $_POST['view_archived_properties']==1) || (isset($archived_properties_arr) && in_array('view', $archived_properties_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
			</div>
		  </div>
		  <div class="col-md-1">
			<div class="checkbox">
			  <label for="add_archived_properties">
			  <input type="checkbox" name="add_archived_properties" id="add_archived_properties" value="1" <?php if((isset($_POST['add_archived_properties']) && $_POST['add_archived_properties']==1) || (isset($archived_properties_arr) && in_array('add', $archived_properties_arr))){ echo 'checked="checked"'; } ?> class="styled"> Add </label>
			</div>
		  </div>
		  <div class="col-md-1">
			<div class="checkbox">
			  <label for="update_archived_properties">
			  <input type="checkbox" name="update_archived_properties" id="update_archived_properties" value="1" <?php if((isset($_POST['update_archived_properties']) && $_POST['update_archived_properties']==1) || (isset($archived_properties_arr) && in_array('update', $archived_properties_arr))){ echo 'checked="checked"'; } ?> class="styled">  Update </label>
			</div>
		  </div>
		  <div class="col-md-1">
			<div class="checkbox">
			  <label for="delete_archived_properties">
			  <input type="checkbox" name="delete_archived_properties" id="delete_archived_properties" value="1" <?php if((isset($_POST['delete_archived_properties']) && $_POST['delete_archived_properties']==1) || (isset($archived_properties_arr) && in_array('delete', $archived_properties_arr))){ echo 'checked="checked"'; } ?>  class="styled"> Delete </label>
			</div>
		  </div>
		</div>	
 
  <div class="form-group">
	  <label class="col-md-2 control-label" for="deleted_properties"> Deleted Properties </label>
	  <div class="col-md-1"> 
		<div class="checkbox">
		  <label for="view_deleted_properties">
		  <input type="checkbox" name="view_deleted_properties" id="view_deleted_properties" value="1" <?php if((isset($_POST['view_deleted_properties']) && $_POST['view_deleted_properties']==1) || (isset($deleted_properties_arr) && in_array('view', $deleted_properties_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
		</div>
	  </div>
	  <div class="col-md-1">
		<div class="checkbox">
		  <label for="add_deleted_properties">
		  <input type="checkbox" name="add_deleted_properties" id="add_deleted_properties" value="1" <?php if((isset($_POST['add_deleted_properties']) && $_POST['add_deleted_properties']==1) || (isset($deleted_properties_arr) && in_array('add', $deleted_properties_arr))){ echo 'checked="checked"'; } ?> class="styled"> Add </label>
		</div>
	  </div>
	  <div class="col-md-1">
		<div class="checkbox">
		  <label for="update_deleted_properties">
		  <input type="checkbox" name="update_deleted_properties" id="update_deleted_properties" value="1" <?php if((isset($_POST['update_deleted_properties']) && $_POST['update_deleted_properties']==1) || (isset($deleted_properties_arr) && in_array('update', $deleted_properties_arr))){ echo 'checked="checked"'; } ?> class="styled">  Update </label>
		</div>
	  </div>
	  <div class="col-md-1">
		<div class="checkbox">
		  <label for="delete_deleted_properties">
		  <input type="checkbox" name="delete_deleted_properties" id="delete_deleted_properties" value="1" <?php if((isset($_POST['delete_deleted_properties']) && $_POST['delete_deleted_properties']==1) || (isset($deleted_properties_arr) && in_array('delete', $deleted_properties_arr))){ echo 'checked="checked"'; } ?>  class="styled"> Delete </label>
		</div>
	  </div>
	</div>
	
  <div class="form-group">
      <label class="col-md-2 control-label" for="manage_leads"> Manage Leads </label>
      <div class="col-md-1"> 
        <div class="checkbox">
          <label for="view_lead">
          <input type="checkbox" name="view_lead" id="view_lead" value="1" <?php if((isset($_POST['view_lead']) && $_POST['view_lead']==1) || (isset($manage_leads_arr) && in_array('view', $manage_leads_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="add_lead">
          <input type="checkbox" name="add_lead" id="add_lead" value="1" <?php if((isset($_POST['add_lead']) && $_POST['add_lead']==1) || (isset($manage_leads_arr) && in_array('add', $manage_leads_arr))){ echo 'checked="checked"'; } ?> class="styled"> Add </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="update_lead">
          <input type="checkbox" name="update_lead" id="update_lead" value="1" <?php if((isset($_POST['update_lead']) && $_POST['update_lead']==1) || (isset($manage_leads_arr) && in_array('update', $manage_leads_arr))){ echo 'checked="checked"'; } ?> class="styled">  Update </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="delete_lead">
          <input type="checkbox" name="delete_lead" id="delete_lead" value="1" <?php if((isset($_POST['delete_lead']) && $_POST['delete_lead']==1) || (isset($manage_leads_arr) && in_array('delete', $manage_leads_arr))){ echo 'checked="checked"'; } ?>  class="styled"> Delete </label>
        </div>
      </div>
    </div> 
	
  <div class="form-group">
      <label class="col-md-2 control-label" for="manage_contacts"> Manage Contacts </label>
      <div class="col-md-1"> 
        <div class="checkbox">
          <label for="view_contact">
          <input type="checkbox" name="view_contact" id="view_contact" value="1" <?php if((isset($_POST['view_contact']) && $_POST['view_contact']==1) || (isset($manage_contacts_arr) && in_array('view', $manage_contacts_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="add_contact">
          <input type="checkbox" name="add_contact" id="add_contact" value="1" <?php if((isset($_POST['add_contact']) && $_POST['add_contact']==1) || (isset($manage_contacts_arr) && in_array('add', $manage_contacts_arr))){ echo 'checked="checked"'; } ?> class="styled"> Add </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="update_contact">
          <input type="checkbox" name="update_contact" id="update_contact" value="1" <?php if((isset($_POST['update_contact']) && $_POST['update_contact']==1) || (isset($manage_contacts_arr) && in_array('update', $manage_contacts_arr))){ echo 'checked="checked"'; } ?> class="styled">  Update </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="delete_contact">
          <input type="checkbox" name="delete_contact" id="delete_contact" value="1" <?php if((isset($_POST['delete_contact']) && $_POST['delete_contact']==1) || (isset($manage_contacts_arr) && in_array('delete', $manage_contacts_arr))){ echo 'checked="checked"'; } ?>  class="styled"> Delete </label>
        </div>
      </div>
    </div>
	
  <div class="form-group">
      <label class="col-md-2 control-label" for="manage_owners"> Manage Owners </label>
      <div class="col-md-1"> 
        <div class="checkbox">
          <label for="view_owner">
          <input type="checkbox" name="view_owner" id="view_owner" value="1" <?php if((isset($_POST['view_owner']) && $_POST['view_owner']==1) || (isset($manage_owners_arr) && in_array('view', $manage_owners_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="add_owner">
          <input type="checkbox" name="add_owner" id="add_owner" value="1" <?php if((isset($_POST['add_owner']) && $_POST['add_owner']==1) || (isset($manage_owners_arr) && in_array('add', $manage_owners_arr))){ echo 'checked="checked"'; } ?> class="styled"> Add </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="update_owner">
          <input type="checkbox" name="update_owner" id="update_owner" value="1" <?php if((isset($_POST['update_owner']) && $_POST['update_owner']==1) || (isset($manage_owners_arr) && in_array('update', $manage_owners_arr))){ echo 'checked="checked"'; } ?> class="styled">  Update </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="delete_owner">
          <input type="checkbox" name="delete_owner" id="delete_owner" value="1" <?php if((isset($_POST['delete_owner']) && $_POST['delete_owner']==1) || (isset($manage_owners_arr) && in_array('delete', $manage_owners_arr))){ echo 'checked="checked"'; } ?>  class="styled"> Delete </label>
        </div>
      </div>
    </div> 
	
  <div class="form-group">
      <label class="col-md-2 control-label" for="manage_tasks"> Manage Tasks </label>
      <div class="col-md-1"> 
        <div class="checkbox">
          <label for="view_task">
          <input type="checkbox" name="view_task" id="view_task" value="1" <?php if((isset($_POST['view_task']) && $_POST['view_task']==1) || (isset($manage_tasks_arr) && in_array('view', $manage_tasks_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="add_task">
          <input type="checkbox" name="add_task" id="add_task" value="1" <?php if((isset($_POST['add_task']) && $_POST['add_task']==1) || (isset($manage_tasks_arr) && in_array('add', $manage_tasks_arr))){ echo 'checked="checked"'; } ?> class="styled"> Add </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="update_task">
          <input type="checkbox" name="update_task" id="update_task" value="1" <?php if((isset($_POST['update_task']) && $_POST['update_task']==1) || (isset($manage_tasks_arr) && in_array('update', $manage_tasks_arr))){ echo 'checked="checked"'; } ?> class="styled">  Update </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="delete_task">
          <input type="checkbox" name="delete_task" id="delete_task" value="1" <?php if((isset($_POST['delete_task']) && $_POST['delete_task']==1) || (isset($manage_tasks_arr) && in_array('delete', $manage_tasks_arr))){ echo 'checked="checked"'; } ?>  class="styled"> Delete </label>
        </div>
      </div>
    </div>
	
  <div class="form-group">
      <label class="col-md-2 control-label" for="manage_users"> Manage User </label>
      <div class="col-md-1"> 
        <div class="checkbox">
          <label for="view_user">
          <input type="checkbox" name="view_user" id="view_user" value="1" <?php if((isset($_POST['view_user']) && $_POST['view_user']==1) || (isset($manage_users_arr) && in_array('view', $manage_users_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="add_user">
          <input type="checkbox" name="add_user" id="add_user" value="1" <?php if((isset($_POST['add_user']) && $_POST['add_user']==1) || (isset($manage_users_arr) && in_array('add', $manage_users_arr))){ echo 'checked="checked"'; } ?> class="styled"> Add </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="update_user">
          <input type="checkbox" name="update_user" id="update_user" value="1" <?php if((isset($_POST['update_user']) && $_POST['update_user']==1) || (isset($manage_users_arr) && in_array('update', $manage_users_arr))){ echo 'checked="checked"'; } ?> class="styled">  Update </label>
        </div>
      </div>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="delete_user">
          <input type="checkbox" name="delete_user" id="delete_user" value="1" <?php if((isset($_POST['delete_user']) && $_POST['delete_user']==1) || (isset($manage_users_arr) && in_array('delete', $manage_users_arr))){ echo 'checked="checked"'; } ?>  class="styled"> Delete </label>
        </div>
      </div>
    </div>	
  
    <div class="form-group">
      <label class="col-md-2 control-label" for="manage_reports"> Manage Reports  </label>
      <div class="col-md-1">
        <div class="checkbox">
          <label for="view_report">
          <input type="checkbox" name="view_report" id="view_report" value="1" <?php if((isset($_POST['view_report']) && $_POST['view_report']==1) || (isset($manage_reports_arr) && in_array('view', $manage_reports_arr))){ echo 'checked="checked"'; } ?> class="styled"> View </label>
        </div>
      </div> 
    </div>
</form>
    </div>  
   
   