<?php

namespace App\Console\CommandSendRegistrationUpdateWhatsapp;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use DOMDocument;
use Carbon\Carbon;
use EmsApi\Config;
use EmsApi\Base;
use EmsApi\Cache\File;
use EmsApi\Endpoint\Lists;
use EmsApi\Params;

use Twilio\Rest\Client;
use App\Models\NotificationJobQueue;
use Illuminate\Support\Facades\Log;

class SendRegistrationUpdateWhatsapp extends Command
{
 /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:send-registration-update-whatsapp {--registration_id=0} {--notification_job_queue_id=0} {--limit=0} {--force=no} ';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Execute the console command.
   */
  public function handle()
  {

    // \Log::info('Your command is working!');



    $error = '';
    $log = '';
    $limit = $this->option('limit');
    $registration_id = $this->option('registration_id');
    $notification_job_queue_id = $this->option('notification_job_queue_id');
    $force = $this->option('force');



    $cron_jobs = DB::table('cron_jobs')
    ->where('cronjob_name', 'registration-update-whatsapp')
    ->where('cron_job_status', 'active')
    ->where('cron_job_processing_status', 'idle')
    ->get();

    if( $cron_jobs->count() < 1 ){
      return;         
    }else{

      cli_set_process_title('registration-update-whatsapp');
      $pid = getmypid();


      DB::table('cron_jobs')
      ->where('cronjob_name', 'registration-update-whatsapp')       
      ->update(
          [
            "process_id" =>   $pid,
            "cron_job_processing_status" =>   'running',
            "cron_job_start_datetime" =>   Carbon::now('UTC')->format('Y-m-d H:i:s'),
            "cron_job_end_datetime" =>  NULL
          ]
      );

    }


    if ($notification_job_queue_id != 0) {

      $query =  DB::table('notification_job_queue')
        ->where('notification_job_queue_id', $notification_job_queue_id)
        ->where('scheduled_datetime', '<', Carbon::now('UTC')->format('Y-m-d H:i:s'))
        ->where('notification_job_queue_type', 'registration-update-whatsapp')      
        ->orderBy('notification_job_queue_id', 'asc');
    } else if ($registration_id != 0) {
      $query =  DB::table('notification_job_queue')
        ->where('registration_id', $registration_id)
        ->where('scheduled_datetime', '<', Carbon::now('UTC')->format('Y-m-d H:i:s'))
        ->where('notification_job_queue_type', 'registration-update-whatsapp')
        ->orderBy('notification_job_queue_id', 'asc');
    } else {
      $query =  DB::table('notification_job_queue')
        ->where('scheduled_datetime', '<', Carbon::now('UTC')->format('Y-m-d H:i:s'))
        ->where('notification_job_queue_type', 'registration-update-whatsapp')
        ->orderBy('notification_job_queue_id', 'asc');
    }

    $query->when($force != 'yes', function ($query) {

      return $query->where('notification_job_queue.notification_status', 'pending');
    });


    $query->when($limit != 0, function ($query) {
      return $query->limit($this->option('limit'));
    });

    $notifications = $query->get();

    if ($notifications->isEmpty()) {
      $log = "\nNotification queue is empty\n";
      echo $log;     
    }

    if (!empty($notifications)) {
      foreach ($notifications  as $notification) {

        $notification_queue = NotificationJobQueue::findOrFail($notification->notification_job_queue_id);

        if ($notification->notification_status  == 'running') {
          $log =  "\nRegistration id: {$notification->registration_id} | Notification Type: {$notification->notification_job_queue_type} | Status: Whatsapp sent unsuccessfully | Msg: notification is already running";
          echo $log;
          continue;
        } else  if ($notification->notification_status  == 'success') {
          $log =  "\nRegistration id: {$notification->registration_id} | Notification Type: {$notification->notification_job_queue_type} | Status: Whatsapp sent unsuccessfully | Msg: notification is already completed";
          echo $log;
          continue;
        } else  if ($notification->notification_enabled  == 'N') {
          $log =  "\nRegistration id: {$notification->registration_id} | Notification Type: {$notification->notification_job_queue_type} | Status: Whatsapp sent unsuccessfully | Msg: notification is disabled";
          echo $log;
          continue;
        }
        $this->sendWhatsapp($notification);
      }
    }

    DB::table('cron_jobs')
    ->where('cronjob_name', 'registration-update-whatsapp')       
    ->update(
        [
          "process_id" =>  NULL,
          "cron_job_processing_status" =>   'idle',
          "cron_job_end_datetime" =>   Carbon::now('UTC')->format('Y-m-d H:i:s'),
        ]
    );




  }




