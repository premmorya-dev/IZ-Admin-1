<html dir="ltr" lang="en-US">

<head>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PRPWMF9');</script>
<!-- End Google Tag Manager -->

   

    

    <!-- Document Title
	============================================= -->
    <title>Workshop Registration Portal : Rendezvous 2024 IIT Delhi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="author" content="technocon.org">
    <meta name="description" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi">
    <meta property="fb:app_id" content="" />
    <meta property="og:type" content="event" />
    <meta property="og:title" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi" />
    <meta property="og:url" content="{{ url('/') }}/event/registration/rdv-2024-iit-delhi" />
    <meta property="og:image" content="{{ url('/') }}/assets/images/og-images/rdv-iit-delhi-og-image.jpg"/>
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="650" />
    <meta property="og:description" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@" />
    <meta name="twitter:title" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi" />
    <meta name="twitter:description" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi">
    <meta name="twitter:image" content="{{ url('/') }}/assets/images/og-images/rdv-iit-delhi-og-image.jpg" />
    <meta name="twitter:image:width" content="1200" />
    <meta name="twitter:image:height" content="600" />

    <link rel="icon" href="{{ url('/') }}/assets/images/favicons/favicon.png">






    <!-- Font Imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800;900&family=Cookie&display=swap" rel="stylesheet">

    <!-- Core Style -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   

    <link rel="stylesheet" href="{{ url('/') }}/assets/css/style.css ">

    <!-- Font Icons -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/registration/font-icons.css">

    <!-- Plugins/Components CSS -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/registration/swiper.css">

    <!-- Saas Page Module Specific Stylesheet -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/saas-2.css">
    <!-- select2 CSS -->
    <link href="{{ url('/') }}/assets/css/select2.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/custom.css">
	<script src="{{ url('/') }}/assets/js/jquery.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">



 
    
</head>


<body style="overflow-x:hidden;">
   
	<div id="wrapper">

    <section id="content">
			<div class="content-wrap content-wrap-workshop-registration">
				<div class="container">

					<div class="mx-auto mb-0" id="tab-login-register" style="max-width: 700px;">
						<div class="tab-content">
							<div class="tab-pane active show" id="tab-login" role="tabpanel" aria-labelledby="canvas-tab-login-tab" tabindex="0">
								<div class="card mb-0">
									<div class="card-body" style="padding: 10px;">
									<div class="row " style="border-bottom:var(--cnvs-themecolor) solid 5px;">
											<div>
                                            <img src="{{ url('/') }}/assets/images/login-page-banner.jpg" alt="">
											</div>
									</div>

									<div class="mt-3 promo promo-light">
										<h3 class="mb-3 text-center">Login to See Your Registered Program</h3>
										</div>
								
									
										<form id="login-form" name="login-form" class="mb-0" action="tryst_login.php" method="POST" novalidate>

											

											<div class="row">
												<div class="col-12 form-group">
													<label for="login-form-email">Email:</label>
                                                    <input type="email" id="email_id" onKeyUp="return check_mail1_error(this.value)" name="email_id" title="Email ID" placeholder="Email Id" value="" class="form-control">
                                                        <span class="text-danger"  id="error-msgemail"></span>
												</div>
											
												<div class="col-12 form-group">
													<label for="login-form-registration-no">Workshop Registration No.:</label>
													<input type="text" title="Your Registration Id" id="registration_number" placeholder="XXXX-XXXXXXXX" name="registration_number" value="" class="form-control" autocomplete="off"  onKeyUp="return check_login_reg_error(this.value)">
												</div>
												
											
												<div class="alert alert-danger" role="alert" id="error-email" style="display:none;">
														<span style=" font-style:italic; color:red;">        	 
														Please provide valid email!
														</span>
												</div>

												<div class="alert alert-danger" role="alert" id="error-registration" style="display:none;">
														<span style=" font-style:italic; color:red;">        	 
														Please provide valid registration!
														</span>
												</div>
                                                
                                                <div class="row">
                                                <div class="ms-2 alert alert-danger" role="alert" id="error-msg1login" style="display:none;">
														<span style=" font-style:italic; color:red;">        	 
														Email ID or Registration ID is Incorrect ! Please Try Again!
														</span>
												</div>

                                                </div>
											
												
												<div class="col-12 form-group">
													<div class="d-flex justify-content-between">
														<button class="button button-3d w-50 m-0"  id="login-form-submit" name="login-form-submit" value="login">Login</button>

													</div>
													<div class="d-flex justify-content-between mt-5">
														
													
														<a  href="#" class="" data-bs-toggle="modal" id="forget-link" data-bs-target="#staticBackdrop">
														    Forgot Workshop Registration No.?
																						</a>
													</div>

												</div>
											</div>

										</form>
									</div>
								</div>
							</div>

							

						</div>

					</div>

				</div>
			</div>
		</section><!-- #content end -->



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Retrieve Registration No.</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">   
			<div class="col-12 form-group">
			<label for="login-form-email">Email:</label>
			<input type="email" name="forget_email" id="forget_email" placeholder="yourname@example.com" value="" class="form-control" onKeyUp="check_forget_email_error(this.value)" autocomplete="off" title="Your Email Id">
			
		</div>


		   <div class="alert alert-success" role="alert" id="forget-registration-message" style="display:none;">
														<span style="">        	 
													       Registration no. sent successfully! Please check your email.
														</span>
		  </div>

		  <div class="alert alert-danger" role="alert" id="error-forget-email" style="display:none;">
														<span style=" font-style:italic; color:red;">        	 
														Please provide valid email!
														</span>
		  </div>
		  <div class="alert alert-danger" role="alert" id="error-email_not_exit" style="display:none;">
														<span style=" font-style:italic; color:red;">        	 
														This Email is not exist.
														</span>
		 </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="get-registration-number-btn" >Get Registration No.</button>
      </div>
    </div>
  </div>
