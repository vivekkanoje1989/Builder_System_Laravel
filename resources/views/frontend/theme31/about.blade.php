@extends('layouts/frontend/theme31/main')
@section('content')
<div class="wrapper">
    <div class="content-area" ng-init="getAboutPageContent(); getEmployees();">
        <div class="container">
            <article class="post-wrap">
                <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
                        <div class="overlay"></div>
                        <ol class="carousel-indicators">
                            <li data-target="#bs-carousel"  ng-repeat="banner in banner_images track by $index" ng-class="{'active':$first}" data-slide-to="{{$index}}" class="active"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div  ng-repeat="banner in banner_images track by $index" ng-class="{'active':$first}" class="item slides">
                                <div class="slide-{{$index+1}}" style="background-image: url([[config('global.s3Path')]]website/banner-images/{{banner}}"></div>
                            </div>
                        </div> 
                    </div>
                <div class="post-header">
                    <h2 class="post-title"><a href="#">What We Are</a></h2>
                </div>
                <div class="post-body">
                    <div class="post-excerpt">
                        <p>{{aboutUs.page_content| htmlToPlaintext}} </p>
                    </div>
                </div>

            </article>

        </div>



        <section id="help-desk" class="page-section image">
            <div class="container">

                <h2 class="section-title wow fadeInDown" data-wow-offset="200" data-wow-delay="100ms">
                    <small>Do You Have Any Question or Anything else </small>
                    <span>Our Team</span>
                </h2>

                <!-- Team row -->
                <div class="row row-centered">
                    <!-- Team-->
                    <div class="col-md-3 col-sm-6 wow fadeInDown col-centered"  ng-repeat="emp in employee | limitTo:3" data-wow-offset="200" data-wow-delay="400ms"  align="center">
                        <div class="thumbnail thumbnail-team no-border no-padding">
                            <div class="">
                                <img src="[[config('global.s3Path')]]hr/employee-photos/{{emp.employee_photo_file_name}}" alt="" class="team-img center-block">
                            </div>
                            <div class="caption">
                                <h4 class="caption-title">{{emp.first_name+" "+emp.last_name}} <small>{{emp.designation}}</small></h4>
                                <ul class="team-details">
                                    <li><a href="{{emp.personal_email1}}">{{emp.personal_email1}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
        </section>
    </div>
    <div id="to-top" class="to-top"><i class="fa fa-angle-up"></i></div>

    @endsection()