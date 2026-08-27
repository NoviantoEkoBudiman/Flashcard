
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.108.0">
        <title>Vian's Flashcard</title>

        <!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/"> -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" integrity="" crossorigin="anonymous">

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
        <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
        <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
        <link rel="manifest" href="{{ asset('js/manifest.json') }}">
        <link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
        <link rel="icon" href="{{ asset('images/favicon.ico') }}">
        <meta name="theme-color" content="#712cf9">
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
        <script src="{{ asset('js/jquery.min.js'); }}"></script>
        <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" /> -->
        <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css'); }}" />
        <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> -->
        <script src="{{ asset('js/jquery.dataTables.js'); }}"></script>
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            .b-example-divider {
                height: 3rem;
                background-color: rgba(0, 0, 0, .1);
                border: solid rgba(0, 0, 0, .15);
                border-width: 1px 0;
                box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
            }

            .b-example-vr {
                flex-shrink: 0;
                width: 1.5rem;
                height: 100vh;
            }

            .bi {
                vertical-align: -.125em;
                fill: currentColor;
            }

            .nav-scroller {
                position: relative;
                z-index: 2;
                height: 2.75rem;
                overflow-y: hidden;
            }

            .nav-scroller .nav {
                display: flex;
                flex-wrap: nowrap;
                padding-bottom: 1rem;
                margin-top: -1px;
                overflow-x: auto;
                text-align: center;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }
        </style>

    
        <!-- Custom styles for this template -->
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    </head>
    <body>
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="{{ route('language.index') }}">Vian's Flashcard</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-none d-md-flex align-items-center ms-auto px-3 text-white-50 text-nowrap">
                <span data-feather="user" class="align-text-bottom me-2"></span>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <div class="navbar-nav border-start border-secondary">
                <div class="nav-item text-nowrap">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link px-3 bg-transparent border-0">Sign out</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('language.index') }}">
                                    <span data-feather="home" class="align-text-bottom"></span>
                                    Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('language_index') }}">
                                    <span data-feather="book" class="align-text-bottom"></span>
                                    Language & Card
                                </a>
                            </li>
                    
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('play.index') }}">
                                    <span data-feather="command" class="align-text-bottom"></span>
                                    Play
                                </a>
                            </li>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"> --}}
                    <br/>
                    @yield('main')
                    {{-- </div> --}}
                </main>
            </div>
        </div>

        <script src="{{ asset('js/bootstrap.bundle.min.js'); }}" integrity="" crossorigin="anonymous"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="" crossorigin="anonymous"></script> -->
        <script src="{{ asset('js/feather.min.js'); }}" integrity="" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="" crossorigin="anonymous"></script>
        <script src="{{ asset('js/dashboard.js'); }}"></script>
        
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready( function () {
                $('#myTable').DataTable();
            } );
        </script>

        @if (session('success'))
            <script>
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: '{{ session("success") }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
        @elseif(session('failed'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session("failed") }}'
                })
            </script>
        @endif
    </body>
</html>
