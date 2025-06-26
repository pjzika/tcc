@extends('layouts.app')

@section('content')

<div style="background-color: #e8c2c2; min-height: 100vh; padding: 60px 20px;">
    <div style="max-width: 420px; margin: 0 auto; background-color: #ffffff;
                padding: 40px 40px 30px; border-radius: 20px;
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.08);">

        <h2 style="font-size: 28px; color: #6b1f1f; font-weight: bold; text-align: center; margin-bottom: 10px;">
            Cadastre-se
        </h2>
        <p style="font-size: 15px; color: #000; text-align: center; margin-bottom: 30px;">
            Crie sua conta para começar
        </p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom: 20px;">
                <label for="name" style="display: block; font-size: 15px; margin-bottom: 8px; color: #333;">
                    Nome:
                </label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       style="width: 100%; height: 42px; padding: 10px 15px;
                              border: none; border-radius: 10px; background-color: #f2f2f2; font-size: 15px;">
                @error('name')
                    <span style="color: #a33c3c; font-size: 13px; display: block; margin-top: 5px;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-size: 15px; margin-bottom: 8px; color: #333;">
                    E-mail:
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       style="width: 100%; height: 42px; padding: 10px 15px;
                              border: none; border-radius: 10px; background-color: #f2f2f2; font-size: 15px;">
                @error('email')
                    <span style="color: #a33c3c; font-size: 13px; display: block; margin-top: 5px;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; font-size: 15px; margin-bottom: 8px; color: #333;">
                    Senha:
                </label>
                <input id="password" type="password" name="password" required
                       style="width: 100%; height: 42px; padding: 10px 15px;
                              border: none; border-radius: 10px; background-color: #f2f2f2; font-size: 15px;">
                @error('password')
                    <span style="color: #a33c3c; font-size: 13px; display: block; margin-top: 5px;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label for="password_confirmation" style="display: block; font-size: 15px; margin-bottom: 8px; color: #333;">
                    Confirmar Senha:
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       style="width: 100%; height: 42px; padding: 10px 15px;
                              border: none; border-radius: 10px; background-color: #f2f2f2; font-size: 15px;">
            </div>

            <div style="text-align: center;">
                <button type="submit"
                        style="background-color: #a33c3c; color: #fff; border: none;
                               border-radius: 10px; font-size: 18px; padding: 10px 40px; cursor: pointer;">
                    Cadastrar
                </button>
            </div>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('login') }}" style="font-size: 13px; color: #5a1e1e;">
                Já tem uma conta? Faça login
            </a>
        </div>
    </div>
</div>

@endsection
