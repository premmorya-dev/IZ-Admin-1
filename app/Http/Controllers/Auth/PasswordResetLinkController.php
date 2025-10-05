<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Validation\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {

        //   dd($request->all());
        // addJavascriptFile('assets/js/custom/authentication/reset-password/reset-password.js');

        return view('pages/auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function sendLink(Request $request)
    {

        $otp = random_int(100000, 999999);
        session(['otp' => $otp]);

        // session('otp'); 

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = setting('debug')  ?? '' ; 
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host       = setting('host_name')  ?? '' ; 
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   =  setting('user_name')  ?? '' ; 
            $mail->Password   =  setting('password')  ?? '' ; 
            $mail->SMTPSecure = setting('encryption')  ?? '' ; 
            $mail->Port       = setting('port')  ?? '' ; 

            // from
            $mail->setFrom(  setting('email_from'),setting('email_from_name')  );

            //to
            $mail->addAddress($request->email); // 


            // Content

            

            $message =   str_replace('{OTP}' , $otp,setting('otp_template') );     


            $subject =   setting('otp_template_subject') ;     

            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject =  $subject;
            $mail->Body    =  $message;

            $mail->send();
            return response()->json(
                [
                    'error' => 0,
                    'message' => 'mail sent successfully'

                ]
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => 1,
                    'message' => $mail->ErrorInfo
                ]
            );
        }
    }

    public function reset(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'otp' => [
                'required',
                'numeric',
                'digits:6',
                function ($attribute, $value, $fail) {
                    if ($value != session('otp')) {
                        $fail('The ' . $attribute . ' is invalid.');
                    }
                }
            ],
            'new_password' => 'required',
            'confirm_password' => ['required', 'same:new_password', Rules\Password::defaults()],
        ]);

        // If validation fails, return a JSON response with errors
        if ($validator->fails()) {
            return response()->json([
                'error' => 1,
                'errors' => $validator->errors()
            ], 200); // 422 status code for validation errors
        }

        $request->session()->forget('otp');
        \DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->new_password),
            ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
