<div class="content"> 
<!-- Dashboard content -->
<div class="row">
  <div class="col-lg-12"> 
    <!-- Horizontal form --> 
    <style>
        .form-horizontal .control-label[class*="col-md-"]{
            padding-top:0px;	
            font-size:11px;
            font-weight:bold;
        }
        
        .form-horizontal div.col-md-9, .form-horizontal div.col-md-8 { 	
            font-size:11px; 
        }
    </style> 
    <form name="datas_form" id="datas_form" method="post" action="" class="form-horizontal">
      <div class="panelsss panel-flat">
          
        <div class="panel-heading"> 
            <h6 class="panel-title text-semibold">Properties Address & Details</h6>
            <hr style="margin-top:8px; margin-bottom:5px;"> 
        </div>
                   
        <div class="panel-body">
          <div class="form-group">
                  
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-md-3 control-label" for="title">Title</label>
                <div class="col-md-9">
                   <?php echo (isset($record)) ? stripslashes($record->title) : set_value('title'); ?>     
                </div>  
             </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="description">Description </label>
                <div class="col-md-9">
                	<?php echo (isset($record)) ? stripslashes($record->description): set_value('description'); ?>   
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="property_type">Property Type </label>
                <div class="col-md-9"> 
                	<?php echo (isset($record) && $record->property_type==1) ? 'Sale':'Rent' ?>
                 </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="category_id"> Category </label>
                <div class="col-md-9"> 
                  <?php echo stripslashes($record->cate_name); ?>
                </div>
              </div>    
		 	</div>
             
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-md-3 control-label" for="ref_no">Ref # </label>
                <div class="col-md-9">
               		<?php if(isset($record) && strlen($record->ref_no)>0){ echo stripslashes($record->ref_no); } ?>     
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-3 control-label" for="assigned_to_id">Assigned To </label>
                <div class="col-md-9"> 
                <?php echo stripslashes($record->crt_usr_name); ?> 
                 </div>
              </div>
               
              <div class="form-group">
                <label class="col-md-3 control-label" for="owner_id">Owners </label>
                <div class="col-md-9"> 
                  <?php echo stripslashes($record->ownr_name); ?>    
              	</div>
              </div>   
              
              <div class="form-group">
                <label class="col-md-3 control-label" for="no_of_beds_id">Bedrooms </label>
                <div class="col-md-9">
                	<?php if(isset($record) && $record->no_of_beds_id>0){ echo stripslashes($record->no_of_beds_id); } ?> 
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="no_of_baths">Bathrooms </label>
                <div class="col-md-9">
                <?php if(isset($record) && $record->no_of_baths>0){ echo stripslashes($record->no_of_baths); } ?>  
                 </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="emirate_id">Emirates </label>
                <div class="col-md-9">
                  <?php echo stripslashes($record->em_name); ?>  
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="location_id">Locations </label>
                <div class="col-md-9">  
              		<?php echo stripslashes($record->em_lc_name); ?>  
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="sub_location_id">Sub Locations </label>
                <div class="col-md-9"> 
                 <?php echo stripslashes($record->sub_loc_name); ?> 
                 </div>
              </div> 
                    
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 control-label" for="property_address">Address </label>
                    <div class="col-md-8">
                        <?php echo stripslashes($record->property_address); ?>  
                    </div>
                  </div>
                  
                <div class="form-group">
                <label class="col-md-4 control-label" for="plot_area">Plot Area </label>
                <div class="col-md-8">
                    <?php echo stripslashes($record->plot_area); ?>   
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-4 control-label" for="property_ms_unit">Measuring Unit </label>
                <div class="col-md-8">
                <?php 
                    if(isset($record) && $record->property_ms_unit==1){
                        echo "Square Feet (ft2)";
                    }else if(isset($record) && $record->property_ms_unit==2){
                        echo "Square Centimetres (cm2)";
                    }else if(isset($record) && $record->property_ms_unit==3){
                        echo "Square Metres (m2)";
                    }else if(isset($record) && $record->property_ms_unit==4){
                        echo "Square Millimetres (mm2)";
                    }else if(isset($record) && $record->property_ms_unit==5){
                        echo "Square Kilometres (km2)";
                    }else if(isset($record) && $record->property_ms_unit==6){
                        echo "Square Yards (yd2)";
                    }else if(isset($record) && $record->property_ms_unit==7){
                        echo "Square Miles (mi2)";
                    }  ?>
                   </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-4 control-label" for="price">Price </label>
                <div class="col-md-8">
                    <?php echo stripslashes($record->price); ?> 
                </div>
              </div>    
              <div class="form-group">
                <label class="col-md-4 control-label" for="property_status"> Property Status </label>
                <div class="col-md-8">
                <?php 
                    if(isset($record) && $record->property_status==1){
                        echo "Sold";
                    }else if(isset($record) && $record->property_status==2){
                        echo "Rented";
                    }else if(isset($record) && $record->property_status==3){
                        echo "Available";
                    }else if(isset($record) && $record->property_status==4){
                        echo "Upcoming";
                    } ?>
                 </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-4 control-label" for="youtube_video_link">Youtube Video Link </label>
                <div class="col-md-8">
                    <?php echo stripslashes($record->youtube_video_link); ?>  
                </div>
              </div>
              <style>
                .radio-inline {
                    padding-left:27px;	
                } 
              </style>
                    
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="is_furnished1">Is Furnished ?</label> 
                    <div class="col-md-8">  
                    <?php 
                        if(isset($record) && $record->is_furnished==1){
                            echo "Furnished";
                        }else if(isset($record) && $record->is_furnished==2){
                            echo "SemiFurnished";
                        }else if(isset($record) && $record->is_furnished==3){
                            echo "UnFurnished";
                        } ?>
                     </div> 
                  </div>
                   
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="source_of_listing">Source of Listing </label>
                    <div class="col-md-8">
                        <?php echo stripslashes($record->sr_lst_title); ?>   
                    </div>
                  </div>
            </div>
            
          </div>
        </div>
      </div>
      
      
      <div class="row">
          <div class="col-md-12">
            <div class="panelsss panel-flat">
              <div class="panel-heading"> 
                <h6 class="panel-title text-semibold">Portal(s)</h6>
       			<hr style="margin-top:8px; margin-bottom:5px;"> 
              </div>
              <div class="panel-body">  
                 <ul class="list list-icons no-margin-bottom" style="text-align:left;"> 
                    <?php  
                        if(isset($record) && strlen($record->show_on_portal_ids)>0){
                            $db_portal_ids = $record->show_on_portal_ids;  
                            $portal_arrs = $this->portals_model->get_all_portals_in_id($db_portal_ids);
                            if(isset($portal_arrs)){
                                foreach($portal_arrs as $portal_arr){ 
                                    echo '<li> <i class="icon-checkmark-circle text-teal-400 position-left"></i>'.stripslashes($portal_arr->name)."</li>";
                                }  
                            } 
                         } ?> 
                          </ul>
              </div> 
            </div>  
          </div> 
    	</div>
      
