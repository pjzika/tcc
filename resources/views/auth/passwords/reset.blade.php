@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header text-center">
                    <h4>Redefinir Senha</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ $email ?? old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Redefinir Senha
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem;
    }

    .card-header h4 {
        margin: 0;
        color: #4a1c1c;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .form-label {
        color: #4a5568;
        font-weight: 500;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border-color: #d48c8c;
        box-shadow: 0 0 0 3px rgba(212, 140, 140, 0.3);
    }

    .btn-primary {
        background-color: #d48c8c;
        border: none;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #c47c7c;
    }

    .invalid-feedback {
        color: #e53e3e;
        font-size: 0.875rem;
    }
</style>
@endsection
