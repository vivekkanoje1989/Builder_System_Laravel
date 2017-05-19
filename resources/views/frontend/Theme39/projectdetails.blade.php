@extends('layouts/frontend/Theme39/main')
@section('content')

        <main id="main" class="main index-main_ clearfix" role="main">
            <div class="container">
                <div class="row">
                    <section id="content" class="site-content hfeed site-content col-xs-12 col-sm-12 col-md-12" role="main">
						<?php if (!empty($project_info->project_images)) { ?>	

					   <div class="fitsc-row hidden-xs row-fluid row-fluid-content">
                            <div class="row">
                                <div class="fitsc-column col-md-12 col-sm-12 col-xs-12">
                                    <div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="classicslider1" style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
									<!-- START REVOLUTION SLIDER 5.0.7 auto mode -->
										<div id="rev_slider_4_1" class="rev_slider fullwidthabanner" data-version="5.0.7">
											<ul>	<!-- SLIDE  -->
											<?php
												$images = explode(',', $project_info->project_images);
												foreach ($images as $image) 
												{   ?>	
												<li data-index="rs-18" data-transition="zoomin" data-slotamount="7"  data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="2000"  data-thumb=""  data-rotate="0"  data-saveperformance="off"  data-title="Ken Burns" data-description="">
													<!-- MAIN IMAGE -->
													<img src="<?php echo $this->image_path; ?>Projects/projectImages/<?php echo $image; ?>"  alt=""  data-bgposition="center center" data-kenburns="on" data-duration="30000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="120" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0" data-bgparallax="10" class="rev-slidebg" data-no-retina>
													<!-- LAYERS -->

												</li>
												<!-- SLIDE  -->
											<?php  } ?>	
											</ul>
											<div class="tp-static-layers"></div>
											<div class="tp-bannertimer" style="height: 7px; background-color: rgba(255, 255, 255, 0.25);"></div>	
										</div>
									</div><!-- END REVOLUTION SLIDER -->
                                </div>
                            </div>
                        </div>
						<?php } 	 ?>			
						
                        <div class="fitsc-row  row-background row-fluid row-no-gutter row-parallax overlay-enabled primary-color" 
						style="; background-image: url(images/bg-for-parallax.jpg);">
                            <div class="overlay"></div>
                            <div class="row">
                                <div class="fitsc-column col-md-3 col-sm-3 col-xs-12">
                                    
                                </div>
                                <div class="fitsc-column col-md-6 col-sm-6 col-xs-12" align="center">
                                    <div class="fitsc-bubble bubble-number">
                                        <span class="bubble-icon"><i class="fa fa-search"></i></span>
                                        <div class="bubble-text">
                                            <h2><?php echo $project_info->project_name?></h2>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="fitsc-column col-md-3 col-sm-3 col-xs-12">
                                   
                                </div>
                            </div>
                        </div>
                       
                        <div class="fitsc-row  row-background row-fluid row-parallax overlay-enabled secondary-color pattern" style="; background-image: url(<?php echo $url;?>/images/bg2.jpg);">
                            <div class="overlay"></div>
                            <div class="row">
                                <div class="fitsc-space"></div>
                                <div class="fitsc-column col-md-4 col-sm-4 col-xs-12 hidden-sm hidden-xs">
									<img class="aligncenter size-large wp-image-1914" src="<?php echo $url;?>/images/man.png" alt="man" width="243" height="470" />
                                </div>
                                <div class="fitsc-column col-md-1 col-sm-1 col-xs-12 hidden-sm hidden-xs"></div>
                                <div class="fitsc-column col-md-7 col-xs-12 col-sm-12">
                                    <div class="fitsc-tabs fitsc-horizontal fitsc-only-icon">
                                        <ul class="fitsc-nav">
                                            <li class="fitsc-active"><a href="#"><i class="fa fa-search"></i></a></li>
                                            <li><a href="#"><i class="fa fa-lightbulb-o"></i></a></li>
                                            <li><a href="#"><i class="fa fa-users"></i></a></li>
                                            <li><a href="#"><i class="fa fa-video-camera"></i></a></li>
                                            <li><a href="#"><i class="fa fa-sitemap"></i></a></li>
                                            <li><a href="#"><i class="fa fa-map-marker"></i></a></li>
                                          
                                        </ul>
                                        <div class="fitsc-content fitsc-tabs-content">
                                           
											<div class="fitsc-tab fitsc-active">
                                                <h5><span>PROJECT INFO</span></h5>


														<p><?php
														if(!empty($project_info->brief_description))   
														echo $project_info->brief_description;
														else
														echo "Description coming soon !!!";
														?></p>
													<?php if(!empty($project_info->broacher))
													{   ?>  
												  <a href="<?php echo $this->image_path; ?>Projects/brochures/<?php echo $project_info->broacher; ?>" target="_blank" class="fitsc-button fitsc-background-yellow">DOWNLOAD BROCHURE</a>
												  <?php } ?>
                                            </div>
											
										   <div class="fitsc-tab">
                                                <h5><span>AMENITIES LIST</span></h5>
													<?php if(!empty($project_info->amenities_list))
															{
															$amenities = explode(',', $project_info->amenities_list);
															?>
															<?php foreach ($amenities as $data)  
															{
															?>
															<p class="col-md-6 col-xs-12"><i class="fa fa-chevron-circle-right">&nbsp;&nbsp;</i><?php echo $data;?></p>
															<?php }
															}
															if(empty($project_info->amenities_list)){
															?>
															<p><i class="fa fa-check-square">&nbsp;&nbsp;</i>Amenities List coming soon !!!</p>     
															<?php }
															?>
									
                                            </div>
                                            <div class="fitsc-tab">
                                                <h5><span>SPECIFICATION LIST</span></h5>
															<?php
															if (!empty($project_info->specification_list)) 
															{
															$specification = explode(',', $project_info->specification_list);
															?>

															<?php	foreach ($specification as $data) {	?>

															<p class="col-md-6 col-xs-12"><i class="fa fa-chevron-circle-right">&nbsp;&nbsp;</i><?php echo $data;?></p>
															<?php } }    
															if (empty($project_info->specification_list)) 
															{  
															?>
															<p><i class="fa fa-check-square">&nbsp;&nbsp;</i>Specification List coming soon !!!</p>
															<?php  }?> 
                                            </div>
											<div class="fitsc-tab">
                                                <h5><span>PROJECT VIDEO</span></h5>
												<?php
													if (!empty($project_info->video_link))
														{
												?>
													
													<iframe  style="max-width: 450px; width: 100%; height: 250px;" src="<?php echo $project_info->video_link; ?>" frameborder="0" allowfullscreen></iframe>
													
													
												
												<?php }	else {	echo '<li class="col-md-12 text-center">walk-through coming soon !!!</li>';	} ?>
													
											</div>		
                                            <div class="fitsc-tab">
                                                <h5><span>SITE MAP</span></h5>
													<?php if(!empty($project_info->location_map)) { ?>
													<img src="<?php echo $this->image_path . "Projects/locationMap/" . $project_info->location_map; ?>" class="proj-loc-map"/>
													<?php } ?>
                                            </div>
                                            <div class="fitsc-tab">
                                                <h5><span>GOOGLE MAP</span></h5>
												<?php if(!empty($project_info->site_map)) { ?>
												<div class="proj-google-map">
												<?php    echo  $project_info->site_map ;?>
												</div>
												<?php } ?>	
                                            </div>
                                          
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                      
                        
                        <div class="fitsc-row ">
                            <div class="row">
                             
							 <div class="fitsc-row  row-background row-fluid" style="; background-image: url(<?php echo $url; ?>/images/work-pattern.png);">
                            <div class="row">
                                <div class="fitsc-space" style="height: 100px"></div>
                            </div>
                        </div>
	
                        <h3 class="fitsc-heading fitsc-heading-underline fitsc-font-medium fitsc-align-center  clearfix"><span>NEWEST PRODUCTS</span></h3>
                        <p class="center_text">We&#8217;re Offering High Quality, Guaranteed Tools in Real Low Prices, Check Our Shop For New Products</p>
                        <div class="fitsc-space"></div>
                        <div class="woocommerce columns-4 col-md-12 col-xs-12">
                             <div class="products">
                               
