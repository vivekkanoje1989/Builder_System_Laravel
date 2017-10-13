<!DOCTYPE html>
<!--
 * A Design by GraphBerry
 * Author: GraphBerry
 * Author URL: http://graphberry.com
 * License: http://graphberry.com/pages/license
-->
<html lang="en">
    
    <head>
        <meta charset=utf-8>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Project Details</title>
        <!-- Load Roboto font -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <!-- Load css styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/ekko-lightbox.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/pluton.css" />
        
        <!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="css/pluton-ie7.css" />
        <![endif]-->
		
		<link rel="stylesheet" type="text/css" href="css/jquery.cslider.css" />
		<!-- bxSlider CSS file -->
		<link href="css/jquery.bxslider.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="css/animate.css" />
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72.png">
        <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57.png">
        <link rel="shortcut icon" href="images/ico/favicon.ico">
        
        <script src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script>
			window.onload = function () {
    document.getElementById("enquiry").onclick = function () {
        var e = document.getElementById("enquiry-popup");
        var f = document.getElementById("enquiry-popup-form");
        e.style.display = "block";
		f.style.display = "block";
    };
	document.getElementById("enquiry2").onclick = function () {
        var e = document.getElementById("enquiry-popup");
        var f = document.getElementById("enquiry-popup-form");
        e.style.display = "block";
		f.style.display = "block";
    };
	document.getElementById("enquiry3").onclick = function () {
        var e = document.getElementById("enquiry-popup");
        var f = document.getElementById("enquiry-popup-form");
        e.style.display = "block";
		f.style.display = "block";
    };
    document.getElementById("clos").onclick = function () {
        var e = document.getElementById("enquiry-popup");
		var f = document.getElementById("enquiry-popup-form");
        e.style.display = "none";
		f.style.display = "none";
    };
} 
		</script> 
    </head>
    
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <a href="index.html" class="brand">
                        <img src="images/logo.png" alt="Logo" />
                        <!-- This is website logo -->
                    </a>
                    <!-- Navigation button, visible on small resolution -->
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <i class="icon-menu"></i>
                    </button>
                    <!-- Main navigation -->
                    <div class="nav-collapse collapse pull-right">
                        <ul class="nav" id="top-navigation">
                            <li><a href="index.html#home">Home</a></li>
                            <li><a href="projects.html">Projects</a></li>
                            <li><a href="index.html#about">About</a></li>
                            <li><a href="index.html#clients">Testimonials</a></li>
                            <li><a href="index.html#careers">Careers</a></li>
                            <li><a href="index.html#contact">Contact</a></li>
                        </ul>
                    </div>
                    <!-- End main navigation -->
                </div>
            </div>
        </div>
        <!-- Start home section -->
        <div id="home" class="centered">
            <!-- Start cSlider -->
            <ul class="bxslider">
				<li><img src="images/banner1.jpg"  title="Funky roots"/></li>
				<li><img src="images/banner2.jpg"  title="Funky roots"/></li>
				<li><img src="images/banner3.jpg"  title="Funky roots"/></li>
			</ul>
			
        </div>
        <!-- End home section -->
         <!-- About us section start -->
        <div class="section secondary-section" id="about">
            <div class="triangle"></div>
            <div class="container">
                <div class="about-text">
                    <div class="title">
						<h1>Project Name</h1>
					</div>
                    <div class="span3" id="project-logo">
                    	<img src="images/logo.png" class="img-responsive"/>
                    </div>
                    <div class="span9">
                    	<h3>Description</h3>
                    	<p>ABC Builders was set up in 1999, under the Chairmanship of Babasaheb Atkire with property development as its main focus. Growing swiftly to become the leading property developers in Pune, ABC Builders successfully created a niche as preferred building partners for some of the global corporate clients and has been the Benchmark builder and is growing in all facets of industry. </p>
                    </div>
                </div>
             </div>
                <!-- Project Details Tab -->
		
