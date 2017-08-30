@extends('layouts/frontend/Gagan/main')
@section('content')
<div ng-init="getAboutPageContent(); getEmployees();">
    <!-- end horizontal filter --> 
    <div class="innerBanner">
        <!--<img src="frontend/Gagan/img/about-banner.jpg" alt="" />-->
        <figure ng-repeat="banner in banner_images|orderBy:random  | limitTo:1 ">
            <img ng-src="[[config('global.s3Path')]]/website/banner-images/{{banner}}" alt="">
        </figure>
    </div>

    <!-- start big message -->

    <section class="bigMessage innerPage" >
        <div class="container">

            <div id="system-message-container">
            </div>
            <div class="pageData ">

                <h1>About Us</h1>
                <div class="content">
                    <p>{{aboutUs.page_content| htmlToPlaintext}}</p>
                </div>

            </div>

        </div>
    </section>
</div>
@endsection()