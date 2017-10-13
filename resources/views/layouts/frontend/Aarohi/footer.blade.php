<?php
$url = Yii::app()->theme->baseUrl;
$action = Yii::app()->controller->action->id;
$contact1 = Contactus::model()->findByAttributes(array('id' => 1));
$about = Pages::model()->findByPk(1);
?>
<!-- Footer section start -->
<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 footer-box wow fadeInUp">
                <center><h4>Contact Us</h4></center>
                <?php if (!empty($contact1) && $contact1->address != null) {
                    ?>
                    <div class="col-sm-4 footer-box wow fadeInUp">
                        <div class="footer-box-text">
                            <div class="footer-box-text footer-box-text-contact">
                                <p><i class="fa fa-map-marker"></i> Address: <?php echo $contact1->address; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 footer-box wow fadeInUp">
                        <div class="footer-box-text footer-box-text-contact">
                            <p><i class="fa fa-phone"></i> Phone: <?php echo $contact1->telephone; ?></p>
                        </div>
                    </div>
                    <div class="col-sm-4 footer-box wow fadeInUp">
                        <div class="footer-box-text footer-box-text-contact">
                            <p><i class="fa fa-envelope"></i> Email: <a href=""><?php echo $contact1->email; ?></a></p>
                        </div>
                    </div>
                    <?php }
                ?>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 wow fadeIn">
                    <div class="footer-border"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-7 footer-copyright wow fadeIn">

                    <p>
                        <a href="http://www.edynamics.co.in" target="_blank">									
                            <img src="<?php echo EDYNAMICS_COMPANY_LOGO; ?>" alt="e-dynamics"/> 
                        </a>
                        <?php $year = date('Y');
                        echo 'All Rights Reserved & copy ' . "$year " . LEGAL_NAME;
                        ?></p>


                </div>
                <div class="col-sm-5 footer-social wow fadeIn">
                    <?php if ($this->FACEBOOK->status == 1) { ?>   <a target="_blank" href="<?php echo $this->FACEBOOK->link; ?>"><i class="fa fa-facebook"></i></a><?php } ?>
                    <?php if ($this->YOUTUBE->status == 1) { ?>	<a href="<?php echo $this->YOUTUBE->link; ?>" target="_blank"><i class="fa fa-youtube"></i></a><?php } ?>
                    <?php if ($this->LINKEDIN->status == 1) { ?> <a href="<?php echo $this->LINKEDIN->link; ?>" target="_blank"><i class="fa fa-linkedin"></i></a> <?php } ?>
                    <?php if ($this->TWITTER->status == 1) { ?>  <a href="<?php echo $this->GOOGLE->link; ?>" target="_blank"><i class="fa fa-twitter"></i></a> <?php } ?>
                    <?php if ($this->GOOGLE->status == 1) { ?><a href="<?php echo $this->TWITTER->link; ?>" target="_blank"><i class="fa fa-google"></i></a> <?php } ?>
<?php if ($this->PINTEREST->status == 1) { ?> <a href="<?php echo $this->PINTEREST->link; ?>" target="_blank"><i class="fa fa-pinterest"></i></a><?php } ?>

                </div>
            </div>
        </div>
</footer>


<!--Google Analytics Code--->
<?php
$path = Yii::app()->basePath . '/../common/php/google_analytics.php';
require($path);
?>
<!---end the googl analytics code--->	
<!-- Javascript -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Javascript -->
<script src="frontend/Aarohi/assets/js/jquery-1.11.1.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="frontend/Aarohi/assets/js/jquery.bxslider.min.js"></script>
<script src="frontend/Aarohi/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="frontend/Aarohi/assets/js/bootstrap-hover-dropdown.min.js"></script>
<script src="frontend/Aarohi/assets/js/jquery.backstretch.min.js"></script>
<script src="frontend/Aarohi/assets/js/wow.min.js"></script>
<script src="frontend/Aarohi/assets/js/retina-1.1.0.min.js"></script>
<script src="frontend/Aarohi/assets/js/jquery.magnific-popup.min.js"></script>
<script src="frontend/Aarohi/assets/flexslider/jquery.flexslider-min.js"></script>
<script src="frontend/Aarohi/assets/js/masonry.pkgd.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="frontend/Aarohi/assets/js/jquery.ui.map.min.js"></script>
<script src="frontend/Aarohi/assets/js/scripts.js"></script>    

