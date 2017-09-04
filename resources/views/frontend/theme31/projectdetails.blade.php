@extends('layouts/frontend/theme31/main')
@section('content') 
<!-- CONTENT AREA -->
<div class="content-area" ng-controller="webAppController" ng-init="getProjectDetails('[[$projectId]]')">
    <!-- PAGE WITH SIDEBAR -->
    <section class="page-section with-sidebar sub-page">
        <div class="container">
            <div class="row">
                <!-- CONTENT -->
                <div class="col-md-9 content" id="content">

                    <h3 class="block-title alt">{{project_name}}</h3>
                    <div class="car-big-card alt">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
                                    <div class="overlay"></div>
                                    <ol class="carousel-indicators">
                                        <li data-target="#bs-carousel"  ng-repeat="banner in bannerImgs track by $index" ng-class="{'active':$first}" data-slide-to="{{$index}}" class="active"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div  ng-repeat="banner in bannerImgs track by $index" ng-class="{'active':$first}" class="item slides">
                                            <div class="slide-{{$index + 1}}" style="background-image: url([[config('global.s3Path')]]project/project_banner_images/{{banner}}"></div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="car-details">
                                    <div class="list">
                                        <ul>
                                            <li class="title">
                                                <h2>Available <span>AMENITIES</span></h2>
                                            </li>
                                            <li ng-repeat="aminity in aminities">{{aminity.name_of_amenity}}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="car-details">
                                    <div class="list">
                                        <ul>
                                            <li class="title">
                                                <h2>Available <span>Specification</span></h2>

                                            </li>
                                            <li>{{specification| htmlToPlaintext}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="page-divider half transparent"/>
                    <h3 class="block-title alt">Description</h3>
                    <div class="row">

                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <p>{{description| htmlToPlaintext}} </p>

                        </div>
                    </div>
                    <h3 class="block-title alt">Availability</h3>
                    <div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <!-- faq1 -->
                        <div class="panel panel-default" ng-repeat="avail in availble">
                            <div class="panel-heading" role="tab" ng-click="getSubBlock(avail.id, [[$projectId]])">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#{{avail.id}}" aria-expanded="false" aria-controls="collapse2">
                                        <span class="dot"></span>{{avail.block_name}}
                                    </a>
                                </h4>
                            </div>
                            <div id="{{avail.id}}"  class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                                <div class="panel-body row-centered">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-centered" ng-repeat="block in blockRow">
                                        <h4> {{block.block_sub_type}} </h4>
                                        <p>1 BHK flats with modern specifications , luxurious amenities and peaceful environment. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="block-title alt">Specification Images</h3>
                    <div class="row row-centered">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered"  ng-repeat="specification in specification_images track by $index">

                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='1'>
                                <img ng-src="[[config('global.s3Path')]]project/specification_images/{{specification.specification_images}}" class="proj-img" >
                            </a>	
                        </div>
                    </div>
                    <h3 class="block-title alt">Amenities Images</h3>
                    <div class="row row-centered" ng-repeat="amenities in amenities_images track by $index">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='1'>
                                <img ng-src="[[config('global.s3Path')]]project/amenities_images/{{amenities}}" class="proj-img" >
                            </a>	
                        </div>
                    </div>
                    <h3 class="block-title alt">Layout Plans</h3>
                    <div class="row row-centered">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered" ng-repeat="layout in layout_plan track by $index">

                            <a href='assets/img/img2.jpg' class='fancybox' data-fancybox-group='2'>
                                <img ng-src="[[config('global.s3Path')]]project/layout_plan_images/{{layout.layout_plan_images}}" class="proj-img" >
                            </a>	
                        </div>
                    </div>
                    <h3 class="block-title alt">Floor Plans</h3>
                    <div class="row row-centered">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered"  ng-repeat="floor in floor_plan track by $index">
                            <a href='assets/img/img2.jpg' class='fancybox' data-fancybox-group='2'>
                                <img ng-src="[[config('global.s3Path')]]project/floor_plan_images/{{floor.floor_plan_images}}" class="proj-img" >
                            </a>	
                        </div>
                    </div>
                    <h3 class="block-title alt">Gallery</h3>
                    <div class="row row-centered">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered" ng-repeat="gallery in gallery track by $index">
                            <a href='assets/img/img2.jpg' class='fancybox' data-fancybox-group='2'>
                                <img ng-src="[[config('global.s3Path')]]project/project_gallery/{{gallery}}" class="proj-img" >
                            </a>	
                        </div>
                    </div>	
                </div>
                <aside class="col-md-3 sidebar" id="sidebar">
                    <div class="widget shadow widget-details-reservation">
                        <h4 class="widget-title">Project Logo </h4>
                        <div class="widget-content" >
                            <img ng-src="[[config('global.s3Path')]]project/project_logo/{{project_logo}}" class="proj-img">
                        </div>
                    </div>
                    <div class="widget shadow widget-details-reservation">
                        <h4 class="widget-title">Project Address </h4>
                        <div class="widget-content">
                            <h5 class="widget-title-sub">Location</h5>

                            <div class="media">
                                <span class="media-object pull-left"><i class="fa fa-location-arrow"></i></span>
                                <div class="media-body"><p>{{project_address}}</p></div>
                            </div>

                            <div class="media">
                                <span class="media-object pull-left"><i class="fa fa-phone"></i></span>
                                <div class="media-body"><p>{{project_contact_numbers}}</p></div>
                            </div>
                            <div class="media">
                                <span class="media-object pull-left"><i class="fa fa-envelope-o"></i></span>
                                <div class="media-body"><p>{{email_sending_id}}</p></div>
                            </div>

                        </div>
                    </div>
                    <div class="widget shadow">
                        <div class="widget-title">Other projects</div>
                        <div class="testimonials-carousel" style="height:100px;" >
                            <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel1">
                                <div class="overlay"></div>
                                <ol class="carousel-indicators">
                                    <li data-target="#bs-carousel1"  ng-repeat="banner in projects track by $index" ng-class="{'active':$first}" data-slide-to="{{$index}}" class="active"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div  ng-repeat="banner in projects track by $index" ng-class="{'active':$first}" class="item slides">
                                        <h3 style="position:absolute; padding:90% 0 0 30%"><b>{{banner.project_name}}</b></h3>
                                        <div class="slide-{{$index + 1}}" style="background-image: url([[config('global.s3Path')]]project/project_logo/{{banner.project_logo}}"></div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="widget shadow widget-helping-center" style="margin-top:300px;">
                        <h4 class="widget-title">Helping Center</h4>
                        <div class="widget-content">
                            <p>Vivamus eget nibh. Etiam cursus leo vel metus. Nulla facilisi. Aenean nec eros.</p>
                            <h5 class="widget-title-sub">+90 555 444 66 33</h5>
                            <p><a href="mailto:support@supportcenter.com">support@supportcenter.com</a></p>
                            <div class="button">
                                <a href="[[config('global.s3Path')]]project_broacher/{{project_broacher}}" target="_blank" class="btn btn-block btn-theme btn-theme-dark">Download Brochure</a>
                            </div>
                        </div>
                    </div>
                    <div class="widget shadow widget-helping-center">
                        <h4 class="widget-title">Location Map</h4>
                        <div class="widget-content">
                            <a href='assets/img/location-map.jpg' class='fancybox' data-fancybox-group='Loc'>
                                <img ng-src="[[config('global.s3Path')]]project/location_map_images/{{location_map_images}}" class="proj-img" >
                            </a>
                        </div>
                    </div>
                    <div class="widget shadow widget-helping-center">
                        <h4 class="widget-title">Google Map</h4>
                        <div class="widget-content">
                            <iframe  width="100%" ng-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3782.204208294423!2d73.77941731478177!3d18.56483007266471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2becdc1d67b2b%3A0xd7eddb46e6814db5!2sedynamics+(H.O.+Pune)!5e0!3m2!1sen!2sin!4v1457762025461" height="250px" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>


</div>
@endsection()                    