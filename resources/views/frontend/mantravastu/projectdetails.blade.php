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
                    <h2>Availability in {{ project_name }} </h2>
                    <div class="row">
                        <!-- Product Summary & Options -->
                        <div ng-repeat="list in availble" class="span4 product-details">
                            <div class="interest">
                                <ul>
                                    <li class="h3">
                                        {{ list.block_name }}
                                    </li>
                                    <li class="h5">
                                        2 BHK apartment of 950 Sq Ft , with state of the art design of the apartment.
                                    </li>
                                    <li class="interested">
                                        <a id="enquiry" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">I am Interested</a>
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
                    <ul class="nav nav-tabs" >{{ gallery}}
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
        <div class="row-fluid">
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
<!-- projects section end -->

<!--        <div class="section primary-section">
            <div class="triangle"></div>
            <div class="container centered">
                <p class="large-text">Enquire About Our Project Here</p>
                <a id="enquiry" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">Enquire now</a>
            </div>
        </div> 
-->
<!-- Contact section start -->
<div id="contact" class="contact">
    <div class="section secondary-section">
        <div class="container">            
            <div class="span9 center contact-info">
                <p>{{ contacts[0].address }}</p>
                <p class="info-mail">{{ contacts[0].email}}</p>
                <p>{{ contacts[0].contact_number1 }}</p>
                <p>{{ contacts[0].contact_number2 }}</p>                
                <div class="title">
                    <h3>We Are Social</h3>
                </div>
            </div>
            <div class="row-fluid centered">
                <ul class="social">
                    <li>
                        <a href="">
                            <span class="icon-facebook-circled"></span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="icon-twitter-circled"></span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="icon-linkedin-circled"></span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="icon-pinterest-circled"></span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="icon-dribbble-circled"></span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="icon-gplus-circled"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Contact section edn -->

<div id="enquiry-popup">
    <form action="" class="enquiry" id="enquiry-popup-form">
        <h4> Enquiry for Property</h4>
        <a href="" class="close" id="clos"><img src="frontend/mantravastu/imagesclose_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
        <fieldset class="enquiry-inner">
            <p class="enquiry-input">
                <input type="text" name="Fname" placeholder="Your First Name…" autofocus>
            </p>

            <p class="enquiry-input">
                <input type="text" name="Lname" placeholder="Your Last Name…" autofocus>
            </p>

            <p class="enquiry-input">
                <input type="phone" name="phone" placeholder="Your Mobile Number" autofocus>
            </p>

            <p class="enquiry-input">
                <input type="email" name="email" placeholder="Your Email" autofocus>
            </p>

            <p class="enquiry-input">
                <textarea name="remark" placeholder="Your Remark…"></textarea>
            </p>

            <div>
                Captcha Image*
                <div><img id="captchaimg5" style="padding: 0 0 0 5px;" src="http://www.e-dynamics.in/reb/captcha_code_file.php?rand=1265139648&amp;name=enquiry_captcha">
                    <div style="padding: 0 0 0 5px;">
                        Click <a class="here" href="javascript: refreshCaptcha(&quot;captchaimg5&quot;);">here</a> to refresh
                    </div> 
                </div>
            </div>
            <p class="enquiry-input">
                <input id="txtCaptcha" name="txtCaptcha" value="" type="text" autocomplete="on" placeholder="Captcha">
            </p>


            <p class="enquiry-submit">
                <input type="submit" value="Send Message">
            </p>
        </fieldset>
    </form>

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
</main>
@endsection()
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        
         jQuery library (served from Google) 
         bxSlider Javascript file 
<script src="frontend/mantravastu/js/bootstrap.min.js"></script>
        <script src="frontend/mantravastu/js/ekko-lightbox.js"></script>
        <script src="frontend/mantravastu/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.mixitup.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/modernizr.custom.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.inview.js"></script> -->

<!-- Load google maps api and call initializeMap function defined in app.js -->
<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;callback=initializeMap"></script>-->
<!-- css3-mediaqueries.js for IE8 or older -->
<!--[if lt IE 9]-->
    <!--<script src="frontend/mantravastu/js/respond.min.js"></script>-->
<!--[endif]-->
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