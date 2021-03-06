@extends('layouts/frontend/Gagan/main')
@section('content')
<style>.err{
        font-size: 13;
        color:red;
    }
</style>
<main class="main-content" ng-init="getCareers(); getPostsDropdown();">

    <div class="container" style="margin-top:165px">
        <header class="heading page-heading">
            <h2>Current Openings</h2>
        </header>
        <div class="row">
            <div class="col span_12" ng-repeat="career in careers track by $index" style="border: 1px solid black;padding: 51px 51px 0px 51px;margin-bottom: 51px;">
                <section  class="offset-bottom" >
                    <header class="heading">
                        <h2>{{career.job_title}}</h2>
                    </header>
                    <div class="row">
                        <div class="col-md-6 span_6">
                            <h3>Role</h3>
                            <ul>
                                <li><p>{{career.job_role}}</p></li>
                            </ul> 

                            <h3>Work Location</h3>
                            <ul>
                                <li><p>{{career.job_locations}}</p></li>
                            </ul>   
                        </div> 
                        <div class="col-md-6 span_6">
                            <h3>Responsibility</h3>
                            <ul>
                                <li><p>{{career.job_responsibilities}}</p></li>
                            </ul> 
                            <h3>Eligibility</h3>
                            <ul>
                                <li><p>{{career.job_eligibility}}</p></li>
                            </ul>
                        </div> 
                    </div>
                </section>
            </div>
        </div>    
        <header class="heading page-heading" id="apply">
            <h2>Apply Here</h2>
        </header>
        <div class="alert alert-success" ng-if="submitted">
            <strong>Your career application saved successfully</strong> 
        </div>
        <div class="row">
            <div class="col span_12"  style="padding:4px">
                <form id="careerForm" ng-submit="careerForm.$valid && doApplicantAction(career, career.resume, career.photo_url)" class="" name="careerForm" novalidate >
                    <input type="hidden" ng-model="_token" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="" class="sr-only2">First Name<span class="err">*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" ng-model="career.first_name" required />
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.first_name.$error" >
                                    <div ng-message="required" class="err">First name is required</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="sr-only2">Last Name<span class="err">*</span></label>

                                <input type="text" class="form-control" name="last_name" id="last_name" ng-model="career.last_name" required />
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.last_name.$error">
                                    <div ng-message="required" class="err">Last name is required</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="sr-only2">Mobile Number<span class="err">*</span></label>

                                <input type="text" class="form-control" name="mobile_number" id="mobile_number" ng-model="career.mobile_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-maxlength="10" ng-minlength="10" required />
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.mobile_number.$error" class="err">
                                    <div ng-message="required" class="err">Mobile number is required</div>
                                    <div ng-message="maxlength" class="err">Mobile number is must be 10 digit</div>
                                    <div ng-message="minlength" class="err">Mobile number is must be 10 digit</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="sr-only2">Photo Url</label>
                                <input type="file" ngf-select   ng-model="career.photo_url" name="career.photo_url" id="photo_url"   ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >

                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12" >
                            <div class="form-group">
                                <label for="" class="sr-only2">Email Id<span class="err">*</span></label>
                                <input type="email" class="form-control" name="email_id" id="email_id" ng-model="career.email_id" required />
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.email_id.$error" class="err">
                                    <div ng-message="required" class="err">Email is required</div>
                                    <div ng-message="email" class="err">Invalid Email</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" >Select Post<span class="err">*</span></label>
                                <select class="form-control" name="career_id" id="career_id" ng-model="career.career_id" required
                                        <option  value="">Select Post</option>
                                    <option ng-repeat="job in jobPostRow" value="{{job.id}}">{{job.job_title}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.career_id.$error">
                                    <div ng-message="required" class="err">Select post to apply</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="sr-only2">Upload Your Resume<span class="err">*</span></label>
                                <input type="file" ngf-select valid-file  ng-model="career.resume" name="resume_file_name" required  required id="resume_file_name"   ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                <div class="help-block" ng-show="sbtBtn" ng-messages="careerForm.resume_file_name.$error" >
                                    <div ng-message="required" class="err">Resume is required</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LezFyAUAAAAAM1fRUDpyRXLSjHPiYFQkIQWYK2d"></div>
                                <div class="help-block"  >
                                    <div class="err" ng-if="recaptcha" style="float: left;">{{recaptcha}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12"><br>
                        <button type="submit" class="btn" ng-click="sbtBtn = true" >Apply For job</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</div>


<!-- end content -->

</main>
@endsection() 