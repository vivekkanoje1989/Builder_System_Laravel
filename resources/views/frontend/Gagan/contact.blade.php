@extends('layouts/frontend/Gagan/main')
@section('content')
<style>
    .err{
        font-size: 13;
        color:red;
    }
</style>
<div class="innerBanner">
    <img src="frontend/Gagan/img/contact-banner.jpg" alt="" />
</div>

<!-- start big message -->

<section class="bigMessage innerPage"  ng-init="getContactDetails()">
    <div class="container">

        <div id="system-message-container">
        </div>



        <div class="pageData ">

            <h1>
                Contact Us	</h1>

            <div class="content">

                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12"  > 
                        <div ng-repeat="contact in contacts track by $index">
                            <h3>Corporate office:</h3>
                            <p><strong>Address:</strong> {{contact.address}}</p>
                            <p><strong>Phone: </strong>+91 {{contact.contact_number1}}</p>
                            <p><strong>Email: </strong><span id="cloak65449">{{contact.email}}</span>
                            </p>
                            <hr>

                        </div>
                        <div class="sep"></div>
                        <h3>Location Map</h3>
                        <iframe width="100%" height="550" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.in/maps?oe=utf-8&amp;client=firefox-a&amp;ie=UTF8&amp;q=gagan+properties&amp;fb=1&amp;gl=in&amp;hq=gagan+properties&amp;hnear=0x3bc2bf2e67461101:0x828d43bf9d9ee343,Pune,+Maharashtra&amp;cid=0,0,14708408796273501409&amp;ll=18.519867,73.874001&amp;spn=0.006295,0.006295&amp;t=h&amp;iwloc=A&amp;output=embed"></iframe>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12"> 
                        <h2>Send a message</h2>
                        <form class="contact" method="post" name="contactForm"  ng-submit="contactForm.$valid && doContactAction(contact)" novalidate>

                            <div class="form-item">
                                <label class="form-item-label">Name<span class="err">*</span></label>
                                <input type="text" name="name" ng-model="contact.name" class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,' ')" required>
                                <div ng-show="sbtBtn" ng-messages="contactForm.name.$error">
                                    <div ng-message="required" class="err">Name is required</div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="form-item-label">E-mail<span class="err">*</span></label>
                                <input type="email" name="email_id" ng-model="contact.email_id" class="form-control" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactForm.email_id.$error" class="err">
                                    <div ng-message="required" class="err">Email is required</div>
                                    <div ng-message="email" class="err">Invalid email address </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="form-item-label">Mobile Number<span class="err">*</span></label>
                                <input type="tel" name="mobile_number" ng-model="contact.mobile_number"  ng-maxlength="10" ng-minlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactForm.mobile_number.$error" class="err">
                                    <div ng-message="required" class="err">Mobile number is required</div>
                                    <div ng-message="maxlength" class="err">Mobile number is must be 10 digit</div>
                                    <div ng-message="minlength" class="err">Mobile number is must be 10 digit</div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="form-item-label">Message<span class="err">*</span></label>
                                <textarea name="message" ng-model="contact.message"  class="form-control" cols="90" rows="4" required></textarea>
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


<!--                        <script type="text/javascript">rsfp_addEvent(window, 'load', function () {
                                        var form = rsfp_getForm(3);
                                        form.onsubmit = ajaxValidation;
                                    });</script>-->
                    </div>
                </div> 
            </div>
        </div>
    </div>

</section>
@endsection()