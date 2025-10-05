<?php

namespace App\Console\CommandPaymentSuccessWhatsapp;

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
class PaymentSuccessWhatsapp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:registration-whatsapp {--registration_id=0} {--notification_job_queue_id=0} {--limit=2}';

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
      $registration_id = $this->option('registration_id');
      $notification_job_queue_id = $this->option('notification_job_queue_id');
      $limit = $this->option('limit');


      if($notification_job_queue_id != 0){ 
        $notifications = DB::table('notification_job_queue')
        ->where('notification_status', 'pending')
        ->where('notification_job_queue_id', $notification_job_queue_id )
        ->where('notification_job_queue_type', 'registration-whatsapp')
        ->orderBy('notification_job_queue_id', 'asc') // Change 'created_at' to the appropriate column
        ->limit($limit) // Set the limit to any number you need
        ->get();
      } else if($registration_id != 0){
        $notifications = DB::table('notification_job_queue')
        ->where('notification_status', 'pending')
        ->where('registration_id', $registration_id )
        ->where('notification_job_queue_type', 'registration-whatsapp')
        ->orderBy('notification_job_queue_id', 'asc') // Change 'created_at' to the appropriate column
        ->limit($limit) // Set the limit to any number you need
        ->get();
      }else{       
        $notifications = DB::table('notification_job_queue')
        ->where('notification_status', 'pending')
        ->where('notification_job_queue_type', 'registration-whatsapp')
        ->orderBy('notification_job_queue_id', 'asc') // Change 'created_at' to the appropriate column
        ->limit($limit) // Set the limit to any number you need
        ->get();
      }
      
      if ($notifications->isEmpty()) {
        $log = "\nNotification queue is empty\n";
        exit($log);
      }
  
      foreach ($notifications  as $notification) {
  
        $notification_queue = NotificationJobQueue::findOrFail($notification->notification_job_queue_id);
  
        if(  $notification->notification_status  == 'running'   ){
            $log =  "\nRegistration id: {$notification->registration_id} | Notification Type: {$notification->notification_job_queue_type} | Status: Whatsapp sent unsuccessfully | Msg: notification is already running";                  
            echo $log;    
            continue;
        }else  if( $notification->notification_status  == 'success'   ){        
            $log =  "\nRegistration id: {$notification->registration_id} | Notification Type: {$notification->notification_job_queue_type} | Status: Whatsapp sent unsuccessfully | Msg: notification is already completed";                  
            echo $log;    
            continue;
        }else  if( $notification->notification_enabled  == 'N'   ){
            $log =  "\nRegistration id: {$notification->registration_id} | Notification Type: {$notification->notification_job_queue_type} | Status: Whatsapp sent unsuccessfully | Msg: notification is disabled";                  
            echo $log;    
            continue;
        }
        $this->sendRegistrationWhatsapp($notification);
      }

      echo "\n";
    }


    public function sendRegistrationWhatsapp($notification)
    {
        $notification_queue = NotificationJobQueue::findOrFail($notification->notification_job_queue_id);
        $notification_queue->notification_status = 'running';
        $notification_queue->queue_process_start_datetime = Carbon::now('UTC')->format('Y-m-d h:i:s');
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
                                        ->where('whatsapp_api_id',$registration_data ['whatsapp_api_id'])
                                        ->first();

        $data = [
          "registration_data" => $registration_data,
          "time_zone_name" => $time_zone_name,
          "registration_time" => $registration_time,
          "whatsapp_api_id" => $whatsapp_api_id,
          "notification" => $notification,
        ];

        if( $whatsapp_api_id->whatsapp_api_provider == 'twilio'  ){
          $this->twilio($data);

        }
        

       

       

       
    
    }


    public function twilio($data){


      $status = 1;
      $platform_config = json_decode($data['whatsapp_api_id']->config_json,true);

      $whatsapp_sender= (array) DB::table('whatsapp_sender')
      ->where('whatsapp_sender_id',$data['registration_data']['whatsapp_sender_id'])
      ->first();
   
      $whatsapp_templates =(array)  DB::table('whatsapp_templates')
      ->where('whatsapp_api_id',$data['whatsapp_api_id']->whatsapp_api_id)
      ->where('whatsapp_template_id',$data['registration_data']['whatsapp_template_id_on_registration_success'])
      ->first();


      $template_config_json =   json_decode($whatsapp_templates['template_config_json'] ,true);


      $mapping_json_code = shortcode($data['registration_data']['registration_number'],$whatsapp_templates['template_short_code_mapping_config_json']);
     
    

      $template_short_code_mapping_config_json =   json_decode($mapping_json_code ,true);

      $template_short_code_mapping_config_json_decode = [];  //pass this array to whatsapp template

      if( !empty($template_short_code_mapping_config_json) ){
        foreach( $template_short_code_mapping_config_json as $key=>$value ){
           $key = str_replace("{{","",$key);          
           $key = str_replace("}}","",$key);
           $template_short_code_mapping_config_json_decode[$key] = $value;
          
     
        }
      
      } 
      Log::info('whatsapp info: ', ["data:"=> $template_short_code_mapping_config_json_decode  ] );
      $sid = $platform_config['account_sid'];
      $token = $platform_config['auth_token'];
      $twilio = new Client($sid, $token);

      try{
        $message = $twilio->messages
        ->create(
            "whatsapp:" .'+'. $data['registration_data']['country_code'] . $data['registration_data']['mobile_no'], // to
            [
                "contentSid" => $template_config_json['content_template_sid'],
                // "contentSid" => "HX4f2a2fcfe1b7bd46c79961e8dff3e781",
                "from" => "whatsapp:" .'+'. $whatsapp_sender['sender_number'],
                "contentVariables" => json_encode($template_short_code_mapping_config_json_decode),
                "messagingServiceSid" => $template_config_json['messaging_service_sid']
            ]
        );
      }catch(\Exception $e){
        $status = 0;
        $log =  "\nRegistration id: {$data['notification']->registration_id} | Notification Type: {$data['notification']->notification_job_queue_type} | Status: failed | Msg: {$e->getMessage()}"; 
        
        echo $log;

        $notification_queue = NotificationJobQueue::findOrFail($data['notification']->notification_job_queue_id);
        $notification_queue->notification_status = 'failed';
        $notification_queue->queue_process_end_datetime = Carbon::now('UTC')->format('Y-m-d h:i:s');
        $notification_queue->notification_log = $log;
        $notification_queue->save();    

       

      }


      if($status){

        $log =  "\nRegistration id: {$data['notification']->registration_id} | Notification Type: {$data['notification']->notification_job_queue_type} | Status: success | Msg: Whatsapp sent successfully | Api response: {$message} | Mobile no: +{$data['registration_data']['country_code']}{$data['registration_data']['mobile_no']}";  
        echo $log;
        $notification_queue = NotificationJobQueue::findOrFail($data['notification']->notification_job_queue_id);
        $notification_queue->notification_status = 'success';
        $notification_queue->queue_process_end_datetime = Carbon::now('UTC')->format('Y-m-d h:i:s');
        $notification_queue->notification_log = $log;
        $notification_queue->save(); 
      }
     
     


    }





}
