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
            <label class="col-md-3 control-label" for="category_id"> Category </label>
            <div class="col-md-8" id="fetch_cates_list">
            <?php 
				if(isset($record) && $record->category_id >0){ 
					$cates_arr = $this->admin_model->get_category_by_id($record->category_id);
					if(isset($cates_arr) && count($cates_arr) >0){
						echo stripslashes($cates_arr->name);
					} 
				}  ?> 
                </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="no_of_beds_id">No. of Bedrooms </label>
            <div class="col-md-8">
            <?php
				if(isset($record) && $record->no_of_beds_id >0){ 
					$beds_arr = $this->admin_model->get_no_of_beds_by_id($record->no_of_beds_id);
					if(isset($beds_arr) && count($beds_arr) >0){
						echo stripslashes($beds_arr->title);
					} 
				}  ?> 
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="emirate_id">Emirate(s) </label>
            <div class="col-md-8">
			<?php  
                if($record->emirate_id >0){
                    $emrt_arr =  $this->admin_model->get_emirate_by_id($record->emirate_id);
                    echo stripslashes($emrt_arr->name);
                } ?> 
                </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="location_id">Location(s) </label>
            <div class="col-md-8">  
		   <?php 
                if($record->location_id >0){
                    $locts_arr =  $this->admin_model->get_emirate_location_by_id($record->location_id);
                    echo stripslashes($locts_arr->name);
                } ?>
            </div>
          </div>
           
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label class="col-md-3 control-label" for="sub_location_id">Sub Location(s)</label>
            <div class="col-md-8"> 
		<?php
            if(isset($record) && $record->no_of_beds_id >0){ 
                $beds_arr = $this->admin_model->get_no_of_beds_by_id($record->no_of_beds_id);
                if(isset($beds_arr) && count($beds_arr) >0){
                    echo stripslashes($beds_arr->title);
                } 
            }  ?> 
		     </div>
          </div> 
          <div class="form-group">
            <label class="col-md-3 control-label" for="types">Property Type </label>
            <div class="col-md-8">
             <?php echo (isset($record)) ? stripslashes($record->types): set_value('types'); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="plot_area">Size </label>
            <div class="col-md-8">
              <?php echo (isset($record)) ? stripslashes($record->plot_area): set_value('plot_area'); ?>
            </div>
          </div> 
          <div class="form-group">
            <label class="col-md-3 control-label" for="price">Price  </label>
            <div class="col-md-8">
             <?php echo (isset($record)) ? 'AED '.number_format($record->price,2,".",",") : set_value('price'); ?>
                </div>
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
 