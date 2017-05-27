@extends('layouts/frontend/Theme32/main')
@section('content')
<style>
 a {
     text-decoration: none ;
  }
</style>
<main class="main-content">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/index">Home</a></li>
                <li><span>Testimonial</span></li>
            </ul>
        </div>
    </div>
    <div class="container">

        <header class="heading page-heading">
            <h1>Clients Speak...</h1>
        </header>

        <div  class="testimonials owl-carousel owl-separated offset-bottom" data-slideshow-options='{"items":3,"itemsDesktop":false,"itemsDesktopSmall":false,"itemsTablet":[768,1],"singleItem":false,"pagination":false}'>
            @for($i = 0; $i < count($testimonials); $i++)
            <a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/testimonial/[[$testimonials[$i]->testimonial_id]]"><div class="testimonials-item" >
                <blockquote>
                    <p>[[$testimonials[$i]->description]]</p>
                </blockquote>
                <div class="person" >
                    <div class="person-photo">
                        <img src="[[config('global.s3Path')]]Testimonial/[[$testimonials[$i]->photo_url]]" width="110" height="110" alt="">
                    </div>
                    <div class="person-info">
                        [[$testimonials[$i]->customer_name]]
                    </div>
                </div>
            </div>
            </a>
            @endfor
        </div>
        <header class="heading page-heading">
            <h1>Share Your Experience...</h1>
        </header>
        <div class="alert alert-success" ng-if="submitted">
            <strong>Your experience saved successfully </strong> 
        </div>
        <div class="row" style="margin-left:15px;">
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
                            <button type="submit" ng-click="sbtBtn = true" class="btn">Send</button>
                        </center>
                    </div>
                </div>    
            </form>
        
    </div>

</div>
</main>
@endsection() 