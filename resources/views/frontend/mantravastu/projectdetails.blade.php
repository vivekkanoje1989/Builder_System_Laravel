<style>
    .span4 {
        width: 250px!important;
    }
</style>
@extends('layouts/frontend/mantravastu/main')
@section('content')
<!-- Start home section -->
<main class="main-content" ng-init="getProjectDetails('[[$projectId]]');getContactDetails();getProjects();">
    <div id="home" class="centered">
        <!-- Start cSlider -->
        <ul class="bxslider">
            <li><img src="frontend/mantravastu/images/banner1.jpg"  title="Funky roots"/></li>
            <li><img src="frontend/mantravastu/images/banner2.jpg"  title="Funky roots"/></li>
            <li><img src="frontend/mantravastu/images/banner3.jpg"  title="Funky roots"/></li>
        </ul>			
    </div>
    <!-- End home section -->
    <!-- About us section start -->
    <div class="section secondary-section" id="about">
        <div class="triangle"></div>
        <div class="container">
            <div class="about-text">                    
                <div class="title">{{ projectsdata}}
                    <h1>{{ project_name}}  </h1>
                </div>
                <div class="span3" id="project-logo">
                    <img src="frontend/mantravastu/imageslogo.png" class="img-responsive"/>
                </div>
                <div class="span9">
                    <h3>Description</h3>
                    <p>{{description| htmlToPlaintext}}</p>
                </div>
            </div>
        </div>
        <!-- Project Details Tab -->

        <div class="container" id="details">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="" id="availability">Availability</a></li>
                <li><a data-toggle="tab" href="" id="locationid">Location Map</a></li>
                <li><a data-toggle="tab" href="" id="amenities">Amenities</a></li>
                <li><a data-toggle="tab" href="" id="layout">Layout Plans</a></li>
                <li><a data-toggle="tab" href="" id="floor">Floor Plans</a></li>
                <li><a data-toggle="tab" href="" id="gallary">Gallary</a></li>
            </ul>

            <div class="tab-content">
                <div id="availabilitydata" class="tab-pane fade in active">
                    <h2>Availability in {{ project_name}} </h2>
                    <div class="row">
                        <!-- Product Summary & Options -->
                        <div ng-repeat="list in availble" class="span4 product-details">
                            <div class="interest">
                                <ul>
                                    <li class="h3">
                                        {{ list.block_name}}
                                    </li>
                                    <li class="h5">
                                        2 BHK apartment of 950 Sq Ft , with state of the art design of the apartment.
                                    </li>
                                    <li class="interested">
                                        <a id="enquiry_{{list.id}}_{{list.project_id}}" class="projectEnquiry" style="border: 1px solid #FECE1A; cursor:pointer ;color: #FECE1A;padding: 6px;" onclick="interestedProject(this.id)">I am Interested</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Product Summary & Options -->
                    </div>
                </div>
                <div id="locationmap" class="tab-pane fade" style="margin-top:10px;">
                    <div class="row">
                        <div class="span12">
                            <div class="row">
                                <div id="contact-us-map">
                                    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
                                    <br />
                                    <small>
                                        <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A"></a>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <a  ng-repeat="list in location_map_images.split(',')"  href='https://storage.googleapis.com/bkt_bms_laravel/project/location_map_images/{{list}}' target="_blank" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="https://storage.googleapis.com/bkt_bms_laravel/project/location_map_images/{{list}}" class="img-responsive" style="width: 200px;height: 200px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="amenitiesimg" class="tab-pane fade" style="margin-top:10px;">
                    <div class="row">
                        <div class="span12">
                            <div class="row">
                                <a ng-repeat="list in amenities_images" href="https://storage.googleapis.com/bkt_bms_laravel/project/amenities_images/{{list}}" target="_blank" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="https://storage.googleapis.com/bkt_bms_laravel/project/amenities_images/{{list}}" class="img-responsive" style="width: 200px;height: 200px;">
                                </a>
                            </div>
                        </div>
                    </div>   
                </div>
                <div id="layoutimg" class="tab-pane fade" style="margin-top:10px;"->
                    <div class="row">
                        <div class="span12">
                            <div class="row">
                                <a ng-repeat="list in layout_plan" href="https://storage.googleapis.com/bkt_bms_laravel/project/layout_plan_images{{ list.layout_plan_images}}"  target="_blank" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="https://storage.googleapis.com/bkt_bms_laravel/project/layout_plan_images/{{ list.layout_plan_images}}" class="img-responsive" style="width: 200px;height: 200px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="floorimgs" class="tab-pane fade" style="margin-top:10px;">
                    <div class="row">
                        <div class="span12">
                            <div class="row">
                                <a ng-repeat="list in floor_plan" href="https://storage.googleapis.com/bkt_bms_laravel/project/floor_plan_images/{{ list.floor_plan_images}}"  target="_blank" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="https://storage.googleapis.com/bkt_bms_laravel/project/floor_plan_images/{{ list.floor_plan_images}}" class="img-responsive" style="width: 200px;height: 200px;">
                                </a>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div id="gallaryimg" class="tab-pane fade" style="margin-top:10px;">
                    <ul class="nav nav-tabs" >
                        <li class="active"><a data-toggle="tab" href="" id="elevationsid">Elevations</a></li>
                        <li><a data-toggle="tab" href="" id="walk">Walk Through</a></li>
                    </ul>
                    <div class="tab-content" id="galleryData">
                        <div id="elevations" class="tab-pane fade in active" style="margin-top:10px;">		
                            <div class="row">
                                <div class="span12">
                                    <div class="row">
                                        <a href="frontend/mantravastu/images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                            <img src="frontend/mantravastu/images/banner1.jpg" class="img-responsive">
                                        </a>
                                        <a href="frontend/mantravastu/images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                            <img src="frontend/mantravastu/images/banner1.jpg" class="img-responsive">
                                        </a>
                                        <a href="frontend/mantravastu/images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                            <img src="frontend/mantravastu/images/banner1.jpg" class="img-responsive">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="walkdata" class="tab-pane fade" style="margin-top:10px;">		
                            <div class="row">
                                <div class="span12">
                                    <div class="row">
                                        <a href="frontend/mantravastu/images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                            <img src="frontend/mantravastu/images/banner1.jpg" class="img-responsive">
                                        </a>
                                        <a href="frontend/mantravastu/images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                            <img src="frontend/mantravastu/images/banner1.jpg" class="img-responsive">
                                        </a>
                                        <a href="frontend/mantravastu/images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                            <img src="frontend/mantravastu/images/banner1.jpg" class="img-responsive">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>	

    <!-- Project Details Tab ends here-->	 