<div class="container" id="details">
  <ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#availability">Availability</a></li>
    <li><a data-toggle="tab" href="#location">Location Map</a></li>
    <li><a data-toggle="tab" href="#amenities">Amenities</a></li>
    <li><a data-toggle="tab" href="#layout">Layout Plans</a></li>
    <li><a data-toggle="tab" href="#floor">Floor Plans</a></li>
    <li><a data-toggle="tab" href="#gallary">Gallary</a></li>
  </ul>

  <div class="tab-content">
    <div id="availability" class="tab-pane fade in active">
		<h2>Availability in Shree Park </h2>
			<div class="row">
	    			
	    			<!-- Product Summary & Options -->
                    
                    <div class="span4 product-details">
                    <div class="interest">
                        	<ul>
                            	<li class="h3">
                                2 BHK
                                </li>
                                
                                <li class="h5">
                               		2 BHK apartment of 950 Sq Ft , with state of the art design of the apartment.
                                </li>
                                
                                <li class="interested">
                                    <a id="enquiry" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">I am Interested</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    
                    <div class="span4 product-details">
                    <div class="interest">
                        	<ul>
                            	<li class="h3">
                                2 BHK
                                </li>
                                
                                <li class="h5">
                                2 BHK apartment of 950 Sq Ft , with state of the art design of the apartment.
                                </li>
                                
                                <li class="interested">
                                <a id="enquiry2" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">I am Interested</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    
                    <div class="span4 product-details">
                    <div class="interest">
                        	<ul>
                            	<li class="h3">
                                2 BHK
                                </li>
                                
                                <li class="h5">
                                2 BHK apartment of 950 Sq Ft , with state of the art design of the apartment.
                                </li>
                                
                                <li class="interested">
                                <a id="enquiry3" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">I am Interested</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    
	    			<!-- End Product Summary & Options -->
	    			
	    		</div>
	</div>
	<div id="location" class="tab-pane fade" style="margin-top:10px;">
						<div class="row">
                        <div class="span12">
                        	<div class="row">
                            		<div id="contact-us-map">
										<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
										<br />
										<small>
											<a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A"></a>
										</small>
										</iframe>
	        						</div>
                            </div>
                            <div class="row">
                                <a href="images/locationMap.jpeg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/locationMap.jpeg" class="img-responsive">
                                </a>
                                <a href="images/locationMap.jpeg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/locationMap.jpeg" class="img-responsive">
                                </a>
                               <a href="images/locationMap.jpeg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/locationMap.jpeg" class="img-responsive">
                                </a>
                            </div>
                        </div>
                    </div>		
	
    <div id="amenities" class="tab-pane fade" style="margin-top:10px;">
		<div class="row">
                        <div class="span12">
                            <div class="row">
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                            </div>
                        </div>
                    </div>   
	</div>
    <div id="layout" class="tab-pane fade" style="margin-top:10px;"->
		<div class="row">
                        <div class="span12">
                            <div class="row">
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                            </div>
                        </div>
                    </div>
    </div>
    <div id="floor" class="tab-pane fade" style="margin-top:10px;">
        <div class="row">
                        <div class="span12">
                            <div class="row">
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                            </div>
                        </div>
                    </div>
	</div>
	<div id="gallary" class="tab-pane fade" style="margin-top:10px;">
        <ul class="nav nav-tabs" >
				<li class="active"><a data-toggle="tab" href="#elevations">Elevations</a></li>
				<li><a data-toggle="tab" href="#walk-through">Walk Through</a></li>
		</ul>
		<div class="tab-content">
		<div id="elevations" class="tab-pane fade in active" style="margin-top:10px;">		
			<div class="row">
                        <div class="span12">
                            <div class="row">
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                            </div>
                        </div>
            </div>
		</div>
		<div id="walk-through" class="tab-pane fade" style="margin-top:10px;">		
			<div class="row">
                        <div class="span12">
                            <div class="row">
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                                <a href="images/banner1.jpg" data-toggle="lightbox" data-gallery="multiimages" class="span4">
                                    <img src="images/banner1.jpg" class="img-responsive">
                                </a>
                            </div>
                        </div>
            </div>
		</div>
		</div>
	</div>
	</div>
  </div>
</div>	

	<!-- Project Details Tab ends here-->	 
</div>
        <!-- About us section end -->
        
        
        <!-- projects section start -->
        <div class="section primary-section" id="projects">
        	<div class="triangle"></div>
            <div class="container">
                <!-- Start title section -->
                <div class="title">
                    <h1>Other Projects</h1>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="centered projects">
                            <div class="zoom-in">
                                <img class="img-responsive" src="images/project.jpg" alt="projects 1">
                            </div>
                            <h3>Project Name</h3>
                            <p>Project Information</p>
							<a href="projects.html" class="btn">Read more</a>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="centered projects">
                            <div class="zoom-in">
                                <img class="img-responsive" src="images/project.jpg" alt="projects 2" />
                            </div>
                            <h3>Project Name</h3>
                            <p>Project Information</p>
							<a href="projects.html" class="btn">Read more</a>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="centered projects">
                            <div class="zoom-in">
                                <img class="img-responsive" src="images/project.jpg" alt="projects 3">
                            </div>
                            <h3>Project Name</h3>
                            <p>Project Information</p>
							<a href="projects.html" class="btn">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- projects section end -->
        
<!--        <div class="section primary-section">
            <div class="triangle"></div>
            <div class="container centered">
                <p class="large-text">Enquire About Our Project Here</p>
                <a id="enquiry" class="button" style="border: 1px solid #FECE1A; color: #FECE1A;">Enquire now</a>
            </div>
        </div> 
