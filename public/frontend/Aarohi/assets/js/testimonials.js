
function validate_testimonial()
    {
        var mob = /^([987]{1,1})+([0-9]{9,9})$/;
         
     if($('#test_firstname').val()=='' )
          {
           alert('Enter First Name');   
           return false;
          }
      else if($('#test_lastname').val()=='' )
          {
          alert('Enter Last Name');   
           return false;
          }
		else if($('#test_mobile').val()=='' )
          {
           alert('Enter Mobile Number');   
           return false;
          }
		  else if(!mob.test($('#test_mobile').val()))
          {
           alert('Enter Correct Mobile Number');   
           return false;
          }
      else if($('#test_cname').val()=='' )
          {
           alert('Enter Company Name');   
           return false;
          }
       
      else if($('#test_exp').val()=='')
          {
           alert('Enter Experience ');   
           return false;
          }
       else if($('#captchatxt').val()=='')
          {
           alert('Please Enter Captcha Text ');   
           return false;
          }    
    
      else
          return true;
        
    }


$(document).ready(function() {
$('#submit_testimonials').click(function(e){
     
        if(validate_testimonial())
        {
                var captcha = $('#captchatxt').val();
               $.ajax({
                   url: baseURL+"/index.php/site/captchatestimonial",
                   type: "POST",
                   data: {"captcha":captcha },	
                  async: false,
           }).done(function(data) {
             if(data == 'true')
                 {
                   alert('Thank You For Sharing Your Experience');  
                  document.forms["Testimonials"].submit();
                 }
             else
                 {
                   alert('Please Enter Correct Captcha Text');
                   return false;
                 }

            });
       }
       else
       {
          return false;
       }
    });
});	