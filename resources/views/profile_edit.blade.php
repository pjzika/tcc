@extends('layouts.app') 

@section('content')
    <div class="container">
        <h1>Editar Perfil</h1>

        <form method="POST" action="{{ route('profile.edit') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nome -->
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Senha atual (obrigatório para mudar email) -->
            <div class="form-group">
                <label for="current_password">Senha atual <span class="text-muted" style="font-size:0.9em;">(necessária para mudar o email)</span></label>
                <input type="password" name="current_password" id="current_password" class="form-control" autocomplete="current-password">
                @error('current_password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Nova senha (opcional) -->
            <div class="form-group">
                <label for="password">Nova senha <span class="text-muted" style="font-size:0.9em;">(deixe em branco para não alterar)</span></label>
                <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Confirmação da nova senha (opcional) -->
            <div class="form-group">
                <label for="password_confirmation">Confirmar nova senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Foto de Perfil -->
            <div class="form-group">
                <label>Foto de Perfil</label><br>
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}"
                         alt="Foto de Perfil" style="width:100px; height:100px; border-radius:50%; object-fit:cover;">
                @else
                    <p>Nenhuma foto enviada.</p>
                @endif

                <input type="file" name="profile_photo" class="form-control-file" accept="image/*">
                @error('profile_photo') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
