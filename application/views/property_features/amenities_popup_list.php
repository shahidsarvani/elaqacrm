 
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
<script> 
	function sels_chk_box_vals(nw_owner_id_val){  
		//var nw_owner_id_val = document.datasformchk.sel_user_id_val.value;
		if(nw_owner_id_val >0){
			window.parent.clickeds_users(nw_owner_id_val);  
		}
	}  
	
	function operate_amenities(){  
		$(document).ready(function() {
			var selected_value = []; // initialize empty array 
			$(".private_amenities:checked").each(function(){
				selected_value.push($(this).val());
			});
			
			var selected_value2 = []; // initialize empty array 
			$(".commercial_amenities:checked").each(function(){
				selected_value2.push($(this).val());
			});
			 
			//document.getElementById("private_amenities_data").value = selected_value;
			 
			window.parent.operate_amenities_datas(selected_value,selected_value2);  
			
		});  
	}	
  
</script>
<div class="panel-body"> 
<form name="datasformchk" id="datasformchk" method="post" action="" class="form-horizontal">  
    <div class="row">
        <div class="col-md-6" style="border-right:1px solid #999;"> 
        	<strong class="text-semibold">Private Amenities:</strong>
        	<div class="row">
                <div class="form-group">  
                <?php 
					if(isset($paras2) && strlen($paras2)>0){
						//$paras2 = str_replace('_',',',$paras2);
						$db_amenities_arrs = explode('__',$paras2);
						$db_private_amt_recs = $db_amenities_arrs[0];
						$db_commercial_amt_recs = $db_amenities_arrs[1];
						
						$db_private_amt_arrs = explode('_',$db_private_amt_recs);
						$db_commercial_amt_arrs = explode('_',$db_commercial_amt_recs);
					}
				
					$p=1;
					if(isset($private_amt_recs) && count($private_amt_recs)>0){
						foreach($private_amt_recs as $private_amt_rec){
							$chks_1 = '';
							if(isset($db_private_amt_arrs) && count($db_private_amt_arrs)>0){
								 if(in_array($private_amt_rec->id, $db_private_amt_arrs)){
									$chks_1 = 'checked="checked"';
								}
							}  ?> 
                            <div class="col-md-4">
                            	<label class="control-label" for="private_amenities_<?php echo $p; ?>"> <input name="private_amenities[]" id="private_amenities_<?php echo $p; ?>" type="checkbox" class="styled private_amenities" value="<?php echo stripslashes($private_amt_rec->id); ?>" <?php echo $chks_1; ?> onclick="operate_amenities();">   <?php echo stripslashes($private_amt_rec->title); ?> </label>  
                            </div> 
						 <?php   
						$p++;
						}
					} ?>   
                </div> 
          	</div>   
        </div>
        
     <div class="col-md-6"> 
        <strong class="text-semibold">Commercial Amenities:</strong>
        <div class="row">
            <div class="form-group">  
			<?php
                $p=1; 
                if(isset($commercial_amt_recs) && count($commercial_amt_recs)>0){ 
                    foreach($commercial_amt_recs as $commercial_amt_rec){  
                        $chks_1 = '';  
                        if(isset($db_commercial_amt_arrs) && count($db_commercial_amt_arrs)>0){
                             if(in_array($commercial_amt_rec->id, $db_commercial_amt_arrs)){
                                $chks_1 = 'checked="checked"';
                            }
                        }  ?>   
                        <div class="col-md-4">
                            <label class="control-label" for="commercial_amenities_<?php echo $p; ?>"> <input name="commercial_amenities[]" id="commercial_amenities_<?php echo $p; ?>" type="checkbox" class="styled commercial_amenities" value="<?php echo stripslashes($commercial_amt_rec->id); ?>" <?php echo $chks_1; ?> onclick="operate_amenities();"> <?php echo stripslashes($commercial_amt_rec->title); ?> </label>  
                        </div> 
                     <?php   
                    $p++;
                    }
                } ?>   
            </div> 
          </div>   
        </div>  
    </div>    
  </form>
    </div>  
   
   