     
        <?php 
        $permission_results_arr = $this->Permission_Results; 
        $chk_rets = $this->general_model->in_array_field('21', 'module_id','1', 'is_view_permission', $permission_results_arr);  
        if($chk_rets){ 
            $sr=1; 
            if(isset($page) && $page >0){
                $sr = $page+1;
            }
        
            if(isset($records) && count($records)>0){
                foreach($records as $record){ 
                    $details_url = 'public_properties/property_detail/'.$record->id;
                    $details_url = site_url($details_url); 
                    
                    $archv_url = 'properties/property_to_archive/3/'.$record->id;
                    $archv_url = site_url($archv_url); 
                    
                    $dealts_url = 'properties/property_to_dealt/3/'.$record->id;
                    $dealts_url = site_url($dealts_url); 
                    
                    $operate_url = 'properties/operate_property/0/'.$record->id;
                    $operate_url = site_url($operate_url);
                    
                    $trash_url = 'properties/delete_property/5/'.$record->id;
                    $trash_url = site_url($trash_url); 
					
					$get_lead_property_brief = 'properties/get_lead_property_brief/'.$record->id.'/';
                    $get_lead_property_brief = site_url($get_lead_property_brief); ?>
                    <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>"> 
                        <td><?php echo $sr;
						echo ($record->is_new==1) ? ' <span class="badge_mini label-danger">new</span>':'';  ?></td>
                        <td><?= stripslashes($record->ref_no); ?></td>
                        <td><?php echo stripslashes($record->sub_loc_name); ?> </td> 
                        <td><?php echo stripslashes($record->bed_title); ?> </td>
                         
                        <td><?php echo CRM_CURRENCY.' '.number_format($record->price,2,".",","); ?> </td> 
                        <td><?= stripslashes($record->plot_area); ?></td>
                        <td class="center"> 
                          <div class="btn-group dropup">
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button> 
    <ul class="dropdown-menu" role="menu"> <?php if(isset($this->properties_leads_edit_module_access) && $this->properties_leads_edit_module_access==1){ ?> <!--<li> <a href="<?php echo $operate_url; ?>"><i class="fa fa-pencil"></i> Update </a> </li>--> <?php } if(isset($this->properties_leads_view_module_access) && $this->properties_leads_view_module_access==1){ ?>  <li> <!--<a href="<?php echo $details_url; ?>" target="_blank"><i class="fa fa-search-plus"></i> Detail </a>--> <a class="simple-ajax-modal" href="<?php echo $get_lead_property_brief; ?>"><i class="fa fa-search-plus"></i> Detail</a></li> <?php } if(isset($this->properties_leads_delete_module_access) && $this->properties_leads_delete_module_access==1){ ?>  <li> <a href="<?php echo $trash_url; ?>" title="Delete" onClick="return confirm('Do you want to delete this?');"><i class="fa fa-times"></i> Delete </a> </li> <?php } ?> </ul> 
                         </div>   
                        </td> 
                        </tr>
            <?php 
                $sr++;
                } ?> 
                <tr>
                       <td colspan="7">
                       <div style="float:left;"> <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate" onChange="operate_leads_properties();">
                  <option value="25"> Pages</option>
                  <option value="25" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==25) ? 'selected="selected"':''; ?>> 25 </option>
                  <option value="50" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==50) ? 'selected="selected"':''; ?>> 50 </option>
                  <option value="100" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==100) ? 'selected="selected"':''; ?>> 100 </option> 
                </select>  </div>
                        <div style="float:right;">  <?php echo $this->ajax_pagination->create_links(); ?> </div> </td>  
                      </tr> 
          <?php 
            }else{ ?>	
             <tr>
               <td colspan="7" align="center">
               <div style="float:left;"> <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate" onChange="operate_leads_properties();">
          <option value="25"> Pages</option>
          <option value="25"> 25 </option>
          <option value="50"> 50 </option>
          <option value="100"> 100 </option> 
        </select>  </div>
                <div>  <strong> No Record Found! </strong></div>  </td>  
              </tr> 
            <?php 
            } 
        }else{ ?>	
            <tr class="gradeX"><td colspan="7" class="center"> <strong> No Permission to access this area! </strong> </td>
            </tr>
    <?php } ?>   