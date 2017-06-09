@extends('layouts/frontend/Theme32/main')
@section('content')
<style>
    .err{
        font-size: 13;
        color:red;
    }
</style>
<main class="main-content" ng-init="getContactDetails()">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/index">Home</a></li>
                <li><span>Contact Us</span></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <header class="heading page-heading">
            <h1>Contact Us</h1>
        </header>
        <div class="map offset-bottom">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3782.204208294445!2d73.7794173153493!3d18.564830072663327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2becdc1d67b2b%3A0xd7eddb46e6814db5!2sedynamics+(H.O.+Pune)!5e0!3m2!1sen!2sin!4v1458219738336" width="1200" height="450" allowfullscreen ></iframe>
        </div>
        <div class="row">
            <div class="col span_6" >
                <h2>Get in touch</h2>
                <div class="row">
                    <div class="col-md-6" ng-repeat="contact in contacts track by $index"> 
                        <div class="offset-bottom" >
                            <h3><i class="fa fa-map-marker"></i> Address</h3>
                            <address>{{contact.address}}</address>
                            <h3><i class="fa fa-phone"></i> Phone</h3>
                            <p>{{contact.contact_number1}}</p>
                            <h3><i class="fa fa-envelope"></i> Email</h3>
                            <p>{{contact.email}}</p>
                        </div>
                    </div></div>
            </div>
            <div class="alert alert-success" ng-if="submitted">
            <strong>Thank You for contacting us</strong> 
        </div>
            <div class="col span_6"  style="padding:4px">
                <form class="contact" method="post" name="contactForm"  ng-submit="contactForm.$valid && doContactAction(contact)" novalidate>
                    <h2>Send a message</h2>
                    <div class="form-item">
                        <label class="form-item-label">Name<span class="err">*</span></label>
                        <input type="text" name="name" ng-model="contact.name" class="form-control" required>
                        <div ng-show="sbtBtn" ng-messages="contactForm.name.$error">
                            <div ng-message="required" class="err">Name is required</div>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label">E-mail<span class="err">*</span></label>
                        <input type="email" name="email" ng-model="contact.email" class="form-control" required>
                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactForm.email.$error" class="err">
                            <div ng-message="required" class="err">Email is required</div>
                            <div ng-message="email" class="err">Invalid email address </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label">Mobile Number<span class="err">*</span></label>
                        <input type="tel" name="contact_number1" ng-model="contact.contact_number1"  ng-maxlength="10" ng-minlength="10" class="form-control" required>
                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactForm.contact_number1.$error" class="err">
                            <div ng-message="required" class="err">Mobile number is required</div>
                            <div ng-message="maxlength" class="err">Mobile number is must be 10 digit</div>
                            <div ng-message="minlength" class="err">Mobile number is must be 10 digit</div>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label">Message<span class="err">*</span></label>
                        <textarea name="message" ng-model="contact.massage"  class="form-control" cols="90" rows="4" required></textarea>
                        <div ng-show="sbtBtn" ng-messages="contactForm.message.$error">
                            <div ng-message="required" class="err">Message is required</div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="g-recaptcha" data-sitekey="6LezFyAUAAAAAM1fRUDpyRXLSjHPiYFQkIQWYK2d"></div>
                        <div class="help-block"  >
                            <div class="err" ng-if="recaptcha" style="float: left;">{{recaptcha}}</div>
                        </div>
                    </div>
                    <div class="form-item">
                        <input type="submit" ng-click="sbtBtn = true" class="btn" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection() 