</div>




</div>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{ url('/') }}/assets/js/functions.bundle.js"></script>

<script src="{{ url('/') }}/assets/js/plugins.min.js"></script>

<script src="{{ url('/') }}/assets/js/select2.js"></script>


<script>

$('#login-form-submit').on("click",function(e){
    e.preventDefault();
    var email_id = $("#email_id").val();
    var registration_number = $("#registration_number").val();
	if((check_mail1_error(email_id)!=1) )
	{		
		return false;		
	}
	else{ 
		var email=$('#email_id').val();
		var reg=$('#registration_number').val();
         $.ajax({
         url: '/event/do_login',
		 data: {registered_email:email_id,registration_number:registration_number},       
         type:'POST',
         headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
		 beforeSend: function() {
                    $('.loader').show()
                    },
         success:function(result){  
            
              if(result.error != 0){
                  $('#error-msg1login').show();  
				  $('.loader').hide() 
                  return false;
              }else{
                $('.loader').hide()
				   $('#error-msg1login').hide();
                   window.location.href = result.redirect;
                   $("#landing_busy_login").hide();
              }
         },
         error: function(data) {  console.log(data)
         alert('Error in Data Processing. Please try Again.');
          $("#landing_busy_login").hide();return false;
         }
       });
	}
        

});




$('#forget-link').on("click",function(e){
e.preventDefault();
    $('#forget-registration-message').hide();
	$('#error-email_not_exit').hide();   
	$('#get-registration-number-btn').text('Get Registration No.');
});

$('#get-registration-number-btn').on("click",function(e){

	e.preventDefault();
	var forget_email = $("#forget_email").val();  
	if((check_forget_email_error(forget_email)!=1) )
	{		
		return false;		
	}
	else{ 
			
         $.ajax({
         url: '/event/forget-email',
		 data: {registered_email: forget_email }, 
         type:'POST',
		 headers:{
			'X-CSRF-TOKEN': '{{ csrf_token() }}'
		 },
		 beforeSend: function() {
			$('#get-registration-number-btn').text('Loading..');
			$('#error-email_not_exit').hide();   
			$('#forget-registration-message').hide(); 
                    },
         success:function(result){ 
              if(result.error==0){
				$('#error-email_not_exit').hide();
				$('#forget-registration-message').show();              
                 
              }else{
				  $('#error-email_not_exit').show();  
                  return false;
              }
			  $('#get-registration-number-btn').text('Get Registration No.');
			 // $('#get-registration-number-btn').prop('disabled', true);
         },
		 complete:function(){
			$('#get-registration-number-btn').text('Get Registration No.');
		 },
         error: function(data) {
         alert('Error in Data Processing. Please try Again.');
		 $('#get-registration-number-btn').text('Get Registration No.');
          $("#landing_busy_login").hide();return false;
         }
       });0
	 
	}
        

});


