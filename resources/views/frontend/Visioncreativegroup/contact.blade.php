@extends('layouts/frontend/Visioncreativegroup/main')
@section('content')
<div class="pageWrapper">
    <!-- Content Start -->
    <div id="contentWrapper">

        <div class="page-title title-3">
            <div class="container">
                <div class="row">
                    <div class="cell-8">
                        <i class="fa fa-phone Anim" data-animate="fadeInUp"></i>
                        <h1 class="Anim" data-animate="fadeInRight">CONTACT US</h1>						
                    </div>
                    <div class="cell-4">
                        <div class="breadcrumbs Anim" data-animate="fadeInRight">
                            <span class="bold">You Are In:</span><a href="index.html"> Home</a><span class="line-separate">/</span> Contact Us
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="padd-top-50">
            <div class="container">
                <div class="row">
                    <div class="cell-7 contact-form fx" data-animate="fadeInLeft">
                        <h3 class="block-head">Get in Touch</h3>
                        <form action="#" method="post">
                            <div class="form-input fx animated fadeInLeft">
                                <label>Your Name<span class="red">*</span></label>
                                <input type="text" required>
                            </div>
                            <div class="form-input fx animated fadeInRight">
                                <label>Email<span class="red">*</span></label>
                                <input type="email" required>
                            </div>
                            <div class="form-input fx animated fadeInLeft">
                                <label>Phone<span class="red">*</span></label>
                                <input type="text" required>			    						
                            </div>
                            <div class="form-input fx animated fadeInRight">
                                <label>Message<span class="red">*</span></label>
                                <textarea required></textarea>
                            </div>
                            <div class="form-input fx animated fadeInLeft">
                                <center>
                                    <img src="frontend/Visioncreativegroup/img_vision/captcha_code_file.jpg">
                                    <br />
                                    <a href="#"> Click Here </a> To Refresh
                                </center>
                            </div>
                            <div class="form-input fx animated fadeInRight">
                                <label>Enter Captcha<span class="red">*</span></label>
                                <input type="text" required>
                            </div>
                            <div>
                                <center>
                                    <input type="submit" class="btn btn-large main-bg" value="Submit">
                                </center>
                            </div>
                            <br>
                        </form>
                    </div>
                    <div class="cell-5 contact-detalis">
                        <h3 class="block-head">Contact Details</h3>
                        <hr class="hr-style4">
                        <div class="clearfix"></div>
                        <div class="padding-vertical">
                            <div class="cell-12 fx" data-animate="fadeInRight">
                                <h4 class="main-color bold">Office: Main</h4>
                                <h5 >Address:</h5>
                                <p>Gat No. 510-514, Chikhali-Moshi Link Road, Off Spine Road,Jadhavwadi, Chikhali, Pune-412114</p>
                                <h5 >Email:</h5>
                                <p>sales@visionkalpavriksha.com</p>
                                <h5 >Phone:</h5>
                                <p>9595 022 000</p>

                            </div>

                        </div>
                        <hr class="cell-12 hr-style4">
                        <div class="padding-vertical">
                            <div class="cell-12 fx" data-animate="fadeInRight">
                                <h4 class="main-color bold">Current Projects: Contact No.</h4>
                                <h5 class="mar-5">Project Name&nbsp;:&nbsp;<span class="cont-sp">000-000-00-00</span></h5>
                                <h5 class="mar-5">Project Name&nbsp;:&nbsp;<span class="cont-sp">000-000-00-00</span></h5>
                                <h5 class="mar-5">Project Name&nbsp;:&nbsp;<span class="cont-sp">000-000-00-00</span></h5>
                                <h5 class="mar-5">Project Name&nbsp;:&nbsp;<span class="cont-sp">000-000-00-00</span></h5>
                                <h5 class="mar-5">Project Name&nbsp;:&nbsp;<span class="cont-sp">000-000-00-00</span></h5>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="map_canvas" style="height: 450px; width: 100%;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3779.8143811714563!2d73.88214451540203!3d18.672323669387694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2c87f3e8427f1%3A0x497d7dff00f8f4f5!2sVision+Kalpavriksha!5e0!3m2!1sen!2sin!4v1459511598281" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <!-- Content End -->
            <!-- Back to top Link -->
            <div id="to-top" class="main-bg"><span class="fa fa-chevron-up"></span></div>

    </div>
    @endsection()