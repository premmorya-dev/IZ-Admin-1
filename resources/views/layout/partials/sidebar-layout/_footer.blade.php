<!-- begin::Footer -->
<footer class="text-center py-3 bg-light border-top small">
    <div class="container">
        <div class="mb-2">
            <a href="{{ route('policy.terms') }}" target="__blank"   class="text-muted me-3">Terms & Conditions</a>
            <a href="{{ route('policy.privacy') }}"  target="__blank"  class="text-muted me-3">Privacy Policy</a>
            <a href="{{ route('policy.cookie') }}"  target="__blank"  class="text-muted me-3">Cookie Policy</a>
            <a  href="{{ route('policy.contact') }}"   target="__blank"  class="text-muted me-3">Contact Us</a>
            <a href="{{ route('policy.about') }}"  target="__blank"  class="text-muted me-3">About Us</a>
             <a href="{{ route('policy.refund') }}"  target="__blank"  class="text-muted me-3">Cancellation and Refund Policy</a>
        </div>
        <div class="text-muted">
            &copy; {{ date('Y') }} Invoicezy. All rights reserved.
        </div>
    </div>
</footer>
<!-- end::Footer -->

