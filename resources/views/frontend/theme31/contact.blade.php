<style>
    .err{
        color:red;
    }
</style>
@extends('layouts/frontend/theme31/main')
@section('content')
<div class="content-area" ng-controller="webAppController" >
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3782.204208294423!2d73.77941731478177!3d18.56483007266471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2becdc1d67b2b%3A0xd7eddb46e6814db5!2sedynamics+(H.O.+Pune)!5e0!3m2!1sen!2sin!4v1457762025461" width="100%" height="450px" frameborder="0" style="border:0" allowfullscreen></iframe>
    <section id="contact-us" class="page-section contact dark">
        <div class="container">
            <h2 class="section-title wow fadeInDown" data-wow-offset="200" data-wow-delay="100ms">
                <small>Feel Free to Say Hello!</small>
                <span>Get in Touch With Us</span>
            </h2>
            <div class="row">
                <div class="col-md-6 wow fadeInLeft" data-wow-offset="200" data-wow-delay="200ms">

                    <form name="contactForm" ng-submit="contactForm.$valid && doContactAction(contact)"  novalidate >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="outer required">
                                    <div class="form-group af-inner has-icon">
                                        <label class="sr-only" for="name">Name</label>
                                        <input
                                            type="text" name="name" id="name" ng-model="name" placeholder="Name" value="" size="30"
                                            data-toggle="tooltip" title="Name is required"
                                            class="form-control placeholder" required/>
                                        <span class="form-control-icon"><i class="fa fa-user" style="margin-top: 10%;"></i></span>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactForm.name.$error" >
                                            <div ng-message="required" class="err">Name is required</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="outer required">
                                    <div class="form-group af-inner has-icon">
                                        <label class="sr-only" for="email">Email</label>
                                        <input type="email"  required name="email" ng-model="email" id="email" placeholder="Email"  size="30"  class="form-control placeholder"/>
                                        <span class="form-control-icon"><i class="fa fa-envelope" style="margin-top: 10%;"></i></span>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactForm.email.$error" class="err">
                                            <div ng-message="required" class="err">Email is required</div>
                                            <div ng-message="email" class="err">Invalid email address </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="outer required">
                            <div class="form-group af-inner has-icon">
                                <label class="sr-only" >Mobile Number</label>
                                <input
                                    type="text" name="contact_number1" required ng-model="contact_number1"  ng-maxlength="10" ng-minlength="10" id="contact_number1" placeholder="Mobile number" value="" size="30"
                                    data-toggle="tooltip" title="Mobile Number is required"
                                    class="form-control placeholder"/>
                                <span class="form-control-icon"><i class="fa fa-phone" style="margin-top: 10%;"></i></span>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactForm.contact_number1.$error" class="err">
                                    <div ng-message="required" class="err">Mobile number is required</div>
                                    <div ng-message="maxlength" class="err">Mobile number is must be 10 digit</div>
                                    <div ng-message="minlength" class="err">Mobile number is must be 10 digit</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group af-inner has-icon">
                            <label class="sr-only" for="input-message">Message</label>
                            <textarea
                                name="message" id="input-message" placeholder="Message" rows="4" cols="50" ng-model="massage"
                                data-toggle="tooltip" title="Message is required"
                                class="form-control placeholder"></textarea>
                            <span class="form-control-icon"><i class="fa fa-bars" style="margin-top: 10%;"></i></span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="g-recaptcha" data-sitekey="6LezFyAUAAAAAM1fRUDpyRXLSjHPiYFQkIQWYK2d"></div>
                                <div class="help-block"  >
                                    <div class="err" ng-if="recaptcha" style="float: left;">{{recaptcha}}</div>
                                </div>

                            </div>
                        </div>
                        <div class="outer required">
                            <div class="form-group af-inner">
                                <input type="submit" ng-click="sbtBtn = true"  name="submit" class="form-button form-button-submit btn btn-block btn-theme ripple-effect btn-theme-dark" id="submit_btn" value="Send message" />
                            </div>
                        </div>

                    </form>
                </div>
                <div class="col-md-6 wow fadeInRight" data-wow-offset="200" data-wow-delay="200ms" style="color: #fff;" ng-init="getContactDetails()">

                    <ul class="media-list contact-list" ng-repeat="contact in contacts track by $index">
                        <li class="media">
                            <div class="media-left"><i class="fa fa-home"></i></div>
                            <div class="media-body">Adress {{$index + 1}}: {{contact.address}}</div>
                        </li>
                        <li class="media">
                            <div class="media-left"><i class="fa fa-phone"></i></div>
                            <div class="media-body">Support Phone: {{contact.contact_number1}}</div>
                        </li>
                        <li class="media">
                            <div class="media-left"><i class="fa fa-envelope"></i></div>
                            <div class="media-body">E mails: {{contact.email}}</div>
                        </li>
                        <br>
                    </ul>


                </div>
            </div>
        </div>
</div>

@endsection()                                  