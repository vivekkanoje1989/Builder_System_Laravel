<style>
    .span9 {
    padding-top: 8%;
}
.bx-wrapper #clint-slider  img
{
    width:104px !important;
}
</style>
@extends('layouts/frontend/mantravastu/main')
@section('content')
<main class="main-content"  ng-init="getProjects(); getPostsDropdown(); getTestimonials(); getAboutPageContent(); getEmployees(); getCareers(); getPostsDropdown(); getContactDetails();" ng-controller="AppCtrl">
    <!-- Start home section -->
    <div id="homepage" class="centered">
        <!-- Start cSlider -->
        <ul class="bxslider">
            <li><img src="frontend/mantravastu/images/banner1.jpg"  title="Funky roots"/></li>
            <li><img src="frontend/mantravastu/images/banner2.jpg"  title="Funky roots"/></li>
            <li><img src="frontend/mantravastu/images/banner3.jpg"  title="Funky roots"/></li>
        </ul>

    </div>
    <!-- End home section -->
    <!-- projects section start -->
    <div class="section primary-section" id="projects">
        <div class="container">
            <!-- Start title section -->
            <div class="title">
                <h1>Projects</h1>
            </div>
            <div class="">
                <div class="span4"  ng-repeat="list in current">
                    <h3>Currents Projects</h3>
                    <div class="centered projects">
                        <div class="zoom-in">
                            <img class="img-responsive" src="[[config('global.s3Path')]]/project/project_logo/{{list.project_logo}}"  alt="projects 1">
                        </div>
                        <h3>{{list.project_name}}</h3>
                        <p>{{list.short_description|htmlToPlaintext | limitTo : 15}}{{list.short_description.length > 15? '': '...'}}</p>
                        <a href="/projects" class="btn">Read more</a>
                    </div>
                </div>            
            </div>
            
        </div>
    </div>
    <!-- projects section end -->

    <!-- About us section start -->
    <div class="section secondary-section" id="aboutus">
        <div class="triangle"></div>
        <div class="container">
            <div class="about-text">
                <div class="title">
                    <h1>About Us</h1>
                </div>
                <p>{{aboutUs.page_content| htmlToPlaintext}}</p>
            </div>
            <div class="row-fluid centered" id="abt">
                <figure>
                <img src="frontend/mantra_vastu/images/sample.jpg" class="img-responsive" alt="" />
                </figure>
            </div>
            <div class="about-text">
                <p>Today, ABC Builders is one of the leading and reputed property developers headquartered in Pune, primarily focused on residential and contractual projects. </p>
                <h3>Mission</h3>
                <p>ABC Builders was set up in 1999, under the Chairmanship of Babasaheb Atkire with property development as its main focus. Growing swiftly to become the leading property developers in Pune, ABC Builders successfully created a niche as preferred building partners for some of the global corporate clients and has been the Benchmark builder and is growing in all facets of industry. </p>
                <h3>Vision</h3>
                <p>ABC Builders was set up in 1999, under the Chairmanship of Babasaheb Atkire with property development as its main focus. Growing swiftly to become the leading property developers in Pune, ABC Builders successfully created a niche as preferred building partners for some of the global corporate clients and has been the Benchmark builder and is growing in all facets of industry. </p>
                <h3>Vision</h3>
                <p>ABC Builders was set up in 1999, under the Chairmanship of Babasaheb Atkire with property development as its main focus. Growing swiftly to become the leading property developers in Pune, ABC Builders successfully created a niche as preferred building partners for some of the global corporate clients and has been the Benchmark builder and is growing in all facets of industry. </p>
                <h3>Vision</h3>
                <p>ABC Builders was set up in 1999, under the Chairmanship of Babasaheb Atkire with property development as its main focus. Growing swiftly to become the leading property developers in Pune, ABC Builders successfully created a niche as preferred building partners for some of the global corporate clients and has been the Benchmark builder and is growing in all facets of industry. </p>

                <div class="sub-section">
                    <div class="title clearfix">
                        <div class="pull-left">
                            <h3>Meet Our Team</h3>
                        </div>
                        <ul class="client-nav pull-right">
                            <li id="client-prev"></li>
                            <li id="client-next"></li>
                        </ul>
                    </div>
                    <ul class="row client-slider" id="clint-slider">                    
                        <li style="float: left; list-style: none; position: relative; width: 210px; margin-right: 25px;" class="bx-clone" aria-hidden="true" ng-repeat="emp in employee | limitTo:8">
                            <a href="">
                                <img src="https://storage.googleapis.com/bkt_bms_laravel/employee-photos/{{ emp.employee_photo_file_name}}" class="img-responsive img-circle" alt="" style="display:block;">
                            </a>
                            <h3>{{ emp.first_name }} {{ emp.last_name }}</h3>
                            <p>{{ emp.designation }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- About us section end -->
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
                                <img ng-if="photo_url != null " src="[[config('global.s3Path')]]/Testimonial/{{ photo_url}}" alt="https://furtaev.ru/preview/user_3_small.png" class="img-circle centered" alt="client 1">
                                <img ng-if="photo_url == null " src="https://furtaev.ru/preview/user_3_small.png" class="img-circle centered" alt="client 1">
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
    <!-- Newsletter section start -->
    <div class="section third-section" id="careersdata">
        <div class="container newsletter">
            <div class="title">
                <h1>Careers</h1>
            </div>
            <div class="sub-section">
                <div class="title1">
                    <h3>Current Openings</h3>
                </div>
            </div>
            <div>
                <div class="span6" ng-repeat="list in careers">
                    <p>{{ list.job_title}}</p>
                    <!--<p>{{ list.job_eligibility}}</p>-->
                    <p> Eligibility Criteria: <span>BE / B-Tech</span></p>
                    <p> Location: <span>{{list.job_locations}}</span></p>
                    <p> Job Posted Date: <span>{{ list.application_start_date }}</span></p>
                    <p> Job Application Closed by: <span>{{ list.application_close_date}}</span></p>
                    <a id="job-apply" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">Apply now</a>
                    <hr>
                </div>
            </div>
<!--            <div class="row-fluid">
                <div class="span6">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                    <p> Eligibility Criteria: <span>BE / B-Tech</span></p>
                    <p> Job Posted Date: <span>23 /06 /2015</span></p>
                    <p> Job Application Closed by: <span>23 /06 /2015</span></p>
                    <a id="job-apply" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">Apply now</a>
                    <hr>
                </div>

                <div class="span6">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                    <p> Eligibility Criteria: <span>BE / B-Tech</span></p>
                    <p> Job Posted Date: <span>23 /06 /2015</span></p>
                    <p> Job Application Closed by: <span>23 /06 /2015</span></p>
                    <a id="job-apply-2" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">Apply now</a>
                    <hr>
                </div>       
            </div>-->
        </div>
    </div>
    <!-- Newsletter section end -->
    <!-- Contact section start -->
    <div id="contact" class="contact">
        <div class="section secondary-section">
            <div class="container">
                <div class="title">
                    <h1>Contact Us</h1>
                </div>
            </div>
            <div class="map-wrapper">
                <div class="map-canvas" id="map-canvas">Loading map...</div>
                <div class="container">
                    <div class="row-fluid">
                        <div class="span5 contact-form centered">
                            <div id="successSend" class="alert alert-success invisible">
                                <strong>Well done!</strong>Your message has been sent.</div>
                            <div id="errorSend" class="alert alert-error invisible">There was an error.</div>
                            <form  name="contactFormdata" action="">
                                <input type="hidden" ng-model="userForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="userForm.csrfToken = '<?php echo csrf_token(); ?>'"  class="form-control">
                                <div class="control-group">
                                    <div class="controls">
                                        <input class="span12" type="text" id="fname" name="fname" placeholder="* Your name..." />
                                        <div class="error left-align" id="err-name">Please enter name.</div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input class="span12" type="email" name="emailid" id="emailid" placeholder="* Your email..." />
                                        <div class="error left-align" id="err-email">Please enter valid email adress.</div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input class="span12" type="text" id="mobile" pattern="\d{10
                                               -}"  maxlength="10" name="mobile" placeholder="* Your Mobile number..." />
                                        <div class="error left-align" id="err-mobile">Please enter mobile.</div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <textarea class="span12" name="message" id="message" placeholder="* Message..."></textarea>
                                        <div class="error left-align" id="err-message">Please enter your Message here.</div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="error left-align" id="err-all">Please enter valid information.</div>
                                        <button id="send-mail" type="button" class="message-btn" onclick="contactUs()">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                            <a href="https://www.facebook.com/mantravpl" target="_blank">
                                <span class="icon-facebook-circled"></span>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/JahagirdarD" target="_blank">
                                <span class="icon-twitter-circled"></span>
                            </a>
                        </li>
                        <li>
                            <a href="https://in.linkedin.com/in/dineshjahagirdar" target="_blank">
                                <span class="icon-linkedin-circled"></span>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.pinterest.com/Mantra_vastu/" target="_blank">
                                <span class="icon-pinterest-circled"></span>
                            </a>
                        </li>
                        <li>
                            <a href="" target="_blank">
                                <span class="icon-dribbble-circled"></span>
                            </a>
                        </li>
                        <li>
                            <a href="https://plus.google.com/111989364413040119355" target="_blank">
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
            <a href="" class="close" id="clos"><img src="frontend/mantravastu/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
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

                <!--            <div>
                                Captcha Image*
                                <div><img id="captchaimg5" style="padding: 0 0 0 5px;" src="http://www.e-dynamics.in/reb/captcha_code_file.php?rand=1265139648&amp;name=enquiry_captcha">
                                    <div style="padding: 0 0 0 5px;">
                                        Click <a class="here" href="javascript: refreshCaptcha(&quot;captchaimg5&quot;);">here</a> to refresh
                                    </div> 
                                </div>
                            </div>-->
                <!--            <p class="enquiry-input">
                                <input id="txtCaptcha" name="txtCaptcha" value="" type="text" autocomplete="on" placeholder="Captcha">
                            </p>-->


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
            <a href="" class="close" id="clos"><img src="frontend/mantravastu/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
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

                <!--            <div>
                                Captcha Image*
                                <div><img id="captchaimg5" style="padding: 0 0 0 5px;" src="http://www.e-dynamics.in/reb/captcha_code_file.php?rand=1265139648&amp;name=experience_captcha">
                                    <div style="padding: 0 0 0 5px;">
                                        Click <a class="here" href="javascript: refreshCaptcha(&quot;captchaimg5&quot;);">here</a> to refresh
                                    </div> 
                                </div>
                            </div>
                            <p class="experience-input">
                                <input id="txtCaptcha" name="txtCaptcha" value="" type="text" autocomplete="on" placeholder="Captcha">
                            </p>-->


                <p class="experience-submit">
                    <input type="submit" value="Send Message">
                </p>
            </fieldset>
        </form>

    </div>
    <!-- Share your experience ends here -->

    <!-- Apply for Job Pop up -->

    <div id="job-apply-popup">
        <form action="" class="job-apply" id="job-apply-popup-form">
            <h4> Fill the form to Apply</h4>
            <a href="" class="close" id="clos"><img src="frontend/mantravastu/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
            <fieldset class="job-apply-inner">
                <p class="job-apply-input">
                    <input type="text" name="Fname" placeholder="Your First Name…" autofocus>
                </p>

                <p class="job-apply-input">
                    <input type="text" name="Lname" placeholder="Your Last Name…" autofocus>
                </p>

                <p class="job-apply-input">
                    <input type="phone" name="phone" placeholder="Your Mobile Number" autofocus>
                </p>

                <p class="job-apply-input">
                    <input type="email" name="email" placeholder="Your Email" autofocus>
                </p>

                Upload Your CV
                <p class="job-apply-input">      	
                    <input id="uploadcv" name="uploadcv" value="" autocomplete="on" placeholder="Upload CV" type="file" autofocus>
                </p>

                Upload Your Photo
                <p class="job-apply-input">
                    <input id="uploadimg" name="uploadimg" value="" autocomplete="on" placeholder="Upload Your Photo" type="file" autofocus>
                </p>

                <!--            <div>
                                Captcha Image*
                                <div><img id="captchaimg5" style="padding: 0 0 0 5px;" src="http://www.e-dynamics.in/reb/captcha_code_file.php?rand=1265139648&amp;name=job-apply_captcha">
                                    <div style="padding: 0 0 0 5px;">
                                        Click <a class="here" href="javascript: refreshCaptcha(&quot;captchaimg5&quot;);">here</a> to refresh
                                    </div> 
                                </div>
                            </div>
                            <p class="job-apply-input">
                                <input id="txtCaptcha" name="txtCaptcha" value="" type="text" autocomplete="on" placeholder="Captcha">
                            </p>-->


                <p class="job-apply-submit">
                    <input type="submit" value="Send Message">
                </p>
            </fieldset>
        </form>
    </div>
    <!-- Apply for Job Pop up ends here-->

    <!-- Footer section start -->
    <div class="footer">
        <p><img src="frontend/mantravastu/images/favicon.jpg" alt="e-dynamics" width="32" height="32" border="0" class="ftr-logo"> &copy; 2015 ABC BUILDER</p>
    </div>
    <!-- Footer section end -->
    <!-- ScrollUp button start -->
    <div class="scrollup">
        <a href="#">
            <i class="icon-up-open"></i>
        </a>
    </div>
</main>
@endsection()

