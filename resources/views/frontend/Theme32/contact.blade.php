@extends('layouts/frontend/Theme32/main')
@section('content')
<!-- END HEADER -->
<!-- BEGIN MAIN CONTAINER -->
<main class="main-content">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="index.html">Home</a></li>
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
            <div class="col span_6" style="padding:4px">
                <div class="offset-bottom">
                    <h2>Get in touch</h2>
                    <h3><i class="fa fa-map-marker"></i> Address</h3>
                    <address><blockquote> <b> edynamics (H.O. Pune) </b></blockquote> <br />
                        No 5, Richmond Park, Opp. Orchid School,<br />
                        Baner Road, Balewadi Phata, Baner, <br />
                        Pune, Maharashtra 411045</address>
                    <h3><i class="fa fa-phone"></i> Phone</h3>
                    <p>+91 98 8376 6284</p>
                    <h3><i class="fa fa-envelope"></i> Email</h3>
                    <p>mail@edynamics.com</p>
                    <h3>Social</h3>
                    <ul class="nav-social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#"><i class="fa fa-skype"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col span_6"  style="padding:4px">
                <form class="form-contact" method="post" >
                    <h2>Send a message</h2>
                    <div class="form-item">
                        <label class="form-item-label">Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label">Phone</label>
                        <input type="tel" name="phone" required>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label">E-mail</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label">Message</label>
                        <textarea name="message" cols="90" rows="4" required></textarea>
                    </div>
                    <div class="form-item">
                        <center>
                            <img src="img/captcha_code_file.jpg" class="img-responsive center-block">	
                            <br />
                            <label class="form-item-label"><a href="#">Click To Refresh </a></label>
                        </center>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label">Captcha</label>
                        <input type="text" name="captcha" required>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="btn">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection() 