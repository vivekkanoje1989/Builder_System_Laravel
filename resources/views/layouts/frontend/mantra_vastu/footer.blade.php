<div class="footer">
    <p>			
        <a href="http://www.edynamics.in" target="_blank">									
      <img src="<?php //echo EDYNAMICS_COMPANY_LOGO; ?>" alt="e-dynamics" width="32" height="32" border="0" class="ftr-logo">
        </a>			
        <?php
        $year = date('Y');
        //echo 'All Rights Reserved & copy ' . "$year " . LEGAL_NAME;
        ?>
    </p>
</div>
<div class="scrollup">
    <a href="#">
        <i class="icon-up-open"></i>
    </a>
</div>

<!---end the googl analytics code--->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Included the External Contact Us Jquery file--> 
<script type="text/javascript">
    var baseURL = "<?php //echo Yii::app()->getBaseUrl(true); ?>";
</script>

<!-- End the Contact Us Jquery File -->

    <script src="frontend/mantra_vastu/js/jquery.js"></script>
    
<script>
$(document).ready(function(){

 $(".nav > li a").click(function () {
        $(".nav li").removeClass('active');
        $(this).parent().addClass('active');
    });

    $("a").click(function () {
        $(".navt > li").removeClass('active');
        $(this).parent().addClass('active');
    });
     });
</script>
   
 <script type="text/javascript">
    $(document).ready(function ($) {

        $('.bxslider').bxSlider({mode: 'fade', captions: true, auto: true, autoControls: true, });
        // delegate calls to data-toggle="lightbox"
        $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function (event) {
            event.preventDefault();
            return $(this).ekkoLightbox({
                onShown: function () {
                    if (window.console) {
                        return console.log('Checking our the events huh?');
                    }
                },
                onNavigate: function (direction, itemIndex) {
                    if (window.console) {
                        return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
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
        $(document).delegate('*[data-gallery="navigateTo"]', 'click', function (event) {
            event.preventDefault();
            return $(this).ekkoLightbox({
                onShown: function () {
                    var a = this.modal_content.find('.modal-footer a');
                    if (a.length > 0) {
                        a.click(function (e) {
                            e.preventDefault();
                            this.navigateTo(2);
                        }.bind(this));
                    }
                }
            });
        });
    });
</script>


<script>
    window.onload = function ()
    {

        $('.popup').click(function (e) {
            var e = document.getElementById("enquiry-popup");
            var f = document.getElementById("enquiry-popup-form");
            e.style.display = "block";
            f.style.display = "block";
        });

        /*document.getElementById("experience").onclick = function () {
         var a = document.getElementById("experience-popup");
         var b = document.getElementById("experience-popup-form");
         a.style.display = "block";
         b.style.display = "block";
         };*/

        $('.popup1').click(function (e) {
            var g = document.getElementById("job-apply-popup");
            var h = document.getElementById("resumeform");
            g.style.display = "block";
            h.style.display = "block";
        });

        $('.popup2').click(function (e) {
            var a = document.getElementById("experience-popup");
            var b = document.getElementById("testimonialsform");
            a.style.display = "block";
            b.style.display = "block";
        });


//        document.getElementById("clos").onclick = function () {
//            var e = document.getElementById("enquiry-popup");
//            var f = document.getElementById("enquiry-popup-form");
//            var g = document.getElementById("job-apply-popup");
//            var h = document.getElementById("resumeform");
//            var a = document.getElementById("experience-popup");
//            var b = document.getElementById("testimonialsform");
//
//            e.style.display = "none";
//            f.style.display = "none";
//            g.style.display = "none";
//            h.style.display = "none";
//            a.style.display = "none";
//            b.style.display = "none";
//        };
    }
    
    $(function () {
    $(".btn_close").on('click', function() {
        $('.enquiry').hide();
        return false;
    });
});
    $(function () {
    $(".btn_close").on('click', function() {
        $('#experience-popup').hide();
        return false;
    });
});

   $(function () {
    $(".btn_close").on('click', function() {
        $('#resumeform').hide();
        return false;
    });
});
  
</script> 
<script src="frontend/mantra_vastu/js/jquery.bxslider.min.js" type="text/javascript"></script>
<script src="frontend/mantra_vastu/js/jquery.mixitup.js" type="text/javascript"></script>
<script src="frontend/mantra_vastu/js/bootstrap.js" type="text/javascript"></script>
<script src="frontend/mantra_vastu/js/modernizr.custom.js" type="text/javascript"></script>
<?php
//if ($action != 'projectdetails') {
    ?>
    <script src="frontend/mantra_vastu/js/jquery.cslider.js" type="text/javascript"></script>
    <script src="frontend/mantra_vastu/js/app.js" type="text/javascript"></script>
    <?php
//}
?>       	
<script src="frontend/mantra_vastu/js/jquery.placeholder.js" type="text/javascript"></script>
<script src="frontend/mantra_vastu/js/jquery.inview.js" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;callback=initializeMap" ></script>
<script src="frontend/mantra_vastu/js/respond.min.js" type="text/javascript"></script>
</body>
</html>