<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MaternArte - Apoio para Mães de Primeira Viagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
       :root {
    --primary-color: #9A434A;
    --secondary-color: #D3A4A2;
    --background-color: #F8EFEF;
    --text-color: #0a0707;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--background-color);
        color: var(--text-color);
        min-height: 100vh;
    }

    .top-nav {
        background-color: var(--background-color);
        padding: 15px 60px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(166, 93, 87, 0.1);
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

   .logo-container img {
        height: 55px;
    }

    .nav-items {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .nav-link {
        color: var(--text-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 20px;
        transition: color 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        color: var(--primary-color);
    }

    .btn-auth {
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 500;
        font-size: 16px;
        text-decoration: none;
    }

    .btn-login {
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        background-color: transparent;
    }

    .btn-login:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-register {
        background-color: var(--primary-color);
        border: 2px solid var(--primary-color);
        color: white;
    }

    .btn-register:hover {
        background-color: transparent;
        color: var(--text-color);
    }

    footer {
        text-align: center;
        padding: 20px;
        color: var(--text-color);
        font-size: 14px;
        background-color: var(--background-color);
        margin-top: 60px;
    }

    .info-box {
        border: 2px solid var(--primary-color);
        border-radius: 16px;
        padding: 32px;
        background-color: #ffffff;
        color: var(--text-color);
        transition: transform 0.3s ease;
    }

    .info-box:hover {
        transform: translateY(-4px);
    }

    .info-box i {
        font-size: 32px;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .info-box h5 {
        font-weight: 600;
        font-size: 32px;
        margin-bottom: 10px;
    }

    .info-box p {
        font-size: 20px;
    }



    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            window.fetchConfig = {
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            };
        });
    </script>
</head>
<body>
    <nav class="top-nav">
        <a href="/" class="logo-container">
            <img src="{{ asset('images/logo-maternarte.png') }}" alt="MaternArte Logo">
        </a>
        <div class="nav-items">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Início</a>
            <a href="/sobre" class="nav-link {{ request()->is('sobre*') ? 'active' : '' }}">Sobre</a>
            <a href="/recursos" class="nav-link {{ request()->is('recursos*') ? 'active' : '' }}">Recursos</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-sair" style="border: none; background: none; cursor: pointer; padding: 0;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-auth btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn-auth btn-register">Registrar</a>
            @endauth
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer>
        © MaternArte {{ date('Y') }} Todos os direitos reservados
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    @stack('scripts')
</body>
</html> 