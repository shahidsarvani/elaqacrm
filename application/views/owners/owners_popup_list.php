 
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
 
<div class="containersss">
    <div class="row">
    
    <div class="form-group"> 
      <div class="col-md-3">   
      <input name="c_name" id="c_name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->name): set_value('name'); ?>" placeholder="Enter Name" title="Enter Owner Name" onblur="check_custom_validation();">
         <span class="text-danger"><?php echo form_error('name'); ?></span>  
      </div> 
      <div class="col-md-3">   
       <input name="c_email" id="c_email" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->email): set_value('email'); ?>" placeholder="Enter Email address" title="Enter Owner Email address" onblur="check_custom_validation();">
        <span class="text-danger"><?php echo form_error('email'); ?></span> 
      </div>  
      <div class="col-md-3" id="owner_phone_item_0">
        <input name="mobile_no" id="mobile_no" type="text" class="form-control phones" value="<?php echo set_value('mobile_no'); ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" placeholder="Enter Mobile No."  title="Enter Mobile No." onblur="check_custom_validation();">
        <span class="text-danger"><?php echo form_error('mobile_no'); ?></span> 
      </div>
      
      <div class="col-md-2">  
		 <?php  
            $operate_url = 'owners/owners_popup_add_list/';
            $operate_url = site_url($operate_url); ?>
        
         <button class="btn border-slate text-slate-800 btn-flat" type="button" name="adds_contacts" id="adds_contacts" onclick="operate_adds_owners('<?php echo $operate_url; ?>','fetch_owners_popup_add_list');"> Save Owner </button>  
      </div>
    </div>  
   </div>
     
