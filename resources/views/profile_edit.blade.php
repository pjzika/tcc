@extends('layouts.app')

@section('styles')
<style>
    .profile-container {
        max-width: 480px;
        margin: 40px auto 60px auto;
        background: #fff;
        padding: 30px 25px;
        border-radius: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-align: center; 
    }

    .profile-title {
        font-weight: 700;
        color: #b84141;
        margin-bottom: 1.5rem;
    }

    .profile-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #b84141;
        display: block;
        margin: 0 auto 1.5rem auto;
    }

    .profile-photo-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #e8c2c2;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        color: #7a7a7a;
        font-weight: 600;
        font-size: 0.9rem;
    }

    form {
        text-align: left;
    }

    label {
        font-weight: 600;
        display: block;
        margin-bottom: 6px;
        color: #4a4a4a;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"] {
        width: 100%;
        padding: 10px 12px;
        font-size: 1rem;
        border: 1.5px solid #ccc;
        border-radius: 10px;
        margin-bottom: 1.2rem;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="file"]:focus {
        border-color: #b84141;
        outline: none;
    }

    .text-danger {
        margin-top: -1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    button.btn-edit-profile {
        background-color: #A65D57;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        padding: 12px 40px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: block;
        margin: 0 auto;
        text-align: center;
        width: fit-content;
        min-width: 140px;
    }

    button.btn-edit-profile:hover {
        background-color: transparent;
        border: 2px solid #A65D57; 
        color: #A65D57;
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <h2 class="profile-title">Editar Perfil</h2>

    <form method="POST" action="{{ route('profile.edit') }}" enctype="multipart/form-data">
        @csrf

        <label for="name">Nome</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
        @error('email') <div class="text-danger">{{ $message }}</div> @enderror

        <label>Foto de Perfil</label>
        @if ($user->profile_photo)
            <img src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}" alt="Foto de Perfil" class="profile-photo">
        @else
            <div class="profile-photo-placeholder">Sem foto</div>
        @endif
        <input type="file" name="profile_photo" accept="image/*">
        @error('profile_photo') <div class="text-danger">{{ $message }}</div> @enderror

        <button type="submit" class="btn-edit-profile">Salvar</button>
    </form>
</div>
@endsection
