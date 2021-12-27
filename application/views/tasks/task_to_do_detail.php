<div id="custom-content" class="modal-block modal-block-full">
  <!--modal-block modal-block-md-->
  <style>
	  label.control-label{
		font-weight:bold;
	  }
  </style>
  <!--<section class="panel"> 
	<div class="panel-body"> -->  
	
	<div class="row">
        <div class="form-group">
		  <label class="col-md-3 control-label" for="property_ref"> Property Ref No.  </label>
		  <div class="col-md-8">
			 <?php echo stripslashes($record->property_ref); ?>
		  </div> 
		</div>		
	</div>
	
	<div class="row"> 
        <div class="form-group">
		  <label class="col-md-3 control-label" for="lead_ref"> Lead Ref No.  </label>
		  <div class="col-md-8">
			 <?php echo stripslashes($record->lead_ref); ?>
		  </div> 
		</div>
	</div>
	
	<div class="row"> 
		<div class="form-group">
		  <label class="col-md-3 control-label" for="title"> Task Detail </label>
		  <div class="col-md-8">
		  	<?php echo stripslashes($record->title); ?> 
		  </div> 
		</div> 
	</div>
	
	<div class="row">
		<div class="form-group">
		  <label class="col-md-3 control-label" for="assigned_to">Assigned To </label>
		  <div class="col-md-8">
		  	<?php  
            $assigned_to_nm ='';
			if($record->assigned_to >0){
				$temp_usr_arr = $this->general_model->get_user_info_by_id($record->assigned_to);
				if(isset($temp_usr_arr)){
					$assigned_to_nm = stripslashes($temp_usr_arr->name); 
				}
			}
			echo $assigned_to_nm;  ?> 
		  </div> 
		</div>	
	</div>
	
	<div class="row">	
		<div class="form-group">
		  <label class="col-md-3 control-label" for="due_date">Due Date </label>
		  <div class="col-md-8">
		  	<?php echo date('d-M-Y',strtotime($record->due_date)); ?>  
		  </div>
		</div>
	</div>
	
	<div class="row">
		<div class="form-group">
		  <label class="col-md-3 control-label" for="due_timing">Due Timing </label>
			<div class="col-md-8"> 
			<?php echo stripslashes($record->due_timing); ?>  
			</div>
		</div>
    </div>
	
	<div class="row">
        <div class="form-group">
		  <label class="col-md-3 control-label" for="created_on">Task Added </label>
			<div class="col-md-8"> 
			<?= date('d-M-Y',strtotime($record->created_on)); ?> 
			</div>
		</div> 
    </div>
	
	<div class="row ">    		
		<div class="form-group">
		  <label class="col-md-3 control-label" for="status">  Status </label>
		  <div class="col-md-8">
		   <?php
				if(isset($record) && $record->status==0){ 
					echo '<span class="label label-info"> Pending </span>';
				} 
				if(isset($record) && $record->status==1){ 
					echo '<span class="label label-success"> Completed </span>';
				}
				if(isset($record) && $record->status==2){
					echo '<span class="label label-primary"> In Progress </span>';
				}
				if(isset($record) && $record->status==3){
					echo '<span class="label label-warning"> Rejected </span>';
				} 
				if(isset($record) && $record->status==4){
					echo '<span class="label label-danger"> Over Due </span>';
				} ?>   
		  </div> 
		</div>  
	</div>
	<!--</div> 
  </section>-->
</div>
