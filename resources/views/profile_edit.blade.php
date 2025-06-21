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