<?php 
											$block_type = ProjectBlockDetails::model()->findAllByAttributes(array('project_id' => $project_info->id), array('group' => 'block_type'));
											foreach ($block_type as $blocks)
											{   
															$block_types = ProjectBlockDetails::model()->findAllByAttributes(array('project_id' => $project_info->id,'block_type' => $blocks->block_type,'availablity'=>'Yes'));
															$j=1;
															foreach($block_types as $block_type)
																	{
														?> 

							   <div class="col-md-4 col-xs-12 ">
                                    <div class="product-inner2">
                                       
                                            <div class="prod-div">
                                                <h3> <?php echo ucwords($block_type->sub_heading); ?></h3>
                                               <p> <?php echo substr($block_type->block_description, 0, 94); ?></p>
                                            </div>
                                        <a href="#" rel="nofollow" data-product_id="99" data-product_sku="" data-quantity="1" class="prod-div-a"  data-toggle="modal" data-target="#interest" onclick="interested_inproject(<?php echo $blocks->project_id; ?>,<?php echo $blocks->id; ?>);">Add to Favourite</a> 
									</div>
                                </div>
 <?php }
							}
							
							 if(empty($block_type)){ 
                                                               ?>
								<p class="first post-99 product type-product status-publish has-post-thumbnail product_cat-drills clearfix col-sm-6 col-xs-6 col-md-3 	shipping-taxable purchasable product-type-simple product-cat-drills instock"><span>1</span> We'll Update This Page Soon..</p>
									
								
								 <?php }?> 

                            </div>

                        </div>
						
                        <div class="fitsc-space col-md-12 col-xs-12" style="height: 50px"></div>



                        <h3 class="fitsc-heading fitsc-heading-underline fitsc-font-medium fitsc-align-center  clearfix"><span>PROJECT IMAGES</span></h3>
                        <p class="center_text">We Offer Our Customers the Best Services &amp; Solutions, This is Our Main Services List</p>
                        <div class="fitsc-tabs fitsc-horizontal">
                            <ul class="fitsc-nav">
                                <li class="fitsc-active"><a href="#">AMENITIES IMAGES</a></li>
                                <li><a href="#">SPECIFICATION IMAGES</a></li>
                               <li><a href="#">LAYOUT PLANS</a></li>
                                <li><a href="#">FLOOR PLANS</a></li>
                                <li><a href="#">PROJECT STATUS</a></li>
                                <li><a href="#">GALLERY</a></li>
                            </ul>
                            <div class="fitsc-content">
                                <div class="fitsc-tab fitsc-active">
										<?php
													if(!empty( $project_info->amenities)) 
													{ ?>
												<div class="col-md-3 col-xs-12">
														<a class="fancybox" href="<?php echo $this->image_path . "Projects/amenities/" . $project_info->amenities; ?>" data-fancybox-group="1" title="<?php echo ucwords($project_info->project_name); ?>"><img src="<?php echo $this->image_path . "Projects/amenities/" . $project_info->amenities; ?>" class="proj-img2" alt="" /></a>
												</div>
												<?php 
													}
													if(empty( $project_info->amenities))
													{ ?>
														<h5>Amenities Images coming soon !!!</h5>
														<?php 
													} 
												?>
										<br>
                                </div>
                                <div class="fitsc-tab fitsc-tab-home">
												
													<?php if(!empty($project_info->specification)) 
													{ 

													?>
														<div class="col-md-3 col-xs-12">
															<a class="fancybox col-centered" href="<?php echo $this->image_path . "Projects/specification/" . $project_info->specification; ?>" data-fancybox-group="2" title="<?php echo ucwords($project_info->project_name); ?>">
															<h6>Entire Project</h6>
															<img src="<?php echo $this->image_path . "Projects/specification/" . $project_info->specification; ?>" alt="" class="proj-img2" />
															</a>
														</div>	
													<?php
													} 
													?>
													<?php 
													$wingspec = Wing::model()->findAllByAttributes(array('project_id'=>$_GET['id'])); 
													if(!empty($wingspec)) 
													{ 
													$i=1;
													foreach($wingspec as $spec)
													{
													if(!empty($spec->specification))
													{
													$specificationInWing = @json_decode($spec->specification, true);   

													foreach($specificationInWing as $specification)
													{
													if(!empty($specification['floor']))
													{
													$wing=$spec->wing;
													$floor = str_replace("_", ",", $specification['floor']);
													?>
														<div class="col-md-3 col-xs-12">
															<a class="fancybox col-centered" href="<?php echo $this->image_path . "Projects/specification/" . $specification['image']; ?>" data-fancybox-group="2" title="<?php echo ucwords($project_info->project_name); ?>">

															<img src="<?php echo $this->image_path . "Projects/specification/" . $specification['image']; ?>" alt="Specification Images <?php echo $i;?>" class="proj-img2"/>
															</a>
														</div>	
													<?php
													} 
													$i++;
													}
													}
													}	
													} ?>    



													<?php if(empty($project_info->specification) && empty($wingspec) ) 
													{ ?>         
													<h5>Specification Images coming soon !!!</h5>
													<?php 
													} 
													?>

											
											
												
                                </div>
                                <div class="fitsc-tab">
													<?php  
													if(!empty($project_info->layout_plan)) 
													{ 
													?> 
														<div class="col-md-3 col-xs-12">
															<a class=" fancybox col-centered " href="<?php echo $this->image_path . "Projects/layoutPlan/" . $project_info->layout_plan; ?>" data-fancybox-group="4" title="<?php echo ucwords($project_info->project_name); ?>">
															<h6>Entire Project Layout</h6>
															<img src="<?php echo $this->image_path . "Projects/layoutPlan/" . $project_info->layout_plan; ?>" class="proj-img2" alt="" />
															</a>
														</div>
													<?php 
													}

													$winglayout = Wing::model()->findAllByAttributes(array('project_id'=>$_GET['id'])); 
													if(!empty($winglayout)) 
													{ 
													foreach($winglayout as $layout)
													{	

													$wing=$layout->wing;
													if(!empty($layout->layout_plan_image))
													{
													?>  

														<div class="col-md-3 col-xs-12">
															<a class=" fancybox col-centered" href="<?php echo $this->image_path . "Projects/layoutPlan/" . $layout->layout_plan_image; ?>" data-fancybox-group="4" title="<?php echo ucwords($project_info->project_name); ?>">
															<h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $wing." Layout";?></h6>
															<img src="<?php echo $this->image_path . "Projects/layoutPlan/" . $layout->layout_plan_image; ?>" alt=""  class="proj-img2" />
															</a>
														</div>
													<?php   
													}
													}
													}

													if( empty($winglayout) && empty($project_info->layout_plan) )
													{
													echo '<li class="col-md-12 text-center">Layout Plans coming soon !!!</li>';
													}
													?>
													<?php
													?>
                                </div>
                                <div class="fitsc-tab">
													<?php
													if(!empty($project_info->floor_plan)) 
													{ 
													?>
													<div class="col-md-3 col-xs-12">	
														<a class="fancybox col-centered" href="<?php echo $this->image_path . "Projects/floorPlan/" . $project_info->floor_plan; ?>" data-fancybox-group="3" title="<?php echo ucwords($project_info->project_name); ?>">
														<h6>Entire Project</h6>
														<img src="<?php echo $this->image_path . "Projects/floorPlan/" . $project_info->floor_plan; ?>" alt=" " class="proj-img2"/></a>
													</div>
													<?php
													}  	

													$wingfloor = Wing::model()->findAllByAttributes(array('project_id'=>$_GET['id']));
													if(!empty($wingfloor)) 
													{    
													foreach($wingfloor as $floor)
													{

													if(!empty($floor->floor_plan))
													{
													$floorplanInWing = @json_decode($floor->floor_plan, true); 
													foreach($floorplanInWing as $specification)
													{     
													if(!empty($specification['floor']))
													{						

													$wing=$floor->wing;
													$floor = str_replace("_", ",", $specification['floor']);
													$cnt++;
													//echo $floor->wing.' Floor '.$floor.' : ';
													?>
														<div class="col-md-3 col-xs-12">				
															<a class="fancybox  col-centered" href="<?php echo $this->image_path . "Projects/floorPlan/" . $specification['image']; ?>" data-fancybox-group="3"title="<?php echo ucwords($project_info->project_name); ?>">
															<h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $wing.' Floor:'.$floor; ?></h6>
															<img src="<?php echo $this->image_path . "Projects/floorPlan/" . $specification['image']; ?>" alt="" class="proj-img2"/>
															</a>
														</div>
													<?php  
													} 
													}    
													}
													}
													}
													if(empty($project_info->floor_plan) && empty($wingfloor)) 
													{
													echo '<li class="col-md-12 text-center">Floor Plans coming soon !!!</li>';
													}
													?>
					
                                </div>
                                <div class="fitsc-tab">
													<?php
													if (!empty($project_info->project_status_images))
													{								
													$images = explode(',', $project_info->project_status_images);
													foreach ($images as $image)
													{
													?>
													<div class="col-md-3 col-xs-12">													
														<a class="fancybox  col-centered" href="<?php echo $this->image_path; ?>Projects/projectImages/projectStatusImages/<?php echo $image; ?>" data-fancybox-group="5" title="<?php echo ucwords($project_info->project_name); ?>">
														<img src="<?php echo $this->image_path; ?>Projects/projectImages/projectStatusImages/<?php echo $image; ?>" alt="" class="proj-img2"/>
														</a>
													</div>

													<?php			}
													} 
													else
													{
													echo '<li class="col-md-12 text-center">Project Status Images !!!</li>';
													}  
													?>
                                </div>
                                <div class="fitsc-tab">
												<?php
															if (!empty($project_info->project_images))
															{								
															$images = explode(',', $project_info->project_images);
															foreach ($images as $image)
															{
															?>
																<div class="col-md-3 col-xs-12">
																	<a class="fancybox" href="<?php echo $this->image_path; ?>Projects/projectImages/<?php echo $image; ?>" data-fancybox-group="6" title="<?php echo ucwords($project_info->project_name); ?>">
																	<img src="<?php echo $this->image_path; ?>Projects/projectImages/<?php echo $image; ?>" alt="" class="proj-img2" /></a>
																</div>
												
													<?php   
																						   }                        
															} 
															if(empty($project_info->project_images))
															{
															?>
															<div class="col-md-6 col-sm-6 col-xs-12 col-centered">                            
															<div class="proj-div" align="center">
															<h5>Elevations coming soon !!!</h5>
															</div>
															</div>
															<?php               }   
															?>
                                </div>
                            </div>
                        </div>
                       
                    </section>

                </div>
            </div>
        </main>
		<br><br>
			<!-- interest Modal -->
	  <div class="modal fade" id="interest" role="dialog">
		<div class="modal-dialog modal-sm">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Enquiry for Property </h4>
			</div>
			<div class="modal-body inter inter-in">
			<form method="post"  action="#">	
			
			<input id="first_name" name="txtFirstName"  value="" type="text" autocomplete="on" placeholder="First Name*" onkeypress=" $(this).val(capital($(this).val())); onlychar(event);">
			 
			 <input id="last_name" name="txtLastName" value="" type="text" autocomplete="on" placeholder="Last Name*" onkeyup="$(this).val(capital($(this).val()))" onkeypress='onlychar(event)'>
							                            
							<input id="mobile_no" name="txtMobile"  value="" type="text" autocomplete="on" placeholder="Mobile Number*" onkeypress='onlynum(event)' maxlength="10">
							
							<input id="email_id" name="txtEmail"  value="" type="text" autocomplete="on" placeholder="Email*">
							
							<textarea name="txtRemarks" id="comment" rows="3"  onkeypress='$(this).val(capitaliseFirstLetter($(this).val()))' placeholder="Remarks*"></textarea>
				
						<div>
						<img id="enq_captcha" style="padding: 5px 0 0 5px;" src="<?php echo Yii::app()->getBaseUrl(true); ?>/captcha_code_file.php?rand=<?php echo rand(); ?>&name=enq_captcha" placeholder="Captcha">
						<div style="padding: 0 0 0 5px;"> <a style="color:blue"class="here" href="javascript: refreshCaptcha('enq_captcha');">Click here to refresh</a></div> 
						</div>
				<input id="captcha_value" name="txtCaptcha"  value="" type="text" autocomplete="on" placeholder="Captcha Text">
				
				<input type="hidden" name="hid_property_id" id="hid_property_id" value="">
				<input type="hidden" name="hid_project_id" id="hid_project_id" value="">
				<input type="hidden" name="hid_block_id" id="hid_block_id" value="">   
				
			  <div class="btn-img" align="center">
			  	<center><span id="wait_project" style="color:black;">Please Wait</span> <div id="loading_project" ><img id="loadimg_project" src="<?php echo Yii::app()->baseUrl; ?>/common/images/loading.gif" alt="" /></div>
                    	<button name="enq_sbt" id="enq_sbt" type="button" class="btn btn-send en-btn dark" >Send Us</button>
			  </div>
			 </form> 
			</div>
		  </div>
		  
		</div>
	  </div>
	  

        <main id="main" class="main index-main_ clearfix" role="main">
            <div class="container">
                <div class="row">
                    <section id="content" class="site-content hfeed site-content col-xs-12 col-sm-12 col-md-12" role="main">
                        <div class="fitsc-row hidden-xs row-fluid row-fluid-content">
                            <div class="row">
                                <div class="fitsc-column col-md-12 col-sm-12 col-xs-12">
                                    <div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="classicslider1" style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
									<!-- START REVOLUTION SLIDER 5.0.7 auto mode -->
										<div id="rev_slider_4_1" class="rev_slider fullwidthabanner" data-version="5.0.7">
											<ul>	<!-- SLIDE  -->
												
												<li data-index="rs-18" data-transition="zoomin" data-slotamount="7"  data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="2000"  data-thumb=""  data-rotate="0"  data-saveperformance="off"  data-title="Ken Burns" data-description="">
													<!-- MAIN IMAGE -->
													<img src="images/slider/03.jpg"  alt=""  data-bgposition="center center" data-kenburns="on" data-duration="30000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="120" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0" data-bgparallax="10" class="rev-slidebg" data-no-retina>
													<!-- LAYERS -->

												</li>
												<!-- SLIDE  -->
												
											</ul>
											<div class="tp-static-layers"></div>
											<div class="tp-bannertimer" style="height: 7px; background-color: rgba(255, 255, 255, 0.25);"></div>	
										</div>
									</div><!-- END REVOLUTION SLIDER -->
                                </div>
                            </div>
                        </div>
                        <div class="fitsc-row  row-background row-fluid row-no-gutter row-parallax overlay-enabled primary-color" 
						style="; background-image: url(images/bg-for-parallax.jpg);">
                            <div class="overlay"></div>
                            <div class="row">
                                <div class="fitsc-column col-md-4 col-sm-4 col-xs-12">
                                    <div class="fitsc-bubble bubble-number">
                                        <span class="bubble-icon">01</span>
                                        <div class="bubble-text">
                                            <p>THINKING &amp;</p>
                                            <p>SKETCHING IDEA</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="fitsc-column col-md-4 col-sm-4 col-xs-12">
                                    <div class="fitsc-bubble bubble-number">
                                        <span class="bubble-icon">02</span>
                                        <div class="bubble-text">
                                            <p>WORKING &amp;</p>
                                            <p>ACCOMPLISHMENT</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="fitsc-column col-md-4 col-sm-4 col-xs-12">
                                    <div class="fitsc-bubble bubble-number">
                                        <span class="bubble-icon">02</span>
                                        <div class="bubble-text">
                                            <p>UTILIZATION &amp;</p>
                                            <p>ADMINISTRATION</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="fitsc-row  row-background row-fluid row-parallax overlay-enabled secondary-color pattern" style="; background-image: url(images/bg2.jpg);">
                            <div class="overlay"></div>
                            <div class="row">
                                <div class="fitsc-space"></div>
                                <div class="fitsc-column col-md-4 col-sm-4 col-xs-12 hidden-sm hidden-xs">
									<img class="aligncenter size-large wp-image-1914" src="images/man.png" alt="man" width="243" height="470" />
                                </div>
                                <div class="fitsc-column col-md-1 col-sm-1 col-xs-12 hidden-sm hidden-xs"></div>
                                <div class="fitsc-column col-md-7 col-xs-12 col-sm-12">
                                    <div class="fitsc-tabs fitsc-horizontal fitsc-only-icon">
                                        <ul class="fitsc-nav">
                                            <li class="fitsc-active"><a href="#"><i class="fa fa-lightbulb-o"></i></a></li>
                                            <li><a href="#"><i class="fa fa-search"></i></a></li>
                                            <li><a href="#"><i class="fa fa-sitemap"></i></a></li>
                                            <li><a href="#"><i class="fa fa-wrench"></i></a></li>
                                            <li><a href="#"><i class="fa fa-rocket"></i></a></li>
                                            <li><a href="#"><i class="fa fa-users"></i></a></li>
                                            <li><a href="#"><i class="fa fa-check"></i></a></li>
                                            <li><a href="#"><i class="fa fa-umbrella"></i></a></li>
                                        </ul>
                                        <div class="fitsc-content fitsc-tabs-content">
                                            <div class="fitsc-tab fitsc-active">
                                                <h5><span>INNOVATIVE IDEAS</span></h5>


                                                <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt. Cras congue posuer eros eget egestas. Aenean varius ex ut ex laoreet fermentum. Curabitur ornare varius mi, sit amet faucibus erate.</p>
                                            </div>
                                            <div class="fitsc-tab">
                                                <h5><span>IN DETAILS RESEARCHES</span></h5>


                                                <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt. Cras congue posuer eros eget egestas. Aenean varius ex ut ex laoreet fermentum. Curabitur ornare varius mi, sit amet faucibus erate.</p>

                                            </div>
                                            <div class="fitsc-tab">
                                                <h5><span>WELL ORGANIZED WORKFLOWS</span></h5>


                                                <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt. Cras congue posuer eros eget egestas. Aenean varius ex ut ex laoreet fermentum. Curabitur ornare varius mi, sit amet faucibus erate.</p>

                                            </div>
                                            <div class="fitsc-tab">
                                                <h5><span>THE LATEST TECHNOLOGIES</span></h5>


                                                <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt. Cras congue posuer eros eget egestas. Aenean varius ex ut ex laoreet fermentum. Curabitur ornare varius mi, sit amet faucibus erate.</p>

                                            </div>
                                            <div class="fitsc-tab">
                                                <h5><span>FAST OPERATIONA</span></h5>


                                                <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt. Cras congue posuer eros eget egestas. Aenean varius ex ut ex laoreet fermentum. Curabitur ornare varius mi, sit amet faucibus erate.</p>

                                            </div>
                                            <div class="fitsc-tab">
                                                <h5><span>PROFESSIONAL SPECIALISTS</span></h5>


                                                <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt. Cras congue posuer eros eget egestas. Aenean varius ex ut ex laoreet fermentum. Curabitur ornare varius mi, sit amet faucibus erate.</p>

                                            </div>
                                            <div class="fitsc-tab">
                                                <h5><span>HIGH QUALITY RESULTS</span></h5>


                                                <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt. Cras congue posuer eros eget egestas. Aenean varius ex ut ex laoreet fermentum. Curabitur ornare varius mi, sit amet faucibus erate.</p>

                                            </div>
                                            <div class="fitsc-tab">
                                                <h5><span>AWESOME FRIENDLY SUPPORT</span></h5>


                                                <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt. Cras congue posuer eros eget egestas. Aenean varius ex ut ex laoreet fermentum. Curabitur ornare varius mi, sit amet faucibus erate.</p>

                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="fitsc-button fitsc-background-yellow">Get a Quote Now</a>
                                </div>
                            </div>
                        </div>
                      
                        
                        <div class="fitsc-row ">
                            <div class="row">
                                
                        
                        <div class="fitsc-row  row-background row-fluid" style="; background-image: url(images/work-pattern.png);">
                            <div class="row">
                                <div class="fitsc-space" style="height: 100px"></div>
                            </div>
                        </div>
                        <div class="fitsc-space" style="height: 90px"></div>
                        <h3 class="fitsc-heading fitsc-heading-underline fitsc-font-medium fitsc-align-center  clearfix"><span>WHAT WE OFFER</span></h3>
                        <p class="center_text">We Offer Our Customers the Best Services &amp; Solutions, This is Our Main Services List</p>
                        <div class="fitsc-tabs fitsc-horizontal">
                            <ul class="fitsc-nav">
                                <li class="fitsc-active"><a href="#">CONSTRUCTION</a></li>
                                <li><a href="#">RENOVATIONS</a></li>
                                <li><a href="#">CONSULTING</a></li>
                                <li><a href="#">CONSTRUCTOR</a></li>
                                <li><a href="#">ARCHITECTURE</a></li>
                                <li><a href="#">PLANNING</a></li>
                            </ul>
                            <div class="fitsc-content">
                                <div class="fitsc-tab fitsc-active">
                                    <p><img class="alignleft size-full wp-image-1953 hidden-xs hidden-sm special-image" style="margin-right: 30px;" src="images/banner.png" alt="banner" width="245" />
                                    </p>
                                    <h5>MAKING IT <span style="color: #eeb313;">POSSIBLE</span> FOR YOU</h5>
                                    <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt. Cras congue posuer eros eget egestas. Aenean varius ex ut ex laoreet fermentum. Curabitur ornare varius mi, sit amet faucibus erate. consectetur id. Aenean sit amet massa eu velit commodo cursus fringilla a tellus. Morbi eros urna, mollis porta feugiat non, ornare eu augue. Sed rhoncus est sit amet diam tempus, et tristique est viverra. Etiam ex tellus, sectur at dapibus id.</p>
                                    <p>
                                        <div class="fitsc-row hidden-md">
                                            <div class="row">
                                                <div class="fitsc-column fitsc-column-home_gutter col-md-3 col-xs-12 col-sm-4 col-md-no-gutter-left col-lg-no-gutter-left">
                                                    <h6><i class="fitsc-icon fa fa-check fitsc-color-yellow" ></i> INNOVATIVE IDEAS</h6>
                                                    <p>Proin sagittis feugiat elit finibus pretium Donec et tortor non purus vulputate tinci dunt Cras congue.</p>
                                                    <h6><i class="fitsc-icon fa fa-check fitsc-color-yellow"></i> THE LATEST TECHNOLOGIES</h6>
                                                    <p>Proin sagittis feugiat elit finibus pretium Donec et tortor non purus vulputate tinci dunt Cras congue.</p>
                                                </div>
												
                                                <div class="fitsc-column col-md-3 col-xs-12 col-sm-4">
                                                    <h6><i class="fitsc-icon fa fa-check fitsc-color-yellow"></i> IN DETAIL RESEARCHES</h6>
                                                    <p>Proin sagittis feugiat elit finibus pretium Donec et tortor non purus vulputate tinci dunt Cras congue.</p>
                                                    <h6><i class="fitsc-icon fa fa-check fitsc-color-yellow"></i> FAST OPERATIONS</h6>
                                                    <p>Proin sagittis feugiat elit finibus pretium Donec et tortor non purus vulputate tinci dunt Cras congue.</p>
                                                </div>
												
                                                <div class="fitsc-column col-md-3 col-xs-12 col-sm-4">
                                                    <h6><i class="fitsc-icon fa fa-check fitsc-color-yellow"></i> WELL ORGANIZED WORKFLOWS</h6>
                                                    <p>Proin sagittis feugiat elit finibus pretium Donec et tortor non purus vulputate tinci dunt Cras congue.</p>
                                                    <h6><i class="fitsc-icon fa fa-check fitsc-color-yellow"></i> PROFESSINAL SPECIALISTS</h6>
                                                    <p>Proin sagittis feugiat elit finibus pretium Donec et tortor non purus vulputate tinci dunt Cras congue.</p>

                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="fitsc-tab fitsc-tab-home">
                                    <h5>MAKING IT <span>POSSIBLE</span> FOR YOU</h5>
                                    <p>Proin sagittis feugiat elit.</p>
                                </div>
                                <div class="fitsc-tab">
                                    <h5>MAKING IT <span>POSSIBLE</span> FOR YOU</h5>
                                    <p>Proin sagittis feugiat elit .</p>
                                </div>
                                <div class="fitsc-tab">
                                    <h5>MAKING IT <span>POSSIBLE</span> FOR YOU</h5>
                                    <p>Proin sagittis feugiat elit finibus pretium.</p>
                                </div>
                                <div class="fitsc-tab">
                                    <h5>MAKING IT <span>POSSIBLE</span> FOR YOU</h5>
                                    <p>Proin sagittis feugiat elit finibus pretium.</p>
                                </div>
                                <div class="fitsc-tab">
                                    <h5>MAKING IT <span>POSSIBLE</span> FOR YOU</h5>
                                    <p>Proin sagittis feugiat elit finibus pretium. Donec et tortor non purus vulputate tincidunt.</p>
                                </div>
                            </div>
                        </div>
                       
                    </section>

                </div>
            </div>
        </main>
@endsection()   