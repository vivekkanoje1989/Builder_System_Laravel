$(document).ready(function(){
    $('.toggleForm').click(function(){
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