  public function sendWhatsapp($notification)
  {
    $notification_queue = NotificationJobQueue::findOrFail($notification->notification_job_queue_id);
    $notification_queue->notification_status = 'running';
    $notification_queue->queue_process_start_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
    $notification_queue->save();

    $registration_data =  getRegistrationData($notification->registration_id);

   

    if (!empty(DB::table('time_zone')
      ->where('time_zone_id', $registration_data['user_time_zone_id'])
      ->first())) {
      $time_zone_name =   DB::table('time_zone')
        ->where('time_zone_id', $registration_data['user_time_zone_id'])
        ->first()->timezone;
    } else {
      $time_zone_name = '';
    }

    $registration_time = '';
    if (isset($registration_data['registration_time'])) {
      $registration_time = convertUtcToTimeZone($registration_data['registration_time'], $time_zone_name);
    }

    $whatsapp_api_id = DB::table('whatsapp_api')
      ->where('whatsapp_api_id', $registration_data['whatsapp_api_id'])
      ->first();

    $whatsapp_sender = DB::table('whatsapp_sender')
      ->where('whatsapp_sender_id', $registration_data['whatsapp_sender_id'])
      ->first();

    $whatsapp_templates = DB::table('whatsapp_templates')
      ->where('whatsapp_template_id', setting('registration_update_whatsapp_template_id'))
      ->first();

      if( empty($whatsapp_templates) ){
        $log =  "\nRegistration id: {$notification->registration_id} | Queue Id: {$notification->notification_job_queue_id} | Status: failed | Msg: whatsapp template not found.";
        echo $log;
  
  
        $notification_queue = NotificationJobQueue::findOrFail($notification->notification_job_queue_id);
        $notification_queue->notification_status = 'failed';
        $notification_queue->queue_process_end_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
        $notification_queue->notification_log = $log;
        $notification_queue->save();

      }

    

    if ($registration_data['whatsapp_api_id'] != $whatsapp_sender->whatsapp_api_id) {
      $log = "\nprogram whatsapp_api_id not matched with sender whatsapp_api_id";
      echo $log;
      return;
    }

    if ($registration_data['whatsapp_api_id'] != $whatsapp_templates->whatsapp_api_id) {
      $log = "\nprogram whatsapp_api_id not matched with whatsapp whatsapp_api_id";
      echo $log;
      return;
    }


    $data = [
      "registration_data" => $registration_data,
      "time_zone_name" => $time_zone_name,
      "registration_time" => $registration_time,
      "whatsapp_api_id" => $whatsapp_api_id,
      "notification" => $notification,
    ];

    if ($whatsapp_api_id->whatsapp_api_provider == 'twilio') {
      $this->twilio($data);
    }
    if ($whatsapp_api_id->whatsapp_api_provider == 'msg91') {
      $this->msg91($data);
    }
  }

