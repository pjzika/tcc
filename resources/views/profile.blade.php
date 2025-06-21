@extends('layouts.app') 

@section('content')
<div class="container">
    <h1>Perfil de {{ $user->name }}</h1>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    @if ($user->profile_photo)
    <img src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}" alt="Foto de Perfil" style="width:120px; height:120px; object-fit:cover; border-radius:50%;">
@else
    <p>Sem foto de perfil.</p>
@endif

    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
    Editar Perfil
</a>
</div>
@endsection
