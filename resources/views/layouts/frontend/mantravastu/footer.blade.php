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
                                    <div class="g-recaptcha" data-sitekey="6LcIDDcUAAAAAEzlU702L0_99cDqkYaXsZxDO42C"></div>  
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
<!-- Contact section end -->


</main>
<!-- share your Experience -->
<div id="experience-popup" class="black_overlay">
    <form action="" class="experience" id="experience-popup-form" method="post" onsubmit="createTestimonial()" enctype="multipart/form-data">
        <h4> experience for Property</h4>
        <a href="" class="close" id="clos"><img src="frontend/mantravastu/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
        <fieldset class="experience-inner">
            <p class="experience-input">
                <input type="text" name="CustFname" id="CustFname" placeholder="Your First Name…" autofocus>
                <span class="error left-align" id="err-fname">Please enter first name.</span>
            </p>

            <p class="experience-input">
                <input type="text" name="CustLname" id="CustLname" placeholder="Your Last Name…" autofocus>
                <span class="error left-align" id="err-lname">Please enter last name.</span>
            </p>

            <p class="experience-input">
                <input type="phone" name="mobile_num" id="mobile_num" placeholder="Your Mobile Number" maxlength="10" autofocus>
                <span class="error left-align" id="err-mobile">Please enter mobile number.</span>
            </p>
            <p class="experience-input">
                <input type="email" name="email_id" id="email_id" placeholder="Your Email" autofocus>
                <span class="error left-align" id="err-email">Please enter email.</span>
            </p>
            Upload Your Photo
            <p class="experience-input">
                <input id="uploadimg" name="image" autocomplete="on" placeholder="Upload Your Photo" type="file" autofocus>
                <span class="error left-align" id="err-file">Please upload profile.</span>
            </p>
            <p class="experience-input">
                <textarea name="descriptiondata" id="descriptiondata" placeholder="Your Experience…"></textarea>
            </p>
            <div>
                Captcha Image*
                <div class="g-recaptcha" data-sitekey="6LcIDDcUAAAAAEzlU702L0_99cDqkYaXsZxDO42C"></div>
                <span class="error left-align" id="err-capcha">Please enter name.</span>
            </div>
            <span style="color:red;" id="all-err"></span>
            <p class="experience-submit">
                <input type="submit" id="experienceMessageBtn" value="Send Message">
            </p>
        </fieldset>
    </form>
</div>
<!-- Share your experience ends here -->

<!--enquiry pop up start-->
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
            <div>
                Captcha Image*
                <div class="g-recaptcha" data-sitekey="6LcIDDcUAAAAAEzlU702L0_99cDqkYaXsZxDO42C"></div>
            </div>            
            <p class="enquiry-submit">
                <input type="submit" value="Send Message">
            </p>
        </fieldset>
    </form>
</div>
<!--enquiry pop up end here -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="frontend/mantravastu/js/jquery.js"></script>
<script type="text/javascript">
                    $(document).ready(function () {
                        $('.bxslider').bxSlider({
                            mode: 'fade',
                            captions: true,
                            auto: true,
                            //  autoControls: true,
                        });
                    });
</script>
<script>
            window.onload = function () {
                document.getElementById("enquiry").onclick = function () {
                    var e = document.getElementById("enquiry-popup");
                    var f = document.getElementById("enquiry-popup-form");
                    e.style.display = "block";
                    f.style.display = "block";
                };

                document.getElementById("experience").onclick = function () {
                    var a = document.getElementById("experience-popup");
                    var b = document.getElementById("experience-popup-form");
                    a.style.display = "block";
                    b.style.display = "block";
                };
                document.getElementById("job-apply").onclick = function () {
                    var g = document.getElementById("job-apply-popup");
                    var h = document.getElementById("job-apply-popup-form");
                    g.style.display = "block";
                    h.style.display = "block";
                };
                document.getElementById("job-apply-2").onclick = function () {
                    var g = document.getElementById("job-apply-popup");
                    var h = document.getElementById("job-apply-popup-form");
                    g.style.display = "block";
                    h.style.display = "block";
                };
                document.getElementById("clos").onclick = function () {
                    var e = document.getElementById("enquiry-popup");
                    var f = document.getElementById("enquiry-popup-form");
                    var g = document.getElementById("job-apply-popup");
                    var h = document.getElementById("job-apply-popup-form");
                    var a = document.getElementById("experience-popup");
                    var b = document.getElementById("experience-popup-form");
                    e.style.display = "none";
                    f.style.display = "none";
                    g.style.display = "none";
                    h.style.display = "none";
                    a.style.display = "none";
                    b.style.display = "none";
                };
            }

</script> 

<script>
            window.onload = function () {
                document.getElementById("enquiry").onclick = function () {
                    var e = document.getElementById("enquiry-popup");
                    var f = document.getElementById("enquiry-popup-form");
                    e.style.display = "block";
                    f.style.display = "block";
                };
                document.getElementById("enquiry2").onclick = function () {
                    var e = document.getElementById("enquiry-popup");
                    var f = document.getElementById("enquiry-popup-form");
                    e.style.display = "block";
                    f.style.display = "block";
                };
                document.getElementById("enquiry3").onclick = function () {
                    var e = document.getElementById("enquiry-popup");
                    var f = document.getElementById("enquiry-popup-form");
                    e.style.display = "block";
                    f.style.display = "block";
                };
                document.getElementById("clos").onclick = function () {
                    var e = document.getElementById("enquiry-popup");
                    var f = document.getElementById("enquiry-popup-form");
                    e.style.display = "none";
                    f.style.display = "none";
                };
            }
</script>
<!-- jQuery library (served from Google) -->
<!-- bxSlider Javascript file -->
<script src="frontend/mantravastu/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.mixitup.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/bootstrap.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/modernizr.custom.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.cslider.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.inview.js"></script>
<!-- Load google maps api and call initializeMap function defined in app.js -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;callback=initializeMap"></script>
 <!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuqQhrzarB8fb-kP-hTrwKNsbk1ifF4f0&callback=initMap" type="text/javascript"></script>-->
<!-- css3-mediaqueries.js for IE8 or older -->
<!--[if lt IE 9]-->
<script src="frontend/mantravastu/js/respond.min.js"></script>
<!--[endif]-->
<script type="text/javascript" src="frontend/mantravastu/js/app.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.scrollTo.js"></script>
</body>
</html>