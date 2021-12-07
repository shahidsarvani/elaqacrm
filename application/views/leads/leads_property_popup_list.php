<?php $this->ajax_base_paging =1; ?>
<!--<script src="<?= asset_url();?>javascripts/fields.js"></script>-->

<div id="custom-content" class="modal-block modal-block-full"> 
  <!--modal-block modal-block-md-->
  <style>
	  label.control-label{
		font-weight:bold;
	  }
	  
	  table td {
		word-wrap: break-word;
		word-break: break-all;
		white-space: normal;
	 } 
  </style>
  <section class="panel">
    <header class="panel-heading">  
       <h2 class="panel-title text-weight-bold m-none" style="width:100%;"> <span> <?php echo $page_headings; ?> </span> <span class="modal-dismiss" style="float:right; cursor:pointer;"><i class="fa fa-times"></i> </span> </h2>
    </header>
    <div class="panel-body">
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <label class="col-md-3 control-label" for="category_id"> Category <span class="reds">*</span></label>
            <div class="col-md-8" id="fetch_cates_list">
              <select name="category_id" id="category_id" data-plugin-selectTwo class="form-control populate">
                <option value="">Category Name</option>
			<?php  
                if(isset($_POST['property_type']) && $_POST['property_type']>0){
                $tmp_property_type = $_POST['property_type'];  
                $category_arrs = $this->admin_model->fetch_property_type_cates($tmp_property_type); 
                }else if(isset($record) && $record->property_type>0){ 
                $tmp_property_type = $record->property_type;
                $category_arrs = $this->admin_model->fetch_property_type_cates($tmp_property_type);
                }	  		  
                          
                if(isset($category_arrs) && count($category_arrs)>0){
                foreach($category_arrs as $category_arr){
                $sel_1 = '';
                if(isset($_POST['category_id']) && $_POST['category_id']==$category_arr->id){
                    $sel_1 = 'selected="selected"';
                }else if(isset($record) && $record->category_id==$category_arr->id){
                    $sel_1 = 'selected="selected"';
                } ?>
                    <option value="<?= $category_arr->id; ?>" <?php echo $sel_1; ?>>
                    <?= stripslashes($category_arr->name); ?>
                    </option>
                    <?php 
                }
                } ?>
              </select>
              <span class="text-danger"><?php echo form_error('category_id'); ?></span> </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="no_of_beds_id">No. of Bedrooms <span class="reds">*</span> </label>
            <div class="col-md-8">
              <select name="no_of_beds_id" id="no_of_beds_id" data-plugin-selectTwo class="form-control populate">
                <option value="">Select No. of Bedrooms</option>
                <?php  
                if(isset($beds_arrs) && count($beds_arrs)>0){
                    foreach($beds_arrs as $beds_arr){
                    $sel_1 = '';
                    if(isset($_POST['no_of_beds_id']) && $_POST['no_of_beds_id']==$beds_arr->id){
                        $sel_1 = 'selected="selected"';
                    }else if(isset($record) && $record->no_of_beds_id==$beds_arr->id){
                        $sel_1 = 'selected="selected"';
                    } ?>
                <option value="<?= $beds_arr->id; ?>" <?php echo $sel_1; ?>>
                <?= stripslashes($beds_arr->title); ?>
                </option>
                <?php 
                    }
                } ?>
              </select>
              <span class="text-danger"><?php echo form_error('no_of_beds_id'); ?></span> </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="emirate_id">Emirate(s) <span class="reds">*</span></label>
            <div class="col-md-8">
              <?php 
                if(isset($record) && $record->emirate_id >0){
                    $sel_emirate_ids = $record->emirate_id;
                }else{
                    $sel_emirate_ids = 3;
                } ?>
              <select name="emirate_id" id="emirate_id" data-plugin-selectTwo class="form-control populate" onChange="get_emirate_location(this.value,'<?php echo site_url('properties/fetch_emirate_locations'); ?>','fetch_emirate_locations');">
                <option value="">Select Emirate </option>
                <?php  
                if(isset($emirate_arrs) && count($emirate_arrs)>0){
                    foreach($emirate_arrs as $emirate_arr){
                    $sel_1 = '';
                    if(isset($_POST['emirate_id']) && $_POST['emirate_id']==$emirate_arr->id){
                        $sel_1 = 'selected="selected"';
                    }else if(isset($sel_emirate_ids) && $sel_emirate_ids==$emirate_arr->id){
                        $sel_1 = 'selected="selected"';
                    } ?>
                <option value="<?= $emirate_arr->id; ?>" <?php echo $sel_1; ?>>
                <?= stripslashes($emirate_arr->name); ?>
                </option>
                <?php 
                    }
                } ?>
              </select>
              <span class="text-danger"><?php echo form_error('emirate_id'); ?></span> </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="location_id">Location(s) <span class="reds">*</span></label>
            <div class="col-md-8"> <span id="fetch_emirate_locations">
              <select name="location_id" id="location_id" data-plugin-selectTwo class="form-control populate" onChange="get_emirate_sub_location(this.value,'<?php echo site_url('properties/fetch_emirate_sub_locations'); ?>','fetch_emirate_sub_locations');">
                <option value="">Select Emirate Location </option>
                <?php  
                    $emirate_location_arrs = $this->admin_model->fetch_emirate_locations($sel_emirate_ids);
                    if(isset($emirate_location_arrs) && count($emirate_location_arrs)>0){
                        foreach($emirate_location_arrs as $emirate_location_arr){
                            $sel_1 = '';
                            if(isset($_POST['location_id']) && $_POST['location_id']==$emirate_location_arr->id){
                                $sel_1 = 'selected="selected"';
                            }else if(isset($record) && $record->location_id==$emirate_location_arr->id){
                                $sel_1 = 'selected="selected"';
                            }  ?>
                <option value="<?= $emirate_location_arr->id; ?>" <?php echo $sel_1; ?>>
                <?= stripslashes($emirate_location_arr->name); ?>
                </option>
                <?php 
                        }
                    }  ?>
              </select>
              </span> <span class="text-danger"><?php echo form_error('location_id'); ?></span> </div>
          </div>
           
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">  
             <?php  
			$operate_url = 'properties/leads_properties_popup_add_list/';
			$operate_url = site_url($operate_url); ?>
            <input type="button" name="adds_contacts" id="adds_contacts" class="btn btn-primary" value="Save requirement" onclick="operate_adds_lead_property('<?php echo $operate_url; ?>','fetch_contacts_popup_add_list');" /> 
            </div>
          </div>
        </div>
        <div class="col-lg-6"> 
        
          <div class="form-group">
            <label class="col-md-3 control-label" for="sub_location_id">Sub Location(s) <span class="reds">*</span></label>
            <div class="col-md-8"> <span id="fetch_emirate_sub_locations">
              <select name="sub_location_id" id="sub_location_id" data-plugin-selectTwo class="form-control populate">
                <option value="">Select Emirate Sub Location </option>
                <?php 
                $tmps_location_id='';
                if(isset($_POST['location_id']) && strlen($_POST['location_id'])>0){
                    $tmps_location_id = $_POST['location_id'];
                }else if(isset($record->location_id) && $record->location_id>0){
                    $tmps_location_id = $record->location_id;
                }
                
                $emirate_sub_location_arrs = $this->admin_model->fetch_emirate_sub_locations($tmps_location_id);
                if(isset($emirate_sub_location_arrs) && is_array($emirate_sub_location_arrs)){
                    foreach($emirate_sub_location_arrs as $emirate_sub_location_arr){ 
                    $sel_1 = '';
                    if(isset($_POST['sub_location_id']) && $_POST['sub_location_id']==$emirate_sub_location_arr->id){
                        $sel_1 = 'selected="selected"';
                    }else if(isset($record) && $record->sub_location_id==$emirate_sub_location_arr->id){
                        $sel_1 = 'selected="selected"';
                    } ?>
                <option value="<?= $emirate_sub_location_arr->id; ?>" <?php echo $sel_1; ?>>
                <?= stripslashes($emirate_sub_location_arr->name); ?>
                </option>
                <?php 
                    }
                } ?>
              </select>
              </span> <span class="text-danger"><?php echo form_error('sub_location_id'); ?></span> </div>
          </div>	
          <div class="form-group">
            <label class="col-md-3 control-label" for="types">Property Type </label>
            <div class="col-md-8">
              <input name="types" id="types" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->types): set_value('types'); ?>">
              <span class="text-danger"><?php echo form_error('types'); ?></span> </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="plot_area">Size </label>
            <div class="col-md-8">
              <input name="plot_area" id="plot_area" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->plot_area): set_value('plot_area'); ?>">
              <span class="text-danger"><?php echo form_error('plot_area'); ?></span> </div>
          </div> 
          <div class="form-group">
            <label class="col-md-3 control-label" for="price">Price <span class="reds">*</span></label>
            <div class="col-md-8">
              <input name="price" id="price" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->price): set_value('price'); ?>">
              <span class="text-danger"><?php echo form_error('price'); ?></span> </div>
          </div>
        </div>
      </div> 
    </div>
    <footer class="panel-footer">
      <div class="row"> 
        <input name="paras1" id="paras1" type="hidden" value="<?php echo $paras1; ?>"> 
        <div class="col-md-12 text-right">
          <button id="close_modals" class="btn btn-default modal-dismiss">Close</button>
        </div>
      </div>
    </footer>
  </section>  
