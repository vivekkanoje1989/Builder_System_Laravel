@extends('layouts/frontend/theme31/main')
@section('content')
<section class="page-section testimonials">
    <div class="container wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms">
        <div class="testimonials-carousel">
            <div class="owl-carousel" id="testimonials">
                @for($i = 0; $i < count($testimonials); $i++)

                <div class="testimonial">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object testimonial-avatar" ng-src="[[config('global.s3Path')]]Testimonial/[[$testimonials[$i]->photo_url]]" alt="Testimonial avatar">
                            </a>
                        </div>
                        <div class="media-body">
                            <div class="testimonial-text">[[$testimonials[$i]->description]]</div>
                            <div class="testimonial-name">[[$testimonials[$i]->customer_name]] <span class="testimonial-position">[[$testimonials[$i]->company_name]]</span></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</section>
<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content">
                <div class="section page-title gallery bg-overlay">
                    <div class="container">
                        <div class="page-title-wrapper"><h2 class="captions" style="color:black!important">Share your experience </h2>

                            <ol class="breadcrumb" >
                                <li><a href="" style="color:black!important" >Home</a></li>
                                <li class="active"><a href="#" style="color:black!important">Your Good Thoughts For Us.</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <p id="msg" style=" text-align: center; display:none;">Form Submited Successfully </p>
                <style>
                    #msg{
                        color: #006400;   
                    }
                    .form-control {
                        border: 1px solid #151414;
                    }
                </style>


                <div class="section property-view">
                    <div class="container">
                        <div class="alert alert-success" ng-if="submitted">
                            <strong>Your experience saved successfully </strong> 
                        </div>
                        <div class="property-wrapper padding-both">

                            <div class="col-sm-10 col-sm-offset-1 col-xs-12 test-form">
                                <form  method="post" name="testimonialForm" novalidate ng-submit="testimonialForm.$valid && createTestimonials(testimonial, photo_url)" >
                                    <div class="row"  >  
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                            <label class="form-item-label">Name<span class="err">*</span></label>
                                            <input type="text" name="customer_name" ng-model="testimonial.customer_name" class="form-control" required>
                                            <div ng-if="sbtBtn" ng-messages="testimonialForm.customer_name.$error" class="err">
                                                <div ng-message="required">Name is required</div>
                                            </div> 
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                            <label class="form-item-label">Company Name<span class="err">*</span></label>
                                            <input type="text" name="company_name" ng-model="testimonial.company_name" class="form-control" required>
                                            <div ng-if="sbtBtn" ng-messages="testimonialForm.company_name.$error" class="err">
                                                <div ng-message="required">Company name is required</div>
                                            </div> 
                                        </div>
                                    </div>  
                                    <div class="row"  >     
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                            <label class="form-item-label">Upload Photo<span class="err">*</span></label>
                                            <input type="file" ngf-select valid-file  name="photo_url" ng-model="photo_url" class="form-control" required>
                                            <div ng-if="sbtBtn" ng-messages="testimonialForm.photo_url.$error" class="err">
                                                <div ng-message="required">Photo is required</div>
                                            </div> 
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                            <label class="form-item-label">Video Url</label>
                                            <input type="text" name="video_url" ng-model="testimonial.video_url" class="form-control" >
                                        </div>
                                    </div>   
                                    <div class="row">      
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                            <label class="form-item-label">Mobile Number<span class="err">*</span></label>
                                            <input type="text" name="mobile_number" ng-model="testimonial.mobile_number" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  ng-maxlength="10" ng-minlength="10" required>
                                            <div ng-if="sbtBtn" ng-messages="testimonialForm.mobile_number.$error" class="err">
                                                <div ng-message="required">Mobile number is required</div>
                                                <div ng-message="minlength">Mobile number must be 10 digit</div>
                                                <div ng-message="maxlength">Mobile number must be 10 digit</div>
                                            </div> 
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                            <label class="form-item-label">Message<span class="err">*</span></label>
                                            <textarea name="description" cols="90" rows="3" ng-model="testimonial.description" class="form-control" required></textarea>
                                            <div ng-if="sbtBtn" ng-messages="testimonialForm.description.$error" class="err">
                                                <div ng-message="required">Description is required</div>
                                            </div> 
                                        </div>
                                    </div> 
                                    <div class="row">     
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                            <div class="g-recaptcha" data-sitekey="6LezFyAUAAAAAM1fRUDpyRXLSjHPiYFQkIQWYK2d"></div>
                                            <div class="help-block"  >
                                                <div class="err" ng-if="recaptcha" style="float: left;">{{recaptcha}}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-item">
                                            <center>
                                                <button type="submit" ng-click="sbtBtn = true" class="btn btn-theme ripple-effect btn-theme-light btn-more-posts">Save</button>
                                            </center>
                                        </div>
                                    </div>    
                                </form>
                            </div>    
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection()     