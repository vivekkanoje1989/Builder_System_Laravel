@extends('layouts/frontend/Theme39/main')
@section('content')

<main id="main" class="main index-main_ clearfix" role="main" ng-controller="webAppController">
    <div class="container" ng-init=" getAboutPageContent(); getEmployees();">
        <div class="row">
            <section id="content" class="site-content hfeed site-content col-xs-12 col-sm-12 col-md-12" role="main">
                <div class="fitsc-row hidden-xs row-fluid row-fluid-content">
                    <div class="row">
                        <div class="fitsc-column col-md-12 col-sm-12 col-xs-12">
                            <div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="classicslider1" style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
                                <!-- START REVOLUTION SLIDER 5.0.7 auto mode -->
                                <div id="rev_slider_4_1" class="rev_slider fullwidthabanner" data-version="5.0.7">
                                    <?php
                                    $allimages = @explode(',', $background->banner_images);
                                    if (isset($allimages)) {
                                        ?>	
                                        <ul>	<!-- SLIDE  -->
                                            <?php
                                            foreach ($allimages as $img) {
                                                ?>		
                                                <li data-index="rs-18" data-transition="zoomin" data-slotamount="7"  data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="2000"  data-thumb=""  data-rotate="0"  data-saveperformance="off"  data-title="Ken Burns" data-description="">
                                                    <!-- MAIN IMAGE -->
                                                    <img src="<?php echo "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/website/banner-images/" . $img; ?>"  alt=""  data-bgposition="center center" data-kenburns="on" data-duration="30000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="120" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                                                    <!-- LAYERS -->

                                                    <!-- LAYER NR. 1 -->
                                                    <div class="tp-caption Fashion-BigDisplay   tp-resizeme rs-parallaxlevel-0" id="slide-6-layer-1" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['-60','-60','-60','-60']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:-50px;opacity:0;s:300;e:Power0.easeIn;" data-transform_out="opacity:0;s:300;s:300;" data-start="500" data-splitin="chars" data-splitout="none" data-responsive_offset="on" data-elementdelay="0.05" style="z-index: 5; white-space: nowrap; color: rgba(238, 179, 19, 1.00);font-family:Ubuntu;"><?php //echo substr(COMPANY_NAME, 0, 35);     ?>
                                                    </div>

                                                    <!-- LAYER NR. 2 -->
                                                    <div class="tp-caption Fashion-TextBlock   tp-resizeme rs-parallaxlevel-0" id="slide-6-layer-2" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:50px;opacity:0;s:900;e:Power2.easeInOut;" data-transform_out="y:50px;opacity:0;s:300;s:300;" data-start="500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap; font-size: 16px; color: rgba(255, 255, 255, 1.00);font-family:Ubuntu;"><?php //echo substr(PUNCH_LINE, 0, 50);     ?>
                                                    </div> 


                                                    <!-- LAYER NR. 3 -->
                                                    <div class="tp-caption rev-btn  rs-parallaxlevel-0" id="slide-6-layer-3" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['60','60','60','60']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:0;e:Linear.easeNone;" data-style_hover="c:rgba(255, 255, 255, 1.00);bg:rgba(238, 179, 19, 1.00);bc:rgba(238, 179, 19, 1.00);cursor:pointer;" data-transform_in="y:50px;opacity:0;s:1200;e:Power2.easeInOut;" data-transform_out="y:50px;opacity:0;s:300;s:300;" data-start="500" data-splitin="none" data-splitout="none" data-responsive_offset="on" data-responsive="off" style="z-index: 7; white-space: nowrap; font-size: 16px; line-height: 18px; font-weight: 500; color: rgba(255, 255, 255, 1.00);font-family:Ubuntu;background-color:rgba(0, 0, 0, 0);padding:12px 35px 12px 35px;border-color:rgba(255, 255, 255, 1.00);border-style:solid;border-width:1px;border-radius:3px 3px 3px 3px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">Sketching Your Ideas & Building Your Future
                                                    </div>
                                                </li>
                                                <!-- SLIDE  -->
                                            <?php } ?>			
                                        </ul>
                                    <?php } ?>				
                                    <div class="tp-static-layers"></div>
                                    <div class="tp-bannertimer" style="height: 7px; background-color: rgba(255, 255, 255, 0.25);"></div>	
                                </div>
                            </div><!-- END REVOLUTION SLIDER -->
                        </div>
                    </div>
                </div>
                <div class="fitsc-row  row-background row-fluid row-no-gutter row-parallax overlay-enabled primary-color" 
                     style="; background-image: url(/frontend/Theme39/images/bg-for-parallax.jpg);">
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
                <div class="fitsc-row ">
                    <div class="row">
                        <div class="fitsc-space" style="height: 100px"></div>
                        <div class="fitsc-column col-md-12 col-sm-12 col-xs-12">
                             <h3 class="fitsc-heading fitsc-heading-underline fitsc-font-medium fitsc-align-center  clearfix"><span>ABOUT US</span></h3>
                            <p>{{aboutUs.page_content| htmlToPlaintext | limitTo:400}} {{aboutUs.page_content.length >400 ? '...' : ''}} </p>
                            <a href="about" class="fitsc-button ghost">Read More</a> <a href="projects.html" class="fitsc-button ghost">Projects</a>
                       
                        <br/>
                    </div>
                </div>
         

                <div class="fitsc-space" style="height: 90px"></div>
                <div class=""> 
                    <h3 class="fitsc-heading fitsc-heading-underline fitsc-font-medium fitsc-align-center  clearfix"><span>OUR CURRENT PROJECTS</span></h3>
                    <p class="center_text">We’re Currently Working on Some Big Projects, Our Specialists Are Trying Their Bests to Complete Them ASAP.</p>
                    <div class="fitsc-space"></div>
                    <?php if (!empty($current)) { ?>       
                        <div class="fitsc-projects fitsc-projects-under_construction row">
                            <?php
                            foreach ($current as $projects) {



                                //if (!empty($projects->thumbnail))
                                //  $image_url = $this->image_path . 'Projects/projectImages/thumbs/' . $projects->thumbnail;
                                ?> 

                                <div class="project col-md-6 col-sm-6 col-xs-12">
                                    <div class="project">
                                        <div class="project-info">
                                            <h3 class="project-name"><a href="<?php // echo Yii::app()->getBaseUrl(true) . '/index.php/site/projectdetails/' . $projects->id;  ?>" rel="bookmark"><strong><?php
                                                        echo ucwords(substr($projects['project_name'], 0, 12));
                                                        if (strlen($projects['project_name'] > 12)) {
                                                            echo '...';
                                                        }
                                                        ?></strong></a></h3>
                                            <div class="project-desc">
                                                <p><?php
                                                    //echo substr($projects['short_description'], 0, 50);
                                                    //if (strlen($projects->short_description) > 30) {
                                                    //      echo '...';
                                                    // }
                                                    ?> <a href="<?php echo "project-details/" . $projects['id']; ?>" class="more-link" title="Continue reading &quot;Elegant Bridge&quot;">Read More</a>
                                                </p>
                                            </div>

                                            
                                        </div>
                                        <div class="project-thumbnails">
                                            <div id="project-gallery-1939" class="carousel slide" data-ride="carousel" data-interval="false">

                                                <div class="carousel-inner">
                                                    <div class="item active"><img src="<?php echo "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/" . $projects['project_logo']; ?>" alt="gallery">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>


                        </div>
                    <?php } ?>
                </div>

                <div class="fitsc-space" style="height: 90px"></div>
                <div class="fitsc-row fitsc-row-custom-space  row-background row-fluid">
                    <div class="row">
                        <div class="fitsc-space"></div>
                    </div>
                </div>
                <div class="fitsc-space" style="height: 90px"></div>
                <h3 class="fitsc-heading fitsc-heading-underline fitsc-font-medium fitsc-align-center  clearfix"><span>TEAM MEMBERS</span></h3>
                <p class="center_text">We&#8217;re Some Creative People with Powerful Knowledge &amp; Skills Behind the Scene Bringing You the Bests</p>
                <div class="fitsc-space"></div>
                <div class="fitsc-team">
                    <div class="team-members" data-items="4">

                        <?php foreach ($employee as $team) {
                            ?>	
                            <div class="team-member clearfix">
                                <?php
                                if (!empty($team->emp_photo))
                                    
                                    ?>
                                <img  src="<?php //echo //$image_av;     ?>" class="attachment-member-thumbnail" alt="04" />
                                <div class="member-bio">
                                    <p><a href="mailto:<?php echo $team->personal_email1; ?>"><?php //$team->personal_email1;       ?></a>&hellip;</p>
                                </div>
                                <div class="member-info">
                                    <h5 class="name"><?php echo $team->first_name . " " . $team->last_name; ?></h5>
                                    <span class="position"><?php echo $team->designation; ?></span>
                                </div>
                                <ul class="social-icons">
                                    <li><a href="#" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#" rel="nofollow" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        <?php } ?>  



                    </div>
                </div>
                <div class="fitsc-space" style="height: 90px"></div>
                <div class="fitsc-row  row-background row-fluid" style="; background-image: url(/frontend/Theme39/images/work-pattern.png);">
                    <div class="row">
                        <div class="fitsc-row  row-background row-background-custom row-fluid row-parallax overlay-enabled primary-color pattern">
                            <div class="overlay"></div>
                            <div class="row">
                                <div class="fitsc-column col-md-12 col-sm-12 col-xs-12">
                                    <div class="fitsc-space" style="height: 60px"></div>
                                    <div class="fitsc-testimonials">

                                        <?php
                                        for ($i = 0; $i < count($testimonials); $i++) {

                                            if ($i == 0) {
                                                ?>
                                                <div class="item active">
                                                <?php } else { ?>
                                                    <div class="item"> 
                                                    <?php } ?>   
                                                    <div class="testinonial-avatar">
                                                        <div class="wrap-avatar"><img src="/frontend/Theme39/images/avatar/014.jpg" alt="Ernest Rodgers"></div>
                                                    </div>
                                                    <div class="testimonial-des">
                                                        <span class="name-author"><i class="fa fa-quote-left"></i>[[ ucwords($testimonials[$i]->customer_name) ]]</span>
                                                        <span class="regency-author">( [[ ucwords($testimonials[$i]->company_name) ]] )</span>
                                                    </div>
                                                    <div class="testimonial-text">[[ucwords($testimonials[$i]->description)]].</div>
                                                </div>  <?php } ?>

                                        </div>
                                        <div class="fitsc-space" style="height: 60px"></div>
                                    </div>
                                    <div class="fitsc-space" style="height: 60px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</main>
@endsection()    