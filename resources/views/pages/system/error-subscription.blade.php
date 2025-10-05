
<x-default-layout>
    <div class="container py-5">
        <div class="text-center mb-5">
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828843.png" alt="Error Icon" width="120" class="mb-4">
            <h2 class="fw-bold text-danger">Access Restricted!</h2>
            <p class="text-muted fs-5"> {{ session('msg') }}</p>
        </div>

        <div class="alert alert-warning border-0 rounded-4 shadow-sm p-4 mx-auto" style="max-width: 700px;">
            <div class="d-flex align-items-start">
                <i class="fas fa-exclamation-triangle fa-2x text-warning me-3 mt-1"></i>
                <div>
                    <h5 class="fw-semibold">Why am I seeing this?</h5>
                    <p class="mb-1">You’re trying to access a premium feature that’s only available to users with an active subscription plan.</p>
                    <p class="mb-0">To continue, please choose or upgrade to a suitable plan.</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('plan.upgrade') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                <i class="fas fa-gem me-2"></i> View Subscription Plans
            </a>
        </div>
    </div>
</x-default-layout>
