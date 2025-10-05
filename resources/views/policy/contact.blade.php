<x-default-layout>

<style>
    body {
        font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    .contact-container {
        max-width: 800px;
        margin: 60px auto;
        background-color: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.04);
    }

    h1 {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
    }

    .form-label {
        font-weight: 500;
    }
</style>


<div class="container contact-container">
    <h1>Contact Us</h1>

    <p class="text-center mb-4">Have a question, feedback, or need support? We'd love to hear from you.</p>

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('policy.store.contact') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}">
                    @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5">{{ old('message') }}</textarea>
                    @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Send Message</button>

                @if(session('success'))
                <div class="mt-3 alert alert-success alert-dismissible fade show " role="alert" style="min-width: 300px;">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

            </form>


        </div>

        <div class="col-md-6 mt-4 mt-md-0">
            <h5>Contact Details</h5>
            <p><strong>Email:</strong> <a href="mailto:support@invoicezy.com">support@invoicezy.com</a></p>
            <p><strong>Website:</strong> <a href="https://invoicezy.com" target="_blank">https://invoicezy.com</a></p>
            <p><strong>Premium Link:</strong> <a href="https://pro.invoicezy.com" target="_blank">https://pro.invoicezy.com</a></p>
            <p><strong>Location:</strong> Ghaziabad, Uttar Pradesh, India</p>
            <p><strong>Business Name:</strong> Invoicezy (Owned by Prem Morya)</p>
        </div>
    </div>
</div>


</x-default-layout>