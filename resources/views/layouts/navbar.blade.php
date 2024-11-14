<nav class="navbar">
    @if(Auth::user() && Auth::user()->role === 'profesor')
        <a class="navbar-brand" href="#">Moodle (Profesor) </a>
    @else
        <a class="navbar-brand" href="#">Moodle</a>
    @endif
    <ul class="navbar-nav">
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
        </li>
    </ul>
</nav>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    .navbar {
        background-color: #343a40;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .navbar-brand {
        font-size: 1.5rem;
        color: white;
        text-decoration: none;
    }

    .navbar-nav {
        list-style: none;
        display: flex;
        margin: 0;
        padding: 0;
    }

    .nav-item {
        margin-left: 1rem;
    }

    .nav-link {
        color: white;
        text-decoration: none;
        font-size: 1rem;
    }

    .nav-link:hover {
        text-decoration: underline;
    }

    .container {
        padding: 2rem;
    }

    h1 {
        color: #343a40;
        font-size: 2rem;
    }

</style>
