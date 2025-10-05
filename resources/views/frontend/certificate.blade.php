@extends('frontend.master')
@section('content')

<body style="overflow-x:hidden;">


    <div id="wrapper">
       


    <section id="content">
<div class="content-wrap bg-light">
				<div class="container">

					<div class="row col-mb-80">
						<main class="postcontent col-lg-12">

							<div class="row g-4 mb-5">

								<article class="entry event col-12 mb-0">
									<div class="grid-inner bg-white row g-0 p-3 border-0 rounded-5 shadow-sm h-shadow all-ts h-translate-y-sm">
										
									<div class="heading-block text-center">
											<h1>Certificate Validation</h1>
											<h5>This Utility is to verify Workshop/Training Certificates</h5>
									</div>

									<div class="card border-0 mx-auto" style="max-width: 600px;">
							
							<div class="card-body p-4">
								<h3 class="card-title font-body">Enter Your Certificate Information</h3>
								<div class="form-widget">

									<div class="form-result"></div>

									<form class="mb-0 position-relative" id="modal-health" name="modal-health" method="post" enctype="multipart/form-data" novalidate="novalidate">

										<div class="form-process">
											<div class="css3-spinner">
												<div class="css3-spinner-scaler"></div>
											</div>
										</div>
										<div class="row">

											<div class="col-12 form-group">
												<label for="modal-Certificate-name">Certificate Code or Registration Number:</label>
												<input type="text" name="modal_certificate_name" id="certificate-code" class="form-control required valid" value="" placeholder="Please Enter Your Certificate Code or Registration Number">

												<div class="alert alert-danger mt-3" id="error-message" style="display:none;" role="alert">
														
											    </div>
											</div>

											


											
											<div class="col-12">
												<button name="modal-Certificate-submit" id="modal-Certificate-submit" class="btn btn-danger w-100 py-2 mt-10">Validate Certificate</button>
											</div>



										</div>

									</form>
								</div>
							</div>
						</div>

									</div>
								</article>

								

							</div>

							
						</main>

						
					</div>

				</div>
			</div>
			<div class="content-wrap py-0">
				<div class="clear"></div>
					<div id="section-blog" class="page-section pb-5" style="background: linear-gradient(to bottom, transparent 40%, rgba(var(--bs-primary-rgb), .1) 40%);">
						<div class="container py-5"></div>
					</div>
			</div>
			
</section>


    </div>




</body>

<script>
    $(document).ready(function() {

        $('#modal-Certificate-submit').on('click', function(e) {
            e.preventDefault();
            var certificate_code =   $('#certificate-code').val() ? $('#certificate-code').val() : 0;

            
            try {
                $.ajax({
                    url: '/certificate/get-certificate/', 
					data:{ certificate_registration_number: certificate_code }   ,               
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function () {

                    $('#modal-Certificate-submit').text('Loading...');
                    },
                    complete: function(){
                    $('#modal-Certificate-submit').text('View Certificate');
                    },
                    success: function(response) {    
                        	
                    if(response.error == 1 ){
                        $('#error-message').text(response.message)
                        $('#error-message').show()

                    }else{
                        $('#error-message').text('')
                        $('#error-message').hide()
                    }

                
                    if( response.error == 0 ){
                        window.location.href = response.redirect_url
                    }
                   
                     
                    }

                });
            } catch (error) {
                console.error('Error:', error);
            }
        });







    });


</script>


@endsection