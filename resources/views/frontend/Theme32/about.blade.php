@extends('layouts/frontend/Theme32/main')
@section('content')
<!-- END HEADER -->
<!-- BEGIN MAIN CONTAINER -->
<main class="main-content" >

    <!-- start content -->
    <!-- start breadcrumbs.html-->
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/index">Home</a></li>
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
            <div class="col span_12">
                <figure ng-repeat="banner in banner_images |orderBy:random  | limitTo:1 ">
                    <img ng-src="[[config('global.s3Path')]]website/banner-images/{{banner}}" style="height:450px; width:100%;border-bottom-left-radius: 4pc;
                         border-top-right-radius: 4pc;" alt="">
                </figure>
            </div>
        </div>
        <header class="heading">
            <h2>Who we are</h2>
        </header>
        <div class="offset-bottom">
            <p>{{aboutUs.page_content| htmlToPlaintext}} </p>
        </div>
        <header class="heading">
            <h2>Our team</h2>
        </header>
        <div class="row offset-bottom">
            <div class="col span_3"  ng-repeat="emp in employee| limitTo:4">
                <div class="profile">
                    <div class="profile-photo" aria-haspopup="true">
                        <figure>
                            <img ng-if="emp.employee_photo_file_name" ng-src="[[config('global.s3Path')]]hr/employee-photos/{{emp.employee_photo_file_name}}" style="height:150px;width:250px;" class="center-block" alt="">
                        </figure>
                    </div>
                    <div class="profile-name">{{emp.first_name + " " + emp.last_name}}<small>{{emp.designation}}</small></div>
                </div>
            </div>

        </div>

    </div>


    <!-- end content -->

</main>
<!-- END MAIN CONTAINER -->
@endsection()   