@extends('layouts.app')

@section('content')

<div style="background-color: #e8c2c2; min-height: 100vh; padding: 60px 20px;">
    <div style="max-width: 420px; margin: 0 auto; background-color: #ffffff;
                padding: 40px 40px 30px; border-radius: 20px;
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.08);">

        <h2 style="font-size: 28px; color: #6b1f1f; font-weight: bold; text-align: center; margin-bottom: 20px;">
            Redefinir Senha
        </h2>

        @if (session('status'))
            <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;
                        padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div style="margin-bottom: 25px;">
                <label for="email" style="display: block; font-size: 15px; margin-bottom: 8px; color: #333;">
                    Email:
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

            <div style="text-align: center;">
                <button type="submit"
                        style="background-color: #a33c3c; color: #fff; border: none;
                               border-radius: 10px; font-size: 18px; padding: 10px 40px; cursor: pointer;">
                    Enviar Link de Redefinição
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
