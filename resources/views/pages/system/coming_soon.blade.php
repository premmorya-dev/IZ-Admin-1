<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon | Invoicezy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .coming-soon {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
        }
        .coming-soon h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .coming-soon p {
            font-size: 1.25rem;
            color: #6c757d;
        }
        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="coming-soon">
        <div class="logo mb-3">Invoicezy</div>
        <h1>🚧 Coming Soon</h1>
        <p>We're working hard to bring you something amazing.<br>Stay tuned for updates!</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-4">Back to Home</a>
    </div>
</body>
</html>
