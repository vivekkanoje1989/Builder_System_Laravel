
<!-- Include javascript -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="frontend/mantravastu/js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.bxslider').bxSlider({
        mode: 'fade',
        captions: true,
        auto: true,
        //  autoControls: true,
    });
});
</script>

<script>
        window.onload = function () {
document.getElementById("enquiry").onclick = function () {
var e = document.getElementById("enquiry-popup");
var f = document.getElementById("enquiry-popup-form");
e.style.display = "block";
f.style.display = "block";
};
document.getElementById("experience").onclick = function () {
var a = document.getElementById("experience-popup");
var b = document.getElementById("experience-popup-form");
a.style.display = "block";
b.style.display = "block";
};
document.getElementById("job-apply").onclick = function () {
var g = document.getElementById("job-apply-popup");
var h = document.getElementById("job-apply-popup-form");
g.style.display = "block";
h.style.display = "block";
};
document.getElementById("job-apply-2").onclick = function () {
var g = document.getElementById("job-apply-popup");
var h = document.getElementById("job-apply-popup-form");
g.style.display = "block";
h.style.display = "block";
};
document.getElementById("clos").onclick = function () {
var e = document.getElementById("enquiry-popup");
var f = document.getElementById("enquiry-popup-form");
var g = document.getElementById("job-apply-popup");
var h = document.getElementById("job-apply-popup-form");
var a = document.getElementById("experience-popup");
var b = document.getElementById("experience-popup-form");
e.style.display = "none";
f.style.display = "none";
g.style.display = "none";
h.style.display = "none";
a.style.display = "none";
b.style.display = "none";
};
} 

</script> 






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
                
                
                
<!-- jQuery library (served from Google) -->
<!-- bxSlider Javascript file -->
<script src="frontend/mantravastu/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.mixitup.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/bootstrap.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/modernizr.custom.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.cslider.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.inview.js"></script>
<!-- Load google maps api and call initializeMap function defined in app.js -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;callback=initializeMap"></script>
<!-- css3-mediaqueries.js for IE8 or older -->
<!--[if lt IE 9]-->
<script src="frontend/mantravastu/js/respond.min.js"></script>
<!--[endif]-->
<script type="text/javascript" src="frontend/mantravastu/js/app.js"></script>
<script type="text/javascript" src="frontend/mantravastu/js/jquery.scrollTo.js"></script>
</body>
</html>