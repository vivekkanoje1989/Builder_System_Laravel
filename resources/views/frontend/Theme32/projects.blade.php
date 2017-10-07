@extends('layouts/frontend/Theme32/main')
@section('content')
<!-- END HEADER -->

<!-- BEGIN MAIN CONTAINER -->
<main class="main-content"  ng-init="getProjectsAllProjects()">

    <!-- start content -->
    <!-- start breadcrumbs.html-->
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/index">Home</a></li>
                <li><span>All Projects</span></li>
            </ul>
        </div>
    </div>

    <!-- end breadcrumbs.html-->

    <div class="container">

        <header class="heading page-heading">
            <h1>All Projects</h1>
        </header>

        <div class="filter thumbs-filter" id="current">
            <ul>
                <li class="active" data-group="all"><span>Current Project</span></li>
            </ul>
        </div>
        <div class="thumbs offset-bottom">
            <div class="thumbs-item " ng-repeat="currentProject in current">
                <a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/project-details/{{currentProject.id}}">
                    <header class="thumbs-item-heading">
                        <h3>{{currentProject.project_name}}</h3>
                         <p>{{currentProject.short_description | htmlToPlaintext}} </p>
                    </header>
                    <img ng-src="[[config('global.s3Path')]]project/project_logo/{{currentProject.project_logo}}" alt="">
                </a>
            </div>
            <div class="thumbs-sizer"></div>
        </div>

        <div class="filter thumbs-filter" id="upcoming">
            <ul>
                <li class="active" data-group="all"><span>Upcoming Project</span></li>
            </ul>
        </div>

         <div class="thumbs offset-bottom">
            <div class="thumbs-item " ng-repeat="currentProject in upcoming">
                <a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/project-details/{{currentProject.id}}">
                    <header class="thumbs-item-heading">
                        <h3>{{currentProject.project_name}}</h3>
                        <p>{{currentProject.short_description | htmlToPlaintext}} </p>
                    </header>
                    <img ng-src="[[config('global.s3Path')]]project/project_logo/{{currentProject.project_logo}}" alt="">
                </a>
            </div>
            <div class="thumbs-sizer"></div>
        </div>

        <div class="filter thumbs-filter" id="completed">
            <ul>
                <li class="active" data-group="all"><span>Completed Project</span></li>
            </ul>
        </div>

         <div class="thumbs offset-bottom">
            <div class="thumbs-item " ng-repeat="currentProject in completed">
                <a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/project-details/{{currentProject.id}}">
                    <header class="thumbs-item-heading">
                        <h3>{{currentProject.project_name}}</h3>
                        <p>{{currentProject.short_description | htmlToPlaintext}} </p>
                    </header>
                    <img ng-src="[[config('global.s3Path')]]project/project_logo/{{currentProject.project_logo}}" alt="">
                </a>
            </div>
            <div class="thumbs-sizer"></div>
        </div>

    </div>


    <!-- end content -->

</main>
<!-- END MAIN CONTAINER -->
@endsection() 