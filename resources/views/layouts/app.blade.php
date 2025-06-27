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
    <link rel="icon" href="{{ asset('icons/logo_icon.png') }}" type="image/png" />
    <style>
        :root {
            --primary-color: #A65D57;
            --secondary-color: #D3A4A2;
            --background-color: #FFF5F5;
            --text-color: #4A3735;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: 100vh;
        }

        .main-content {

            width: 100%;
            box-sizing: border-box;
        }

        /* Navegação Superior */
        .top-nav {
            background-color: var(--background-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(166, 93, 87, 0.1);
        }
        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .logo-container img {
            height: 40px;
        }
        .logo-text {
            font-size: 1.5rem;
            color: var(--primary-color);
            font-weight: 600;
        }
        .nav-items {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: var(--primary-color);
        }
        .nav-link.active {
            color: var(--primary-color);
        }

        .avatar-img {
             width: 40px;
             height: 40px;
             border-radius: 50%;
             object-fit: cover;
             border: 2px solid #fff;
             box-shadow: 0 0 4px rgba(0,0,0,0.1);
        }

        .avatar-link {
            display: flex;
            align-items: center;
        }
        
        .btn-sair {
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }
        .btn-sair i {
            font-size: 1.1rem;
        }
        .btn-auth {
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-login {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        .btn-login:hover {
            background-color: var(--primary-color);
            color: white;
        }
        .btn-register {
            background-color: var(--primary-color);
            color: white;
        }
        .btn-register:hover {
            background-color: var(--secondary-color);
            color: var(--text-color);
        }
    

        /* Footer */
        footer {
            text-align: center;
            padding: 1rem;
            color: var(--text-color);
            opacity: 0.8;
            font-size: 0.9rem;
            margin-top: auto;
        }
    </style>

        @yield('styles')

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
    <nav class="top-nav navbar navbar-expand-lg">
        <a href="/" class="logo-container navbar-brand">
            <img src="{{ asset('images/logo-maternarte.png') }}" alt="MaternArte Logo">
        </a>

        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" style="border: none;">
            <i class="fas fa-bars" style="font-size: 1.5rem; color: var(--primary-color);"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <ul class="nav-items navbar-nav d-flex flex-column flex-lg-row gap-3 gap-lg-4 align-items-start align-items-lg-center mt-3 mt-lg-0">
                @guest
                    <li class="nav-item">
                        <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Início
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>
                @endauth

                <li class="nav-item">
                    <a href="/sobre" class="nav-link {{ request()->is('sobre*') ? 'active' : '' }}">Sobre</a>
                </li>

                @auth
                    <li class="nav-item">
                        <a href="{{ route('profile') }}" class="nav-link avatar-link">
                            @if (auth()->user()->profile_photo)
                                <img src="{{ asset('storage/profile_photos/' . auth()->user()->profile_photo) }}" 
                                    alt="Perfil" class="avatar-img">
                            @else
                                <i class="fas fa-user-circle fa-2x"></i>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-sair" style="border: none; background: none; cursor: pointer; padding: 0;">
                                <i class="fas fa-sign-out-alt"></i> <span>Sair</span>
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn-auth btn-login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn-auth btn-register">Registrar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer>
        © MaternArte {{ date('Y') }} Todos os direitos reservados
    </footer>

    <div class="modal fade" id="customAlertModal" tabindex="-1" aria-labelledby="customAlertModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 18px;">
          <div class="modal-header" style="background: #b84141; color: #fff; border-top-left-radius: 18px; border-top-right-radius: 18px;">
            <h5 class="modal-title" id="customAlertModalLabel"><i class="fas fa-exclamation-circle me-2"></i> Alerta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar" style="filter: invert(1);"></button>
          </div>
          <div class="modal-body text-center" id="customAlertModalBody" style="font-size: 1.1rem; color: #4A3735;">
            <!-- Mensagem será inserida via JS -->
          </div>
          <div class="modal-footer" style="border-bottom-left-radius: 18px; border-bottom-right-radius: 18px;">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="border-radius: 10px; background: #A65D57; border: none; font-weight: 600;">OK</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="customConfirmModal" tabindex="-1" aria-labelledby="customConfirmModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 18px;">
          <div class="modal-header" style="background: #A65D57; color: #fff; border-top-left-radius: 18px; border-top-right-radius: 18px;">
            <h5 class="modal-title" id="customConfirmModalLabel"><i class="fas fa-question-circle me-2"></i> Confirmação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar" style="filter: invert(1);"></button>
          </div>
          <div class="modal-body text-center" id="customConfirmModalBody" style="font-size: 1.1rem; color: #4A3735;">
            <!-- Mensagem será inserida via JS -->
          </div>
          <div class="modal-footer d-flex justify-content-center" style="border-bottom-left-radius: 18px; border-bottom-right-radius: 18px;">
            <button type="button" class="btn btn-secondary me-2" id="customConfirmCancelBtn" style="border-radius: 10px;">Cancelar</button>
            <button type="button" class="btn btn-primary" id="customConfirmOkBtn" style="border-radius: 10px; background: #A65D57; border: none; font-weight: 600;">Confirmar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/notifications.js') }}"></script>
    @stack('scripts')
    <script>
    function showCustomModal(message, type = 'alert') {
        const modalLabel = document.getElementById('customAlertModalLabel');
        const modalBody = document.getElementById('customAlertModalBody');
        modalBody.innerHTML = message;
        if (type === 'error') {
            modalLabel.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i> Erro';
            modalLabel.style.color = '#fff';
            modalLabel.parentElement.style.background = '#b84141';
        } else if (type === 'success') {
            modalLabel.innerHTML = '<i class="fas fa-check-circle me-2"></i> Sucesso';
            modalLabel.style.color = '#fff';
            modalLabel.parentElement.style.background = '#4BB543';
        } else {
            modalLabel.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i> Alerta';
            modalLabel.style.color = '#fff';
            modalLabel.parentElement.style.background = '#b84141';
        }
        const modal = new bootstrap.Modal(document.getElementById('customAlertModal'));
        modal.show();
    }

    function showCustomConfirm(message) {
        return new Promise((resolve) => {
            const modalLabel = document.getElementById('customConfirmModalLabel');
            const modalBody = document.getElementById('customConfirmModalBody');
            modalBody.innerHTML = message;
            modalLabel.innerHTML = '<i class="fas fa-question-circle me-2"></i> Confirmação';
            modalLabel.style.color = '#fff';
            modalLabel.parentElement.style.background = '#A65D57';
            const modal = new bootstrap.Modal(document.getElementById('customConfirmModal'));
            modal.show();
            const okBtn = document.getElementById('customConfirmOkBtn');
            const cancelBtn = document.getElementById('customConfirmCancelBtn');
            const cleanup = () => {
                okBtn.removeEventListener('click', onOk);
                cancelBtn.removeEventListener('click', onCancel);
            };
            function onOk() {
                cleanup();
                modal.hide();
                resolve(true);
            }
            function onCancel() {
                cleanup();
                modal.hide();
                resolve(false);
            }
            okBtn.addEventListener('click', onOk);
            cancelBtn.addEventListener('click', onCancel);
        });
    }
    </script>
</body>
</html> 