<div class="row">
  <div class="col-md-12">
    <div class="panelsss panel-flat"> 
      <div class="panel-body">  
         <div class="row">
            <div class="col-md-6">
                <h6 class="panel-title text-semibold">Private Amenities</h6>
                <hr style="margin-top:8px;">
                <ul class="list list-icons" style="text-align:left;">
<?php 
    $private_amenities_txt = ''; 
    if(isset($record) && strlen($record->private_amenities_data)>0){
        $private_amenities_ids = $record->private_amenities_data;  
        $private_amenities_arrs = $this->property_features_model->get_all_property_features_in_id($private_amenities_ids);
        if(isset($private_amenities_arrs)){
            foreach($private_amenities_arrs as $private_amenities_arr){
                echo '<li> <i class="icon-checkmark-circle text-teal-400 position-left"></i>'.stripslashes($private_amenities_arr->title)."</li>";
            }  
        }  
     } ?> 
      </ul>
  
            </div> 
                    
    <div class="col-md-6">           
        <h6 class="panel-title text-semibold">Commercial Amenities</h6>
        <hr style="margin-top:8px;">
        <ul class="list list-icons no-margin-bottom" style="text-align:left;">
         <?php  
            if(isset($record) && strlen($record->commercial_amenities_data)>0){
                $commercial_amenities_ids = $record->commercial_amenities_data;  
                $commercial_amenities_arrs = $this->property_features_model->get_all_property_features_in_id($commercial_amenities_ids);
                if(isset($commercial_amenities_arrs)){
                    foreach($commercial_amenities_arrs as $commercial_amenities_arr){
                          echo '<li> <i class="icon-checkmark-circle text-teal-400 position-left"></i>'.stripslashes($commercial_amenities_arr->title)."</li>"; 
                    }  
                } 
             } ?>
            </ul>
          
            </div> 
        </div>  
  
      </div> 
    </div>  
  </div> 
