 <form class="row g-3">
     <fieldset class="border p-4 rounded row mt-3">
         <div class="row mt-3">
             <div class="col-6 fw-bold">Request Id</div>
             <div class="col-6">{{ $notification_job_queue->request_id }} <a href="#" class="copyButton" link="{{ $notification_job_queue->request_id }}"><i class="fa-regular fa-copy copy-font"></i></a></div>
         </div>
         @php
         $badgeClasses = [
         'pending' => 'badge text-bg-warning',
         'processing' => 'badge text-bg-primary',
         'running' => 'badge text-bg-secondary',
         'success' => 'badge text-bg-success',
         'failed' => 'badge text-bg-danger',
         ];
         @endphp
         <div class="row mt-3">
             <div class="col-6 fw-bold">Delivery Status</div>
             <div class="col-6"><span class="{{ $badgeClasses[$notification_job_queue->notification_status] ?? 'badge text-bg-dark' }}">
                     {{ ucfirst($notification_job_queue->notification_status) }}
                 </span> </div>
         </div>

         <div class="row mt-3">
             <div class="col-6 fw-bold">Delivery Status Datettime</div>
             <div class="col-6">{{ $notification_job_queue->delivery_status_datettime }}</div>
         </div>
         <div class="row mt-3">
             <div class="col-6 fw-bold">Log</div>
             <div class="col-6">{{ $notification_job_queue->notification_log }} <a href="#" class="copyButton" link="{{$notification_job_queue->notification_log  }}"><i class="fa-regular fa-copy copy-font"></i></a></div>
         </div>
     </fieldset>
 </form>

 <script>
     $(document).ready(function() {

         $('.copyButton').on('click', function(e) {
             e.preventDefault();
             copyToClipboard($(this).attr('link'));
         });

     });
 </script>