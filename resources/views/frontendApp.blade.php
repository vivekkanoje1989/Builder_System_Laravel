<html lang="en">
    <head>
        <title>BMS</title>

        <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="shortcut icon" href="assets/ico/favicon.ico">
        <!-- CSS Global -->
        <link href="/frontend/theme31/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/prettyphoto/css/prettyPhoto.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/owl-carousel2/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/owl-carousel2/assets/owl.theme.default.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/animate/animate.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/swiper/css/swiper.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="/frontend/theme31/assets/css/theme.css" rel="stylesheet">

        <!-- Head Libs -->
        <script src="/frontend/theme31/assets/plugins/modernizr.custom.js"></script>

        <!--[if lt IE 9]>
        <script src="assets/plugins/iesupport/html5shiv.js"></script>
        <script src="assets/plugins/iesupport/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="home" class="wide">
        <!-- PRELOADER -->
        <div id="preloader">
            <div id="preloader-status">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
                <div id="preloader-title">Loading</div>
            </div>
        </div>
        <!-- /PRELOADER -->
        <div class="head-menu">
            <i class="fa fa-bars menu-bar"></i>
            <ul class="nav sf-menu">                                               
                <li><a href="#" title="HOME"><i class="fa fa-university"></i></a>
                    <ul class="menu-titl">
                        <li><a href="index.html">Home</a></li>
                    </ul>
                </li>
                <li><a href="#" title="All Projects"><i class="fa fa-building"></i></a>
                    <ul class="menu-titl">
                        <li><a href="projects.html">All Projects</a></li>
                    </ul>
                </li>
                <li><a href="#" title="Who We Are"><i class="fa fa-file-text"></i></a>
                    <ul class="menu-titl">
                        <li><a href="about.html">What We Are</a></li>
                        <li><a href="career.html">Career With Us</a></li>
                    </ul>
                </li>	
                <li><a href="contact.html" title="Contact"><i class="fa fa-phone"></i></a>	
                    <ul class="menu-titl">
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </li>
            </ul>									
        </div>
        <!-- WRAPPER -->
        <div class="wrapper">



            <!-- CONTENT AREA -->
            <div class="content-area">   

           @yield('content')


                <!-- modal -->
                <div class="modal fade" id="experience" role="dialog">
                    <div class="modal-dialog modal-sm">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-asterisk"></i></button>
                                <h4 class="modal-title">Share Thoughts With Us</h4>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="mod-in" placeholder="Mobile Number">
                                <input type="text" class="mod-in" placeholder="First Name">
                                <input type="text" class="mod-in" placeholder="Last Name">
                                <input type="text" class="mod-in" placeholder="Company Name">
                                <textarea class="mod-in" placeholder="Your Thoughts"></textarea>
                                <img src="assets/img/captcha.png" />
                                <input type="text" class="mod-in" placeholder="Captcha Text">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-red">Send&nbsp;<i class="fa fa-paper-plane"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end modal -->
                <!-- FOOTER -->
                <footer class="footer">
                    <div class="footer-meta">
                        <div class="container">
                            <div class="row">

                                <div class="col-sm-12">
                                    <p class="btn-row text-center">
                                        <a href="#" class="btn btn-theme ripple-effect btn-icon-left facebook wow fadeInDown" data-wow-offset="20" data-wow-delay="100ms"><i class="fa fa-facebook"></i>FACEBOOK</a>
                                        <a href="#" class="btn btn-theme btn-icon-left ripple-effect twitter wow fadeInDown" data-wow-offset="20" data-wow-delay="200ms"><i class="fa fa-twitter"></i>TWITTER</a>
                                        <a href="#" class="btn btn-theme btn-icon-left ripple-effect pinterest wow fadeInDown" data-wow-offset="20" data-wow-delay="300ms"><i class="fa fa-pinterest"></i>PINTEREST</a>
                                        <a href="#" class="btn btn-theme btn-icon-left ripple-effect google wow fadeInDown" data-wow-offset="20" data-wow-delay="400ms"><i class="fa fa-google"></i>GOOGLE</a>
                                    </p>
                                    <div class="copyright"> All Rights Reserved &copy; 2016 ABC Builders Private Limited</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </footer>
                <!-- /FOOTER -->

                <div id="to-top" class="to-top"><i class="fa fa-angle-up"></i></div>

            </div>
            <!-- /WRAPPER -->

            <!-- JS Global -->
            <script src="/frontend/theme31/assets/plugins/jquery/jquery-1.11.1.min.js"></script>
            <script src="/frontend/theme31/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
            <script src="/frontend/theme31/assets/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
            <script src="/frontend/theme31/assets/plugins/superfish/js/superfish.min.js"></script>
            <script src="/frontend/theme31/assets/plugins/prettyphoto/js/jquery.prettyPhoto.js"></script>
            <script src="/frontend/theme31/assets/plugins/owl-carousel2/owl.carousel.min.js"></script>
            <script src="/frontend/theme31/assets/plugins/jquery.sticky.min.js"></script>
            <script src="/frontend/theme31/assets/plugins/jquery.easing.min.js"></script>
            <script src="/frontend/theme31/assets/plugins/jquery.smoothscroll.min.js"></script>
            <!--<script src="assets/plugins/smooth-scrollbar.min.js"></script>-->
            <!--<script src="assets/plugins/wow/wow.min.js"></script>-->
            <script>
                // WOW - animated content
                //new WOW().init();
            </script>
            <script src="/frontend/theme31/assets/plugins/swiper/js/swiper.jquery.min.js"></script>
            <script src="/frontend/theme31/assets/plugins/datetimepicker/js/moment-with-locales.min.js"></script>
            <script src="/frontend/theme31/assets/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

            <!-- JS Page Level -->
            <script src="/frontend/theme31/assets/js/theme-ajax-mail.js"></script>
            <script src="/frontend/theme31/assets/js/theme.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
            <script>
        $(document).ready(function () {
            $(".head-menu").mouseover(function () {
                $(".head-menu").css({"left": "0px"});
            });

            $(".head-menu").mouseout(function () {
                $(".head-menu").css({"left": "-55px"});
            });


        });
            </script>
    </body>
</html>