function check_forget_email_error(login_email)
{

	    var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        // var error_msg = 'Please Enter Valid Email ID .';
        if (filter.test(login_email)) {
			$("#error-forget-email").hide();
            return true;
        } else {
			$("#error-forget-email").show();
			$("#forget_email").focus();
			return false;
        }

		
	
}
</script>


<script>
    const error = new Array();
   
    
   
    function check_mobile_country_code_id_error(mobile_country_code_id) {
        var error_msg = 'Please select country code';

        if ((mobile_country_code_id == "" || mobile_country_code_id == "0" || !mobile_country_code_id)) {
                $('#error-msgmobile_country_code_id').text(error_msg);
                $('#select-error-mobile_country_code_id .form-select ').addClass('is-invalid');
                $("#mobile_country_code_id").focus();
                $('#error-msgmobile_country_code_id').show();
                return false;
        }else{  
                $('#error-msgmobile_country_code_id').text('');
                $('#select-error-mobile_country_code_id .form-select ').removeClass('is-invalid');
                $("#mobile_country_code_id").focus();
                $('#error-msgmobile_country_code_id').hide();
                return true;
        }
    }
  


    function check_agree_error() {
        var error_msg = 'Please select agree term and condition';
        var checkbox = document.querySelector('#agree');
        if ($('#agree').length) { 
                        if (checkbox.checked) {
                            $('#error-msgagree').text('');
                            $('#agree').removeClass('is-invalid');
                            $("#agree").focus();
                            $('#error-msgagree').hide();
                            return true;
                    }else{  
                            $('#error-msgagree').text(error_msg);
                            $('#agree').addClass('is-invalid');
                            $("#agree").focus();
                            $('#error-msgagree').show();
                            return false;
                    }
            }else{
                return true;
            }
        
    }
  


    function check_state_id_error(state_id) {  
        var error_msg = 'Please Select State..';
        if ($('#state_id').length) {
            if ((state_id == "" || state_id == "0" || !state_id)) {
            $('#error-msgstate_id').text(error_msg);
            $('#select-error-state_id .form-select ').addClass('is-invalid');
            $("#state_id").focus();
            $('#error-msgstate_id').show();
            return false;
        } else {
            $('#error-msgstate_id').text('');
            $('#select-error-state_id .form-select ').removeClass('is-invalid');
            $('#error-msgstate_id').hide();
            return true;
        }
        }else{
                return true;
            }
       
    }

    function check_country_id_error(country_id) { 
        var error_msg = 'Please Select Country..';
        if ($('#country_id').length) {
                    if ((country_id == "" || country_id == "0" || !country_id)) {
                    $('#error-msgcountry_id').text(error_msg);           
                    $('#select-error-country_id .form-select ').addClass('is-invalid');
                    $("#country_id").focus();
                    $("#country_id").focus();
                    $('#error-msgcountry_id').show();
                    return false;
                } else {
                    $('#error-msgcountry_id').text('');
                    $('#select-error-country_id .form-select ').removeClass('is-invalid');
                    $('#error-msgcountry_id').hide();
                    return true;
                }
        }else{
                return true;
            }
       
    }



    function check_distt_error(distt) {
        if ((distt == "") || (distt.length <= 2)) {
            $("#distt").addClass('is-invalid');
            $("#distt").focus();
            return false;
        } else {

            $("#distt").removeClass('is-invalid');
            return true;
        }
    }

 

    function check_seats_error(seats) {
        var error_msg = 'Please Select Seats..';

        if ($('#seats').length) { 
                            if ((seats == "")) {
                            $('#error-msgseat').text(error_msg);
                            $("#seats").addClass('is-invalid');
                            $("#seats").focus();
                            $('#error-msgseat').show();
                            $('.errormsg').show();
                            return false;
                        } else {
                            $('#error-msgseat').text('');
                            $("#seats").removeClass('is-invalid');
                            $('#error-msgseat').hide();
                            $('.errormsg').hide();
                            return true;
                        }
            }else{
                return true;
            }

       
    }


    function check_check_in_error(check_in) {
        if ((check_in == "")) {
            $("#check_in").addClass('is-invalid');
            $("#check_in").focus();
            return false;
        } else {

            $("#check_in").removeClass('is-invalid');
            return true;
        }
    }


    function check_check_out_error(check_out) {
        if ((check_out == "")) {
            $("#check_out").addClass('is-invalid');
            $("#check_out").focus();
            return false;
        } else {

            $("#check_out").removeClass('is-invalid');
            return true;
        }
    }


    function check_login_email_error(login_email) {

        var filter = /^([\w-\.]+)@((\[[0-9]{1,9}\.[0-9]{1,9}\.[0-9]{1,9}\.)|(([\w-]+\.)+))([a-zA-Z]{2,9}|[0-9]{1,9})(\]?)$/;
        if (filter.test(login_email)) {
            $("#login_email").removeClass('is-invalid');
            return true;
        } else {
            $("#login_email").addClass('is-invalid');
            $("#login_email").focus();
            return false;
        }
    }


    function check_login_reg_error(login_reg) {
        if ((login_reg == "")) {
            $("#login_reg").addClass('is-invalid');
            $("#login_reg").focus();

            return false;
        } else {

            $("#login_reg").removeClass('is-invalid');
            return true;
        }
    }

    function check_collage_name_error(collage_name) { 
        var error_msg = 'Please Enter Your College Name.';
        if ($('#c_name').length) { 
                            if (collage_name == "") {
                            $('#error-msgcollege').text(error_msg);
                            $("#c_name").addClass('is-invalid');
                            $("#c_name").focus();
                            $('#error-msgcollege').show();
                            return false;
                        } else {
                            $('#error-msgcollege').text('');
                            $("#c_name").removeClass('is-invalid');
                            $('#error-msgcollege').hide();
                            return true;
                        }
            }else{
                return true;
            }
     
    }




    function check_city_name_error(city_name) {
        var error_msg = 'Please Enter Your City Name.';
        if ($('#city').length) {
                            if (city_name == "" || !city_name) {
                            $('#error-msgcity').text(error_msg);
                            $("#city").addClass('is-invalid');
                            $("#city").focus();
                            $('#error-msgcity').show();
                            return false;
                        } else {
                            $('#error-msgcity').text('');
                            $("#city").removeClass('is-invalid');
                            $('#error-msgcity').hide();
                            return true;
                        }
            }else{
                return true;
            } 
     
    }


    function check_post_code_error(shipping_address_post_code) {
        var error_msg = 'Please Enter Post Code.';

                        if (shipping_address_post_code == "" || !shipping_address_post_code) {
                            $('#error-shipping-address-shipping_address_post_code').text(error_msg);
                            $("#shipping_address_post_code").addClass('is-invalid');
                            $("#shipping_address_post_code").focus();
                            $('#error-shipping-address-shipping_address_post_code').show();
                            return false;
                        } else {
                            $('#error-shipping-address-shipping_address_post_code').text('');
                            $("#shipping_address_post_code").removeClass('is-invalid');
                            $('#error-shipping-address-shipping_address_post_code').hide();
                            return true;
                        }
         
     
    }




    function check_shipping_address_line1_error(shipping_address_line1) {
        var error_msg = 'Please Enter Shipping Address Line 1.';
        
                        if (shipping_address_line1 == "" || !shipping_address_line1) {
                            $('#error-shipping_address_line_1').text(error_msg);
                            $("#error-shipping_address_line_1").addClass('is-invalid');
                            $("#error-shipping_address_line_1").focus();
                            $('#error-shipping_address_line_1').show();
                            $('.errormsg').show();
                            return false;
                        } else {
                            $('#error-shipping_address_line_1').text('');
                            $("#error-shipping_address_line_1").removeClass('is-invalid');
                            $('#error-shipping_address_line_1').hide();
                            $('.errormsg').hide();
                            return true;
                        }
          
     
    }

    function check_mobile_error(mob) {
        var numericString = mob;
        var firstDigit = parseInt(numericString.charAt(0), 10);
        var error_msg = '';
        if ((isNaN(mob)) || (mob == "") || (mob.length <= 9)) {
            error_msg = 'Please Enter Your Valid Mobile No.';
            $('#error-msgmobile').text(error_msg);
            $("#mobile").addClass(' is-invalid');
            $("#mobile").focus();
            $('#error-msgmobile').show();
            $('.errormsg').show();
            return false;
        } else if (firstDigit == 0) {
            error_msg = 'First Digit should not be 0';
            $('#error-msgmobile').text(error_msg);
            $('#error-msgmobile').show();
            $('.errormsg').show();
        } else {
            $('#error-msgmobile').text('');
            $("#mobile").removeClass('is-invalid');
            $('#error-msgmobile').hide();
            $('#error-msgmobile').hide();
            $('.errormsg').hide();
            return true;
        }
    }


    function check_mail1_error(email) { 
        var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var error_msg = 'Please Enter Valid Email ID .';
        if (filter.test(email)) {
            $('#error-msgemail').text('');
            $("#email_id").removeClass('is-invalid');
            $('#error-msgemail').hide();
            $('.errormsg').hide();
            return true;
        } else {
            $('#error-msgemail').text(error_msg);
            $("#email_id").addClass('is-invalid');
            $("#email_id").focus();
            $('#error-msgemail').show();
            $('.errormsg').show();
            return false;
        }
    }

    function check_last_name_error(last_name) {
        var pattern = /[^a-z|^A-Z|^\s]/;
        var last_name = $("#last_name").val();
        var error_msg = 'Please Enter Valid Last Name..';

        if ($('#last_name').length) { 
                                if (document.getElementById("last_name").value.match(pattern)) {
                                $('#error-msglname').text(error_msg);
                                $("#last_name").addClass('is-invalid');
                                $('#error-msglname').show();
                                $('.errormsg').show();
                                return false;
                            } else if ((last_name == "")) {
                                $('#error-msglname').text(error_msg);
                                $("#last_name").addClass(' is-invalid');
                                $('#error-msglname').show();
                                $('.errormsg').show();
                                return false;
                            } else {
                                $('#error-msglname').text('');
                                $("#last_name").removeClass(' is-invalid');
                                $('#error-msglname').hide();
                                $('.errormsg').hide();
                                return true;
                            }
            }else{
                return true;
            }


    
    }



    function check_fist_name_error(first_name) { 
        var pattern = /[^a-z|^A-Z|^\s]/;
        var first_name = $("#first_name").val();
        var name = isNaN(first_name);
        var error_msg = 'Please Enter Valid First Name..';
        if (document.getElementById("first_name").value.match(pattern)) {
            $('#error-msgname').text(error_msg);
            $("#first_name").addClass('is-invalid');
            $('#error-msgname').show();
            $('.errormsg').hide();
            return true;
        } else if ((first_name == "")) {
            $('#error-msgname').text(error_msg);
            $("#first_name").addClass('is-invalid');
            $("#first_name").focus();
            $('#error-msgname').show();
            $('.errormsg').show();
            return false;
        } else {
            $('#error-msgname').text('');
            $("#first_name").removeClass('is-invalid');
            $('#error-msgname').hide();
            $('.errormsg').hide();
            return true;
        }

    }

    function updateRegistration() { 
        var fname = $("#first_name").val();
        var lname = $("#last_name").val();
        var mobile = $("#mobile").val();
        var collage_name = $("#c_name").val();
        var city = $("#city").val();

        var mobile_country_code_id = $("#mobile_country_code_id").val();
        var country_id = $("#country_id").val();
        var state_id = $("#state_id").val();

    
        var error = 0;

        
        if(check_fist_name_error(fname) === false) {
            error = 1;
        }
        if(check_last_name_error(lname) === false){
            error = 1;
        }
       
        if(check_mobile_error(mobile) === false){
         error = 1;
        }
        if(check_collage_name_error(collage_name) === false){
          error = 1;
        }
        if(check_city_name_error(city) === false){
         error = 1;
        }
       
       
        if(check_mobile_country_code_id_error(mobile_country_code_id) === false){
           error = 1;
        }
       
        if(check_country_id_error(country_id) === false){
           error = 1;
        }
        if(check_state_id_error(state_id) === false){
           error = 1;
        }
        
      if(error){
         return false;
      }



   
    
      $.ajax({
            url: '/ajax/update-registration',
            data: new FormData(document.querySelector('#update-registration')),
            processData: false,
            contentType: false,
            type: 'POST',
            headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token()  }}'
                },
            beforeSend: function() { 
                $('.loader').show()
            },
            complete: function() { 
                $('.loader').hide()
            },
            success: function(result) {  
              if(result.error == 0){  console.log(result);             
                window.location.reload();
              }
                
            },
            error: function(data) { console.log(data)
                $('#edit-registration-message').text('Something went wrong. please try again later');               
                $('#edit-registration-message').addClass('alert alert-danger');
                return false;
            }
        });


    }
  
    function updateShippingAddress() { 
        var fname = $("#first_name").val();
        var shipping_address_line_1 = $("#shipping_address_line_1").val();
        var mobile = $("#mobile").val();
        var city = $("#city").val();
        var shipping_address_post_code = $("#shipping_address_post_code").val();
        var mobile_country_code_id = $("#mobile_country_code_id").val();
        var country_id = $("#country_id").val();
        var state_id = $("#state_id").val();

    
        var error = 0;

        
        if(check_fist_name_error(fname) === false) {
            error = 1;
        }     
       
        if(check_mobile_error(mobile) === false){
         error = 1;
        }
       
        if(check_city_name_error(city) === false){
         error = 1;
        }     
        
        if(check_shipping_address_line1_error(shipping_address_line_1) === false){
           error = 1;
        }    

        if(check_mobile_country_code_id_error(mobile_country_code_id) === false){
           error = 1;
        }
       
        if(check_country_id_error(country_id) === false){
           error = 1;
        }
        if(check_state_id_error(state_id) === false){
           error = 1;
        }
        
      if(error){
         return false;
      }


   
        $.ajax({
            url: '/ajax/update-shipping-address',
            data: new FormData(document.querySelector('#form-update-address')),
            processData: false,
            contentType: false,
            type: 'POST',
            headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token()  }}'
                },
            beforeSend: function() { 
                $('.loader').show()
            },
            complete: function() { 
                $('.loader').hide()
            },
            success: function(result) {  
                if(result.error == 0){             
                   window.location.reload();
                }
               
                
            },
            error: function(data) { console.log(data)
                $('#edit-shipping-address-message').text('Something went wrong. please try again later');               
                $('#edit-shipping-address-message').addClass('alert alert-danger');
                return false;
            }
        });
    }


    function register_workshop() { 

       
        $('#register-btn').attr('disabled','disabled')
        $('.loader').hide()
        var program = $("#program").val();
        var fname = $("#first_name").val();
        var lname = $("#last_name").val();
        var email = $("#email_id").val();
        var mobile = $("#mobile").val();
        var collage_name = $("#c_name").val();
        var city = $("#city").val();
        var seats = $("#seats").val();

        var mobile_country_code_id = $("#mobile_country_code_id").val();
        var country_id = $("#country_id").val();
        var state_id = $("#state_id").val();

    
        var error = 0;

        var reff = $('#rff').val();
        $('#error-user_exist').text('')
        
        if(check_fist_name_error(fname) === false) {
            error = 1;
        }
        if(check_last_name_error(lname) === false){
            error = 1;
        }
        if(check_mail1_error(email) === false){
            error = 1;
        }
        if(check_mobile_error(mobile) === false){
         error = 1;
        }
        if(check_collage_name_error(collage_name) === false){
          error = 1;
        }
        if(check_city_name_error(city) === false){
         error = 1;
        }
        if(check_program_error(program) === false){
           error = 1;
        }
        if(check_seats_error(seats) === false){
           error = 1;
        }

        if(check_mobile_country_code_id_error(mobile_country_code_id) === false){
           error = 1;
        }
        if(check_agree_error() === false){
           error = 1;
        }
        if(check_country_id_error(country_id) === false){
           error = 1;
        }
        if(check_state_id_error(state_id) === false){
           error = 1;
        }
        
      if(error){
         return false;
      }


   
        $.ajax({
            url: '/ajax/add-student-registration',
            data: new FormData(document.querySelector('#user_signup')),
            processData: false,
            contentType: false,
            type: 'POST',
            headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token()  }}'
                },
            beforeSend: function() { 
                 $('.loader').show()
                 $('#register-btn').attr('disabled','disabled')
                 $('#register-btn').hide()
            },
            complete: function() { 
                $('.loader').hide()
                $('#register-btn').show()
               // $('#register-btn').prop('disabled', false);
            },
            success: function(result) { 
                

                if (typeof result.errors !== 'undefined' && 
                    Array.isArray(result.errors.email_id) && 
                    result.errors.email_id.length > 0) {
                    $('#error-user_exist').text(result.errors.email_id[0]);
                } 
                if(result.error == 0 ){
                    window.location.href = result.redirect;                   

                }
                
            },
            error: function(data) { $('#register-btn').prop('disabled', false);console.log(data)
                // alert('Error in Data Processing. Please try Again.');
                // return false;
            }
        });



    }
