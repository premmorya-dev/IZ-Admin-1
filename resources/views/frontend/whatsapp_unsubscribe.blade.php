<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
       
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top:50px;
        }

        .responsive-img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

  

    <div class="image-container">
        <img src="{{ asset('technocon.png') }}" alt="technocon logo" class="responsive-img">
    </div>
   
    <div class="text-center">
        <button class="btn btn-large btn-primary" id="unsubscribe-btn">
            {{ $data['whatsapp_optin_status']=='true' ? 'Unsubscribe' : 'Resubscribe' }}
        </button>
    </div>
    <div class="alert mt-5 mx-5 text-center" style="display: none;" id="msg" role="alert"></div>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $('#unsubscribe-btn').on("click", function() {
        $('#msg').removeClass('alert-success');
        $('#msg').removeClass('alert-danger');
        $.ajax({
            url: "{{ $data['whatsapp_optin_status']=='true' ? route('whatsapp.unsubscribe') : route('whatsapp.resubscribe')  }}",         
            data: {
                mobile_no: "{{ isset($data['mobile_number']) ? $data['mobile_number'] : '' }}",
                registration_number: "{{ isset($data['registration_number']) ? $data['registration_number'] : '' }}"
            },
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token()  }}'
            },
            beforeSend: function() {},
            complete: function() {},
            success: function(response) {
                $('#msg').show();
                $('#msg').text(response.message);

                if (response.error == 0) {
                    $('#msg').addClass('alert-success');
                    $('#msg').removeClass('alert-danger');

                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }

                if (response.error == 1) {
                    $('#msg').addClass('alert-danger');
                    $('#msg').removeClass('alert-success');
                }


            }
        });
    });
</script>