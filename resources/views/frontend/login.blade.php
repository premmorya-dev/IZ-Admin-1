@extends('frontend.master')
@section('content')

<body style="overflow-x:hidden;">
    @if($data['form_setting']['start_body_script'])
    {!! $data['form_setting']['start_body_script'] !!}
    @endif
	<div id="wrapper">
    <div class="loader">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
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
                                            <img src="{{ asset($data['form_setting']['page_header_banner_image_url']) }}" alt="{{ asset($data['form_setting']['page_header_banner_image_alt']) }}">
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
		 data: {registered_email: forget_email, seo_handle:"{{$data['form_setting']['seo_url']}}" }, 
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

@endsection