<?php
//if($action=='projectdetails'){
?>
<link href="frontend/Aarohi/assets/css/ekko-lightbox.css" rel="stylesheet">	
<script src="frontend/Aarohi/assets/js/ekko-lightbox.js"></script>
<?php
//}
?>
</body>

</html>
<!-- Footer section end -->

<!-- Included the External Contact Us Jquery file--> 

<script type="text/javascript">
    var baseURL = "<?php echo Yii::app()->getBaseUrl(true); ?>";
</script>
<!--                <script src="<?php echo Yii::app()->baseUrl; ?>/common/js/testimonials.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/common/js/contactus.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/common/js/careers.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/common/js/common.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/common/js/projects.js"></script>-->
<script src="<?php echo Yii::app()->baseUrl; ?>/common/assets/js/testimonials.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/common/assets/js/brochuer.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/common/assets/js/contactus.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/common/assets/js/careers.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/common/assets/js/common.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/common/assets/js/projects.js" type="text/javascript"></script>
<!-- End -->


<?php
$popup = Yii::app()->basePath . '/../common/php/popup.php';
require($popup);
?>
 

<script type="text/javascript">
    $(document).ready(function () {

        $('.bxslider').bxSlider({
            pager: false,
            mode: 'fade',
            captions: false,
            auto: true,
            autoControls: true
        });

        $('.experience1').on('click', function () {
            $('#experience-popup').attr('style', 'display:block');
            $('#testimonialsform').attr('style', 'display:block');
        });
        $('.close').on('click', function () {
            $('#experience-popup').attr('style', 'display:none');
            $('#testimonialsform').attr('style', 'display:none');
        });

        $('.job-apply1').on('click', function () {
            $('#resumeform').attr('style', 'display:block');
            $('#resumeform').attr('style', 'display:block');
        });
        $('.close').on('click', function () {
            $('#resumeform').attr('style', 'display:none');
            $('#resumeform').attr('style', 'display:none');
        });

        $('.enquiry1').on('click', function () {
            $('#enquiry-popup').attr('style', 'display:block');
            $('#enquiryform').attr('style', 'display:block');
        });
        $('.close').on('click', function () {
            $('#enquiry-popup').attr('style', 'display:none');
            $('#enquiryform').attr('style', 'display:none');
        });


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

<style>
    .resume_error {
        color: red!important;
        font-size: 13px;
    }
</style>

<style>
    #msg{
        color: #006400;   
    }
</style>

<div id="job-apply-popup">

    <form class="job-apply" id="resumeform" method="post"  name='Recruitment' enctype="multipart/form-data">
                            <p id="msg" style="display:none;">Form Submited Successfully </p>

        <h4> Fill the form to Apply</h4>
        <a href="javascript:void(0);" class="close" id="clos"><img src="<?php echo $url; ?>/assets/img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
        <fieldset class="job-apply-inner">
            <p class="job-apply-input">
                <input id='r_firstname' type="text" name="Recruitment[r_firstname]"  placeholder="Your First Name…" onkeyup="$(this).val(capital($(this).val()))" onkeypress='onlychar(event)' autofocus>
                        <span id="r_firstname_error" class="resume_error"></span>

            </p>

            <p class="job-apply-input">
                <input id='r_lastname' type="text" name="Recruitment[r_lastname]" placeholder="Your Last Name…" onkeyup="$(this).val(capital($(this).val()))" onkeypress='onlychar(event)' autofocus>
                          <span id="r_lastname_error" class="resume_error"></span>

            </p>

            <p class="job-apply-input">
                <input id='r_mobile' type="phone" name="Recruitment[r_mobile]" onkeypress='onlynum(event)' placeholder="Your Mobile Number" autofocus>
                                <span id="r_mobile_error" class="resume_error"></span>

            </p>

            <p class="job-apply-input">
                <input id='r_email' type="email" name="Recruitment[r_email]" placeholder="Your Email" autofocus>
                                <span id="r_email_error" class="resume_error"></span>

            </p>
<p>
                <?php
                $criteria = new CDbCriteria;
                $currentdate = date('Y-m-d');
                $criteria->addCondition('app_closing_date >="' . $currentdate . '" ');
                $criteria->addCondition('display_portal = 1');
                $carrier = JobPosting::model()->findAll($criteria);
                $list = CHtml::listData(JobPosting::model()->findAll($criteria), 'id', 'job_title');
                echo CHtml::dropDownList('job_id', 'job_id', $list, array('empty' => '-- Select Position --', 'class' => 'field-input selectsize'));
                ?>
                <span id="job_id_error" class="resume_error"></span>
        </p>
        <p style="text-align:left">    Upload Your CV</p>
            <p class="job-apply-input">      	
                <input id='r_resume' name="JobApplicants[r_resume]" value="" autocomplete="on" placeholder="Upload CV" type="file" autofocus>
                <span id="r_resume_error" class="resume_error"></span>


            </p>
<!--            <p style="text-align:left">             Upload Your Photo
</p>
            <p class="job-apply-input">
                <input id="r_photo" name="JobApplicants[r_photo]" value="" autocomplete="on" placeholder="Upload Your Photo" type="hidden" autofocus>
            </p>-->

            <div>
                Captcha Image*

                <div><img id="resume_captcha" style="padding: 0 0 0 5px;width:150px;height:50px;" src="<?php echo Yii::app()->getBaseUrl(true); ?>/captcha_code_file.php?rand=<?php echo rand(); ?>&name=resume_captcha">
                    <div style="padding: 0 0 0 5px;">Click <a class="here" href="javascript: refreshCaptcha('resume_captcha');" style="color: #2778bf;">here</a> to refresh</div> 
                </div>											
            </div>
            <p class="job-apply-input">
                <input id="resume_captchatxt" name="resume_captchatxt" value="" type="text" autocomplete="on" placeholder="Your Answer">
                <span id="resume_captchatxt_error" class="resume_error">

            </p>

            <input type='hidden' id='job_id' name="job_id">
            <p class="job-apply-submit">
<!--            <center><span id="wait_resume" style="color:black;">Please Wait</span> <div id="loading_resume" style=""><img id="loadimg_resume" src="<?php echo Yii::app()->baseUrl; ?>/common/images/loading.gif" alt=""  /></div></center>-->
            <button id='sbt_resume' class="btn" type="button">Send Message</button>

            </p>
        </fieldset>
    </form>
</div>

<!-- share your Experience -->
<div id="experience-popup">
    <form method="post"  id="testimonialsform" name="Testimonials" enctype="multipart/form-data"  class="experience" id="experience-popup-form">

          <p id="msg" style="display:none;">Form Submited Successfully </p>

        <h4> Experience for Property</h4>
        <a href="javascript:void(0);" class="close" id="clos"><img src="<?php echo $url; ?>/assets/img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
        <fieldset class="experience-inner">
            <p class="experience-input">
                <input type="phone" id="test_mobile" name="Testimonials[mobile]" onkeypress='onlynum(event)' placeholder="Your Mobile Number" autofocus>
                                                    <span class="testmonial_error" id="test_mobile_error"></span>

            </p>
            <p class="experience-input">
                <input type="text" id="test_firstname" name="Testimonials[first_name]" placeholder="Your First Name…" onkeyup="$(this).val(capital($(this).val()))" onkeypress='onlychar(event)' autofocus>
                                                  <span class="testmonial_error" id="test_firstname_error"></span>

            </p>

            <p class="experience-input">
                <input type="text" id="test_lastname" name="Testimonials[last_name]" placeholder="Your Last Name…" onkeyup="$(this).val(capital($(this).val()))" onkeypress='onlychar(event)' autofocus>
                                                  <span class="testmonial_error" id="test_lastname_error"></span>

            </p>
            <p class="experience-input">
                <input type="phone" id="test_cname" name="Testimonials[company_name]" placeholder="Company Name" autofocus>
                                                        <span class="testmonial_error" id="test_cname_error"></span>

            </p>


            <p class="experience-input"> Upload Your Photo</p>
            <p class="experience-input">
                <input id="test_pic" name="Testimonials[userpic]" value="" autocomplete="on" placeholder="Upload Your Photo" type="file" autofocus>
                                                        <span class="testmonial_error" id="test_pic_error"></span>

            </p>

            <p class="experience-input">
                <textarea name="Testimonials[experience]" id="test_exp" placeholder="Your Experience…"></textarea>
                      <span class="testmonial_error" id="test_exp_error"></span>

            </p>

            <div>
                Captcha Image*
                <div>
                    <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/captcha_code_file.php?rand=<?php echo rand(); ?>&name=testimonial_captcha" style="padding: 0 0 0 5px;width:150px;height:50px" id='testimonial_captcha'>
                    <div style="padding: 0 0 0 5px;">Click <a href='javascript: refreshCaptcha("testimonial_captcha");' style="color:blue">here</a> to refresh</div>
                </div>
            </div>
            <p class="experience-input">
                <input id="captchatxt" name="captchaValue" value="" type="text" autocomplete="on" placeholder="Captcha">
                     <span class="testmonial_error" id="captchatxt_error"></span>
            </p>

            <p class="experience-submit">
<!--            <center><span id="wait_test" style="color:black;">Please Wait</span> <div id="loading_test"><img id="loadimg_test" src="<?php echo Yii::app()->baseUrl; ?>/common/images/loading.gif" alt="" /></div></center>-->
            <button id='submit_testimonials' type="button" class='btn'>Send Message</button>
            </p>
        </fieldset>
    </form>
</div> 

<style>
    #pmsg{
        color: #006400;   
    }
    .prjt_error
    {
        color: red!important;
    }
  
