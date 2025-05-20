@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header text-center">
                    <h4>Verificação de Email</h4>
                </div>

                <div class="card-body text-center">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Um novo link de verificação foi enviado para seu email.
                        </div>
                    @endif

                    <p>Antes de continuar, por favor verifique seu email para o link de verificação.</p>
                    <p>Se você não recebeu o email,</p>

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Clique aqui para solicitar outro
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 