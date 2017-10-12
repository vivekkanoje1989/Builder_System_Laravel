 function refreshCaptcha(name)
    {
	var img = document.images[name];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000+'&name='+name;	
    }
			$(document).ready(function()
			{
					 $('#contact_sbt').click(function()	
    {
        if (validate_contact())
        {
            var res;
            var cname = $('#contact_name').val();
            var cemail = $('#contact_email').val();
            var cmobile = $('#contact_mobile').val();
            var cmessage = $('#contact_msg').val();
            var imgcaptcha = 'contact_captcha';
            var img = $('#imgcaptcha').val();
            $.ajax({
                url: "<?php echo Yii::app()->getBaseUrl(true); ?>/index.php/Site/check",
                type: "POST",
                async: false,
                data: {"first_name": cname, "mobile": cmobile, "email": cemail, "message": cmessage, "img": img, "imgcaptcha": imgcaptcha},
                success: function(result) {
					//alert( result );
                    var result = result.split(",");
						 res = result[0];
                },
            });
			res.trim();
            if (res == 'false')
            {
				refreshCaptcha('contact_captcha');
                alert('Worng verification code entered');
                $('#imgcaptcha').focus();
                $('#imgcaptcha').val("");
                return false;
            }
            $('#contact_name').val('');
            $('#contact_email').val('');
            $('#contact_mobile').val('');
            $('#contact_msg').val('');
            $('#imgcaptcha').val("");
            $('#msg').hide();
            $("#imgcaptcha").after("<div id='msg' style='color: #008e47;'>Message sent successfully.</div>");
            refreshCaptcha('contact_captcha');
			$('.close').click();
        }
    });
			
			});

			