</script>



<script>
    function check_program_error(program) {

        var program = $("#program").val();
        var error_msg = 'Please Select WorkShop Type.';
        $.ajax({
            url: '/ajax/get-seat',
            data: { program_id : $('#program').val() },
            type: 'GET',
            dataType: 'json',
            success: function(result) {

                $('#seats').html(result['html']);


                if (result['count'] > 1) {
                    $('#seat-container').show();
                } else {
                    $('#seat-container').hide();

                }
            }
        });


        if ((program == 0)) {
            $("#error-msgworktype").text(error_msg);
            $("#program").addClass('is-invalid');
            $('#select-error-program .form-select ').addClass('is-invalid');

            $('#error-msgworktype').show();
            return false;
        } else {
            $("#error-msgworktype").text('');
            $('#select-error-program .form-select ').removeClass('is-invalid');
            $('#error-msgworktype').hide();
            return true;
        }
    }

    function vpb_refresh_aptcha() {

        return $("#vpb_captcha_code").val('').focus(), document.images['captchaimg'].src = document.images['captchaimg'].src.substring(0, document.images['captchaimg'].src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
    }



 


    function login_workshop() {

        var login_email = $("#login_email").val();
        var login_reg = $("#login_reg").val();
        if ((check_login_email_error(login_email) != 1) || (check_login_reg_error(login_reg) != 1)) {
            $("#show_login_form_workshop").css('border-color', 'red');
            $("#error_msg_login").show();
            return false;

        }



        var email = $('#login_email').val();
        var reg = $('#login_reg').val();
        $.ajax({
            url: 'tryst_login.php',
            data: {
                'Email': email,
                'RegId': reg
            },
            type: 'POST',
            success: function(result) {
                if (result == 0) {
                    $('#error-msg1login').show();
                    $('#error-msg2login').show();
                    $('#show_login_form_workshop').css('border-color', 'red');

                    return false;
                } else {

                    window.location.href = "../wep.php?r=" + result;
                    $("#landing_busy_login").hide();
                }
            },
            error: function(data) {
                alert('Error in Data Processing. Please try Again.');
                $("#landing_busy_login").hide();
                return false;
            }
        });

    }
</script>

