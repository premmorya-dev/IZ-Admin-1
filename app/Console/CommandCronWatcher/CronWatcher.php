<?php

namespace App\Console\CommandCronWatcher;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use DOMDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\NotificationJobQueue;

class CronWatcher extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "app:cron-watcher {--cronjob_name=''} {--delay=0}";

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
    $error = '';
    $log = '';
    $cronjob_name = $this->option('cronjob_name');
    $delay = $this->option('delay');

    if( !empty($cronjob_name) || !isset($cronjob_name)  ){
      $cronjob_name == null;
    }

    $query = DB::table('cron_jobs')
      ->where('cron_job_status', 'active')
      ->where('cron_job_processing_status', 'running');

    // $query->when( $cronjob_name !== null , function ($query) { 
    //   $cronjob_name = $this->option('cronjob_name');
    //   return $query->where('cronjob_name', $cronjob_name );
    // });

    $cron_jobs = $query->get();

    if ($cron_jobs->count() < 1) {
      return;
    } else {
     
      foreach($cron_jobs as $cron_job){

        try {   
          $command = "pgrep -f $cron_job->cronjob_name";
          $processId = shell_exec($command);
          $processIds = array_filter(array_map('trim', explode("\n", $processId)));
  
          if (!empty($processIds)) {
            // echo "Processes with '$processName' running with PIDs:\n";
            foreach ($processIds as $pid) {
              $command = "ps -p $pid -o stat=";
              $status = trim(shell_exec($command));
  
              if ($status == 'R'  || $status == 'S+' || $status == 'S') {
                $log = "\nProcess with PID $pid is running.\n";
              } else {
                $date1 = Carbon::now('UTC');
                $date2 = Carbon::parse($cron_job->cron_job_start_datetime);
                $diffInMinutes = $date1->diffInMinutes($date2);
                if ($delay != 0) {
                  if ($diffInMinutes >= $delay) {
                    $log = "\nPID $pid is not found and killed it.\n";
                    shell_exec("kill -9 $pid");
                    DB::table('cron_jobs')
                      ->where('cronjob_name',  $cron_job->cronjob_name)
                      ->update(
                        [
                          "process_id" =>  NULL,
                          "cron_job_processing_status" =>   'idle',
                          "cron_job_start_datetime" =>   NULL,
                          "cron_job_end_datetime" =>  NULL
                        ]
                      );
                  }
                } else {
                  $log = "\nPID $pid is not found and killed it.\n";
                  shell_exec("kill -9 $pid");
                  DB::table('cron_jobs')
                    ->where('cronjob_name',  $cron_job->cronjob_name)
                    ->update(
                      [
                        "process_id" =>  NULL,
                        "cron_job_processing_status" =>   'idle',
                        "cron_job_start_datetime" =>   NULL,
                        "cron_job_end_datetime" =>  NULL
                      ]
                    );
                }
              }
              echo $log;
              //  Log::channel('cron_watcher')->info($log); 
              break;
            }
          } else {
            $log = "No process found with ' $cron_job->cronjob_name'.";
            echo $log;
            //  Log::channel('cron_watcher')->info($log); 
          }
        } catch (\Exception $e) {
  
          $log = "Process:{$cron_job->cronjob_name} | Error: {$e->getMessage()}";
          echo "\n". $log ;
          Log::channel('cron_watcher')->info($log);
          
        }
  


      }
     
     
  





    }
  }
}


/*
Common statuses:
R: Running
S: Sleeping
D: Uninterruptible sleep (usually I/O)
Z: Zombie
T: Stopped (by a signal or debugger)
*/
