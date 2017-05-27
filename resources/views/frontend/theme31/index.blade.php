@extends('layouts/frontend/theme31/main')
@section('content')

<style>
    .swiper-slid {
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -ms-transform-style: preserve-3d;
    /* transform-style: preserve-3d; */
    /* -webkit-flex-shrink: 0; */
    -ms-flex: 0 0 auto;
    /* flex-shrink: 0; */
    /* width: 100%; */
    /* height: 100%; */
    /* position: relative; */
}
</style>
<div class="content-area" >
    <section class="page-section no-padding slider" ng-init="getBackGroundImages(); getProjects(); getAboutPageContent();">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" ng-repeat="img in backgroundImages track by $index" data-slide-to="{{$index}}" ng-class="{'active':$first}"  ></li>
            </ol>
            <div class="carousel-inner">
                <div class="item" ng-class='{active:$first}'  ng-repeat="img in backgroundImages track by $index">
                    <img ng-src="[[config('global.s3Path')]]website/banner-images/{{img}}" alt="{{img}}" style="width:100%;">
                </div>
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
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
                    <p>{{aboutUs.page_content| htmlToPlaintext | limitTo: 200}} {{aboutUs.page_content.length > 20 ? '...' : ''}} </p>
                    
                    <p class="btn-row">
                        <a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/about" class="btn btn-theme ripple-effect btn-theme-md">See All About Us</a>
                        <a href="#" data-toggle="modal" data-target="#experience" class="btn btn-theme ripple-effect btn-theme-md btn-theme-transparent">Share Your Thoughts</a>
                    </p>
                </div>
                <div class="col-md-6 wow fadeInRight" data-wow-offset="200" data-wow-delay="300ms">
                    <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
                        <div class="overlay"></div>
                        <ol class="carousel-indicators">
                            <li data-target="#bs-carousel"  ng-repeat="banner in banner_images track by $index" ng-class="{'active':$first}" data-slide-to="{{$index}}" class="active"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div  ng-repeat="banner in banner_images track by $index" ng-class="{'active':$first}" class="item slides">
                                <div class="slide-{{$index + 1}}" style="background-image: url([[config('global.s3Path')]]website/banner-images/{{banner}}"></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="page-section testimonials">
        <div class="container wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms">
            <div class="testimonials-carousel">
                <div class="owl-carousel" id="testimonials">
                    @for($i = 0; $i < count($testimonials); $i++)

                        <div class="testimonial">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object testimonial-avatar" ng-src="[[config('global.s3Path')]]Testimonial/[[$testimonials[$i]->photo_url]]" alt="Testimonial avatar">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="testimonial-text">[[$testimonials[$i]->description]]</div>
                                    <div class="testimonial-name">[[$testimonials[$i]->customer_name]] <span class="testimonial-position">[[$testimonials[$i]->company_name]]</span></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>
    <section id="our-cars" class="page-section">
        <div class="container">

            <h2 class="section-title wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms">
                <small>Select What You Want</small>
                <span>Our awesome Running Projects</span>
            </h2>
            <div class="tab-content wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms">

                <!-- tab -->
                <div class="tab-pane fade active in" id="tab-x2">

                    <div class="car-big-card">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="tabs awesome-sub">
                                    <ul id="tabs-x2" class="nav" >
                                        <li  ng-repeat="current in current"  ng-class="{'active':$first}" ><a href="#tab-{{current.id}}" data-toggle="tab">{{current.project_name}}</a></li> 
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content" >
                                    <div ng-repeat="current in current" class="tab-pane fade in"  id="tab-{{current.id}}"  ng-class="{'active':$first}">
                                        {{current.project_aminities}}
                                        <div class="col-md-8">
                                            <div class="swiper-container" id="swiperSlider2x1">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slid" style="width:100% !important;" >
                                                        <a class="btn btn-zoom" href="[[config('global.s3Path')]]project/project_logo/{{current.project_logo}}" data-gal="prettyPhoto"><i class="fa fa-arrows-h"></i></a>
                                                        <a href="[[config('global.s3Path')]]project/project_logo/{{current.project_logo}}" data-gal="prettyPhoto"><img class="img-responsive" style="height: auto; width: 100%;" ng-src="[[config('global.s3Path')]]project/project_logo/{{current.project_logo}}" alt=""/></a>
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
                                                        <li  ng-repeat="amenity in current.amenities">{{amenity.name_of_amenity}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <!-- /Sub tabs content -->

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

@endsection()                    