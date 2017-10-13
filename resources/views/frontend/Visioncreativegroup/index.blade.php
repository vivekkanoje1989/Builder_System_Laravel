@extends('layouts/frontend/Visioncreativegroup/main')
@section('content')	
<main class="main-content"  ng-init="getProjects(); getPostsDropdown(); getTestimonials();">
<div class="pageWrapper" id="wrap">
    <div class="tp-banner-container">
        <div class="details-img">
            <div class="post-lft-info">
                <div class="main-bg">Todays<br>Special<span class="tri-col"></span></div>
            </div>
            <img src="http://www.barit.de/typo3temp/pics/YG7P4985_01_2e7ffffb1d.jpg" alt="Our Blog post image goes here" class="home-bg">
        </div>
    </div>
    <div class="tp-banner-container" style="background: rgb(125, 191, 206);padding: 10px;">

        <div class="container">
            <div class="tp-banner">
                <ul>
                    <li data-transition="fade" data-slotamount="7">
                        <img alt="" src="frontend/Visioncreativegroup/images/slider/dummy.png" data-lazyload="frontend/Visioncreativegroup/img_vision/slider_1.jpg" data-bgposition="left center" data-kenburns="on" data-duration="14000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="130" data-bgpositionend="right center">

                    </li> 
                    <li data-transition="fade" data-slotamount="7">
                        <img alt="" src="frontend/Visioncreativegroup/images/slider/dummy.png" data-lazyload="frontend/Visioncreativegroup/img_vision/slider_2.jpg" data-bgposition="left center" data-kenburns="on" data-duration="14000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="130" data-bgpositionend="right center">

                    </li> 
                    <li data-transition="fade" data-slotamount="7">
                        <img alt="" src="frontend/Visioncreativegroup/images/slider/dummy.png" data-lazyload="frontend/Visioncreativegroup/img_vision/slider_3.jpg" data-bgposition="left center" data-kenburns="on" data-duration="14000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="130" data-bgpositionend="right center">

                    </li> 
                </ul>
            </div>
        </div>
    </div>

    <!-- Content Start -->
    <div id="contentWrapper">

        <!-- Welcome Box start -->
        <div class="welcome page-section">
            <div class="container">
                <div class="row">
                    <h2 class="bolder">Welcome To <span class="main-color"> Vision Creative Group</span> </h2>
                    <p class="margin-bottom-0">
                        Vision creative group incepted in 2006, in response to the growing need for quality residential and commercial space, vision creative group has grown to be one of the leading real estate developers in Mumbai, Gujarat and Pune.
                    </p>
                </div>
            </div>
        </div>
        <!-- Welcome Box end -->

        <!-- Services boxes style 1 start -->
        <div class="gry-bg">
            <div class="container">
                <div class="row">
                    <div class="cell-4 service-box-1 fx" data-animate="fadeInUp" data-animation-delay="200">
                        <div class="box-top">
                            <i class="fa fa-building"></i>
                            <h3>Current <span> Projects</span></h3>

                            <a class="more-btn" href="projects.html#current_projects">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="cell-4 service-box-1 fx" data-animate="fadeInUp" data-animation-delay="400">
                        <div class="box-top">
                            <i class="fa fa-building-o"></i>
                            <h3>Future <span> Projects</span></h3>
                            <a class="more-btn" href="projects.html#upcoming_projects">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="cell-4 service-box-1 fx" data-animate="fadeInUp" data-animation-delay="600">
                        <div class="box-top">
                            <i class="fa fa-puzzle-piece"></i>
                            <h3>Completed <span> Projects</span></h3>
                            <a class="more-btn" href="projects.html#completed_projects">VIEW ALL</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Services boxes style 1 start -->

        <!-- Portfolio start -->
<!--        
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
        </div>-->
        
        
        <div class="sectionWrapper gry-bg">
            <div class="container">
                <div class="row">
                    <div class="cell-3">
                        <h3 class="block-head side-heading">Ongoing <span>projects</span></h3>
                    </div>
                    <div class="cell-9">
                        <div class="homeGallery portfolio">
                            <!-- staff item start -->
                            <div>
                                <div class="portfolio-item">
                                    <div class="img-holder">
                                        <a href="project_details.html"><img alt="" src="frontend/Visioncreativegroup/img_vision/pro_1.png"></a>
                                    </div>
                                    <div class="name-holder">
                                        <a href="project_details.html" class="project-name">Project Title</a>
                                        <span class="project-options">1 & 2 BHK Homes @Moshi Annex...</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="portfolio-item">
                                    <div class="img-holder">
                                        <a href="project_details.html"><img alt="" src="frontend/Visioncreativegroup/img_vision/pro_2.png"></a>
                                    </div>
                                    <div class="name-holder">
                                        <a href="project_details.html" class="project-name">Project Title</a>
                                        <span class="project-options">1 & 2 BHK Homes @Moshi Annex...</span>
                                    </div>
                                </div>
                            </div>
                            <!-- staff item end -->

                            <!-- staff item start -->
                            <div>
                                <div class="portfolio-item">
                                    <div class="img-holder">

                                        <a href="project_details.html"><img alt="" src="frontend/Visioncreativegroup/img_vision/pro_3.png"></a>
                                    </div>
                                    <div class="name-holder">
                                        <a href="project_details.html" class="project-name">Project Title</a>
                                        <span class="project-options">1 & 2 BHK Homes @Moshi Annex...</span>
                                    </div>
                                </div>
                            </div>
                            <!-- staff item end -->

                        </div><!-- .portfolioGallery end -->
                    </div>
                </div>
            </div>
        </div>


        <!-- TESTIMONIALS STYLE 1 -->
        <div class="sectionWrapper">
            <div class="container">
                <h3 class="block-head">Clients Speak...</h3>
                <div class="testimonials-1">
                    <div>
                        <div class="testimonials-bg">
                            <img alt="" src="frontend/Visioncreativegroup/img_vision/test_1.png" class="testimonials-img">
                            <span>CONTROCTION WORK IS PROPERLY....& VISION'S INDRADHANU TEAM IS GOOD...</span>
                        </div>
                        <div class="testimonials-name"><strong>Sandeep Patil</strong></div>
                    </div>
                    <div>
                        <div class="testimonials-bg">
                            <img alt="" src="frontend/Visioncreativegroup/img_vision/test_2.png" class="testimonials-img">
                            <span>my experience with company was too good. all sales team and staff are very coordinated wit...</span>
                        </div>
                        <div class="testimonials-name"><strong>Sakshi Kale </strong></div>
                    </div>
                    <div>
                        <div class="testimonials-bg">
                            <img alt="" src="frontend/Visioncreativegroup/img_vision/test_1.png" class="testimonials-img">
                            <span>CONTROCTION WORK IS PROPERLY....& VISION'S INDRADHANU TEAM IS GOOD...</span>
                        </div>
                        <div class="testimonials-name"><strong>Sandeep Patil</strong></div>
                    </div>
                </div>						
            </div>
        </div>

    </div>
    <!-- Content End -->


    <!-- Back to top Link -->
    <div id="to-top" class="main-bg"><span class="fa fa-chevron-up"></span></div>

</div>   

@endsection() 