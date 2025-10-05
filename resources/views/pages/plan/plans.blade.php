<x-default-layout>

    <h2 class="py-3">All Plans</h2>
    @if(isset($activePlan))
    <div class="container py-4">
        <div class="alert alert-success border-0 shadow-sm rounded-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-gem fa-2x text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Your Active Plan: <strong>{{ $activePlan->plan_name }}</strong></h5>
                    <p class="mb-0">
                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                        Valid from <strong>{{ $activePlan->starts_at }}</strong>
                        to <strong>{{ $activePlan->ends_at }}</strong>
                    </p>
                </div>
                <div class="ms-auto text-end">
                    <span class="badge bg-success px-3 py-2 rounded-pill">Active</span>
                </div>
            </div>
        </div>
    </div>
    @else

    <div class="container py-4">
        <div class="alert alert-success border-0 shadow-sm rounded-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-gem fa-2x text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Your Active Plan: <strong>Free Plan</strong></h5>
                    <p class="mb-0">
                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                        Validity <strong>Unlimited</strong>
                    </p>
                </div>
                <div class="ms-auto text-end">
                    <span class="badge bg-success px-3 py-2 rounded-pill">Active</span>
                </div>
            </div>
        </div>
    </div>
    @endif



    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold">Upgrade Your Experience</h2>
        <p class="text-center mb-5 text-muted">Choose a plan that fits your invoicing needs and grow your business smarter.</p>

        <div class="row g-4">
            @foreach ($plans as $plan)
            <div class="col-md-3">
                <div class="card shadow-sm h-100 border-0 rounded-4 position-relative">
                    @if( isset($activePlan) && $plan->plan_id == $activePlan->plan_id )
                    <div class="position-absolute top-0 end-0 bg-success text-white px-3 py-1 rounded-bottom-start fw-bold z-1">
                        Active
                    </div>

                    @elseif( empty($activePlan) && $plan->plan_id == 1 )
                    <div class="position-absolute top-0 end-0 bg-success text-white px-3 py-1 rounded-bottom-start fw-bold z-1">
                        Active
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center fw-bold">{{ $plan->name }}</h5>
                        <h2 class="text-center my-3 text-primary">
                            @if($plan->price == 0)
                            Free
                            @else
                            ₹{{ number_format($plan->price, 2) }}
                            @endif
                        </h2>
                        <ul class="list-unstyled my-3">
                            <li><i class="fas fa-file-invoice text-success me-2"></i>Invoices: {{  $plan->plan_id == '4' ? 'Unlimited' : $plan->invoice_limit }}/per month</li>
                            <li><i class="fas fa-user-friends text-success me-2"></i>Clients: {{ $plan->plan_id == '4' ? 'Unlimited' : $plan->client_limit }}</li>
                            <li><i class="fa-solid fa-bag-shopping text-success me-2"></i>Products Listing: {{ $plan->plan_id == '4' ? 'Unlimited' : $plan->product_listing_limit }}</li>
                            <li><i class="fas fa-clock text-success me-2"></i>Duration: {{ ucfirst($plan->duration_days) }} days</li>

                            @php
                            $features = json_decode($plan->features, true);
                            @endphp

                            @if($features)
                            @foreach ($features as $key => $value)
                            <li>
                                <i class="fas {{ $value === true ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-2"></i>
                                {{ ucwords(str_replace('_', ' ', $key)) }}
                            </li>
                            @endforeach
                            @endif
                        </ul>

                        <p class="text-muted small mt-auto text-center">
                            {{ $plan->description ?? 'Powerful features to simplify your billing process.' }}
                        </p>

                        @php
                        $isCurrentPlan = isset($activePlan) && $plan->plan_id == $activePlan->plan_id;
                        @endphp


                        @if( $plan->plan_id !== 1 )
                        <a href="{{ $isCurrentPlan ? 'javascript:void(0);' : route('plan.payment', ['plan_id' => $plan->plan_id ]) }}"
                            class="btn btn-primary btn-lg rounded-pill d-grid mt-3 {{ $isCurrentPlan ? 'disabled' : '' }}">
                            @if($plan->price == 0)
                            Start for Free
                            @elseif($isCurrentPlan)
                            Current Plan
                            @else
                            Buy Now
                            @endif
                        </a>

                        @endif

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-default-layout>