<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 p-5 text-center">

                @if(!empty($data['accepted']))
                    <div class="mb-4">
                        <i class="bi bi-patch-check-fill" style="font-size: 4rem; color: #28a745;"></i>
                    </div>
                    <h2 class="fw-bold" style="color: #28a745;">Estimate Accepted</h2>
                    <p class="text-muted">Thank you! You've successfully accepted the estimate.</p>
                @else
                    <div class="mb-4">
                        <i class="bi bi-x-circle-fill" style="font-size: 4rem; color: #dc3545;"></i>
                    </div>
                    <h2 class="fw-bold" style="color: #dc3545;">Estimate Rejected</h2>
                    <p class="text-muted">You have rejected the estimate. If this was a mistake, please contact our team for assistance.</p>
                @endif

            </div>
        </div>
    </div>
</div>