</div> 
 <br> <br>
    <script>
        function validateEmail(myemail){
            var re = /\S+@\S+\.\S+/;
            return re.test(myemail);
        }  
        
        function sels_chk_box_vals(nw_owner_id_val){  
            //var nw_owner_id_val = document.datasformchk.sel_owner_id_val.value;
            if(nw_owner_id_val >0){
                window.parent.clickeds(nw_owner_id_val);  
            }
        } 	 
        
        function check_custom_validation(){ 
            $(document).ready(function(){ 
                
                var c_name = document.getElementById('c_name').value; 
                c_name = c_name.trim();  
                
                var c_email = document.getElementById('c_email').value;
                c_email = c_email.trim();
                
                var c_mobile_no = document.getElementById('mobile_no').value; 
                c_mobile_no = c_mobile_no.trim(); 
                
                if(c_name==''){ 
                    $("#c_name").css("border-color", "red"); 
                }else {
                    $("#c_name").css("border-color", "#cccccc");
                } 
                
                /*if(validateEmail(c_email)){
                    $("#c_email").css("border-color", "#cccccc");
                }else {
                     $("#c_email").css("border-color", "red"); 
                }*/
                
                if(c_mobile_no==''){ 
                    $("#mobile_no").css("border-color", "red");  
                }else {
                    $("#mobile_no").css("border-color", "#cccccc");
                }
            }); 	
        } 
          
        var params;
        var objdiv;  
        function operate_adds_owners(url,dis){   
            $(document).ready(function(){   
                objdiv=dis;
                xmlhttp=GetXmlHttpObject();
                if (xmlhttp==null){
                    alert ("Browser does not support HTTP Request");
                    return;
                } 
                
                var c_name = document.getElementById('c_name').value; 
                c_name = c_name.trim();  
                
                var c_email = document.getElementById('c_email').value;
                c_email = c_email.trim();
                
                var c_mobile_no = document.getElementById('mobile_no').value; 
                c_mobile_no = c_mobile_no.trim(); 
                
                var rets = true;
                
                if(c_name==''){ 
                    $("#c_name").css("border-color", "red");
                    rets = false;
                }else {
                    $("#c_name").css("border-color", "#cccccc");
                } 
                
                /*if(validateEmail(c_email)){
                    $("#c_email").css("border-color", "#cccccc");
                }else {
                     $("#c_email").css("border-color", "red");
                     rets = false;
                }*/
                
                if(c_mobile_no==''){ 
                    $("#mobile_no").css("border-color", "red"); 
                    rets = false;
                }else {
                    $("#mobile_no").css("border-color", "#cccccc");
                }
                
                check_custom_validation(); 
                 
                if(rets==true){  
                    document.getElementById('adds_contacts').value ='Loading...'; 
                    var rands_val = Math.random();
                    url = url+"?c_name="+c_name+"&c_email="+c_email+"&c_mobile_no="+c_mobile_no+"&rands_val="+rands_val; 
                    xmlhttp.onreadystatechange=stateChange;
                    xmlhttp.open("POST",url,true);
                    xmlhttp.send(null);
                
                }
            }); 
        } 
            
		function stateChange(){ 
			if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete"){   
				var temp_res = xmlhttp.responseText;
				 
				if(temp_res=='names'){
					document.getElementById('adds_contacts').value ='Save Owner'; 	
					document.getElementById("c_name").style.border="1px solid red"; 
				}else if(temp_res=='mobiles'){
					document.getElementById('adds_contacts').value ='Save Owner'; 	
					document.getElementById("mobile_no").style.border="1px solid red"; 
				}else if(temp_res=='namesmobiles'){
					document.getElementById('adds_contacts').value ='Save Owner'; 	
					document.getElementById("c_name").style.border="1px solid red"; 
					document.getElementById("mobile_no").style.border="1px solid red"; 
					
				}else{
					document.getElementById("c_name").style.border="1px solid #cccccc"; 
					document.getElementById("mobile_no").style.border="1px solid #cccccc"; 
					//document.getElementById(objdiv).innerHTML= xmlhttp.responseText;
					document.getElementById('adds_contacts').value ='Save Owner'; 		
					document.getElementById('c_name').value ='';   
					document.getElementById('c_email').value ='';   
					document.getElementById('mobile_no').value ='';  
					//document.getElementById('owner_phone_list').innerHTML =''; 
					//window.parent.clickeds('0');
					
					sels_chk_box_vals(xmlhttp.responseText); 
					
					document.getElementById("close_modals").click();  
				}
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
<script>
function operate_owners_list(){ 	 	  
    $(document).ready(function(){ 
        var sel_per_page_val =0;   
        var q_val = document.getElementById("q_val").value;  
        var sel_per_page = document.getElementById("per_page");
        sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value; 
           
        $.ajax({
            method: "POST",
            url: "<?php echo site_url('/owners/owners_popup_list2/'); ?>",
            data: { page: 0, sel_per_page_val: sel_per_page_val, q_val: q_val },
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
            <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control select" onChange="operate_owners_list();">
              <option value="25">Per Page</option>
              <option value="25"> 25 </option>
              <option value="50"> 50 </option>
              <option value="100"> 100 </option> 
            </select>
            </div>
            <div class="col-md-4"> 
            <input name="q_val" id="q_val" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('q_val'); ?>" placeholder="Search by Name, Email or Mobile No..." onKeyUp="operate_owners_list();">
            </div>
            <div class="col-md-4"> </div> 
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
            <th width="15%" class="text-center">Created By </th>
            <th width="15%" class="text-center">Listed</th> 
          </tr> 
        </thead>
        <tbody id="fetch_owners_popup_add_list">
        <?php 
            $sr=1; 
            if(isset($records) && count($records)>0){
                 foreach($records as $record){ 
                    $operate_url = 'owners/operate_owner/'.$record->id;
                    $operate_url = site_url($operate_url);
                    
                    $trash_url = 'owners/trash_owner/'.$record->id;
                    $trash_url = site_url($trash_url);
                    
        $temp_usr_arr = $this->general_model->get_user_info_by_id($record->created_by);
        $created_by_nm = stripslashes($temp_usr_arr->name); 
        
        $assigned_to_nm ='';
        if($record->assigned_to >0){
            $temp_usr_arr = $this->general_model->get_user_info_by_id($record->assigned_to);
            if(isset($temp_usr_arr)){
                $assigned_to_nm = stripslashes($temp_usr_arr->name); 
            }
        }   ?>  
        <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
            <td><input type="radio" name="sel_owner_id_val" id="sel_owner_id_val_<?= $sr; ?>" value="<?= $record->id; ?>" onclick="sels_chk_box_vals(this.value);"> </td>
            <td><label for="sel_owner_id_val_<?= $sr; ?>"><?= stripslashes($record->name); ?></label></td>
            <td><?= stripslashes($record->email); ?></td>
            <td class="text-center"><?php echo stripslashes($record->mobile_no); ?> </td>  
            <td class="text-center"><?= $created_by_nm; ?></td>
            <td class="text-center"><?= date('d-M-Y',strtotime($record->created_on)); ?></td>
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
   
   