</div>
      
           
        <link rel="stylesheet" href="<?= asset_url(); ?>vendor/owl.carousel/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="<?= asset_url(); ?>vendor/owl.carousel/assets/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?= asset_url(); ?>css/theme-elementss.css">     
               
        <div class="row">
          <div class="col-md-12">
            <div class="panelsss panel-flat">
              <div class="panel-heading"> 
                <h6 class="panel-title text-semibold">Photo(s)</h6>
       			<hr style="margin-top:8px; margin-bottom:5px;"> 
              </div>
              <div class="panel-body">  
               <div class="owl-carousel owl-theme show-nav-hover" data-plugin-options='{"items": 4, "margin": 10, "loop": false, "nav": true, "dots": false}'>  
 <?php 		
    $photos_arrs = $this->properties_model->get_all_property_photos_by_property_id($record->id);				
    if(isset($photos_arrs) && count($photos_arrs) >0){
        foreach($photos_arrs as $photos_arr){
            $fl_ext = substr(strrchr($photos_arr->image, '.'), 1); 
            if($fl_ext=="doc" || $fl_ext=="docx" || $fl_ext=="pdf"){ ?>  
                 
                <div> <span class="img-thumbnail"> <a href="<?php echo base_url(); ?>downloads/property_photos/<?php echo $photos_arr->image; ?>" class="image-popup-no-margins" target="_blank">Download</a> </span> </div>
                
      <?php }else{ ?>   
                  
                <div> <img alt="" src="<?php echo base_url(); ?>downloads/property_photos/<?php echo $photos_arr->image; ?>" class="img-responsive img-rounded"> </div>
      	
	  	<?php 
            }  
         } 
     }	?>
                
                </div> 
              </div> 
            </div>  
          </div> 
    	</div>     
         
         
         
        
        <div class="row"> 
          <div class="col-md-12">
            <div class="panelsss panel-flat">
              <div class="panel-heading"> 
                <h6 class="panel-title text-semibold">Document(s)</h6>
       			<hr style="margin-top:8px; margin-bottom:5px;"> 
              </div>
              <div class="panel-body">
              		<div id="documentsfiles">
			<?php 				
				$docs_arrs = $this->properties_model->get_property_dropzone_documents_by_id($record->id);		 
				if(isset($docs_arrs) && count($docs_arrs) >0){
					foreach($docs_arrs as $docs_arr){
						$fl_ext = substr(strrchr($docs_arr->name, '.'), 1); 
						if($fl_ext=="doc" || $fl_ext=="docx" || $fl_ext=="pdf"){ ?>  
							 
							<div> <span class="img-thumbnail"> <a href="<?php echo base_url(); ?>downloads/property_documents/<?php echo $docs_arr->name; ?>" class="image-popup-no-margins" target="_blank"><?php echo $docs_arr->name; ?></a> </span> </div>
							
							<?php }else{ ?>    
                           
                           	<div> <span class="img-thumbnail"> <img alt="<?php echo $docs_arr->name; ?>" src="<?php echo base_url(); ?>downloads/property_documents/<?php echo $docs_arr->name; ?>" class="img-responsive"> </span> </div>
							
						 <?php 
						}  
					 } 
				 }	?> 
                    </div> 
					<br>
              </div>
            </div> 
          </div>    
    	</div>
        
        
        
        
        <div class="row">   
          <div class="col-md-12">
            <div class="panelsss panel-flat">
              <div class="panel-heading"> 
                <h6 class="panel-title text-semibold">Note(s)</h6>
       			<hr style="margin-top:8px; margin-bottom:5px;"> 
              </div>
              <div class="panel-body">   
               <div class="panel panel-flat timeline-content"> 
                <div class="panel-body">
              	<ul class="media-list chat-list content-group" id="fetch_properties_notes_list">    			<?php 
					if(isset($record) && $record->id >0){
						$nt_arrs = $this->properties_model->get_property_notes($record->id); 
						if(isset($nt_arrs) && count($nt_arrs)>0){
							foreach($nt_arrs as $nt_arr){ ?> 	  
								<li class="media"> 
                                  <div class="media-left"> 
                                   <u><i> <?php 
                                        $dbs_user_id = $nt_arr->user_id;
                                        if($dbs_user_id>0){
                                            $usr_arr =  $this->general_model->get_user_info_by_id($dbs_user_id);
                                            echo stripslashes($usr_arr->name);
                                        }  ?> 
                                 		</i> </u> </div> 
                                        
								  <div class="media-body">
									<div class="media-content"><?= stripslashes($nt_arr->notes); ?></div>
									<span class="media-annotation display-block mt-10"><?php echo date('d F, Y',strtotime($nt_arr->datatimes)); ?> </span> </div>
								</li> 
							<?php 
							}
						}
					} ?> 
                  </ul> 
                   
                </div>
              </div>    
          </div>
        </div> 
      </div>
    	</div>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
         
    </form> 
    <script src="<?= asset_url(); ?>vendor/owl.carousel/owl.carousel.js"></script>
    
    <script>   
		window.theme = {};
		 
		// Carousel
		(function(theme, $) {
		
			theme = theme || {};
		
			var instanceName = '__carousel';
		
			var PluginCarousel = function($el, opts) {
				return this.initialize($el, opts);
			};
		
			PluginCarousel.defaults = {
				loop: true,
				responsive: {
					0: {
						items: 1
					},
					479: {
						items: 1
					},
					768: {
						items: 2
					},
					979: {
						items: 3
					},
					1199: {
						items: 4
					}
				},
				navText: []
			};
		
			PluginCarousel.prototype = {
				initialize: function($el, opts) {
					if ($el.data(instanceName)) {
						return this;
					}
		
					this.$el = $el;
		
					this
						.setData()
						.setOptions(opts)
						.build();
		
					return this;
				},
		
				setData: function() {
					this.$el.data(instanceName, this);
		
					return this;
				},
		
				setOptions: function(opts) {
					this.options = $.extend(true, {}, PluginCarousel.defaults, opts, {
						wrapper: this.$el
					});
		
					return this;
				},
		
				build: function() {
					if (!($.isFunction($.fn.owlCarousel))) {
						return this;
					}
		
					var self = this,
						$el = this.options.wrapper;
		
					// Add Theme Class
					$el.addClass('owl-theme');
		
					// Force RTL according to HTML dir attribute
					if ($('html').attr('dir') == 'rtl') {
						this.options = $.extend(true, {}, this.options, {
							rtl: true
						});
					}
		
					if (this.options.items == 1) {
						this.options.responsive = {}
					}
		
					if (this.options.items > 4) {
						this.options = $.extend(true, {}, this.options, {
							responsive: {
								1199: {
									items: this.options.items
								}
							}
						});
					}
		
					// Auto Height Fixes
					if (this.options.autoHeight) {
						$(window).afterResize(function() {
							$el.find('.owl-stage-outer').height( $el.find('.owl-item.active').height() );
						});
		
						$(window).load(function() {
							$el.find('.owl-stage-outer').height( $el.find('.owl-item.active').height() );
						});
					}
		
					// Initialize OwlCarousel
					$el.owlCarousel(this.options).addClass("owl-carousel-init");
		
					return this;
				}
			};
		
			// expose to scope
			$.extend(theme, {
				PluginCarousel: PluginCarousel
			});
		
			// jquery plugin
			$.fn.themePluginCarousel = function(opts) {
				return this.map(function() {
					var $this = $(this);
		
					if ($this.data(instanceName)) {
						return $this.data(instanceName);
					} else {
						return new PluginCarousel($this, opts);
					}
		
				});
			}
		
		}).apply(this, [window.theme, jQuery]);
	 
			// Carousel
			(function($) {
			
				'use strict';
			
				if ($.isFunction($.fn['themePluginCarousel'])) {
			
					$(function() {
						$('[data-plugin-carousel]:not(.manual), .owl-carousel:not(.manual)').each(function() {
							var $this = $(this),
								opts;
			
							var pluginOptions = $this.data('plugin-options');
							if (pluginOptions)
								opts = pluginOptions;
			
							$this.themePluginCarousel(opts);
						});
					});
			
				}
			
			}).apply(this, [jQuery]);
    </script>
    
    <script src="<?= asset_url(); ?>js/examples/examples.carousels.js"></script>	
    
  
        <!-- /horizotal form --> 
        
		<!-- Theme Initialization Files --> 
       
      </div>
    </div>
    <!-- /dashboard content --> 
    
  </div>