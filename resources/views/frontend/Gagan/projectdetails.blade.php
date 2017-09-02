@extends('layouts/frontend/Gagan/main')
@section('content')
<main class="main-content" ng-init="getProjectDetails('[[$projectId]]')"  style="margin-top:165px">

    <div class="container">
        <article class="post project offset-bottom">
            <header class="heading page-heading">
                <h2>{{project_name}}</h2>
            </header>
            <div class="row">
                <div class="col-md-8 span_8">
                    <div class="slideshow-main owl-carousel" data-slideshow-options='{"autoPlay":5000,"stopOnHover":true,"transitionStyle":"fade"}'>
                        <?php $background = explode(',', $bannerImg); ?>
                        @foreach($background as $img) 
                        <div class="slideshow-main-item" style="background-image:url([[config('global.s3Path')]]/project/project_banner_images/[[$img]]);">                         
                        </div>
                        @endforeach
                    </div>
                    <div class="entry-content">
                        <p>{{description| htmlToPlaintext}} </p>   
                    </div>
                </div>
                <div class="col-md-4 span_4">
                    <aside class="secondary-aside">
                        <div class="widget">
                            <h3>Project Details</h3>
                            <div class="entry-meta">
                                <center>
                                    <img ng-src="[[config('global.s3Path')]]/project/project_logo/{{project_logo}}" class="proj-img">
                                    <center>
                                        </div>
                                        </div>
                                        <div class="widget">
                                            <h3>More Links</h3>
                                            <div class="filter thumbs-filter" id="current">
                                                <ul>
                                                    <a href="[[config('global.s3Path')]]/project_broacher/{{project_broacher}}" target="_blank"> 
                                                        <li class="active" data-group="all"><span>Download Broucher</span></li>
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                        </aside>
                                        </div>
                                        </div>
                                        </article>
                                        <div class="row">
                                            <div class="col-md-12 span_12">
                                                <section id="availability" class="offset-bottom" ng-if="projects"  >
                                                    <header class="heading">
                                                        <h2>Available Projects</h2>
                                                    </header>
                                                    <div class="row" style="border:2px solid #ccc; padding:10px; margin-top:40px;">
                                                        <div class="col-md-4 span_4" ng-repeat="project in projects track by $index" >
                                                            <h3>{{project.project_name}}</h3>
                                                            <img ng-src="[[config('global.s3Path')]]/project/project_logo/{{project.project_logo}}" class="proj-img">
                                                            <ul>
                                                                <li style="text-align: justify;">{{project.brief_description| htmlToPlaintext}}</li>
                                                            </ul>
                                                            <!--<p><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/enquiry/{{project.id}}" class="enq-btn btn btn-small">Enquire Now</a></p>-->
                                                        </div>
                                                    </div>
                                                </section>

                                                <section id="amenities" class="offset-bottom" ng-if="aminities">
                                                    <header class="heading">
                                                        <h2>Amenities List</h2>
                                                    </header>
                                                    <div class="row">
                                                        <div class="col span_12">
                                                            <ul>
                                                                <li ng-repeat="amenity in aminities">{{amenity.name_of_amenity}} </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section id="spec" class="offset-bottom" ng-if="specification">
                                                    <header class="heading">
                                                        <h2>Specification List</h2>
                                                    </header>
                                                    <div class="row">
                                                        <div class="col span_12">
                                                            <p>{{specification| htmlToPlaintext}}</p>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section id="gallery" class="offset-bottom" ng-if="amenities_images">
                                                    <header class="heading">
                                                        <h2>Amenity Images</h2>
                                                    </header>
                                                    <div class="row" style="border:2px solid #ccc; padding:10px;margin-bottom:20px">
                                                        <div class="col-md-3 span_12" ng-repeat="amenities in amenities_images track by $index">
                                                            <p align="center">
                                                                <a class="fancybox"  href="[[config('global.s3Path')]]/project/amenities_images/{{amenities}}" data-fancybox-group="1" title="PROJECT 11">
                                                                    <img ng-src="[[config('global.s3Path')]]/project/amenities_images/{{amenities}}" alt="" /></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section id="gallery" class="offset-bottom" ng-if="specification_images">
                                                    <header class="heading">
                                                        <h2>Specification Images</h2>
                                                    </header>
                                                    <div class="row" style="border:2px solid #ccc; padding:10px;margin-bottom:20px">
                                                        <div class="col-md-3 span_12" ng-repeat="specification in specification_images track by $index">
                                                            <p align="center">
                                                                <a class="fancybox"  href="[[config('global.s3Path')]]/project/specification_images/{{specification}}" alt="" />
                                                                <img ng-src="[[config('global.s3Path')]]/project/specification_images/{{specification.specification_images}}" alt="" /></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section id="gallery" class="offset-bottom" ng-if="layout_plan">
                                                    <header class="heading">
                                                        <h2>Layout Plan</h2>
                                                    </header>
                                                    <div class="row" style="border:2px solid #ccc; padding:10px;margin-bottom:20px">
                                                        <div class="col-md-3 span_12" ng-repeat="layout in layout_plan track by $index">
                                                            <p align="center">
                                                                <a class="fancybox"  href="[[config('global.s3Path')]]/project/layout_plan_images/{{layout.layout_plan_images}}" data-fancybox-group="1" title="PROJECT 11"><img ng-src="[[config('global.s3Path')]]/project/layout_plan_images/{{layout.layout_plan_images}}" alt="" /></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section id="gallery" class="offset-bottom" ng-if="gallery">
                                                    <header class="heading">
                                                        <h2>Floor Plan</h2>
                                                    </header>
                                                    <div class="row" style="border:2px solid #ccc; padding:10px;margin-bottom:20px">
                                                        <div class="col-md-3 span_12 " ng-repeat="gallery in gallery track by $index">
                                                            <p align="center">
                                                                <a class="fancybox"  href="[[config('global.s3Path')]]/project/project_gallery/{{gallery}}" data-fancybox-group="1" title="PROJECT 11"><img ng-src="[[config('global.s3Path')]]/project/project_gallery/{{gallery}}" alt="" /></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section id="gallery" class="offset-bottom">
                                                    <header class="heading">
                                                        <h2>Gallery</h2>
                                                    </header>
                                                    <div class="row" style="border:2px solid #ccc; padding:10px; margin-bottom:20px">
                                                        <div class="col-md-3 span_12" ng-repeat="gallery in gallery track by $index">
                                                            <p align="center">
                                                                <a class="fancybox"  href="[[config('global.s3Path')]]/project/project_gallery/{{gallery}}" data-fancybox-group="1" title="PROJECT 11"><img ng-src="[[config('global.s3Path')]]/project/project_gallery/{{gallery}}" alt="" /></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        </div>
                                        </main>
                                        @endsection()  