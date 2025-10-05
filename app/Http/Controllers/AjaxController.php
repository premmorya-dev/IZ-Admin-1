<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\{StudentRegistrationModel, ProgramModel, NotificationJobQueue, WebhookJobQueue};

use Carbon\Carbon;


class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function  getSeat(Request $request)
    {
        $program =  (array) DB::table('event_program')
            ->where('program_id', $request['program_id'])
            ->select('max_member')->first();



        if (isset($program['max_member']) && $program['max_member']) {
            $count = $program['max_member'];
        } else {
            $count = 1;
        }
        // $count = 5;
        $html = '';
        $html .= "<option value=''>[Select Seats]</option>";
        if ($count == 1) {
            $html .= "<option value='1' selected >1</option>";
        } else if ($count > 1) {
            for ($i = 1; $i <= $count; $i++) {
                $html .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }

        return response()->json(['success' => true, 'html' => $html, 'count' => $count]);
    }

    public function  addStudentRegistration(Request $request)
    {


        $request->seats = $request->seats ?? 1;
        $errors = [];


        $location = getGeo($_SERVER['REMOTE_ADDR']);
        $device = getDevice($request);
        $program = ProgramModel::findOrFail($request->program_id);
        
        try {
            $request->validate([
                'email_id' => ['required', 'email', function ($attribute, $value, $fail) use ($request) {
        
                    $program_user = DB::table('event_program_registration')
                        ->where('program_id', $request->program_id)
                        ->where('registered_email', $request->email_id)
                        ->where('student_registration_status_id', 1)
                        ->first();
        
                    if (!empty($program_user)) {
                        $login_url = "https://" . setting('app_main_domain') . "/user/login";
                        $message = "The email <strong>[{$request->email_id}]</strong> is already registered for this program. 
                            Please use a different email to register, or if you want to view your registered program, 
                            please <strong><u><a href='{$login_url}' target='_blank'>log in here</a>.</u></strong>";
        
                        $fail($message);
                    }
                }],
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
                $html_errors = [
                    'error' => 1,
                    'errors' => $errors,
                    'html_errors' => collect($errors)->map(function ($error) {
                        return implode('<br>', $error); // Convert error array to HTML string
                    })
                ];

             
            return response()->json($html_errors, 200);
        }
        


        $currency_settings = DB::table('currency_settings')
            ->where('currency_id', $program->currency_id)
            ->first();

        if ($program) {
            if (isset($program['fees_inclusive_tax']) && $program['fees_inclusive_tax'] == 'N') {
                $total_tax = round((($program['fees'] * $request->seats) * ($program['tax_rate'] / 100)), $currency_settings->decimal_place);
                $workshopfee = round(($program['fees'] * $request->seats), $currency_settings->decimal_place);
                $fees_inclusive_tax = round(($workshopfee + $total_tax), $currency_settings->decimal_place);
                $payment_gateway_fee = round(($fees_inclusive_tax * $program['payment_gateway_fee_rate'] / 100), $currency_settings->decimal_place);
                $total_fee_all_inclusive_tax = round(($workshopfee + $total_tax + $payment_gateway_fee), $currency_settings->decimal_place);


                if (isset($program['fees']) && isset($program['discounted_fee'])  && $program['fees'] && $program['discounted_fee'] &&  $program['fees'] > $program['discounted_fee']) {

                    $discounted_total_tax = round((($program['discounted_fee'] * $request->seats) * ($program['tax_rate'] / 100)), $currency_settings->decimal_place);
                    $discounted_workshopfee = round(($program['discounted_fee'] * $request->seats), $currency_settings->decimal_place);
                    $discounted_fees_inclusive_tax = round(($discounted_workshopfee + $discounted_total_tax), $currency_settings->decimal_place);
                    $discounted_payment_gateway_fee = round(($discounted_fees_inclusive_tax * $program['payment_gateway_fee_rate'] / 100), $currency_settings->decimal_place);
                    $discounted_total_fee_all_inclusive_tax = round(($discounted_workshopfee + $discounted_total_tax + $discounted_payment_gateway_fee), $currency_settings->decimal_place);
                } else {
                    $discounted_total_tax = NULL;
                    $discounted_workshopfee = NULL;
                    $discounted_fees_inclusive_tax = NULL;
                    $discounted_payment_gateway_fee = NULL;
                    $discounted_total_fee_all_inclusive_tax = NULL;
                }
            } else {
                $total_tax = round(($program['fees'] * $request->seats) - (($program['fees'] * $request->seats) / (1 + ($program['tax_rate'] / 100))), $currency_settings->decimal_place);
                $workshopfee = round((($program['fees'] * $request->seats) - $total_tax), $currency_settings->decimal_place);
                $payment_gateway_fee = round((($program['fees'] * $request->seats) * $program['payment_gateway_fee_rate'] / 100), $currency_settings->decimal_place);
                $total_fee_all_inclusive_tax = round((($program['fees'] * $request->seats) + $payment_gateway_fee), $currency_settings->decimal_place);

                if (isset($program['fees']) && isset($program['discounted_fee'])  && $program['fees'] && $program['discounted_fee'] &&  $program['fees'] > $program['discounted_fee']) {

                    $discounted_total_tax = round(($program['discounted_fee'] * $request->seats) - (($program['discounted_fee'] * $request->seats) / (1 + ($program['tax_rate'] / 100))), $currency_settings->decimal_place);
                    $discounted_workshopfee = round((($program['discounted_fee'] * $request->seats) - $discounted_total_tax), $currency_settings->decimal_place);
                    $discounted_payment_gateway_fee = round((($program['discounted_fee'] * $request->seats) * $program['payment_gateway_fee_rate'] / 100), $currency_settings->decimal_place);
                    $discounted_total_fee_all_inclusive_tax = round((($program['discounted_fee'] * $request->seats) + $discounted_payment_gateway_fee), $currency_settings->decimal_place);
                } else {
                    $discounted_total_tax = NULL;
                    $discounted_workshopfee = NULL;
                    $discounted_fees_inclusive_tax = NULL;
                    $discounted_payment_gateway_fee = NULL;
                    $discounted_total_fee_all_inclusive_tax = NULL;
                }
            }
        }

        if (!isset($program['registration_no_prefix']) || empty(trim($program['registration_no_prefix']))  || !trim($program['registration_no_prefix'])) {
            $registration_number = generate_registration_code();
        } else {
            $registration_number = $program['registration_no_prefix']  . generate_registration_code();
        }

        $dttime = strtotime('now');
        $auto_login_string = md5('workshop_registration_' . $dttime . $registration_number);

        $generate_short_code = generate_short_code();
        $generate_certificate_code = generate_certificate_code();


        $direct_login_url = url('/event/registered/' . $request->seo_handle . "/view?id=" . $auto_login_string);

        $direct_payment_url =  url('/event/registered/' . $request->seo_handle . "/view?id=" . $auto_login_string) . "&express_payment=true";


        $direct_login_short_url = shortUrl($direct_login_url, $request->program_id);
        $direct_payment_short_url = shortUrl($direct_payment_url, $request->program_id);

        $direct_login_qr_code_url = $direct_login_short_url . '/qr';

        $email_alias = getEmailAlias(trim($request->email_id), $program['workshop_code']);

        $registration_update_url_on_zoik_app = $program['registration_page_url'] . "w.php?id=" . $auto_login_string . "&update_zoik_app_data=true";
        $registration_time = Carbon::now('UTC')->format('Y-m-d H:i:s');


        $event_program_certificate =  (array) DB::table('event_program_certificate')
            ->where('program_certificate_id', $program->program_certificate_id)
            ->first();

        if (!isset($location['location']['latitude'])  ||  !isset($location['location']['longitude'])) {
            $location_cordinate = "";
        } else {
            $location_cordinate = "Lat: " . $location['location']['latitude'] . ", Long: " .  $location['location']['longitude'];
        }


        if (!isset($request->state_id) || $request->state_id == 0  ||  !$request->state_id) {
            $state_id =  NULL;
        } else {
            $state_id =  $request->state_id;
        }

        if (!isset($request->country_id) || $request->country_id == 0  ||  !$request->country_id) {
            $country_id =  NULL;
        } else {
            $country_id =  $request->country_id;
        }

        if (!isset($request->mobile_country_code_id) || $request->mobile_country_code_id == 0  ||  !$request->mobile_country_code_id) {
            $mobile_country_code_id =  -1;
        } else {
            $mobile_country_code_id =  $request->mobile_country_code_id;
        }

        // Convert the array to JSON
        $registration_outgoing_webhooks  = json_encode($program['registration_outgoing_webhooks']);

        // Remove newlines and extra whitespace
        $registration_outgoing_webhooks = str_replace(["\r", "\n", "\t", " "], '', $registration_outgoing_webhooks);

        // Decode the JSON string back to a PHP array
        $registration_outgoing_webhooks = json_decode(json_decode($registration_outgoing_webhooks, true), true);


        $form_setting =   getSeoHandleSetting($request->seo_handle);
        $registration_success_url = url('/event/registered/' . $request->seo_handle . "/view?id=" . $auto_login_string . "&{$form_setting['registration_success_event_url_parameter']}={$form_setting['registration_success_event_url_parameter_value']}");
        if (empty($error)) {




            try {


                DB::beginTransaction();

                $timezone =  isset($location['location']['time_zone']) ?  $location['location']['time_zone'] : '';


                $timezone_id =   DB::table('time_zone')
                    ->where('timezone', $timezone)
                    ->first();

                $college = !empty($request->college_name) ?   trim($request->college_name) : NULL;
                $city = !empty($request->city) ?   trim($request->city) : NULL;

                if (isset($program['enable_auto_assign_venue']) &&  $program['enable_auto_assign_venue'] == 'Y' && isset($program['auto_assign_venue_id']) && $program['auto_assign_venue_on_selection_status_id'] ==  $program['selection_status_after_registration']) {
                    $class_room_venue_id =  $program['auto_assign_venue_id'];
                } else {
                    $class_room_venue_id =  NULL;
                }
                do {
                    $short_login_code = short_login_code(); // Generate a new code
                    $short_login_code_check = DB::table('event_program_registration')
                        ->where('short_login_code', $short_login_code)
                        ->get();
                } while ($short_login_code_check->count() > 0);

                $student_registration = StudentRegistrationModel::create([
                    'user_time_zone_id' => isset($timezone_id->time_zone_id) ? $timezone_id->time_zone_id : 28,
                    'program_id' => $request->program_id,
                    'first_name' => trim(ucwords($request->first_name)),
                    'last_name' => ucwords($request->last_name) ?? '',

                    'gender' => $request->gender ?? NULL,
                    'age' => $request->age ?? NULL,


                    'registered_email' => strtolower(trim($request->email_id)),
                    'mobile_country_code_id' => $mobile_country_code_id,
                    'mobile_no' => trim($request->mobile),
                    'college' => $college,
                    'city' => $city,
                    'country_id' => $country_id ?? NULL,
                    'country_state_id' =>  $state_id ?? NULL,
                    'registration_number' => trim($registration_number),
                    'auto_login_string' => $auto_login_string,
                    'direct_login_url' => $direct_login_url,
                    'short_login_code' => $short_login_code,
                    'direct_login_short_url' => $direct_login_short_url,
                    'direct_login_qr_code_url' => $direct_login_qr_code_url,
                    'direct_payment_url' => $direct_payment_url,
                    'direct_payment_short_url' => $direct_payment_short_url,
                    'seats' => $request->seats ?? 1,
                    'amount' => $workshopfee,
                    'tax_amount' => $total_tax,
                    'payment_gateway_fee' => $payment_gateway_fee,
                    'total_fee_all_inclusive' => $total_fee_all_inclusive_tax,
                    'certificate_code' => $generate_certificate_code,


                    'discounted_amount' => $discounted_workshopfee,
                    'discounted_tax_amount' => $discounted_total_tax,
                    'discounted_total_fee_all_inclusive' => $discounted_total_fee_all_inclusive_tax,

                    'payment_status_id' =>  $program['payment_status_after_registration'],
                    'student_selection_status_id' => $program['selection_status_after_registration'], 
                    'certificate_print_status' => 'pending',

                    'referrer' => $request->referrer ?? NULL,
                    'utm_source' => $request->utm_source ?? NULL,
                    'utm_medium' => $request->utm_medium ?? NULL,
                    'utm_campaign' => $request->utm_campaign ?? NULL,
                    'utm_term' => $request->utm_term ?? NULL,
                    'utm_content' => $request->utm_content ?? NULL,
                    'url_used_for_registration' => $_SERVER['HTTP_REFERER'],
                    'registration_time' => $registration_time,
                    'last_update_datetime' => $registration_time,
                    'student_registration_status_id' => 1,
                    'email_status' => 'active',
                    'email_bounce_log' => NULL,
                    'email_bounce_datetime' => Null,


                    'shipping_address_firstname' => NULL,
                    'shipping_address_lastname' => NULL,
                    'shipping_address_line_1' => NULL,
                    'shipping_address_line_2' => NULL,
                    'shipping_address_city' => NULL,
                    'shipping_address_state_id' => NULL,
                    'shipping_address_country_id' => NULL,
                    'shipping_address_post_code' => NULL,
                    'shipping_address_mobile' => NULL,
                    'shipping_address_mobile_country_code_id' => NULL,




                    'ip' => $location['ip_address']  ?? '',
                    'user_agent' =>   $_SERVER['HTTP_USER_AGENT'] ?? '',
                    'geo_continent' => $location['continent'] ?? '',
                    'geo_country' => $location['country'] ?? '',
                    'geo_state' => $location['state'] ?? '',
                    'geo_city' => $location['city'] ?? '',
                    'geo_language' => '',
                    'geo_location' => $location_cordinate,
                    'geo_timezone' => $timezone,
                    'browser' => $device['browser'] ?? '',
                    'platform' => $device['platform'] ?? '',
                    'device_type' => $device['device_type']  ?? '',
                    'device_brand' => $device['device_brand']  ?? '',
                    'device_name' => $device['device_name']   ?? '',
                    'is_mobile' => $device['is_mobile']  ??  '',
                    'is_tablet' => $device['is_tablet']  ?? '',



                ]);


                // auto assign venue id
                // $program_setting = DB::table('event_program')
                //     ->where('program_id', $request->program_id)
                //     ->first();

                // $student_data = DB::table('event_program_registration')
                //     ->where('registration_id',  $student_registration->registration_id)
                //     ->first();


                // if ($program_setting->enable_auto_assign_venue == 'Y' && $program_setting->auto_assign_venue_on_selection_status_id ==  $student_data->student_selection_status_id  && isset($program_setting->auto_assign_venue_id)) {
                //     $student_data = DB::table('event_program_registration')
                //         ->where('registration_id',  $student_registration->registration_id)
                //         ->update([
                //             "classroom_venue_id" => $program_setting->auto_assign_venue_id
                //         ]);
                // }


                $registration_data =   DB::table('event_program_registration')
                    ->leftJoin('event_program', 'event_program_registration.program_id', '=', 'event_program.program_id')
                    ->leftJoin('event_program_location_venue', 'event_program_location_venue.classroom_venue_id', '=', 'event_program.classroom_venue_id')
                    ->leftJoin('event_program_location', 'event_program_location.program_location_id', '=', 'event_program_location_venue.program_location_id')
                 
                    ->leftJoin('mobile_country_list', 'mobile_country_list.mobile_country_code_id', '=', 'event_program_registration.mobile_country_code_id')
                    ->leftJoin('country_to_state_code', 'country_to_state_code.country_state_id', '=', 'event_program_registration.country_state_id')
                    ->leftJoin('country', 'country.country_id', '=', 'event_program_registration.country_id')
             
                    ->leftJoin('event_program_certificate', 'event_program_certificate.program_certificate_id', '=', 'event_program.program_certificate_id')
                    ->leftJoin('students_selection_status', 'students_selection_status.student_selection_status_id', '=', 'event_program_registration.student_selection_status_id')
                    ->leftJoin('payment_status', 'payment_status.payment_status_id', '=', 'event_program_registration.payment_status_id')
                    ->leftJoin('payment_gateway_config', 'payment_gateway_config.payment_gateway_id', '=', 'event_program.payment_gateway_id')
                    ->leftJoin('currency_settings', 'currency_settings.currency_id', '=', 'event_program.currency_id')
                    ->leftJoin('payments', 'payments.payment_log_id', '=', 'event_program_registration.payment_log_id')
                    ->leftJoin('event', 'event.event_id', '=', 'event_program.event_id')
                    ->leftJoin('event_program_type', 'event_program_type.event_program_type_id', '=', 'event_program.event_program_type_id')
                    ->leftJoin('event_program_registration_seo_url', 'event_program_registration_seo_url.registration_seo_url_id', '=', 'event_program.registration_seo_url_id')
                    ->where('event_program_registration.registration_id', $student_registration->registration_id)
                    ->select(
                        'event_program.*',  // Select all columns from event_program
                        'event_program_location.*',  // Select all columns from event_program_location
                        'event_program_location_venue.*',  // Select all columns from event_program_location_venue
                        'mobile_country_list.*',  // Select all columns from mobile_country_list
                        'country_to_state_code.*',  // Select all columns from country_to_state_code
                        'country.*',  // Select all columns from country
                        'event_program_certificate.*',  // Select all columns from event_program_certificate
                        'students_selection_status.*',  // Select all columns from students_selection_status
                        'payment_status.*',  // Select all columns from payment_status
                        'payment_gateway_config.*',  // Select all columns from payment_gateway_config
                        'currency_settings.*',  // Select all columns from currency_settings
                        'payments.*',  // Select all columns from payments
                        'event.*',  // Select all columns from event
                        'event_program_type.*',  // Select all columns from event_program_type
                        'event_program_registration_seo_url.*',  // Select all columns from event_program_registration_seo_url
                        'event_program_registration.*',  // Select all columns from event_program_registration
                        DB::raw(dbPrefix() . 'currency_settings.code')
                    )
                    ->first();

                $certificate_data = DB::table('event_program_certificate_records')
                    ->where('registration_number',  $registration_data->registration_number)
                    ->get();

                if ($certificate_data->count() < 1 && !empty($registration_data->enable_digital_certificate) &&  $registration_data->enable_digital_certificate == 'Y'  &&  $registration_data->student_selection_status_id ==   $registration_data->enable_digital_certificate_on_selection_status_id) {

                    if (isset($registration_data->time_zone_id)) {
                        $timezone_id = DB::table('time_zone')
                            ->where('time_zone_id',  $registration_data->time_zone_id)
                            ->first();



                        if ($timezone_id) {
                            $utc_date_time = Carbon::createFromFormat('Y-m-d H:i:s',  $registration_data->registration_time, 'UTC');
                            $user_date_time = $utc_date_time->setTimezone($timezone_id->timezone);
                            $registration_data->registration_time = $user_date_time->format('d-M-Y H:i:s');
                            $registration_data->registration_time_lable = $timezone_id->timezone;
                        } else {
                            $registration_data->registration_time = '';
                            $registration_data->registration_time_lable = '';
                        }
                    } else {
                        $registration_data->registration_time = '';
                        $registration_data->registration_time_lable = '';
                    }

                    // $student_data = DB::table('event_program_certificate_records')
                    //     ->insert([                       
                       
                    //         "program_certificate_id" => $program['program_certificate_id'],
                    //         "certificate_code" => generate_certificate_code(),
                    //         "event_name" =>$registration_data->event_name,
                    //         "registration_number" =>$registration_data->registration_number,
                    //         "first_name" => $registration_data->first_name,
                    //         "last_name" =>$registration_data->last_name,
                    //         "registered_email" =>$registration_data->registered_email,
                    //         "mobile_contry_code" =>$registration_data->mobile_country_code_id,
                    //         "mobile_no" => $registration_data->mobile_no,
                    //         "college" => $registration_data->college,
                    //         "program_name" => $registration_data->program_name,
                    //         "program_venue_name" => $registration_data->location_name ?? NULL,
                    //         "program_start_datetime" => $registration_data->start_datetime,
                    //         "program_end_datetime" => $registration_data->end_datetime,
                    //         "program_mode" => $registration_data->event_program_mode_certificate,
                    //         "program_type" => $registration_data->event_program_title,
                    //         "program_duration" => $registration_data->program_duration,
                    //         "program_duration_time_unit" => $registration_data->program_duration_time_unit,
                    //         "certificate_title" => $registration_data->certificate_title,
                    //         "student_certificate_status" => 'Granted',
                    //         "date_added" => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    //         "last_update" => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    //         "program_timezone" =>  $registration_data->registration_time_lable
                    //     ]);


                }



                // auto assign venue id end 
                NotificationJobQueue::create([
                    'notification_job_queue_type' => 'registration-email',
                    'notification_enabled' =>  $program['email_notification_on_registration'],
                    'registration_id' => $student_registration->registration_id,
                    'notification_status' => 'pending',
                    'added_datetime' =>  Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'queue_process_start_datetime' => NULL,
                    'queue_process_end_datetime' => NULL,
                    'scheduled_datetime' => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'notification_log' => '',
                ]);

                NotificationJobQueue::create([
                    'notification_job_queue_type' => 'registration-sms',
                    'notification_enabled' =>  $program['sms_notification_on_registration'],
                    'registration_id' => $student_registration->registration_id,
                    'notification_status' => 'pending',
                    'added_datetime' =>  Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'queue_process_start_datetime' => NULL,
                    'queue_process_end_datetime' => NULL,
                    'scheduled_datetime' => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'notification_log' => '',
                ]);


                NotificationJobQueue::create([
                    'notification_job_queue_type' => 'registration-whatsapp',
                    'notification_enabled' =>  $program['whatsapp_notification_on_registration'],
                    'registration_id' => $student_registration->registration_id,
                    'notification_status' => 'pending',
                    'added_datetime' =>  Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'queue_process_start_datetime' => NULL,
                    'queue_process_end_datetime' => NULL,
                    'scheduled_datetime' => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'notification_log' => '',
                ]);

                NotificationJobQueue::create([
                    'notification_job_queue_type' => 'zoikmail-common-list-sync',
                    'notification_enabled' =>  $program['zoik_app_common_list_sync'],
                    'registration_id' => $student_registration->registration_id,
                    'notification_status' => 'pending',
                    'added_datetime' =>  Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'queue_process_start_datetime' => NULL,
                    'queue_process_end_datetime' => NULL,
                    'scheduled_datetime' => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'notification_log' => '',
                ]);


                NotificationJobQueue::create([
                    'notification_job_queue_type' => 'zoikmail-program-list-sync',
                    'notification_enabled' =>  $program['zoik_app_program_list_sync'],
                    'registration_id' => $student_registration->registration_id,
                    'notification_status' => 'pending',
                    'added_datetime' =>  Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'queue_process_start_datetime' => NULL,
                    'queue_process_end_datetime' => NULL,
                    'scheduled_datetime' => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                    'notification_log' => '',
                ]);



                if (!empty($registration_outgoing_webhooks)) {

                    foreach ($registration_outgoing_webhooks as $key => $webhook) {
                        if (!empty($webhook)) {
                            WebhookJobQueue::create([
                                'outgoing_webhook_job_queue_content_type' => $webhook['content-type'],
                                'webhook_header_json' => json_encode($webhook['header']),
                                'registration_id' => $student_registration->registration_id,
                                'webhook_url' => $webhook['url'],
                                'webhook_enabled' => $webhook['status'],
                                'webhook_status' => 'pending',
                                'added_datetime' => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                                'queue_process_start_datetime' => NULL,
                                'queue_process_end_datetime' => NULL,
                                'webhook_log' => '',
                            ]);
                        }
                    }
                }

                DB::commit();

                session(['registration_success' => 'true']);

                return response()->json([
                    'error' => 0,
                    'message' => 'Student registration successfully',
                    'redirect' => $registration_success_url,

                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'error' => 1,
                    'message' => 'Student registration failed due to ' . $e->getMessage(),
                ], 400);
            }
        }
    }




    public function updateShippingAddress(Request $request)
    {

        try {
            DB::beginTransaction();

            $registration =  (array) DB::table('event_program_registration')
                ->where('auto_login_string', $request->uid)
                ->first();

            $student_registration = StudentRegistrationModel::findOrFail($registration['registration_id']);
            $student_registration->shipping_address_firstname =  $request->shipping_address_firstname ?? NULL;
            $student_registration->shipping_address_lastname = $request->shipping_address_lastname ?? NULL;
            $student_registration->shipping_address_line_1 = $request->shipping_address_line_1  ?? NULL;
            $student_registration->shipping_address_line_2 = $request->shipping_address_line_2 ?? NULL;
            $student_registration->shipping_address_city = $request->shipping_address_city  ?? NULL;
            $student_registration->shipping_address_state_id = $request->shipping_address_state_id  ?? NULL;
            $student_registration->shipping_address_country_id = $request->shipping_address_country_id  ?? NULL;
            $student_registration->shipping_address_post_code = $request->shipping_address_post_code  ?? NULL;
            $student_registration->shipping_address_mobile = $request->shipping_address_mobile  ?? NULL;
            $student_registration->shipping_address_mobile_country_code_id = $request->shipping_address_mobile_country_code_id  ??  NULL;

            $student_registration->save();

            DB::commit();
            session()->flash('success', 'Shipping Address Updated Successfully.');
            return response()->json([
                'error' => 0,
                'message' => 'Shipping Address Updated Successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 1,
                'message' => 'Shipping Address Updated failed due to ' . $e->getMessage(),
            ], 400);
        }
    }


    public function updateRegistration(Request $request)
    {

        try {
            DB::beginTransaction();



            $registration =  (array) DB::table('event_program_registration')
                ->leftJoin('event_program', 'event_program_registration.program_id', "=", 'event_program.program_id')
                ->leftJoin('event_program_registration_seo_url', 'event_program_registration_seo_url.registration_seo_url_id', '=', 'event_program.registration_seo_url_id')
                ->where('event_program_registration.auto_login_string', $request->uid)
                ->first();



            $student_registration = StudentRegistrationModel::findOrFail($registration['registration_id']);
            $student_registration->first_name =  $request->first_name ?? '';
            $student_registration->last_name = $request->last_name ?? '';
            $student_registration->age = $request->age ?? '';
            $student_registration->gender = $request->gender ?? '';
            $student_registration->mobile_country_code_id = $request->mobile_country_code_id  ?? '';
            $student_registration->mobile_no = $request->mobile ?? '';
            $student_registration->college = $request->college  ?? NULL;
            $student_registration->city = $request->city  ?? NULL;
            $student_registration->country_state_id = $request->state_id  ?? NULL;
            $student_registration->country_id = $request->country_id  ?? NULL;
            $student_registration->save();


            NotificationJobQueue::create([
                'notification_job_queue_type' => 'zoikmail-program-list-sync',
                'notification_enabled' =>  $registration['zoik_app_program_list_sync'],
                'registration_id' => $registration['registration_id'],
                'notification_status' => 'pending',
                'added_datetime' =>  Carbon::now('UTC')->format('Y-m-d H:i:s'),
                'queue_process_start_datetime' => NULL,
                'queue_process_end_datetime' => NULL,
                'scheduled_datetime' => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                'notification_log' => '',
            ]);


            NotificationJobQueue::create([
                'notification_job_queue_type' => 'zoikmail-common-list-sync',
                'notification_enabled' =>  $registration['zoik_app_program_list_sync'],
                'registration_id' => $registration['registration_id'],
                'notification_status' => 'pending',
                'added_datetime' =>  Carbon::now('UTC')->format('Y-m-d H:i:s'),
                'queue_process_start_datetime' => NULL,
                'queue_process_end_datetime' => NULL,
                'scheduled_datetime' => Carbon::now('UTC')->format('Y-m-d H:i:s'),
                'notification_log' => '',
            ]);


            DB::commit();
            session()->flash('success', 'Registration Updated Successfully.');

            return response()->json([
                'error' => 0,
                'message' => 'Registration Updated Successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 1,
                'message' => 'Registration Updated failed due to ' . $e->getMessage(),
            ], 400);
        }
    }


    public function getProgramLocationByProgram(Request $request)
    {
        return ProgramModel::getProgramLocationByProgram($request->program_id);
    }

    public function getVenueByLocation(Request $request)
    {
        
        return ProgramModel::getVenueByLocation($request->program_location_id);
    }

    public function getProgramByEvent(Request $request)
    {
       
        return ProgramModel::getProgramByEvent($request->event_id);
    }


}
