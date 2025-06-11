@extends('layouts.app')

@section('content')

<div style="background-color: #e8c2c2; min-height: 100vh; padding: 60px 20px;">
    <div style="max-width: 420px; margin: 0 auto; background-color: #ffffff;
                padding: 40px 40px 30px; border-radius: 20px;
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.08); text-align: center;">

        <h2 style="font-size: 28px; color: #6b1f1f; font-weight: bold; margin-bottom: 20px;">
            Verificação de Email
        </h2>

        @if (session('resent'))
            <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;
                        padding: 12px 20px; border-radius: 10px; margin-bottom: 20px;">
                Um novo link de verificação foi enviado para seu email.
            </div>
        @endif

        <p style="font-size: 15px; color: #000; margin-bottom: 10px;">
            Antes de continuar, por favor verifique seu email para o link de verificação.
        </p>
        <p style="font-size: 15px; color: #000; margin-bottom: 30px;">
            Se você não recebeu o email,
        </p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit"
                    style="background-color: #a33c3c; color: #fff; border: none;
                           border-radius: 10px; font-size: 18px; padding: 10px 40px; cursor: pointer;">
                Clique aqui para solicitar outro
            </button>
        </form>

    </div>
</div>

@endsection