</style>
<div id="enquiry-popup">
    <form action="" class="enquiry" id="enquiryform">
                                    <p id="pmsg" style="display:none;">Form Submited Successfully </p>
        <h4>Enquiry for Property</h4>
        <a href="" class="close" id="clos"><img src="<?php echo $url; ?>/assets/img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
        <fieldset class="enquiry-inner">
            <p class="enquiry-input">
                <input type="text" id="first_name" name="txtFirstName" placeholder="Your First Name…"  onkeyup=" $(this).val(capital($(this).val()));" onkeypress="onlychar(event);" autofocus>
                                      <span id="first_name_error" class="prjt_error"></span>

            </p>

            <p class="enquiry-input">
                <input type="text" id="last_name" name="txtLastName" placeholder="Your Last Name…"  onkeyup=" $(this).val(capital($(this).val()));" onkeypress="onlychar(event);" autofocus>
                                      <span id="last_name_error" class="prjt_error" ></span>

            </p>

            <p class="enquiry-input">
                <input type="phone" id="mobile_no" name="phone" placeholder="Your Mobile Number" onkeypress='onlynum(event)' autofocus>
                                            <span id="mobile_no_error" class="prjt_error" ></span>

            </p>

            <p class="enquiry-input">
                <input id="email_id" type="email" name="email" placeholder="Your Email" autofocus>
                                            <span id="email_id_error" class="prjt_error" ></span>

            </p>

            <p class="enquiry-input">
                <textarea name="txtRemarks" id="comment" onkeypress='$(this).val(capitaliseFirstLetter($(this).val()))' placeholder="Your Remark…"></textarea>
                                            <span id="comment_error" class="prjt_error" ></span>

            </p>

            <div>
                Captcha Image*

                <div><img id="enq_captcha" style="padding: 0 0 0 5px;width:150px;height:50px;" src="<?php echo Yii::app()->getBaseUrl(true); ?>/captcha_code_file.php?rand=<?php echo rand(); ?>&name=enq_captcha">
                    <div style="padding: 0 0 0 5px;">Click <a href="javascript: refreshCaptcha('enq_captcha');" style="color:#3d3d3d;">here</a> to refresh</div> 
                </div>

            </div>
            <p class="enquiry-input">
                <input id="captcha_value" name="txtCaptcha"  value="" type="text" autocomplete="on" placeholder="Captcha">
                                            <span id="captcha_value_error" class="prjt_error" ></span>

            </p>
            <input type="hidden" name="hid_property_id" id="hid_property_id" value="">
            <input type="hidden" name="hid_project_id" id="hid_project_id" value="<?php echo $project_info->id; ?>">
            <input type="hidden" name="hid_block_id" id="hid_block_id" value="">   
            <p class="enquiry-submit">
<!--            <center><span id="wait_project" style="color:black;">Please Wait</span> <div id="loading_resume" style=""><img id="loadimg_project" src="<?php echo Yii::app()->baseUrl; ?>/common/images/loading.gif" alt=""  /></div></center>-->
            <button name="enq_sbt" id="enq_sbt" class='btn' type="button">Send Message</button>
            </p>
            <label>
                <div id="success" style="display:none; font-size: 10; color:red">Thank You for expressing your Interest.<br>
                    We will contact you soon.</div>
            </label> 


        </fieldset>
    </form>
</div>
<style>
    .testmonial_error{
        
        color:red !important;
    }
    </style>