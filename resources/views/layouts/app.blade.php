<!DOCTYPE html>
<html>
<head>
    <title>Todo App</title>
</head>
<body>
    @if(session('user'))
        Logged in as: {{ session('user.name') }}
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @endif

    <hr>

    @yield('content')
</body>
</html>