-->
          <!-- Contact section start -->
        <div id="contact" class="contact">
            <div class="section secondary-section">
                <div class="container">
                    <div class="span9 center contact-info">
                        <p>123 Fifth Avenue, 12th,Belgrade,SRB 11000</p>
                        <p class="info-mail">ourstudio@somemail.com</p>
                        <p>+91 9876543210</p>
                        <p>+91 0123456789</p>
                        <div class="title">
                            <h3>We Are Social</h3>
                        </div>
                    </div>
                    <div class="row-fluid centered">
                        <ul class="social">
                            <li>
                                <a href="">
                                    <span class="icon-facebook-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-twitter-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-linkedin-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-pinterest-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-dribbble-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-gplus-circled"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact section edn -->
		
		<div id="enquiry-popup">
			<form action="" class="enquiry" id="enquiry-popup-form">
	<h4> Enquiry for Property</h4>
	<a href="" class="close" id="clos"><img src="images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
    <fieldset class="enquiry-inner">
      <p class="enquiry-input">
        <input type="text" name="Fname" placeholder="Your First Name…" autofocus>
      </p>
	  
	  <p class="enquiry-input">
        <input type="text" name="Lname" placeholder="Your Last Name…" autofocus>
      </p>
	  
	  <p class="enquiry-input">
        <input type="phone" name="phone" placeholder="Your Mobile Number" autofocus>
      </p>
	  
	  <p class="enquiry-input">
        <input type="email" name="email" placeholder="Your Email" autofocus>
      </p>

      <p class="enquiry-input">
        <textarea name="remark" placeholder="Your Remark…"></textarea>
      </p>
	
	  <div>
        Captcha Image*
            <div><img id="captchaimg5" style="padding: 0 0 0 5px;" src="http://www.e-dynamics.in/reb/captcha_code_file.php?rand=1265139648&amp;name=enquiry_captcha">
                 <div style="padding: 0 0 0 5px;">
					Click <a class="here" href="javascript: refreshCaptcha(&quot;captchaimg5&quot;);">here</a> to refresh
				 </div> 
            </div>
      </div>
      <p class="enquiry-input">
            <input id="txtCaptcha" name="txtCaptcha" value="" type="text" autocomplete="on" placeholder="Captcha">
      </p>
	
	
      <p class="enquiry-submit">
        <input type="submit" value="Send Message">
      </p>
    </fieldset>
  </form>

		</div>
		
        
        <!-- Footer section start -->
        <div class="footer">
            <p><img src="images/favicon.jpg" alt="e-dynamics" width="32" height="32" border="0" class="ftr-logo"> &copy; 2015 ABC BUILDER</p>
        </div>
        <!-- Footer section end -->
        <!-- ScrollUp button start -->
        <div class="scrollup">
            <a href="#">
                <i class="icon-up-open"></i>
            </a>
        </div>
        <!-- ScrollUp button end -->
        <!-- Include javascript -->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		
		<!-- jQuery library (served from Google) -->
		<!-- bxSlider Javascript file -->
        <script src="js/bootstrap.min.js"></script>
		<script src="js/ekko-lightbox.js"></script>
		<script src="js/jquery.bxslider.min.js"></script>
        <script type="text/javascript" src="js/jquery.mixitup.js"></script>
        <script type="text/javascript" src="js/modernizr.custom.js"></script>
        <script type="text/javascript" src="js/jquery.placeholder.js"></script>
        <script type="text/javascript" src="js/jquery.inview.js"></script>
        <script type="text/javascript">
            $(document).ready(function ($) {
				$('.bxslider').bxSlider({ mode: 'fade', captions: true, auto:true, autoControls:true,});
                // delegate calls to data-toggle="lightbox"
                $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {
                            if (window.console) {
                                return console.log('Checking our the events huh?');
                            }
                        },
						onNavigate: function(direction, itemIndex) {
                            if (window.console) {
                                return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                            }
						}
                    });
                });
                //Programatically call
                $('#open-image').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });
                $('#open-youtube').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });
				// navigateTo
                $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {
							var a = this.modal_content.find('.modal-footer a');
							if(a.length > 0) {
								a.click(function(e) {
									e.preventDefault();
									this.navigateTo(2);
								}.bind(this));
							}
                        }
                    });
                });
            });
        </script>
        <!-- Load google maps api and call initializeMap function defined in app.js -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;callback=initializeMap"></script>
        <!-- css3-mediaqueries.js for IE8 or older -->
        <!--[if lt IE 9]-->
            <script src="js/respond.min.js"></script>
        <!--[endif]-->
        <script type="text/javascript" src="js/app.js"></script>
        
    </body>
</html>
