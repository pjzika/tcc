@extends('layouts.app')

@section('styles')
<style>
    .timer {
        font-size: 2.5em;
        font-weight: bold;
        color: #2d3748;
        margin: 20px 0;
    }
    
    .input-section {
        background-color: #f8fafc;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
    }
    
    .registro {
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .registro:hover {
        background-color: #f8fafc;
    }
    
    .registro strong {
        color: #4a5568;
    }
    
    #btnStart, #btnStop {
        min-width: 100px;
        margin: 0 5px;
    }
    
    #ml {
        border: 1px solid #e2e8f0;
        border-radius: 4px;
    }
    
    #ml:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    .tip-item {
        transition: opacity 0.5s ease-in-out;
        opacity: 0;
    }

    .tip-item.fade-in {
        opacity: 1;
    }

    .tip-item h6 {
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .tip-item p {
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    .tip-item small {
        font-size: 0.8rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if($babies->isEmpty())
                <div class="card">
                    <div class="card-header">Registrar Novo Bebê</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('baby.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nome do Bebê</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="birth_date">Data de Nascimento</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Dashboard</h5>
                            <select class="form-control w-auto" id="baby-selector">
                                @foreach($babies as $b)
                                    <option value="{{ $b->id }}" {{ $b->id === $baby->id ? 'selected' : '' }}>
                                        {{ $b->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Coluna de Amamentação -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Amamentação</div>
                            <div class="card-body">
                                <div class="timer text-center mb-3" id="timer">00:00</div>
                                
                                <div class="text-center mb-3">
                                    <button id="btnStart" class="btn btn-primary">Iniciar</button>
                                    <button id="btnStop" class="btn btn-danger" disabled>Parar</button>
                                </div>

                                <div class="input-section" id="inputSection" style="display: none;">
                                    <div class="form-group">
                                        <label for="ml">Quantidade de leite (mL) <small>(opcional)</small>:</label>
                                        <input type="number" class="form-control" id="ml" placeholder="Ex: 120">
                                    </div>
                                    <button type="button" id="btnSave" class="btn btn-success btn-block mt-2">Salvar Registro</button>
                                </div>

                                <div class="mt-4">
                                    <h5>Registros</h5>
                                    <div id="registros" class="mt-3">
                                        @forelse($feedings as $feeding)
                                            <div class="registro">
                                                <strong>Data:</strong> {{ $feeding->started_at->format('d/m/Y H:i') }}<br>
                                                <strong>Duração:</strong> {{ $feeding->formatted_duration }}<br>
                                                <strong>Quantidade:</strong> {{ $feeding->quantity ? $feeding->quantity . ' mL' : 'não informado' }}
                                            </div>
                                        @empty
                                            <p class="text-muted text-center">Nenhum registro de amamentação encontrado.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna de Alarmes -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Alarmes</div>
                            <div class="card-body">
                                @foreach($alarms as $alarm)
                                    <div class="alarm-item d-flex justify-content-between align-items-center mb-2">
                                        <span>{{ $alarm->formatted_time }} - {{ $alarm->day_name }}</span>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input alarm-toggle" 
                                                id="alarm-{{ $alarm->id }}" 
                                                data-alarm-id="{{ $alarm->id }}"
                                                {{ $alarm->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="alarm-{{ $alarm->id }}"></label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Coluna de Dicas -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Dicas do Dia</div>
                            <div class="card-body">
                                <div id="tipsContainer">
                                    <div class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Carregando...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/feeding-manager.js') }}"></script>
<script src="{{ asset('js/tips-manager.js') }}"></script>
@endpush

@endsection