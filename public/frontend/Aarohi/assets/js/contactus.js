 function validatecontact()
            {
                    if($('#contact_name').val()==="")
                    {
                        alert('Please enter full name');
                        $('#contact_name').focus();
                        return false;
                    }
                   
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if($('#contact_email').val()==="")
                    {
                        alert('Please enter email ID');
                        $('#contact_email').focus();
                        return false;
                    }
                    else if($('#contact_email').val()!== '' )
                    {
                        if(!regex.test($('#contact_email').val())) 
                        {
                             alert('Please enter email ID');
                             $('#contact_email').focus();
                             return false;
                        }
                    }
                    
                    var mob = /^([987]{1,1})+([0-9]{9,9})$/;
                    if($('#contact_mobile').val()==="")
                    {
                        alert('Please enter Mobile Number');
                        $('#contact_mobile').focus();
                        return false;
                    }
                    else if($('#contact_mobile').val()!== '')
                    {
                        if(!mob.test($('#contact_mobile').val()))
                        {            
                            alert('Mobile Number is invalid');
                            $('#contact_mobile').focus();
                            return false;
                        }
                    }
                   
                     if($('#contact_msg').val()==="")
                    {
                        alert('Please enter message');
                        $('#contact_msg').focus();
                        return false;
                    }
                    if($('#imgcaptcha').val()==="")
                    {                
                        alert('Enter varification code shown below .');
                        $('#imgcaptcha').focus();
                        return false;
                    } 
                    return true;
            }
				$(document).ready(function() {
					$('#contact_sbt').click(function()
							 {
								
								if(validatecontact())
								{
									
									var res;
									var cname=$('#contact_name').val();
									var cemail=$('#contact_email').val();
									var cmobile=$('#contact_mobile').val();
									var cmessage=$('#contact_msg').val();
									var imgcaptcha= 'contact_captcha';
									var img=$('#imgcaptcha').val();
									  $.ajax({
											   url:baseURL+"/index.php/site/check",
											   type: "POST",
											   async:false,
											   data: {"first_name":cname,"mobile":cmobile,"email":cemail,"message":cmessage,"img":img,"imgcaptcha":imgcaptcha},		
											   success: function(result){
														 res=result;
														
												},		
										});
										
									if(res ==='false')
									{
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
										$("#imgcaptcha").after( "<div id='msg' style='color: blue;'>Message sent successfully.</div>" );
										refreshCaptcha('contact_captcha');
									
								}
									
							 });
							 
				});



