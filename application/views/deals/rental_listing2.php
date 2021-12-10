<?php 
$view_res_nums =  $this->general_model->check_controller_method_permission_access('Deals','view',$this->dbs_role_id,'1');

$add_res_nums =  $this->general_model->check_controller_method_permission_access('Deals','add',$this->dbs_role_id,'1'); 	
		
$update_res_nums =  $this->general_model->check_controller_method_permission_access('Deals','update',$this->dbs_role_id,'1');   

$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Deals','trash',$this->dbs_role_id,'1'); 
 			 
if($view_res_nums){ 
	$sr=1; 
	if(isset($page) && $page >0){
		$sr = $page+1;
	}
	if(isset($records) && count($records)>0){
		foreach($records as $record){ 
			$details_url = 'deals/deal_detail/'.$record->id;
			$details_url = site_url($details_url); 
			
			$operate_url = 'deals/operate_deal/2/'.$record->id;
			$operate_url = site_url($operate_url);
			
			$trash_url = 'properties/trash_deal/2/'.$record->id;
			$trash_url = site_url($trash_url);  
			
			$dtls_url = 'public_properties/property_detail/'.$record->property_id;
			$dtls_url = site_url($dtls_url); ?> 
				<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
				  <td><?= $sr; ?></td>
				  <td><!--<a href="<?php echo $dtls_url; ?>" target="_blank"><?= stripslashes($record->
					ref_no); ?></a>-->
					<?= stripslashes($record->ref_no); ?>
				  </td>
				  <td><?= stripslashes($record->status); ?></td>
				  <td><?php echo stripslashes($record->owner_name); ?></td>
				  <td><?php echo stripslashes($record->cnt_name); ?></td>
				  <td><?php echo stripslashes($record->sub_loc_name); ?></td>
				  <td><?= stripslashes($record->unit_no); ?></td>
				  <td><?php echo CRM_CURRENCY.' '.number_format($record->deal_price,0,".",","); ?></td>
				  <td><?php 
					if($record->agent1_id>0){
						$usr_arr =  $this->general_model->get_user_info_by_id($record->agent1_id);
						echo stripslashes($usr_arr->name)."<hr class=\"cstms-dash\">";
					} 
					
					if($record->agent2_id>0){
						$usr_arr =  $this->general_model->get_user_info_by_id($record->agent2_id);
						echo stripslashes($usr_arr->name);
					} 	 ?></td>
				  <td class="center"><?php echo date('d-M-Y',strtotime($record->est_deal_date)); ?> </td>
				  <td class="text-center">
				  	<ul class="icons-list">
					  <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a>
						<ul class="dropdown-menu dropdown-menu-right">
						  <!-- icon-search4 -->
						  <?php if($view_res_nums>0){ ?>
						  <li><a href="<?php echo $details_url; ?>"><i class="glyphicon glyphicon-search"></i> Detail</a> </li>
						  <?php } if($update_res_nums>0){ ?>
						  <li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
						  <?php } 
									if($trash_res_nums>0){ ?>
						  <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
						  <?php } ?>
						</ul>
					  </li>
					</ul></td>
				</tr>  
		<?php 
			$sr++;
			}  ?> 
		   <tr>
		   <td colspan="11">
		   <div style="float:left;">  <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate" onChange="operate_deals_properties();">
		  <option value="25"> Pages</option>
		  <option value="25"> 25 </option>
		  <option value="50"> 50 </option>
		  <option value="100"> 100 </option> 
		</select>  </div>
			<div style="float:right;"> <?php echo $this->ajax_pagination->create_links(); ?>  </div> </td>  
		  </tr> 
	  <?php
	}else{ ?>	
		 <tr>
		   <td colspan="11" align="center">
		   <div style="float:left;"> <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate" onChange="operate_deals_properties();">
	  <option value="25"> Pages</option>
	  <option value="25"> 25 </option>
	  <option value="50"> 50 </option>
	  <option value="100"> 100 </option> 
	</select>  </div>
			<div>  <strong> No Record Found! </strong></div>  </td>  
		  </tr> 
	<?php } 
	}else{ ?>	
		<tr class="gradeX"> 
			<td colspan="11" class="center"> <strong> No Permission to access this area! </strong> </td>
		</tr>
	<?php } ?>      