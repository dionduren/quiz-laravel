<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap Integration -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for Flexbox Layout and Sticky Footer -->
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex-grow: 1;
            padding-bottom: 1rem;
        }

        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            border-top: 2px solid black;
            /* Ensure it stays at the bottom */
        }

        /* Ensure the icon styles are visible */
        .bi {
            font-size: 1.5rem;
        }

        .capitalize {
            text-transform: capitalize;
        }
    </style>

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('main_menu') }}">
                <i class="bi bi-house-door"></i>
                Quiz Game
                @isset($sessionNumber)
                    - Session {{ $sessionNumber }}
                @endisset
            </a>

            @if (request()->routeIs('main_menu'))
                <div class="ms-auto d-flex align-items-center">
                    <a href="https://www.multibuzz.app/" class="nav-link px-4" style="color: #ffffff;">Aplikasi Bell
                        Quiz</a>

                    <a href="{{ route('teams.scoreboard') }}" class="nav-link px-4"
                        style="color: #00c0ff;">Scoreboard</a>

                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle px-4" href="#" id="manageQuizDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color: #28a745;">
                            Manage Pertanyaan
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="manageQuizDropdown">
                            <li><a class="dropdown-item" href="{{ route('quiz.create') }}">Buat Pertanyaan</a></li>
                            <li><a class="dropdown-item" href="{{ route('quiz.index') }}">Edit Pertanyaan</a></li>
                        </ul>
                    </div>

                    <a href="{{ route('teams.manage') }}" class="nav-link px-4" style="color: #ffc107;">Team
                        Management</a>
                </div>
            @endif
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <div class="content-wrapper">
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer Section -->
        <footer class="mt-5">
            <div class="container">
                @yield('footer')
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS (for dropdowns and other interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
