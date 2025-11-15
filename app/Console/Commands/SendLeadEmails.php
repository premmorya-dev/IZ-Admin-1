<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LeadModel;
use App\Services\PHPMailerService;

class SendLeadEmails extends Command
{
    protected $signature = 'leads:send-email {--template_id=0} {--group_id=0}';
    protected $description = 'Send bulk emails to InvoiceZy leads';
    protected $mailer;

    public function __construct(PHPMailerService $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    public function handle()
    {
        $template_id = $this->option('template_id');
        $group_id = $this->option('group_id');

        if (empty($template_id) || empty($group_id)  || $template_id == 0 || $group_id == 0) {
            $this->error("Please enter --template_id and --group_id");
        }
        $template = \DB::table('lead_email_template')
            ->where('lead_email_template_id', $template_id)
            ->first();
        $html = $template->content;


        $leads = \DB::table('leads')
            ->where('email_optin', 'Y')
            ->where('status', 'pending')
            ->where('group_id', $group_id)
            ->limit(50)
            ->get();


        foreach ($leads as $lead) {

            $html = str_replace('{{customer_name}}',  $lead->customer_name, $html);


            $tracking_image_src = route('email.tracking', ['id' => $lead->id]);
            $html = str_replace('{{lead_id}}',  $lead->id, $html);
            $html = str_replace('{{tracking_image_src}}',  $tracking_image_src, $html);


            try {

                // Send mail with PHPMailerService
                $this->mailer->sendEmail(
                    $lead->email,
                    $template->subject,
                    $html,
                );

                \DB::table('leads')
                    ->where('id',  $lead->id)
                    ->update([
                        'status' => 'sent',
                        'last_error' => null
                    ]);

                $this->info("Email sent to: {$lead->email}");
            } catch (\Exception $e) {


                \DB::table('leads')
                    ->where('id',  $lead->id)
                    ->update([
                        'status' => 'failed',
                        'last_error' => $e->getMessage()
                    ]);


                $this->error("Failed: {$lead->email} - " . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
