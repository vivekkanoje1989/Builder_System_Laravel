@extends('layouts/frontend/Gagan/main')
@section('content')
<!-- END HEADER -->

<!-- BEGIN MAIN CONTAINER -->
<main class="main-content"  ng-init="getProjectsAllProjects()"  >

    <!-- start content -->
    <div class="container" style="margin-top:165px">
        <header class="heading page-heading">
            <h1>All Projects</h1>
        </header>
        <div class="" ng-if="current">
            <div class=" thumbs-filter" id="current">
                <ul>
                    <li class="active" data-group="all"><h3>Current Project</h3></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6" ng-repeat="list in current">
                    <div class="propertyItem" >
                        <div class="propertyContent"> <a class="propertyImgLink" href="project-details.html">
                                <img alt="" src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" class="propertyImg"></a>
                            <h4><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/project-details/{{list.id}}">{{list.project_name}}</a></h4>
                            <p> {{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}} </p>
                            <div class="divider thin"></div>
                            <p class="forSale"><a href="[[ URL::to('/') ]]/project-details/{{list.id}}">Read More</a></p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="" ng-if="upcoming">
            <div class=" thumbs-filter" id="upcoming">
                <ul>
                    <li class="active" data-group="all"><h3>Upcoming Project</h3></li>
                </ul>
            </div>
<!--            <div class="thumbs offset-bottom">
                <div class="thumbs-item " ng-repeat="currentProject in upcoming">
                    <a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/project-details/{{currentProject.id}}">
                        <header class="thumbs-item-heading">
                            <h3>{{currentProject.project_name}}</h3>
                            <p>{{currentProject.short_description| htmlToPlaintext}} </p>
                        </header>
                        <img ng-src="[[config('global.s3Path')]]/project/project_logo/{{currentProject.project_logo}}" alt="">
                    </a>
                </div>
                <div class="thumbs-sizer"></div>
            </div>-->
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6"  ng-repeat="list in upcoming">
                    <div class="propertyItem">
                        <div class="propertyContent"> <a class="propertyImgLink" href="project-details.html">
                                <img alt="" src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" class="propertyImg"></a>
                            <h4><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/project-details/{{list.id}}">{{list.project_name}}</a></h4>
                            <p> {{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}} </p>
                            <div class="divider thin"></div>
                            <p class="forSale"><a href="[[ URL::to('/') ]]/project-details/{{list.id}}">Read More</a></p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="" ng-if="completed">
            <div class=" thumbs-filter" id="completed">
                <ul>
                    <li class="active" data-group="all"><h3>Completed Project</h3></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6"  ng-repeat="list in completed">
                    <div class="propertyItem">
                        <div class="propertyContent"> <a class="propertyImgLink" href="project-details.html">
                                <img alt="" src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" class="propertyImg"></a>
                            <h4><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/project-details/{{list.id}}">{{list.project_name}}</a></h4>
                            <p> {{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}} </p>
                            <div class="divider thin"></div>
                            <p class="forSale"><a href="[[ URL::to('/') ]]/project-details/{{list.id}}">Read More</a></p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="thumbs offset-bottom">
                    <div class="thumbs-item " ng-repeat="currentProject in completed">
                        <a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/project-details/{{currentProject.id}}">
                            <header class="thumbs-item-heading">
                                <h3>{{currentProject.project_name}}</h3>
                                <p>{{currentProject.short_description| htmlToPlaintext}} </p>
                            </header>
                            <img ng-src="[[config('global.s3Path')]]project/project_logo/{{currentProject.project_logo}}" alt="">
                        </a>
                    </div>
                    <div class="thumbs-sizer"></div>
                </div>-->
    </div>
    <!-- end content -->

</main>
<!-- END MAIN CONTAINER -->
@endsection() 