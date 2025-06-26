@extends('layouts.app')

@section('styles')
<style>

    .profile-container {
        max-width: 480px;
        margin: 40px auto;
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

    .profile-email {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .btn-edit-profile {
        background-color: #A65D57;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        margin: 0 auto 0; 
        padding: 10px 40px;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-edit-profile:hover {
        background-color: transparent;
        border: 2px solid #A65D57; 
        color: #A65D57;
        transform: scale(1.00);
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div style="background-color: #e8c2c2; min-height: 100vh; padding: 60px 20px;">
    <div class="profile-container">
        <h2 class="profile-title">Perfil de {{ $user->name }}</h2>

        @if ($user->profile_photo)
            <img src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}" alt="Foto de Perfil" class="profile-photo">
        @else
            <div class="profile-photo-placeholder">
                Sem foto
            </div>
        @endif

        <p class="profile-email"><strong>Email:</strong> {{ $user->email }}</p>

        <a href="{{ route('profile.edit') }}" class="btn-edit-profile">Editar Perfil</a>
    </div>
</div>
@endsection