  public function msg91($data)
  {

  

    $status = 1;
    $platform_config = json_decode($data['whatsapp_api_id']->config_json, true);

    $whatsapp_sender = (array) DB::table('whatsapp_sender')
      ->where('whatsapp_sender_id', $data['registration_data']['whatsapp_sender_id'])
      ->first();

    $whatsapp_templates = (array)  DB::table('whatsapp_templates')
      ->where('whatsapp_api_id', $data['whatsapp_api_id']->whatsapp_api_id)
      ->where('whatsapp_template_id', setting('registration_update_whatsapp_template_id'))
      ->first();



    $template_config_json =   json_decode($whatsapp_templates['template_config_json'], true);


    $mapping_json_code = shortcode($data['registration_data']['registration_number'], $whatsapp_templates['template_short_code_mapping_config_json']);





    $template_short_code_mapping_config_json =   json_decode($mapping_json_code, true);

    $component[] = $template_short_code_mapping_config_json['headers'];
    $component[] = $template_short_code_mapping_config_json['body'];
    $component[] = $template_short_code_mapping_config_json['button'];

    $mergedJson = array_merge_recursive(...$component);
    $request_json_object = str_replace("\n", "", json_encode($mergedJson, JSON_PRETTY_PRINT));


    $payload_json_string = '{
        "integrated_number": "' . $whatsapp_sender['sender_number'] . '",
        "content_type": "template",
        "payload": {
          "type": "template",
          "template": {
            "name": "' . $whatsapp_templates['template_name'] . '",
            "language": {
              "code": "En_US",
              "policy": "deterministic"
            },
            "to_and_components": [
              {
                "to": [
                  "' . $data['registration_data']['country_code'] . $data['registration_data']['mobile_no'] . '"
                ],
                "components": ' . $request_json_object . '
              }
             
            ]
          },
          "messaging_product": "whatsapp"
        }
      }';


    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://control.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $payload_json_string,
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authkey: {$platform_config['authkey']}",
        "content-type: application/json"
      ],
    ]);

    $response =  curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    $response_json = json_decode($response);


    if ($err) {
      $log =  "\nRegistration id: {$data['notification']->registration_id} | Notification Type: {$data['notification']->notification_job_queue_type} | Whatsapp Noitification Platform: msg91 | Status: failed | Msg: {$err}";

      $display_log =  "\nRegistration id: {$data['notification']->registration_id} | Queue Id: {$data['notification']->notification_job_queue_id} | Status: failed | Msg: {$err}";

      echo $display_log;


      $notification_queue = NotificationJobQueue::findOrFail($data['notification']->notification_job_queue_id);
      $notification_queue->notification_status = 'failed';
      $notification_queue->queue_process_end_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
      $notification_queue->notification_log = $log;
      $notification_queue->save();
    } else if (isset($response_json->hasError) &&  $response_json->hasError == true) {


      $log =  "\nRegistration id: {$data['notification']->registration_id} | Notification Type: {$data['notification']->notification_job_queue_type} |  Whatsapp Noitification Platform: msg91 | Api response: {$response} | Mobile no: +{$data['registration_data']['country_code']}{$data['registration_data']['mobile_no']}";

      $display_log =  "\nRegistration id: {$data['notification']->registration_id} | Queue Id: {$data['notification']->notification_job_queue_id} | Status: failed | Msg: {$response}";

      echo $display_log;

      $notification_queue = NotificationJobQueue::findOrFail($data['notification']->notification_job_queue_id);
      $notification_queue->notification_status = 'failed';
      $notification_queue->queue_process_end_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
      $notification_queue->notification_log = $log;
      $notification_queue->save();
    } else {
      $log =  "\nRegistration id: {$data['notification']->registration_id} | Notification Type: {$data['notification']->notification_job_queue_type} |  Whatsapp Noitification Platform: msg91 | Api response: {$response} | Mobile no: +{$data['registration_data']['country_code']}{$data['registration_data']['mobile_no']}";

      $display_log =  "\nRegistration id: {$data['notification']->registration_id} | Queue Id: {$data['notification']->notification_job_queue_id} | Status: success | Request Id: {$response_json->request_id}";

      echo $display_log;


      $notification_queue = NotificationJobQueue::findOrFail($data['notification']->notification_job_queue_id);
      $notification_queue->notification_status =   'success';
      $notification_queue->queue_process_end_datetime =  Carbon::now('UTC')->format('Y-m-d H:i:s');
      $notification_queue->notification_log =  $log;
      $notification_queue->request_id =   $response_json->request_id;
      $notification_queue->delivery_status = NULL;
      $notification_queue->delivery_status_datettime = NULL;

      $notification_queue->save();
    }
  }
  public function twilio($data)
  {


    $status = 1;
    $platform_config = json_decode($data['whatsapp_api_id']->config_json, true);

    $whatsapp_sender = (array) DB::table('whatsapp_sender')
      ->where('whatsapp_sender_id', $data['registration_data']['whatsapp_sender_id'])
      ->first();

    $whatsapp_templates = (array)  DB::table('whatsapp_templates')
      ->where('whatsapp_api_id', $data['whatsapp_api_id']->whatsapp_api_id)
      ->where('whatsapp_template_id', $data['registration_data']['whatsapp_template_id_on_payment_success'])
      ->first();


    $template_config_json =   json_decode($whatsapp_templates['template_config_json'], true);


    $mapping_json_code = shortcode($data['registration_data']['registration_number'], $whatsapp_templates['template_short_code_mapping_config_json']);



    $template_short_code_mapping_config_json =   json_decode($mapping_json_code, true);

    $template_short_code_mapping_config_json_decode = [];  //pass this array to whatsapp template

    if (!empty($template_short_code_mapping_config_json)) {
      foreach ($template_short_code_mapping_config_json as $key => $value) {
        $key = str_replace("{{", "", $key);
        $key = str_replace("}}", "", $key);
        $template_short_code_mapping_config_json_decode[$key] = $value;
      }
    }
    Log::info('whatsapp info: ', ["data:" => $template_short_code_mapping_config_json_decode]);
    $sid = $platform_config['account_sid'];
    $token = $platform_config['auth_token'];
    $twilio = new Client($sid, $token);

    try {
      $message = $twilio->messages
        ->create(
          "whatsapp:" . '+' . $data['registration_data']['country_code'] . $data['registration_data']['mobile_no'], // to
          [
            "contentSid" => $template_config_json['content_template_sid'],
            // "contentSid" => "HX4f2a2fcfe1b7bd46c79961e8dff3e781",
            "from" => "whatsapp:" . '+' . $whatsapp_sender['sender_number'],
            "contentVariables" => json_encode($template_short_code_mapping_config_json_decode),
            "messagingServiceSid" => $template_config_json['messaging_service_sid']
          ]
        );
    } catch (\Exception $e) {
      $status = 0;
      $log =  "\nRegistration id: {$data['notification']->registration_id} | Notification Type: {$data['notification']->notification_job_queue_type} | Status: failed | Msg: {$e->getMessage()}";

      echo $log;

      $notification_queue = NotificationJobQueue::findOrFail($data['notification']->notification_job_queue_id);
      $notification_queue->notification_status = 'failed';
      $notification_queue->queue_process_end_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
      $notification_queue->notification_log = $log;
      $notification_queue->save();
    }


    if ($status) {

      $log =  "\nRegistration id: {$data['notification']->registration_id} | Notification Type: {$data['notification']->notification_job_queue_type} | Status: success | Msg: Whatsapp sent successfully | Api response: {$message} | Mobile no: +{$data['registration_data']['country_code']}{$data['registration_data']['mobile_no']}";
      echo $log;
      $notification_queue = NotificationJobQueue::findOrFail($data['notification']->notification_job_queue_id);
      $notification_queue->notification_status = 'success';
      $notification_queue->queue_process_end_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
      $notification_queue->notification_log = $log;
      $notification_queue->save();
    }
  }
}
