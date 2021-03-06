<!DOCTYPE html>
<html lang="en">

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Andia - Responsive Agency Template</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400">
<!--        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">-->
        <link rel="stylesheet" href="frontend/Aarohi/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="frontend/Aarohi/assets/font-awesome/css/font-awesome.min.css">
			<!-- bxSlider CSS file -->
		<link href="frontend/Aarohi/assets/css/jquery.bxslider.css" rel="stylesheet" />
        <link rel="stylesheet" href="frontend/Aarohi/assets/css/animate.css">
        <link rel="stylesheet" href="frontend/Aarohi/assets/css/magnific-popup.css">
        <link rel="stylesheet" href="frontend/Aarohi/assets/flexslider/flexslider.css">
        <link rel="stylesheet" href="frontend/Aarohi/assets/css/form-elements.css">
        <link rel="stylesheet" href="frontend/Aarohi/assets/css/style.css">
        <link rel="stylesheet" href="frontend/Aarohi/assets/css/media-queries.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="frontend/Aarohi/assets/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="frontend/Aarohi/assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="frontend/Aarohi/assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="frontend/Aarohi/assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="frontend/Aarohi/assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>
        
        <!-- Top menu -->
		<nav class="navbar" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<div class="navbar-brand">
					<a href="index.html"><img src="frontend/Aarohi/assets/img/logo.png" class="img-responsive"/></a>
					</div>
					<div class="brand-name">
                    	ABC Builder ABC Builder<br>
                        <span>Homes for Life</span>
                    </div>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="top-navbar-1">
					<ul class="nav navbar-nav navbar-right">
					<!--	<li class="dropdown active">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000">
								Home <span class="caret"></span>
							</a>
							<ul class="dropdown-menu dropdown-menu-left" role="menu">
								<li><a href="index.html">Home</a></li>
								<li class="active"><a href="index-2.html">Home 2</a></li>
							</ul>
						</li>-->
						<li class="active">
							<a href="index.html">Home</a>
						</li>
						<li>
							<a href="about.blade.php.html">About</a>
						</li>
						<li>
							<a href="projects.html">Projects</a>
						</li>
						<li>
							<a href="careers.html">Careers</a>
						</li>
						<li>
							<a href="contact.html">Contact</a>
						</li>
					<!--	<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000">
								<i class="fa fa-paperclip"></i><br>Pages <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="pricing-tables.html">Pricing tables</a></li>
							</ul>
						</li> -->
					</ul>
				</div>
			</div>
		</nav>

        <!-- Slider 2 -->
        
			<div id="home" class="centered">
				<!-- Start cSlider -->
				<ul class="bxslider">
					<li><img src="frontend/Aarohi/assets/img/slider/5.jpg"  title="Project Name"/></li>
					<li><img src="frontend/Aarohi/assets/img/slider/6.jpg"  title="Project Name"/></li>
					<li><img src="frontend/Aarohi/assets/img/slider/7.jpg"  title="Project Name"/></li>
				</ul>
			</div>
        
         <!-- Latest work -->
        <div class="work-container">
	        <div class="container">
	        	<div class="row">
		            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 work-title wow fadeIn">
		                <h2>Our Projects</h2>
		            </div>
	            </div>
	            <div class="row row-centered">
	            	<div class="col-lg-4 col-md-4 col-sm-4 col-sx-12 col-centered col-fixed">
						<h2>Current Projects</h2>
		                <div class="work wow fadeInUp">
		                    <img src="frontend/Aarohi/assets/img/portfolio/work1.jpg" alt="Lorem Website" data-at2x="frontend/Aarohi/assets/img/portfolio/work1.jpg" class="img-responsive">
		                    <h3>Lorem Website</h3>
		                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
		                    <div class="work-bottom">
		                        <a class="big-link-2 view-work" href="frontend/Aarohi/assets/img/portfolio/work1.jpg"><i class="fa fa-search"></i></a>
		                        <a class="big-link-2" href="projects.html"><i class="fa fa-link"></i></a>
		                    </div>
		                </div>
	                </div>
	                <div class="col-lg-4 col-md-4 col-sm-4 col-sx-12 col-centered col-fixed">
						<h2>Completed Projects</h2>
		                <div class="work wow fadeInDown">
		                    <img src="frontend/Aarohi/assets/img/portfolio/work2.jpg" alt="Ipsum Logo" data-at2x="frontend/Aarohi/assets/img/portfolio/work2.jpg" class="img-responsive">
		                    <h3>Ipsum Logo</h3>
		                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
		                    <div class="work-bottom">
		                        <a class="big-link-2 view-work" href="frontend/Aarohi/assets/img/portfolio/work2.jpg"><i class="fa fa-search"></i></a>
		                        <a class="big-link-2" href="projects.html"><i class="fa fa-link"></i></a>
		                    </div>
		                </div>
		            </div>
		            <div class="col-lg-4 col-md-4 col-sm-4 col-sx-12 col-centered col-fixed">
						<h2>Upcoming Projects</h2>
		                <div class="work wow fadeInUp">
		                    <img src="frontend/Aarohi/assets/img/portfolio/work3.jpg" alt="Dolor Prints" data-at2x="frontend/Aarohi/assets/img/portfolio/work3.jpg" class="img-responsive">
		                    <h3>Dolor Prints</h3>
		                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
		                    <div class="work-bottom">
		                        <a class="big-link-2 view-work" href="frontend/Aarohi/assets/img/portfolio/work3.jpg"><i class="fa fa-search"></i></a>
		                        <a class="big-link-2" href="projects.html"><i class="fa fa-link"></i></a>
		                    </div>
		                </div>
		            </div>
	            </div>
	        </div>
        </div>

        <!-- Testimonials -->
        <div class="testimonials-container">
	        <div class="container">
	        	<div class="row">
		            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 testimonials-title wow fadeIn">
		                <h2>Testimonials</h2>
		            </div>
	            </div>
	            <div class="row">
	                <div class="col-sm-10 col-sm-offset-1 testimonial-list">
	                	<div role="tabpanel">
	                		<!-- Tab panes -->
	                		<div class="tab-content">
	                			<div role="tabpanel" class="tab-pane fade in active" id="tab1">
	                				<div class="testimonial-image">
	                					<img src="frontend/Aarohi/assets/img/testimonials/1.jpg" alt="" data-at2x="frontend/Aarohi/assets/img/testimonials/1.jpg" class="img-responsive">
	                				</div>
	                				<div class="testimonial-text">
		                                <p>
		                                	"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et. 
		                                	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et. 
		                                	Lorem ipsum dolor sit amet, consectetur..."<br>
		                                	<a href="#">Lorem Ipsum, dolor.co.uk</a>
		                                </p>
	                                </div>
	                			</div>
	                			<div role="tabpanel" class="tab-pane fade" id="tab2">
	                				<div class="testimonial-image">
	                					<img src="frontend/Aarohi/assets/img/testimonials/2.jpg" alt="" data-at2x="frontend/Aarohi/assets/img/testimonials/2.jpg" class="img-responsive">
	                				</div>
	                				<div class="testimonial-text">
		                                <p>
		                                	"Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip 
		                                	ex ea commodo consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit 
		                                	lobortis nisl ut aliquip ex ea commodo consequat..."<br>
		                                	<a href="#">Minim Veniam, nostrud.com</a>
		                                </p>
	                                </div>
	                			</div>
	                			<div role="tabpanel" class="tab-pane fade" id="tab3">
	                				<div class="testimonial-image">
	                					<img src="frontend/Aarohi/assets/img/testimonials/3.jpg" alt="" data-at2x="frontend/Aarohi/assets/img/testimonials/3.jpg" class="img-responsive">
	                				</div>
	                				<div class="testimonial-text">
		                                <p>
		                                	"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et. 
		                                	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et. 
		                                	Lorem ipsum dolor sit amet, consectetur..."<br>
		                                	<a href="#">Lorem Ipsum, dolor.co.uk</a>
		                                </p>
	                                </div>
	                			</div>
	                			<div role="tabpanel" class="tab-pane fade" id="tab4">
	                				<div class="testimonial-image">
	                					<img src="frontend/Aarohi/assets/img/testimonials/1.jpg" alt="" data-at2x="frontend/Aarohi/assets/img/testimonials/1.jpg" class="img-responsive">
	                				</div>
	                				<div class="testimonial-text">
		                                <p>
		                                	"Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip 
		                                	ex ea commodo consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit 
		                                	lobortis nisl ut aliquip ex ea commodo consequat..."<br>
		                                	<a href="#">Minim Veniam, nostrud.com</a>
		                                </p>
	                                </div>
	                			</div>
	                		</div>
	                		<!-- Nav tabs -->
	                		<ul class="nav nav-tabs" role="tablist">
	                			<li role="presentation" class="active">
	                				<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"></a>
	                			</li>
	                			<li role="presentation">
	                				<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"></a>
	                			</li>
	                			<li role="presentation">
	                				<a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"></a>
	                			</li>
	                			<li role="presentation">
	                				<a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab"></a>
	                			</li>
	                		</ul>
	                	</div>
	                </div>
	            </div>
                <a class="experience1 big-link-3" href="javascript:void(0);">Share Your Experience</a>
	        </div>
        </div>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 footer-box wow fadeInUp">
                        <h4>About Us</h4>
                        <div class="footer-box-text">
	                        <p>
	                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et. 
	                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.
	                        </p>
	                    <!--    <p><a href="about.html">Read more...</a></p> -->
							<a class="big-link-1" href="about.blade.php.html">Read more...</a>
                        </div>
                    </div>
                    <div class="col-sm-6 footer-box wow fadeInDown">
                        <h4>Contact Us</h4>
                        <div class="footer-box-text footer-box-text-contact">
	                        <p><i class="fa fa-map-marker"></i> Address: Via Principe Amedeo 9, 10100, Torino, TO, Italy</p>
	                        <p><i class="fa fa-phone"></i> Phone: 0039 333 12 68 347</p>
	                        <p> Skype: Andia_Agency</p>
	                        <p></i> Email: <a href="">contact@andia.co.uk</a></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 wow fadeIn">
                		<div class="footer-border"></div>
                	</div>
                </div>
                <div class="row">
                    <div class="col-sm-7 footer-copyright wow fadeIn">
                        <p>Copyright 2015 <span>Aarohi Developers</span> - All rights reserved.</p>
                    </div>
                    <div class="col-sm-5 footer-social wow fadeIn">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-dribbble"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </footer>
		
              <!-- share your Experience -->
        <div id="experience-popup">
			<form action="" class="experience" id="experience-popup-form">
	<h4> Experience for Property</h4>
	<a href="" class="close" id="clos"><img src="frontend/Aarohi/assets/img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
    <fieldset class="experience-inner">
      <p class="experience-input">
        <input type="text" name="Fname" placeholder="Your First Name…" autofocus>
      </p>
	  
	  <p class="experience-input">
        <input type="text" name="Lname" placeholder="Your Last Name…" autofocus>
      </p>
	  
	  <p class="experience-input">
        <input type="phone" name="phone" placeholder="Your Mobile Number" autofocus>
      </p>
	  
	  <p class="experience-input">
        <input type="email" name="email" placeholder="Your Email" autofocus>
      </p>
	  
      Upload Your Photo
      <p class="experience-input">
        <input id="uploadimg" name="uploadimg" value="" autocomplete="on" placeholder="Upload Your Photo" type="file" autofocus>
      </p>
	
      <p class="experience-input">
        <textarea name="experience" placeholder="Your Experience…"></textarea>
      </p>
	
	  <div>
        Captcha Image*
            <div><img id="captchaimg5" style="padding: 0 0 0 5px;" src="http://www.e-dynamics.in/reb/captcha_code_file.php?rand=1265139648&amp;name=experience_captcha">
                 <div style="padding: 0 0 0 5px;">
					Click <a class="here" href="javascript: refreshCaptcha(&quot;captchaimg5&quot;);">here</a> to refresh
				 </div> 
            </div>
      </div>
      <p class="experience-input">
            <input id="txtCaptcha" name="txtCaptcha" value="" type="text" autocomplete="on" placeholder="Captcha">
      </p>
	
	
      <p class="experience-submit">
        <input type="submit" value="Send Message">
      </p>
    </fieldset>
  </form>

		</div>
        <!-- Share your experience ends here -->
		
        <!-- Javascript -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		
		<script>
		$(document).ready(function(){
			$('.experience1').on('click', function(){
				$('#experience-popup').attr('style','display:block');
				$('#experience-popup-form').attr('style','display:block');
				});
			$('.close').on('click', function(){
				$('#experience-popup').attr('style','display:none');
				$('#experience-popup-form').attr('style','display:none');
				});
		});
		</script>
        
        <!-- Javascript -->
        <script src="frontend/Aarohi/assets/js/jquery-1.11.1.min.js"></script>
		<!-- bxSlider Javascript file -->
		<script src="frontend/Aarohi/assets/js/jquery.bxslider.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('.bxslider').bxSlider({
				  mode: 'fade',
				  captions: false,
				  auto: true,
				  autoControls: true
				});
			});
		</script>
        <script src="frontend/Aarohi/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="frontend/Aarohi/assets/js/bootstrap-hover-dropdown.min.js"></script>
        <script src="frontend/Aarohi/assets/js/jquery.backstretch.min.js"></script>
        <script src="frontend/Aarohi/assets/js/wow.min.js"></script>
        <script src="frontend/Aarohi/assets/js/retina-1.1.0.min.js"></script>
        <script src="frontend/Aarohi/assets/js/jquery.magnific-popup.min.js"></script>
        <script src="frontend/Aarohi/assets/flexslider/jquery.flexslider-min.js"></script>
        <script src="frontend/Aarohi/assets/js/masonry.pkgd.min.js"></script>
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="frontend/Aarohi/assets/js/jquery.ui.map.min.js"></script>
        <script src="frontend/Aarohi/assets/js/scripts.js"></script>
		
    </body>

</html>