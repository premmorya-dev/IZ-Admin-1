<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Validation\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

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

        $mail = new PHPMailer(true);
        $smtp_data = DB::table('smtp_settings')->where('smtp_id', 1)->first();
        $email_template = DB::table('email_templates')->where('email_template_id',2)->first();

        $user = User::select('first_name', 'last_name')
            ->where('email', $request->email)
            ->firstOrFail();

        $name = $user->first_name . ' ' . $user->last_name;
           
        try {
            // Server settings
            $mail->CharSet = 'UTF-8';           // ✅ Fix encoding
            $mail->Encoding = 'base64';
            $mail->SMTPDebug =  $smtp_data->smtp_debug; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host       = $smtp_data->smtp_host; // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = $smtp_data->smtp_username; // SMTP username
            $mail->Password   = $smtp_data->smtp_password; // SMTP password
            $mail->SMTPSecure = $smtp_data->smtp_encryption; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = $smtp_data->smtp_port;; // TCP port to connect to

            // from
            $mail->setFrom($email_template->email_template_from_email , 'InvoiceZy'  );

            //to
            $mail->addAddress($request->email); // 


            // Content

            $message =   str_replace('{{OTP}}' , $otp, $email_template->email_template_html );    
            $message =   str_replace('{{NAME}}' , $name,  $message );  
            $message =   str_replace('{{LOGO}}' , asset('logo.png'), $message );    
            
            $subject =   $email_template->email_template_subject;    

            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject =  $subject;
            $mail->Body    =  $message;
            
            // $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
            // $mail->Debugoutput = 'html';


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
