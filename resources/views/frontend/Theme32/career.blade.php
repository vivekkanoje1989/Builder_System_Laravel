@extends('layouts/frontend/Theme32/main')
@section('content')
<main class="main-content">

    <!-- start content -->
    <!-- start breadcrumbs.html-->
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><span>Careers</span></li>
            </ul>
        </div>
    </div>

    <!-- end breadcrumbs.html-->

    <div class="container">

        <header class="heading page-heading">
            <h2>Current Openings</h2>
        </header>

        <div class="row">
            <div class="col span_3">
                <ul class="nav-secondary offset-bottom sticky" data-sticky-parent=".main-content" data-sticky-offset="50">
                    <li><a href="#web" class="btn-scroll">Web Designer</a></li>
                    <li><a href="#php" class="btn-scroll">Php Developer</a></li>
                    <li><a href="#sales" class="btn-scroll">Sales Manager</a></li>
                    <li><a href="#support" class="btn-scroll">Support Engineer</a></li>

                </ul>
            </div>
            <div class="col span_9">
                <section id="web" class="offset-bottom">
                    <header class="heading">
                        <h2>Web Designer</h2>
                    </header>
                    <div class="row">
                        <div class="col span_12">
                            <h3>Skills Required</h3>
                            <ul>
                                <li> 1. Html5, css3, bootstrap </li>
                                <li> 2. 1-3 Years Of experience in web designing</li>
                            </ul>
                            <p><a href="#apply" class="btn btn-small">Apply Here</a></p>
                        </div>
                    </div>
                </section>

                <section id="php" class="offset-bottom">
                    <header class="heading">
                        <h2>Php Developer</h2>
                    </header>
                    <div class="row">
                        <div class="col span_12">
                            <h3>Skills Required</h3>
                            <ul>
                                <li> 1. Php, Html5, css3, bootstrap </li>
                                <li> 2. 1-3 Years Of experience in web designing</li>
                            </ul>
                            <p><a href="#apply" class="btn btn-small">Apply Here</a></p>
                        </div>
                    </div>
                </section>

                <section id="sales" class="offset-bottom">
                    <header class="heading">
                        <h2>Sales Manager</h2>
                    </header>
                    <div class="row">
                        <div class="col span_12">
                            <h3>Skills Required</h3>
                            <ul>
                                <li> 1. Php, Html5, css3, bootstrap </li>
                                <li> 2. 1-3 Years Of experience in web designing</li>
                            </ul>
                            <p><a href="#apply" class="btn btn-small">Apply Here</a></p>
                        </div>
                    </div>
                </section>

                <section id="support" class="offset-bottom">
                    <header class="heading">
                        <h2>Support Engineer</h2>
                    </header>
                    <div class="row">
                        <div class="col span_12">
                            <h3>Skills Required</h3>
                            <ul>
                                <li> 1. Php, Html5, css3, bootstrap </li>
                                <li> 2. 1-3 Years Of experience in web designing</li>
                            </ul>
                            <p><a href="#apply" class="btn btn-small">Apply Here</a></p>
                        </div>
                    </div>
                </section>

                <header class="heading page-heading" id="apply">
                    <h2>Apply Here</h2>
                </header>

                <div class="row">
                    <div class="col span_12"  style="padding:4px">
                        <form class="form-contact" method="post" >
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                <label class="form-item-label">Name</label>
                                <input type="text" name="name" required>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                <label class="form-item-label">E-mail</label>
                                <input type="email" name="email" required>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                <label class="form-item-label">Phone</label>
                                <input type="tel" name="phone" required>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                <label class="form-item-label">Select Position</label>
                                <select required class="shape">
                                    <option value="" selected disabled>Select Position</option>
                                    <option>Web Designer</option>
                                    <option>Php Developer</option>
                                    <option>Sales Manager</option>
                                    <option>Support Engineer</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                <label class="form-item-label">Upload CV</label>
                                <input type="file" required></textarea>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                <center>
                                    <img src="img/captcha_code_file.jpg" class="img-responsive center-block">	
                                    <br />
                                    <label class="form-item-label"><a href="#">Click To Refresh </a></label>
                                </center>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
                                <label class="form-item-label">Captcha</label>
                                <input type="text" name="captcha" required>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-item">
                                <center>
                                    <button type="submit" class="btn">Send</button>
                                </center>
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