</div>
<script language="javascript">

	function sels_chk_box_vals2(nw_owner_id_val,paras1_val){
		if(nw_owner_id_val >0){ 
			//dyns_properties(nw_owner_id_val,paras1_val); 
			//dyns_properties(nw_owner_id_val,paras1_val);  
			window.parent.dyns_properties(nw_owner_id_val,paras1_val);  
		}
	} 
	  
	var params;
	var objdiv;  
	function operate_adds_lead_property(url,dis){    
		objdiv=dis;
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null){
			alert ("Browser does not support HTTP Request");
			return;
		} 
		
		var valids = true;	
		var msgs = '';
		var category_id = document.getElementById("category_id");
		var category_id_val = category_id.options[category_id.selectedIndex].value;  
		
		var no_of_beds_id = document.getElementById("no_of_beds_id");
		var no_of_beds_id_val = no_of_beds_id.options[no_of_beds_id.selectedIndex].value; 
			
		var emirate_id = document.getElementById("emirate_id");
		var emirate_id_val = emirate_id.options[emirate_id.selectedIndex].value; 
			
		var location_id = document.getElementById("location_id");
		var location_id_val = location_id.options[location_id.selectedIndex].value; 
			
		var sub_location_id = document.getElementById("sub_location_id");
		var sub_location_id_val = sub_location_id.options[sub_location_id.selectedIndex].value; 
		  
		var types = document.getElementById('types').value;
		types = types.trim();
		
		var plot_area = document.getElementById('plot_area').value; 
		plot_area = plot_area.trim();  
		
		var price = document.getElementById('price').value; 
		price = price.trim(); 	
				
		if(category_id_val==''){ 
			valids =false;
			msgs +='Select Category \n';
		}
		
		if(no_of_beds_id_val==''){ 
			valids =false;
			msgs +='Select No. of Bedrooms \n';
		}
		
		if(emirate_id_val==''){ 
			valids =false;
			msgs +='Select Emirate \n';
		} 
		
		if(location_id_val==''){ 
			valids =false;
			msgs +='Select Location \n';
		} 
		
		if(sub_location_id_val==''){ 
			valids =false;
			msgs +='Select Sub Location \n';
		}  
		 
		if(price==''){ 
			valids =false;
			msgs +='Enter Price value  \n';
		}  
		 
		
		if(valids==false){ 
			alert( msgs );
			return false;
		}else{
			
			document.getElementById('adds_contacts').value ='Loading...'; 
			var rands_val = Math.random();
			url = url+"?category_id_val="+category_id_val+"&no_of_beds_id_val="+no_of_beds_id_val+"&emirate_id_val="+emirate_id_val+"&location_id_val="+location_id_val+"&sub_location_id_val="+sub_location_id_val+"&types="+types+"&plot_area="+plot_area+"&price="+price+"&rands_val="+rands_val; 
			xmlhttp.onreadystatechange=stateChangenn;
			xmlhttp.open("POST",url,true);
			xmlhttp.send(null);
		} 
	} 
		
	function stateChangenn(){ 
		if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete"){   
			var temp_res = xmlhttp.responseText;
			
			var paras1_val = document.getElementById('paras1').value; 
			paras1_val = paras1_val.trim();  
			
			sels_chk_box_vals2(temp_res,paras1_val); 
			document.getElementById("close_modals").click();
		} 
	} 
	
	function GetXmlHttpObject(){
		if(window.XMLHttpRequest){  // code for IE7+, Firefox, Chrome, Opera, Safari
		   return new XMLHttpRequest();
		}
		if(window.ActiveXObject){ // code for IE6, IE5
			return new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return null;
	}   
		
</script>