</div>
<!-- About us section end -->


<!-- projects section start -->
<div class="section primary-section" id="projects">
    <div class="triangle"></div>
    <div class="container">
        <!-- Start title section -->
        <div class="title">
            <h1>Other Projects</h1>
        </div>
        <div class="">
            <div ng-repeat="list in current" class="span4">
                <div class="centered projects">
                    <div class="zoom-in">
                        <img class="img-responsive" src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" alt="projects 1">
                    </div>
                    <h3>{{ list.project_name}}</h3>
                    <p>{{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}}</p>
                    <a href="/#/project-details/{{list.id}}" class="btn">Read more</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer section start -->
<div class="footer">
    <p><img src="frontend/mantravastu/imagesfavicon.jpg" alt="e-dynamics" width="32" height="32" border="0" class="ftr-logo"> &copy; 2015 ABC BUILDER</p>
</div>
<!-- Footer section end -->
<!-- ScrollUp button start -->
<div class="scrollup">
    <a href="#">
        <i class="icon-up-open"></i>
    </a>
</div>
<!-- ScrollUp button end -->

@endsection()
<script type="text/javascript" src="frontend/mantravastu/js/app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="frontend/mantravastu/js/jquery.js"></script>
<script type="text/javascript">
                            $(document).ready(function ($) {
                                $("html, body").animate({
                                    scrollTop: 0
                                }, 600);

                                $("a#availability").click(function (e) {
                                    $("#availabilitydata").show();
                                    $('.tab-content').children(':not(#availabilitydata)').hide();
                                    $('.tab-content tab-pane fade').addClass('tab-pane fade').removeClass('tab-pane fade in active');
                                    $("#availabilitydata").addClass('tab-pane fade in active').removeClass('tab-pane fade');
                                });
                                $("a#locationid").click(function (e) {
                                    $("#locationmap").show();
                                    $('.tab-content').children(':not(#locationmap)').hide();
                                    $('.tab-content tab-pane fade').addClass('tab-pane fade').removeClass('tab-pane fade in active');
                                    $("#locationmap").addClass('tab-pane fade in active').removeClass('tab-pane fade');
                                });
                                $("a#layout").click(function (e) {
                                    $("#layoutimg").show();
                                    $('.tab-content').children(':not(#layoutimg)').hide();
                                    $('.tab-content tab-pane fade').addClass('tab-pane fade').removeClass('tab-pane fade in active');
                                    $("#layoutimg").addClass('tab-pane fade in active').removeClass('tab-pane fade');
                                });

                                $("a#amenities").click(function (e) {
                                    $("#amenitiesimg").show();
                                    $('.tab-content').children(':not(#amenitiesimg)').hide();
                                    $('.tab-content tab-pane fade').addClass('tab-pane fade').removeClass('tab-pane fade in active');
                                    $("#amenitiesimg").addClass('tab-pane fade in active').removeClass('tab-pane fade');
                                });

                                $("a#floor").click(function (e) {
                                    $("#floorimgs").show();
                                    $('.tab-content').children(':not(#floorimgs)').hide();
                                    $('.tab-content tab-pane fade').addClass('tab-pane fade').removeClass('tab-pane fade in active');
                                    $("#floorimgs").addClass('tab-pane fade in active').removeClass('tab-pane fade');
                                });
                                $("a#gallary").click(function (e) {
                                    $("#gallaryimg").show();
                                    $('.tab-content').children(':not(#gallaryimg)').hide();
                                    $('.tab-content tab-pane fade').addClass('tab-pane fade').removeClass('tab-pane fade in active');
                                    $("#gallaryimg").addClass('tab-pane fade in active').removeClass('tab-pane fade');
                                });
                                $("a#elevationsid").click(function (e) {
                                    $("#galleryData elevations").show();
                                    $('#galleryData').children(':not(#elevations)').hide();
                                    $('#galleryData tab-content tab-pane fade').addClass('tab-pane fade').removeClass('tab-pane fade in active');
                                    $("#elevations").addClass('tab-pane fade in active').removeClass('tab-pane fade');
                                });
                                /* header redirection */
                                $("a#contactus").click(function (e) {
                                    e.preventDefault();
                                    $('html, body').animate({
                                        scrollTop: $("#contact").offset().top
                                    }, 1500);
                                });

                                $("a#careers").click(function (e) {
                                    var subStr = window.location.pathname.match("/(.*)/");
                                    if (subStr[1] == 'project-details')
                                    {
                                        window.location.href = "http://127.0.0.1:8000";
                                    } else {
                                    }
                                    e.preventDefault();
                                    $('html, body').animate({
                                        scrollTop: $("#careersdata").offset().top
                                    }, 1500);
                                });
                                $("a#clients").click(function (e) {
                                    var subStr = window.location.pathname.match("/(.*)/");
                                    if (subStr[1] == 'project-details')
                                    {
                                        window.location.href = "http://127.0.0.1:8000";
                                    } else {
                                    }
                                    e.preventDefault();
                                    $('html, body').animate({
                                        scrollTop: $("#testmonials").offset().top
                                    }, 1500);
                                });
                                $("a#home").click(function (e) {
                                    var subStr = window.location.pathname.match("/(.*)/");
                                    if (subStr[1] == 'project-details')
                                    {
                                        window.location.href = "http://127.0.0.1:8000";
                                    } else {
                                    }
                                    e.preventDefault();
                                    $('html, body').animate({
                                        scrollTop: $("#homepage").offset().top
                                    }, 1500);
                                });

                                $("a#about").click(function (e) {
                                    var subStr = window.location.pathname.match("/(.*)/");
                                    if (subStr[1] == 'project-details')
                                    {
                                        window.location.href = "http://127.0.0.1:8000";
                                    } else {
                                    }
                                    e.preventDefault();
                                    $('html, body').animate({
                                        scrollTop: $("#aboutus").offset().top
                                    }, 1500);
                                });

                                $(".close").on("click", function () {
                                    $("#enquiry-popup").css("display", "none");
                                    $(".main-content").removeClass("main-overlay");
                                });
                                interestedProject = function (id)
                                {
                                    alert("interest" + id);
                                    $(".main-content").addClass("main-overlay");
                                    $("#enquiry-popup").css("display", "block");
                                    $("#enquiry-popup-form").css("display", "block");
                                }
                            });
                            $(document).ready(function ($) {
                                $('.bxslider').bxSlider({mode: 'fade', captions: true, auto: true, autoControls: true, });
                                // delegate calls to data-toggle="lightbox"
                                $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function (event) {
                                    event.preventDefault();
                                    return $(this).ekkoLightbox({
                                        onShown: function () {
                                            if (window.console) {
                                                return console.log('Checking our the events huh?');
                                            }
                                        },
                                        onNavigate: function (direction, itemIndex) {
                                            if (window.console) {
                                                return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
                                            }
                                        }
                                    });
                                });
                                //Programatically call
                                $('#open-image').click(function (e) {
                                    e.preventDefault();
                                    $(this).ekkoLightbox();
                                });
                                $('#open-youtube').click(function (e) {
                                    e.preventDefault();
                                    $(this).ekkoLightbox();
                                });
                                // navigateTo
                                $(document).delegate('*[data-gallery="navigateTo"]', 'click', function (event) {
                                    event.preventDefault();
                                    return $(this).ekkoLightbox({
                                        onShown: function () {
                                            var a = this.modal_content.find('.modal-footer a');
                                            if (a.length > 0) {
                                                a.click(function (e) {
                                                    e.preventDefault();
                                                    this.navigateTo(2);
                                                }.bind(this));
                                            }
                                        }
                                    });
                                });
                            });
</script>