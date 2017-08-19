$(document).ready(function(){    
    $('.toggleForm').click(function(){       
         var height = jQuery('.wrap-filter-form').height();
          if (height > 650){
              $(".wrap-filter-form").addClass('abc');
//              $(".wrap-filter-form").css("overflow-y","scroll");  
//              $(".wrap-filter-form").css("height","650");  
          }
         
        $('#slideout').toggleClass('on');
        if ($(".wrap-filter-form").hasClass("on")) {
            $(".mainDiv").css("opacity","0.2");
            $(".mainDiv").css("pointer-events","none");
        }else{
            $(".mainDiv").css("opacity","");
            $(".mainDiv").css("pointer-events","visible");
        }
    });
});

//  jQuery(document).on('click', '.toggleForm', function () {
//      
//        var width = jQuery('.wrap-filter-form').width();
//        var right = parseInt(jQuery('.wrap-filter-form').css('right').replace('px', ''));
//        if (right < 0)
//        {
//            jQuery('.wrap-filter-form').animate({right: 0});
//            $(".mainDiv").css("opacity","0.2");
//              $(".mainDiv").css("pointer-events","none");
//        }
//        else
//        {
//            jQuery('.wrap-filter-form').animate({right: -width - 40});
//            setTimeout(function(){  $(".mainDiv").css("opacity",""); }, 1000);
//            $(".mainDiv").css("pointer-events","visible");
//        }
//    });
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