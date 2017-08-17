//$(document).ready(function(){
//    $('.toggleForm').click(function(){
//        $('#slideout').toggleClass('on');
//        if ($(".wrap-filter-form").hasClass("on")) {
//            $(".mainDiv").css("opacity","0.2");
//            $(".mainDiv").css("pointer-events","none");
//        }else{
//            $(".mainDiv").css("opacity","");
//            $(".mainDiv").css("pointer-events","visible");
//        }
//    });
//});
//$(document).ready(function(){
  jQuery(document).on('click', '.toggleForm', function () {
      
        var width = jQuery('.wrap-filter-form').width();
        var right = parseInt(jQuery('.wrap-filter-form').css('right').replace('px', ''));
        if (right < 0)
        {
            jQuery('.wrap-filter-form').animate({right: 0});
            $(".mainDiv").css("opacity","0.2");
              $(".mainDiv").css("pointer-events","none");
        }
        else
        {
            jQuery('.wrap-filter-form').animate({right: -width - 40});
            setTimeout(function(){  $(".mainDiv").css("opacity",""); }, 1000);
            $(".mainDiv").css("pointer-events","visible");
        }
    });
//    function slideOutSlidebar()
//    {
//        var width = jQuery('.wrap-filter-form').width();
//        var right = parseInt(jQuery('.wrap-filter-form').css('right').replace('px', ''));
//        if (right < 0)
//        {
//            jQuery('.wrap-filter-form').animate({right: 0});
//        }
//    }
//    });