@extends('layouts/frontend/Gagan/main')
@section('content')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <main class="main-content" ng-init="getProjects(); getPostsDropdown(); getTestimonials();">
  
    
    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="padding-top:50px;" >
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="/frontend/Gagan/img/banner/banner1.jpg" alt="Image">  
        </div>
        <div class="item">
            <img src="/frontend/Gagan/img/banner/banner2kapitl.jpg" alt="Image">     
        </div>
        <div class="item">
            <img src="/frontend/Gagan/img/banner/Gaganunnathibanner-corp-site-28-11-2016.jpg" alt="Image">    
        </div>
<!--        <div class="item">
            <img src="/frontend/SkyMotoTheme/images/homeImages/wallpaper_2.jpg" alt="Image">    
        </div>-->
        <div class="item">
            <img src="/frontend/Gagan/img/banner/banner4nul.jpg" alt="Image">    
        </div>
    </div>
    <a class="left carousel-control" id="left"  ng-non-bindable  role="button" data-slide="prev" >
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" id="right" ng-non-bindable  role="button" data-slide="next" >
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
    
    
    
    
    <!-- end horizontal filter --> 
    <div class="container bigMessage">
        <div id="system-message-container">
        </div>
        <div class="pageData  homepage">

            <div class="content">
                <script type='application/ld+json'> 
                    {
                    "@context": "http://www.schema.org",
                    "@type": "WebSite",
                    "name": "Gagan Properties",
                    "url": "http://gaganproperties.com/",

                    "@type": "Place",
                    "geo": {
                    "@type": "GeoCoordinates",
                    "latitude": "18.5193472",
                    "longitude": "73.8706963"
                    }

                    }
                </script> 
                <h1>Welcome to the world of GAGAN, <span>Inspiring creations</span>!</h1>
                <br/>
                <p>
                    Introducing ourselves, Gagan Properties is a Gagan Group Company with multiple real estate and automobile verticals in its flagship. It has its core business as prime construction and real estate ventures since last 20 years. Having constructed large number of residential and commercial projects in and around Pune and Pimpri Chinchwad area. Gagan Properties has great expertise in construction and real estate business for the markets of Pune, suburbs and Maharashtra state. […]
                </p> </div>
        </div>
    </div>
    <!-- start recent properties -->
    <section class="properties">
        <div class="container">
            <h3>CURRENT PROJECTS </h3>
            <div class="divider"></div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6"  ng-repeat="list in current">
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
        <!-- end container --> 
        <!-- start call to action -->
        <section class="callToAction ">
            <div class="container">
                <div class="ctaBox">
                    <div class="ctaBox">
                        <div class="col-lg-9">
                            <h1>Welcome to the world of <span>GAGAN</span> </h1>
                            <p>It has its core business as prime construction and real estate ventures since last 20 years.</p>
                        </div>
                        <div class="col-lg-3"> <a style="float:right; margin-top:15px;" class="buttonColor" href="[[ URL::to('/') ]]/contact">ENQUIRE NOW</a> </div>
                        <div style="clear:both;"></div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- end call to action -->



@endsection() 
  
<script>
    $('.carousel-control.left').click(function() {
        alert("fdfd")
    $('#myCarousel').carousel('prev');
    });
    $('#left').click(function() {
        alert("fdfd")
    $('#myCarousel').carousel('prev');
    });
    
    $('.carousel-control.right').click(function() {
    $('#myCarousel').carousel('next');
    });
    
    $(document).ready(function() {
    setTimeout(function() {
    $('#myCarousel').carousel('next');
    }, 5000);
    });
</script>