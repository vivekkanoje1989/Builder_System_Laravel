@extends('layouts/frontend/mantravastu/main')
@section('content')    
<style>
    .nav .current> a{
        border: 1px solid #FECE1A;
        color: #fff !important;
        background-color: #181A1C!important;
        transition: border-color 1s ease;
    }
    #portfolio-grid .mix {
        opacity: 1;
        display: inline-block;
    }
    .toggleDiv{
        display: none;
    }
</style>
<main class="main-content"  ng-init="getProjectsAllProjects();getTestimonials();getContactDetails();"  >
    <!-- Portfolio section start -->
    <div class="section secondary-section " id="portfolio">
        <div class="triangle"></div>
        <div class="container">
            <div class=" title">
                <h1>Our Projects</h1>
            </div>
            <ul class="nav nav-pills">
                <li class="filter" data-filter="all">
                    <a href="" class="currentProjects">All</a>
                </li>
                <li class="filter" data-filter="current">
                    <a href="" class="currentProjects">Current Projects</a>
                </li>
                <li class="filter" data-filter="completed">
                    <a href="" class="currentProjects">Completed Projects</a>
                </li>
                <li class="filter" data-filter="upcoming">
                    <a href="" class="currentProjects">Upcoming Projects</a>
                </li>
            </ul>
            <!-- Start details for portfolio project  -->
            <div id="single-project">
                <div ng-repeat="list in current">
                    <div id="slidingDivcurrent{{$index + 1}}" class="toggleDiv row-fluid single-project">
                        <div class="span6">
                            <img src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" alt="project 1" />
                        </div>
                        <div class="span6">
                            <div class="project-description">
                                <div class="project-title clearfix">
                                    <h3>{{list.project_name}}</h3>
                                    <span class="show_hide close">
                                        <i class="icon-cancel"></i>
                                    </span>
                                </div>
                                <div class="project-info">
                                    <div>
                                        <span>Amenities</span>Sample data</div>
                                    <div>
                                        <span>Speciafication</span>Sample data</div>

                                </div>
                                <p>{{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}}</p>                            
                                <a href="#/project-details/{{list.id}}" target="_self" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div ng-repeat="list in completed">
                    <div id="slidingDivcompleted{{$index + 1}}" class="toggleDiv row-fluid single-project">
                        <div class="span6">
                            <img src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" />
                        </div>
                        <div class="span6">
                            <div class="project-description">
                                <div class="project-title clearfix">
                                    <h3>{{ list.project_name}}</h3>
                                    <span class="show_hide close">
                                        <i class="icon-cancel"></i>
                                    </span>
                                </div>
                                <div class="project-info">
                                    <div>
                                        <span>Amenities</span>Sample data</div>
                                    <div>
                                        <span>Speciafication</span>Sample data</div>
                                </div>
                                <p>{{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}}</p>                            
                                <a href="#/project-details/{{list.id}}" target="_self" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div ng-repeat="list in upcoming">
                    <div id="slidingDivupcoming{{$index + 1}}" class="toggleDiv row-fluid single-project">
                        <div class="span6">
                            <img src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" />
                        </div>
                        <div class="span6">
                            <div class="project-description">
                                <div class="project-title clearfix">
                                    <h3>{{ list.project_name}}</h3>
                                    <span class="show_hide close">
                                        <i class="icon-cancel"></i>
                                    </span>
                                </div>
                                <div class="project-info">
                                    <div>
                                        <span>Amenities</span>Sample data</div>
                                    <div>
                                        <span>Speciafication</span>Sample data</div>
                                </div>
                                <p>{{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}}</p>                            
                                <a href="#/project-details/{{list.id}}" target="_self" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>

                <ul id="portfolio-grid"  class="thumbnails row centered">               
                    <li ng-repeat="list in current"  class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mix current" ng-if="current">
                        <div class="thumbnail">
                            <img src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" alt="project 1">
                            <a class="show_hide more" rel="slidingDivcurrent{{$index + 1}}">
                                <i class="icon-plus"></i>
                            </a>
                            <h3>{{list.project_name}}</h3>
                            <p>{{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}}</p>
                            <div class="mask"></div>
                        </div>
                    </li>
                    <li ng-repeat="list in completed"  class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mix completed" ng-if="completed">
                        <div class="thumbnail">
                            <img src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" alt="project 1" ng-if="list.project_logo != ''">
                            <img ng-if="list.project_logo == null" src="https://xcski.org/site/wp-content/uploads/2017/05/project.png" style="margin-top: -7%;">
                            <a id="slidingDivcompleted{{$index + 1}}" class="show_hide more" rel="slidingDivcompleted{{$index + 1}}">
                                <i class="icon-plus"></i>
                            </a>
                            <h3>{{list.project_name}}</h3>
                            <p>{{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}}</p>
                            <div class="mask"></div>
                        </div>
                    </li>
                    <li ng-repeat="list in upcoming"  class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mix upcoming" ng-if="upcoming">
                        <div class="thumbnail">
                            <img src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}" alt="project 1">
                            <a class="show_hide more" rel="slidingDivupcoming{{$index + 1}}">
                                <i class="icon-plus"></i>
                            </a>
                            <h3>{{list.project_name}}</h3>
                            <p>{{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}}</p>
                            <div class="mask"></div>
                        </div>
                    </li>


                    <!--                 <li class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mix upcoming">
                                         <div class="thumbnail">
                                             <img src="frontend/mantra_vastu/images/project.jpg" alt="project 3">
                                             <a href="#single-project" class="more show_hide" rel="#slidingDiv2">
                                                 <i class="icon-plus"></i>
                                             </a>
                                             <h3>Project Name</h3>
                                             <p>Project Information</p>
                                             <div class="mask"></div>
                                         </div>
                                     </li>
                                     <li class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mix current">
                                         <div class="thumbnail">
                                             <img src="frontend/mantra_vastu/images/project.jpg" alt="project 4">
                                             <a href="#single-project" class="show_hide more" rel="#slidingDiv3">
                                                 <i class="icon-plus"></i>
                                             </a>
                                             <h3>Project Name</h3>
                                             <p>Project Information</p>
                                             <div class="mask"></div>
                                         </div>
                                     </li>
                                     <li class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mix completed">
                                         <div class="thumbnail">
                                             <img src="frontend/mantra_vastu/images/project.jpg" alt="project 5">
                                             <a href="#single-project" class="show_hide more" rel="#slidingDiv4">
                                                 <i class="icon-plus"></i>
                                             </a>
                                             <h3>Project Name</h3>
                                             <p>Project Information</p>
                                             <div class="mask"></div>
                                         </div>
                                     </li>
                                     <li class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mix upcoming">
                                         <div class="thumbnail">
                                             <img src="frontend/mantra_vastu/images/project.jpg" alt="project 6">
                                             <a href="#single-project" class="show_hide more" rel="#slidingDiv5">
                                                 <i class="icon-plus"></i>
                                             </a>
                                             <h3>Project Name</h3>
                                             <p>Project Information</p>
                                             <div class="mask"></div>
                                         </div>
                                     </li>
                                     <li class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mix current">
                                         <div class="thumbnail">
                                             <img src="frontend/mantra_vastu/images/project.jpg" alt="project 7" />
                                             <a href="#single-project" class="show_hide more" rel="#slidingDiv6">
                                                 <i class="icon-plus"></i>
                                             </a>
                                             <h3>Project Name</h3>
                                             <p>Project Information</p>
                                             <div class="mask"></div>
                                         </div>
                                     </li>
                                     <li class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mix upcoming">
                                         <div class="thumbnail">
                                             <img src="frontend/mantra_vastu/images/project.jpg" alt="project 9">
                                             <a href="#single-project" class="show_hide more" rel="#slidingDiv8">
                                                 <i class="icon-plus"></i>
                                             </a>
                                             <h3>Project Name</h3>
                                             <p>Project Information</p>
                                             <div class="mask"></div>
                                         </div>
                                     </li>-->
                </ul>
            </div>
        </div>
    </div>
    <!-- Portfolio section end -->
    <!-- Client section start -->
    <div id="testmonials">
        <div class="section primary-section">
            <div class="triangle"></div>
            <div class="container">
                <div class="title">
                    <h1>What Client Say?</h1>
                </div>
                <div class="row">
                    <div class="span3" ng-repeat="list in testimonial|limitTo:4"">
                        <div class="testimonial">                        
                            <p>{{ list.description}} </p>
                            <div class="whopic">
                                <div class="arrow"></div>
                                <img ng-if="photo_url != null" src="[[config('global.s3Path')]]/Testimonial/{{ photo_url}}" alt="https://furtaev.ru/preview/user_3_small.png" class="img-circle centered" alt="client 1">
                                <img ng-if="photo_url == null" src="https://furtaev.ru/preview/user_3_small.png" class="img-circle centered" alt="client 1">
    <!--                            <strong>{{ list.customer_name}}
                                    <b>{{ list.company_name }}</b>
                                </strong>-->
                            </div>
                        </div>
                    </div>                
                </div>
                <div class="row centered" style="margin-top:10px;">
                    <a id="experience" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">Share Your Experience now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact section start -->
    <div id="contact" class="contact">
        <div class="section secondary-section">
            <div class="container">
                <div class="span9 center contact-info">
                    <p>{{ contacts[0].address}}</p>
                    <p class="info-mail">{{ contacts[0].email}}</p>
                    <p>{{ contacts[0].contact_number1}}</p>
                    <p>{{ contacts[0].contact_number2}}</p>                
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
            <a href="" class="close" id="clos"><img src="frontend/mantra_vastu/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
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
    <!-- share your Experience -->
    <div id="experience-popup">
        <form action="" class="experience" id="experience-popup-form">
            <h4> experience for Property</h4>
            <a href="" class="close" id="clos"><img src="frontend/mantra_vastu/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
            <fieldset class="experience-inner">
                <p class="experience-input">
                    <input type="text" name="Fname" placeholder="Your First Name…" autofocus>
                </p>

                <p class="experience-input">
                    <input type="text" name="Lname" placeholder="Your Last Name…" autofocus>
                </p>

                <p class="experience-input">
                    <input type="phone" name="phone" placeholder="Your Mobile Number" autofocus>
                </p>

                <p class="experience-input">
                    <input type="email" name="email" placeholder="Your Email" autofocus>
                </p>

                Upload Your Photo
                <p class="experience-input">
                    <input id="uploadimg" name="uploadimg" value="" autocomplete="on" placeholder="Upload Your Photo" type="file" autofocus>
                </p>

                <p class="experience-input">
                    <textarea name="experience" placeholder="Your Experience…"></textarea>
                </p>

                <div>
                    Captcha Image*
                    <div><img id="captchaimg5" style="padding: 0 0 0 5px;" src="http://www.e-dynamics.in/reb/captcha_code_file.php?rand=1265139648&amp;name=experience_captcha">
                        <div style="padding: 0 0 0 5px;">
                            Click <a class="here" href="javascript: refreshCaptcha(&quot;captchaimg5&quot;);">here</a> to refresh
                        </div> 
                    </div>
                </div>
                <p class="experience-input">
                    <input id="txtCaptcha" name="txtCaptcha" value="" type="text" autocomplete="on" placeholder="Captcha">
                </p>


                <p class="experience-submit">
                    <input type="submit" value="Send Message">
                </p>
            </fieldset>
        </form>

    </div>
    <!-- Share your experience ends here -->

    <!-- Footer section start -->
    <div class="footer">
        <p><img src="frontend/mantra_vastu/images/favicon.jpg" alt="e-dynamics" width="32" height="32" border="0" class="ftr-logo"> &copy; 2015 ABC BUILDER</p>
    </div>
    <!-- Footer section end -->
    <!-- ScrollUp button start -->
    <div class="scrollup">
        <a href="#">
            <i class="icon-up-open"></i>
        </a>
    </div>
    <!-- ScrollUp button end -->
    <!-- Include javascript -->
    @endsection()
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="frontend/mantravastu/js/jquery.js"></script>

    <script>
        $(document).ready(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            $('.bxslider').bxSlider({
                mode: 'fade',
                captions: true
            });

            $(".currentProjects").click(function (e) {
                $(".nav-pills li").addClass('filter').removeClass('filter active')
                $(this).parent('li').addClass('filter active').removeClass('filter');
                //mix current
                //$("thumbnails li").css("display", "none");
                $('.thumbnails li').not('.li mix current').css("display", "none");
                e.preventDefault();
            });
            $(".show_hide").live("click", function (e) {
                var id = $(this).attr('rel');
                $('html, body').animate({
                    scrollTop: //$('.single-project').not('.single-project '+id).css("display", "none")
                            $("#" + id).show()
                }, 1500);
                $(this).parent('li').addClass('filter active').removeClass('filter');
                e.preventDefault();

            });
            
            $("a#home").click(function (e) {
                        //window.history.replaceState("","title",'http://127.0.0.1:8000');
                window.location.href = 'http://127.0.0.1:8000';
                e.preventDefault();
                $('html, body').animate({
                scrollTop: $("#homepage").offset().top
                },1500);
            });
        });

        window.onload = function () {
            document.getElementById("enquiry").onclick = function () {
                var e = document.getElementById("enquiry-popup");
                var f = document.getElementById("enquiry-popup-form");
                e.style.display = "block";
                f.style.display = "block";
            };
            document.getElementById("experience").onclick = function () {
                var g = document.getElementById("experience-popup");
                var h = document.getElementById("experience-popup-form");
                g.style.display = "block";
                h.style.display = "block";
            };
            document.getElementById("clos").onclick = function () {
                var e = document.getElementById("enquiry-popup");
                var f = document.getElementById("enquiry-popup-form");
                var g = document.getElementById("experience-popup");
                var h = document.getElementById("experience-popup-form");
                e.style.display = "none";
                f.style.display = "none";
                g.style.display = "none";
                h.style.display = "none";
            };
        }

    </script>
</body>
</html>