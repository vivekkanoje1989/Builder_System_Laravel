@extends('layouts/frontend/Theme32/main')
@section('content')
<!-- END HEADER -->
<!-- BEGIN MAIN CONTAINER -->
<main class="main-content" ng-controller="webAppController" >

    <!-- start content -->
    <!-- start breadcrumbs.html-->
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><span>About</span></li>
            </ul>
        </div>
    </div>

    <!-- end breadcrumbs.html-->

    <div class="container" ng-init="getAboutPageContent(); getEmployees();">

        <header class="heading page-heading">
            <h1>About Us</h1>
        </header>

        <div class="row offset-bottom">
             <article class="post-wrap">
                <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
                        <div class="overlay"></div>
                        <ol class="carousel-indicators">
                            <li data-target="#bs-carousel"  ng-repeat="banner in banner_images track by $index" ng-class="{'active':$first}" data-slide-to="{{$index}}" class="active"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div  ng-repeat="banner in banner_images track by $index" ng-class="{'active':$first}" class="item slides">
                                <div class="slide-{{$index+1}}" style="background-image: url(https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/website/banner-images/{{banner}}"></div>
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

        <header class="heading">
            <h2>Who we are</h2>
        </header>

        <div class="offset-bottom">
            <p>In non-Euclidean geometry, squares are more generally polygons with 4 equal sides and equal angles.In spherical geometry, a square is a polygon whose edges are great circle arcs of equal distance, which meet at equal angles. Unlike the square of plane geometry, the angles of such a square are larger than a right angle. Larger spherical squares have larger angles. In hyperbolic geometry, squares with right angles do not exist. Rather, squares in hyperbolic geometry have angles of less than right angles. Larger hyperbolic squares have smaller angles. Squares can tile the hyperbolic plane with 5 around each vertex, with each square having 72-degree internal angles. Six squares can tile the sphere with 3 squares around each vertex and 120-degree internal angles. This is called a spherical cube.</p>
        </div>

        <header class="heading">
            <h2>Our team</h2>
        </header>

        <div class="row offset-bottom">
            <div class="col span_3">
                <div class="profile">
                    <div class="profile-photo" aria-haspopup="true">
                        <figure>
                            <img src="img/testimonial2.jpg" style="height:150px;width:150px;" class="center-block" alt="">
                        </figure>
                    </div>
                    <div class="profile-name">Ramdas Raut <small>Support Engineer</small></div>
                </div>
            </div>
            <div class="col span_3">
                <div class="profile">
                    <div class="profile-photo" aria-haspopup="true">
                        <figure>
                            <img src="img/testimonial1.jpg" style="height:150px;width:150px;margin:0 auto" class="center-block" alt="">
                        </figure>
                    </div>
                    <div class="profile-name">Ramdas Raut <small>Support Engineer</small></div>
                </div>
            </div>
            <div class="col span_3">
                <div class="profile">
                    <div class="profile-photo" aria-haspopup="true">
                        <figure>
                            <img src="img/testimonial2.jpg" style="height:150px;width:150px;margin:0 auto" class="center-block" alt="">
                        </figure>
                    </div>
                    <div class="profile-name">Ramdas Raut <small>Support Engineer</small></div>
                </div>
            </div>
            <div class="col span_3">
                <div class="profile">
                    <div class="profile-photo" aria-haspopup="true">
                        <figure>
                            <img src="img/testimonial3.png" style="height:150px;width:150px;margin:0 auto" class="center-block" alt="">
                        </figure>
                    </div>
                    <div class="profile-name">Ramdas Raut <small>Support Engineer</small></div>
                </div>
            </div>
        </div>

    </div>


    <!-- end content -->

</main>
<!-- END MAIN CONTAINER -->
@endsection()   