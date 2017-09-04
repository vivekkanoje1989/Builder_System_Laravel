@extends('layouts/frontend/theme31/main')
@section('content')
<style>
    .err{
        color:red;
    }
</style>
<div class="content-area" ng-controller="webAppController">
    <section id="blog-posts" class="page-section" ng-init="getPostsDropdown()">
        <div class="container">
            <h2 class="section-title wow fadeInDown" data-wow-offset="200" data-wow-delay="100ms">
                <small>It's A Smart Move With HomeSmart!</small>
                <span>Career With Us</span>
            </h2>
            <div class="row row-centered">
                <?php
                for ($i = 0; $i < count($carrier); $i++) {
                    ?>
                    <div class="col-md-6 col-xs-12 wow fadeInLeft col-centered" data-wow-offset="200" data-wow-delay="200ms">
                        <div class="recent-post alt">
                            <div class="media">
                                <div class="media-left">
                                    <div class="meta-date">
                                        <div class="day"><i class="fa fa-asterisk fa-spin"></i></div>
                                        <div class="month">Job</div>
                                    </div>
                                </div>

                                <div class="media-body">
                                    <h4 class="media-heading"><a href="#"><?php echo $carrier[$i]['job_title']; ?></a></h4>
                                    <div class="media-excerpt">
                                        <p><b>Eligibility criteria &nbsp;:&nbsp;</b><?php echo $carrier[$i]['job_eligibility']; ?></p>
                                        <p><b> Job Posting Date&nbsp;:&nbsp;</b><?php echo $carrier[$i]['application_start_date']; ?> </p>
                                        <p><b> Application Closed by&nbsp;:&nbsp;</b><?php echo $carrier[$i]['application_close_date']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-6 col-xs-12 wow fadeInLeft col-centered" data-wow-offset="200" data-wow-delay="200ms">
                    <div class="recent-post alt">
                        <div class="media">
                            <div class="media-left">
                                <div class="meta-date">
                                    <div class="day"><i class="fa fa-asterisk fa-spin"></i></div>
                                    <div class="month">Job</div>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#">Asst. Sales Manager</a></h4>
                                <div class="media-excerpt">
                                    <p><b>Eligibility criteria &nbsp;:&nbsp;</b>PGDM / MBA (Marketing) from reputed B-School. -Excellent oral and written communication skills. -Ability to work under pressure. -Good General Knowledge. -Should be willing to travel extensively. </p>
                                    <p><b> Job Posting Date&nbsp;:&nbsp;</b>09-03-2015 </p>
                                    <p><b> Application Closed by&nbsp;:&nbsp;</b>26-10-2016 </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center margin-top wow fadeInDown" data-wow-offset="200" data-wow-delay="100ms">
                <h2 class="section-title wow fadeInDown" data-wow-offset="200" data-wow-delay="100ms">
                    <span>Apply For Job</span>
                </h2>
                <div class="alert alert-success" ng-if="submitted">
                    <strong>Your career application saved successfully</strong> 
                </div>
                <div class="col-md-12 col-xs-12">
                    <form id="careerForm" ng-submit="careerForm.$valid && doApplicantAction(career, career.resume, career.photo_url)" class="form-horizontal" enctype="multipart/form-data" name="careerForm" novalidate enctype="multipart/form-data">
                        <input type="hidden" ng-model="_token" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                        <div class="col-md-6 col-xs-6" style="padding-right:100px;">
                            <div class="form-group">
                                <label for="" class="sr-only2">Enter your First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" ng-model="career.first_name" required />
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.first_name.$error" >
                                    <div ng-message="required" class="err">First name is required</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="sr-only2">Enter your Last Name</label>

                                <input type="text" class="form-control" name="last_name" id="last_name" ng-model="career.last_name" required />
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.last_name.$error">
                                    <div ng-message="required" class="err">Last name is required</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="sr-only2">Enter your Mobile Name</label>

                                <input type="text" class="form-control" name="mobile_number" id="mobile_number" ng-model="career.mobile_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-maxlength="10" ng-minlength="10" required />
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.mobile_number.$error" class="err">
                                    <div ng-message="required" class="err">Mobile number is required</div>
                                    <div ng-message="maxlength" class="err">Mobile number is must be 10 digit</div>
                                    <div ng-message="minlength" class="err">Mobile number is must be 10 digit</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="sr-only2">Select Post</label>
                                <select class="form-control" name="career_id" id="career_id" ng-model="career.career_id" required>
                                    <option  value="">Select Post</option>
                                    <option ng-repeat="job in jobPostRow" value="{{job.id}}">{{job.job_title}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.career_id.$error">
                                    <div ng-message="required" class="err">Select post</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12" >
                            <div class="form-group">
                                <label for="" class="sr-only2">Enter your Email Id</label>
                                <input type="email" class="form-control" name="email_id" id="email_id" ng-model="career.email_id" required />
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.email_id.$error" class="err">
                                    <div ng-message="required" class="err">Email is required</div>
                                    <div ng-message="email" class="err">Invalid Email</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="sr-only2">Upload Your Resume</label>
                                <input type="file" ngf-select valid-file  ng-model="career.resume" name="resume_file_name" required id="resume_file_name"   ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.resume_file_name.$error" >
                                    <div ng-message="required" class="err">Resume is required</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="sr-only2">Photo Url</label>
                                <input type="file" ngf-select   ng-model="career.photo_url" name="career.photo_url" id="photo_url"   ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >

                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LezFyAUAAAAAM1fRUDpyRXLSjHPiYFQkIQWYK2d"></div>
                                <div class="help-block"  >
                                    <div class="err" ng-if="recaptcha" style="float: left;">{{recaptcha}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12"><br>
                            <button type="submit" class="btn btn-theme ripple-effect btn-theme-light btn-more-posts" ng-click="sbtBtn = true" value="{{ !careerForm.$valid && 'invalid' || 'valid' }}">Apply For job</button>
                        </div>
                    </form>
                </div>
            </div>
            @endsection()                 