<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@extends('layouts/frontend/main')
@section('content')
<div class="content-area">
    <!-- PAGE -->
    <section class="page-section no-padding slider">
        <div class="container full-width">
            <div class="main-slider">
                <div class="owl-carousel" id="main-slider">
                    <div class="item slide1 ver1">
                        <img class="slide-img home-img" src="/frontend/theme31/assets/img/img3.jpg" alt=""/>
                        <div class="caption">
                            <div class="container">
                                <div class="div-table">
                                    <div class="div-cell">
                                        <div class="caption-content">
                                            <h2 class="caption-title">Simplifying Business !</h2>
                                            <h3 class="caption-subtitle">BMS For Builders</h3>
                                            <img src="/frontend/theme31/assets/img/logo.png" class="home-logo center-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="item slide1 ver1">
                        <img class="slide-img home-img" src="/frontend/theme31/assets/img/img2.jpg" alt=""/>
                        <div class="caption">
                            <div class="container">
                                <div class="div-table">
                                    <div class="div-cell">
                                        <div class="caption-content">
                                            <h2 class="caption-title">Simplifying Business !</h2>
                                            <h3 class="caption-subtitle">BMS For Builders</h3>
                                            <img src="/frontend/theme31/assets/img/logo.png" class="home-logo center-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 wow flipInY" data-wow-offset="70" data-wow-duration="1s">
                    <div class="thumbnail thumbnail-featured no-border no-padding">
                        <div class="media">
                            <a class="media-link" href="about">
                                <div class="caption">
                                    <div class="caption-wrapper div-table">
                                        <div class="caption-inner div-cell">
                                            <div class="caption-icon"><i class="fa fa-support"></i></div>
                                            <h4 class="caption-title">What We Are</h4>
                                            <div class="caption-text">Duis bibendum diam non erat facilaisis tincidunt. Fusce leo neque,lacinia at tempor vitae, porta at arcu.</div>
                                            <div class="buttons">
                                                <span class="btn btn-theme ripple-effect btn-theme-transparent">Read More</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption hovered">
                                    <div class="caption-wrapper div-table">
                                        <div class="caption-inner div-cell">
                                            <div class="caption-icon"><i class="fa fa-support"></i></div>
                                            <h4 class="caption-title">What We Are</h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 wow flipInY" data-wow-offset="70" data-wow-duration="1s" data-wow-delay="200ms">
                    <div class="thumbnail thumbnail-featured no-border no-padding">
                        <div class="media">
                            <a class="media-link" href="projects">
                                <div class="caption">
                                    <div class="caption-wrapper div-table">
                                        <div class="caption-inner div-cell">
                                            <div class="caption-icon"><i class="fa fa-calendar"></i></div>
                                            <h4 class="caption-title">Our Projects</h4>
                                            <div class="caption-text">Buying a bigger home doesn’t necessarily mean spending more money.</div>
                                            <div class="buttons">
                                                <span class="btn btn-theme ripple-effect btn-theme-transparent">Read More</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption hovered">
                                    <div class="caption-wrapper div-table">
                                        <div class="caption-inner div-cell">
                                            <div class="caption-icon"><i class="fa fa-calendar"></i></div>
                                            <h4 class="caption-title">Our Projects</h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 wow flipInY" data-wow-offset="70" data-wow-duration="1s" data-wow-delay="400ms">
                    <div class="thumbnail thumbnail-featured no-border no-padding">
                        <div class="media">
                            <a class="media-link" href="contact">
                                <div class="caption">
                                    <div class="caption-wrapper div-table">
                                        <div class="caption-inner div-cell">
                                            <div class="caption-icon"><i class="fa fa-map-marker"></i></div>
                                            <h4 class="caption-title">Office Locations</h4>
                                            <div class="caption-text">Duis bibendum diam non erat facilaisis tincidunt. Fusce leo neque,lacinia at tempor vitae, porta at arcu.</div>
                                            <div class="buttons">
                                                <span class="btn btn-theme ripple-effect btn-theme-transparent">Read More</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption hovered">
                                    <div class="caption-wrapper div-table">
                                        <div class="caption-inner div-cell">
                                            <div class="caption-icon"><i class="fa fa-map-marker"></i></div>
                                            <h4 class="caption-title">Office Locations</h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section id="who-we-are" class="page-section dark">
        <div class="container">

            <div class="row">
                <div class="col-md-6 wow fadeInLeft" data-wow-offset="200" data-wow-delay="100ms">
                    <h2 class="section-title text-left">
                        <small>What Do You Know About Us</small>
                        <span>Who We Are ?</span>
                    </h2>
                    <p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit. </p>
                    <ul class="list-icons">
                        <li><i class="fa fa-check-circle"></i>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                        <li><i class="fa fa-check-circle"></i>Proin tempus sapien non iaculis pretium.</li>
                    </ul>
                    <p class="btn-row">
                        <a href="about" class="btn btn-theme ripple-effect btn-theme-md">See All About Us</a>
                        <a href="#" data-toggle="modal" data-target="#experience" class="btn btn-theme ripple-effect btn-theme-md btn-theme-transparent">Share Your Thoughts</a>
                    </p>
                </div>
                <div class="col-md-6 wow fadeInRight" data-wow-offset="200" data-wow-delay="300ms">
                    <div class="owl-carousel img-carousel">
                        <div class="item"><a href="/frontend/theme31/assets/img/preview/slider/slide-1.jpg" data-gal="prettyPhoto"><img class="img-responsive" src="/frontend/theme31/assets/img/preview/slider/slide-1.jpg" alt=""/></a></div>
                        <div class="item"><a href="/frontend/theme31/assets/img/preview/slider/slide-2.jpg" data-gal="prettyPhoto"><img class="img-responsive" src="/frontend/theme31/assets/img/preview/slider/slide-2.jpg" alt=""/></a></div>
                        <div class="item"><a href="/frontend/theme31/assets/img/preview/slider/slide-3.jpg" data-gal="prettyPhoto"><img class="img-responsive" src="/frontend/theme31/assets/img/preview/slider/slide-3.jpg" alt=""/></a></div>
                        <div class="item"><a href="/frontend/theme31/assets/img/preview/slider/slide-4.jpg" data-gal="prettyPhoto"><img class="img-responsive" src="/frontend/theme31/assets/img/preview/slider/slide-3.jpg" alt=""/></a></div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="page-section testimonials">
        <div class="container wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms">
            <div class="testimonials-carousel">
                <div class="owl-carousel" id="testimonials">
                    <?php for ($i = 0; $i < count($testimonials); $i++) { ?>

                        <div class="testimonial">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object testimonial-avatar" src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Testimonial/[[$testimonials[$i]->photo_url]]" alt="Testimonial avatar">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="testimonial-text">[[$testimonials[$i]->description]]</div>
                                    <div class="testimonial-name">[[$testimonials[$i]->customer_name]] <span class="testimonial-position">[[$testimonials[$i]->company_name]]</span></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <section id="our-cars" class="page-section">?>
        <div class="container">
            <h2 class="section-title wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms">
                <small>Select What You Want</small>
                <span>Our awesome Running Projects</span>
            </h2>
            <div class="tab-content wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms">
                <div class="tab-pane fade active in" id="tab-x2">
                    <div class="car-big-card">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="tabs awesome-sub">
                                    <ul id="tabs-x2" class="nav">
                                        <?php
                                        $i = 1;
                                        $j = 1;
                                        foreach ($current as $projects) {
                                            ?>
                                            <li class="<?php
                                        if ($i == 1) {
                                            echo 'active';
                                        }
                                            ?>"> <a href="#tab-<?php echo $j++; ?>" data-toggle="tab"><?php echo $projects->project_name; ?></a>
                                            </li>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content">
                                    <?php
                                    $i = 1;
                                    $j = 1;
                                    foreach ($current as $projects) {
                                        ?>
                                        <div class="tab-pane fade in <?php
                                    if ($i == 1) {
                                        echo 'active';
                                    }
                                        ?>" id="tab-<?php echo $j++; ?>">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="swiper-container" id="swiperSlider2x1">
                                                        <div class="swiper-wrapper">
                                                            <div class="swiper-slide"> 
                                                                <a class="btn btn-zoom" href="#" data-gal="prettyPhoto"><i class="fa fa-arrows-h"></i></a>

                                                                <?php if (!empty($projects->project_logo) && $projects->project_logo != null) { ?>
                                                                    <img class="img-responsive" src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/[[$projects->project_logo]]" alt=""/>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="car-details">
                                                        <div class="price">
                                                            <strong>AMINITIES</strong> <i class="fa fa-info-circle"></i>
                                                        </div>
                                                        <div class="list">
                                                            <ul>
                                                                <?php
                                                                // $project_info = Projects::model()->findByAttributes(array('project_status' => 'Current', 'portal_status' => '1'), array('order' => 'RAND()', 'limit' => 10));
//                                                                if (!empty($project_info->amenities_list)) {
//                                                                    
                                                                ?>
                                                                //<?php
//                                                                        $amenities = explode(',', $project_info->amenities_list);
//                                                                        foreach ($amenities as $data) {
//                                                                       
                                                                ?>
                                                                <li>//<?php //echo strip_tags($data);  ?>  </li>                                            
                                                                //<?php
//                                                                    }
//                                                                }
//                                                                if (empty($project_info->amenities_list)) {
//                                                                    
                                                                ?>
                                                                <li> Amenities List coming soon !!!</li>
                                                                //<?php
//                                                                }
                                                                ?> 
                                                            </ul>
                                                        </div>
                                                        <div class="button">
                                                            <a href="<?php //echo $this->getProjectsUrl($projects->id, $projects->seo_url, 'ongoing');  ?>" class="btn btn-theme ripple-effect btn-theme-dark btn-block">Rad more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="page-section no-padding no-bottom-space-off">
        <div class="container full-width">
            <div class="">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3782.204208294423!2d73.77941731478177!3d18.56483007266471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2becdc1d67b2b%3A0xd7eddb46e6814db5!2sedynamics+(H.O.+Pune)!5e0!3m2!1sen!2sin!4v1457762025461" width="100%" height="500px" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </section>
</div>

<script>
    window.onload = getProjects();
    function getProjects()
    {
        $.ajax({
            url: "/website/getCurrentProjectDetails",
            type: "GET",
            success: function (output) {

                console.log(output);
            }
        });
    }
</script>
@endsection();                    