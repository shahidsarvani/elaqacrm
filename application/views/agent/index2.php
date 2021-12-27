<table class="table table-bordered table-striped mb-none" <?php echo (isset($records) && count($records)>0) ? 'id="datatable-default"':''; ?>>
    <thead> 
     <tr>
        <th width="5%">#</th> 
        <th width="10%">Ref No </th>
        <th width="12%">Sub Location</th>
        <th width="11%">Unit No</th>
        <th width="10%">Bedrooms </th>
        <th width="14%">Owner </th>
        <th width="10%">Price</th>
        <th width="9%" class="center">Status</th>
        <th width="12%">Assigned To</th>
      </tr>
    </thead>
    <tbody>
    <?php 
	$vs_user_type_id = $this->session->userdata('us_user_type_id'); 
	$vs_id = $this->session->userdata('us_id');
    $permission_results_arr = $this->Permission_Results; 
    $chk_rets = $this->general_model->in_array_field('1', 'module_id','1', 'is_view_permission', $permission_results_arr);  
    if($chk_rets){ 
        $sr=1; 
		if(isset($page) && $page >0){
			$sr = $page+1;
		}
        if(isset($records) && count($records)>0){
            foreach($records as $record){ 
                $details_url = 'properties/property_detail/'.$record->id;
                $details_url = site_url($details_url); 
                
                $archv_url = 'properties/property_to_archive/'.$record->id;
                $archv_url = site_url($archv_url); 
                
                $dealts_url = 'properties/property_to_dealt/'.$record->id;
                $dealts_url = site_url($dealts_url); 
                
                $operate_url = 'properties/operate_property/0/'.$record->id;
                $operate_url = site_url($operate_url);
                
                $trash_url = 'properties/delete_property/0/'.$record->id;
                $trash_url = site_url($trash_url); ?>
                 <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
                    <td>  
					<?php 
						echo $sr;
						echo ($record->is_new==1 && $vs_id==$record->assigned_to_id) ? ' <span class="badge_mini label-danger">new</span>':'';  ?>  
                            </td>
                    <td><a href="<?php echo $details_url; ?>" target="_blank"><?= stripslashes($record->ref_no); ?></a></td>
                    <td><?php echo stripslashes($record->sub_loc_name); ?> </td>
                    <td><?= stripslashes($record->unit_no); ?></td>
                    <td><?php echo stripslashes($record->bed_title); ?> </td>
                    <td><?php echo stripslashes($record->ownr_name);
                    if(strlen($record->ownr_phone_no)>0){
                        echo ' ( ';
                        $ownr_phn_no_arrs = explode(',',$record->ownr_phone_no); 
                        if(isset($ownr_phn_no_arrs) && count($ownr_phn_no_arrs)>1){
                            echo $ownr_phn_no_arrs[0];
                            $n=1; 
                            $ph_txt=''; 
                            foreach($ownr_phn_no_arrs as $ownr_phn_no_arr){
                                if($n==1){
                                    $n++;
                                    continue;
                                }
                                $ph_txt .= $ownr_phn_no_arr.', '; 
                                $n++;
                            } 
                            $ph_txt = substr($ph_txt,0,-2); ?>
                            <a data-plugin-popover data-plugin-options='{"placement": "top"}' tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Contact Nos." data-content="<?php echo $ph_txt; ?>">more</a>
                        <?php 
                        }else{ 
                             echo stripslashes($record->ownr_phone_no); 
                        } 
                        echo ' )';
                    } ?> 
                    </td>
                    <td><?php echo number_format($record->price,2,".",","); ?> </td>
                    <td class="center"><?php 
                        $bg_cls ='';
                        if($record->property_status==1){
                            $bg_cls = 'label-success';
                        }else if($record->property_status==2){
                            $bg_cls = 'label-primary';
                        }else if($record->property_status==3){
                            $bg_cls = 'label-warning';
                        }else if($record->property_status==6){
                            $bg_cls = 'label-danger';
                        }else{
                            $bg_cls = 'label-info';
                        } ?>
                      <span class="badge <?php echo $bg_cls; ?>"> <?php echo $this->general_model->get_gen_property_status($record->property_status); ?></span></td>
                    <td><?php 
                    if($record->assigned_to_id>0){
                        $usr_arr =  $this->general_model->get_user_info_by_id($record->assigned_to_id);
                        echo stripslashes($usr_arr->name);
                    } ?></td> 
                  </tr>
        <?php 
            $sr++;
            }
        }else{ ?>	
        <tr class="gradeX"> 
            <td colspan="9" class="center"> <strong> No Record Found! </strong> </td>
        </tr>
        <?php 
        } 
    }else{ ?>	
        <tr class="gradeX"><td colspan="9" class="center"> <strong> No Permission to access this area! </strong> </td>
        </tr>
<?php } ?>  
    </tbody>
  </table>
 <?php echo $this->ajax_pagination->create_links(); ?> 