<!-- resources/views/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Outlook Productivity</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">Outlook Productivity</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                @if(session('userId'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Account
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <h6 class="dropdown-item-text">{{ $userName ?? 'User' }}</h6>
                            <p class="dropdown-item-text">{{ $userEmail ?? '' }}</p>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/signout">Sign Out</a>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/signin">Sign In</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
            @if(session('errorDetail'))
                <pre>{{ session('errorDetail') }}</pre>
            @endif
        </div>
    @endif

    @yield('content')
</main>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
