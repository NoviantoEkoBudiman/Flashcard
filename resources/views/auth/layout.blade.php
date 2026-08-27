<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · Vian's Flashcard</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eef4ff 0%, #f8f9fa 55%, #e8fff5 100%);
        }

        .auth-card {
            width: min(100% - 2rem, 430px);
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(17, 24, 39, .12);
        }

        .brand-mark {
            color: #0d6efd;
            font-weight: 700;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">
    <main class="card auth-card">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="brand-mark fs-4">Vian's Flashcard</div>
                <h1 class="h3 mt-3 mb-1">@yield('heading')</h1>
                <p class="text-muted mb-0">@yield('subtitle')</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
