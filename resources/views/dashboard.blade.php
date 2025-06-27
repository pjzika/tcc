@extends('layouts.app')

@section('styles')
<style>

    .container-dashboard {
        background-color: #e8c2c2;
        min-height: 100vh;
        padding-top: 60px;
        padding-left: 20px; 
        padding-right: 20px;
        box-sizing: border-box;
        width: 100%;
        margin: 0 auto;
    }

    .container-dashboard .row {
        margin-left: 0;
        margin-right: 0;
    }

    /* Welcome Card */
    .container-dashboard {
        background-color: #e8c2c2;
        min-height: 100vh;
        padding-top: 60px;
        width: 100%;
    }

    .welcome-card {
        max-width: 420px;
        width: 100%;
        background-color: #ffffff;
        padding: 40px 40px 30px;
        border-radius: 20px;
        box-shadow: 0px 5px 10px rgba(171, 157, 157, 0.08);
    }

    .welcome-title {
        font-size: 28px;
        color: #6b1f1f;
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
    }

    .welcome-text {
        font-size: 15px;
        color: #000;
        text-align: center;
        margin-bottom: 30px;
    }

    .btn-register {
        background-color: #A65D57;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        padding: 10px 40px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        background-color: transparent;
        border: 2px solid #A65D57; 
        transform: scale(1.00);
    }


    /*  regsitro de bebê */
   .btn-register-baby {
        font-size: 18px;
        background-color: #A65D57; 
        color: white; 
        padding: 4px 8px; 
        border: 2px solid #A65D57; 
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-register-baby:hover {
         transform: scale(1.03);
    }

    .btn-cancel {
        font-size: 18px;
        background-color: transparent;
        color: #A65D57;
        padding: 4px 8px;
        border: 2px solid #A65D57;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
         transform: scale(1.03);
    }

    /* dashboard top */
    .dashboard-top-card {
        max-width: 500px;
        margin: 0 auto 30px auto;
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0px 5px 10px rgba(171, 157, 157, 0.08);
        padding: 20px 30px;
    }

    .dashboard-top-card .d-flex {
    flex-wrap: wrap;
    gap: 10px;
    }

    @media (max-width: 576px) {
    .dashboard-top-card .form-control,
    .dashboard-top-card .btn {
        width: 100%;
    }

    #baby-selector {
        margin-bottom: 8px;
    }
    }

    .dashboard-top-card .form-control {
        border-radius: 10px;
    }
    .dashboard-top-card .btn {
        background-color: #a33c3c;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        padding: 8px 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .dashboard-top-card .btn:hover {
        background-color: #902f2f;
        transform: scale(1.03);
    }

    /* Card Amamentação */
    .card-feeding {
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0px 5px 10px rgba(171, 157, 157, 0.08);
        padding: 20px 25px;
        margin-bottom: 30px;
        border: none;
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 100%;
    }

    .feeding-header {
        font-weight: 700;
        font-size: 1.2rem;
        color: #6b1f1f;
        background-color: transparent;
        border-bottom: none;
        padding-bottom: 15px;
    }

    .feeding-timer {
        font-size: 2.5rem;
        font-weight: 700;
        color: #a65d57;
        margin: 20px 0;
        text-align: center;
    }

    /* Botões amamentação */
    .btn-feeding-start,
    .btn-feeding-stop,
    .btn-feeding-save {
        border-radius: 10px;
        padding: 10px 25px;
        font-weight: 600;
        color: white;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        transition: background-color 0.3s ease;
    }

    .btn-feeding-start {
        font-size: 24px;
        background-color: #A65D57; 
        color: white; 
        padding: 4px 8px; 
        border: 2px solid #A65D57; 
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-feeding-start:hover {
        transform: scale(1.03);
    }

    .btn-feeding-stop {
        font-size: 24px;
        background-color: transparent;
        color: #A65D57;
        padding: 4px 8px;
        border: 2px solid #A65D57;
        border-radius: 10px;
        transition: all 0.3s ease;;
    }

    .btn-feeding-stop:hover {
         transform: scale(1.03);
    }

    .btn-feeding-save {
        background-color: #27ae60;
        border-color: #27ae60;
        box-shadow: 0 3px 8px rgba(39, 174, 96, 0.5);
        border-radius: 10px;
        padding: 10px 25px;
        font-weight: 600;
        transition: background-color 0.3s ease;
        color: white;
        display: block;
        margin: 0 auto; 
    }

    .btn-feeding-save:hover {
        background-color: #1e8c4b;
        border-color: #1e8c4b;
    }

    /* Registro de amamentação */
    .feeding-record {
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .feeding-record:hover {
        background-color: #f8fafc;
    }

    .feeding-record strong {
        color: #4a5568;
    }

    /* Card Alarmes */
    .card-alarm {
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0px 5px 10px rgba(171, 157, 157, 0.08);
        padding: 20px 25px;
        margin-bottom: 30px;
        border: none;
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 100%;
    }

    .alarm-header {
        font-weight: 700;
        font-size: 1.2rem;
        color: #6b1f1f;
        padding-bottom: 15px;
        border-bottom: none;
        background-color: transparent;
    }

    .alarm-body {
        flex-grow: 1;
    }

    .alarm-item {
        font-weight: 600;
        font-size: 1rem;
        color: #2d3748;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
    }

    .alarm-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .alarm-time {
        color: #a65d57;
        font-weight: 700;
        font-size: 1.1rem;
    }

    /* Botões dentro do card Alarmes */
    .btn-outline-secondary {
        color: #6b1f1f;
        border-color: #a65d57;
        transition: all 0.3s ease;
        padding: 4px 8px;
        border-radius: 10px;
    }

    .btn-outline-secondary:hover {
        background-color: #a65d57;
        color: #fff;
        border-color: #902f2f;
    }

    .form-check-input {
        cursor: pointer;
        width: 2.2em;
        height: 1.2em;
        margin: 0;
        vertical-align: middle;
    }

    /* Editar Alarme*/
    .alarm-modal-content {
        max-width: 420px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 40px 40px 30px;
        border-radius: 20px;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.08);
    }

    .alarm-modal-header {
        border: none;
        padding-bottom: 0;
    }

    .alarm-modal-title {
        font-size: 20px;
        color: #6b1f1f;
        font-weight: bold;
        text-align: center;
        width: 100%;
    }

    .alarm-modal-body {
        padding-top: 1rem;
    }

    .alarm-label {
        display: block;
        font-size: 15px;
        margin-bottom: 8px;
        color: #333;
    }

    .alarm-modal-footer {
        border: none;
        padding-top: 0;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .btn-register-alarm {
        font-size: 18px;
        background-color: #A65D57; 
        color: white; 
        padding: 4px 8px; 
        border: 2px solid #A65D57; 
        border-radius: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-register-alarm:hover {
        transform: scale(1.03);
    }

    .btn-cancel {
        font-size: 18px;
        background-color: transparent;
        color: #A65D57;
        padding: 4px 8px;
        border: 2px solid #A65D57;
        border-radius: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-cancel:hover {
        transform: scale(1.03);
    }

    .btn-test-alarm {
        font-size: 16px;
        background-color: #A65D57;
        color: white;
        padding: 6px 20px;
        border: 2px solid #A65D57;
        border-radius: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px; 
    }

    .btn-test-alarm:hover {
        background-color: #902f2f;
        border-color: #902f2f;
        transform: scale(1.05);
    }

    .btn-test-alarm:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(166, 93, 87, 0.5);
    }


    /* Card Dicas */
    .card-tips {
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0px 5px 10px rgba(171, 157, 157, 0.08);
        padding: 20px 25px;
        margin-bottom: 30px;
        border: none;
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 100%;
    }

    .tips-header {
        font-weight: 700;
        font-size: 1.2rem;
        color: #6b1f1f;
        padding-bottom: 15px;
        border-bottom: none;
        background-color: transparent;
    }

    .tips-body {
        flex-grow: 1;
        color: #2d3748;
        font-size: 1rem;
        line-height: 1.4;
    }

    /* Spinner carregando centralizado */
    .tips-body .spinner-border {
        margin-top: 40px;
        margin-bottom: 40px;
    }

    /* Texto das dicas */
    .tip-item {
        margin-bottom: 15px;
    }

    .tip-item h6 {
        color: #6b1f1f;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .tip-item p {
        color: #4a5568;
        font-size: 0.9rem;
        margin: 0;
    }

</style>
@endsection


@section('content')

<div class="container-dashboard">

    @if($babies->isEmpty())
        <div class="d-flex justify-content-center align-items-start">
            <div class="welcome-card">
                <h2 class="welcome-title">Bem-vindo(a)!</h2>
                <p class="welcome-text">Para começar a usar o dashboard, por favor, registre seu primeiro bebê.</p>
                <div class="text-center">
                    <button type="button" class="btn-register" data-bs-toggle="modal" data-bs-target="#addBabyModal">
                        Registrar Bebê
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="dashboard-top-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dashboard</h5>
                    <div class="d-flex align-items-center">
                        <select class="form-control w-auto me-2" id="baby-selector">
                            @foreach($babies as $b)
                                <option value="{{ $b->id }}" {{ $b->id === $baby->id ? 'selected' : '' }}>
                                    {{ $b->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBabyModal">
                            <i class="fas fa-plus"></i> Adicionar Bebê
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <!-- Coluna de Amamentação -->
            <div class="col-md-4">
                <div class="card-feeding">
                    <div class="feeding-header">Amamentação</div>
                    <div class="card-body">
                        <div class="feeding-timer" id="timer">00:00</div>
                        
                        <div class="text-center mb-3">
                            <button id="btnStart" class="btn-feeding-start">Iniciar</button>
                            <button id="btnStop" class="btn-feeding-stop" disabled>Parar</button>
                        </div>

                        <div class="feeding-input-section" id="inputSection" style="display: none;">
                            <div class="form-group">
                                <label for="ml">Quantidade de leite (mL) <small>(opcional)</small>:</label>
                                <input type="number" class="form-control" id="ml" placeholder="Ex: 120">
                            </div>
                            <button type="button" id="btnSave" class="btn-feeding-save mt-2">Salvar Registro</button>
                        </div>

                        <div class="mt-4">
                            <h5>Registros</h5>
                            <div id="registros" class="mt-3">
                                @forelse($feedings as $feeding)
                                    <div class="feeding-record">
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
                <div class="card-alarm">
                    <div class="alarm-header d-flex justify-content-between align-items-center">
                        <span>Alarmes</span>
                           <button id="test-alarm-btn" class="btn-test-alarm btn-sm" type="button">
                                <i class="fas fa-bell"></i> Testar Alarme
                            </button>
                            {{-- Futuro botão de adicionar alarme --}}
                    </div>
                    <div class="alarm-body">
                        @forelse($alarms as $alarm)
                            <div class="alarm-item d-flex justify-content-between align-items-center mb-2">
                                <span class="alarm-time">{{ $alarm->formatted_time }}</span>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary me-2 edit-alarm-btn" data-bs-toggle="modal" data-bs-target="#editAlarmModal" data-alarm-id="{{ $alarm->id }}" data-alarm-time="{{ $alarm->time }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <div class="form-check form-switch d-inline-block">
                                        <input type="checkbox" class="form-check-input alarm-toggle" 
                                            id="alarm-{{ $alarm->id }}" 
                                            data-alarm-id="{{ $alarm->id }}"
                                            {{ $alarm->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="alarm-{{ $alarm->id }}"></label>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">Nenhum alarme configurado.</p>
                        @endforelse
                    </div>
                </div>
            </div>



            <!-- Coluna de Dicas -->
            <div class="col-md-4">
                <div class="card card-tips">
                    <div class="card-header tips-header">Dicas do Dia</div>
                    <div class="card-body tips-body">
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

<!-- Modal Adicionar Bebê -->
<div class="modal fade" id="addBabyModal" tabindex="-1" aria-labelledby="addBabyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="max-width: 420px; margin: 0 auto; background-color: #ffffff;
                padding: 40px 40px 30px; border-radius: 20px;
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.08);">
            <div class="modal-header">
                <h5 class="modal-title" id="addBabyModalLabe    l" style="font-size: 20px; color: #6b1f1f; font-weight: bold; text-align: center; margin-bottom: 10px;">Registrar Novo Bebê</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('baby.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label" style="display: block; font-size: 15px; margin-bottom: 8px; color: #333;">Nome do Bebê</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="birth_date" class="form-label" style="display: block; font-size: 15px; margin-bottom: 8px; color: #333;">Data de Nascimento</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center border-0">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-register-baby">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Alarme -->
<div class="modal fade" id="editAlarmModal" tabindex="-1" aria-labelledby="editAlarmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content alarm-modal-content">
            <div class="modal-header alarm-modal-header">
                <h5 class="modal-title alarm-modal-title" id="editAlarmModalLabel">Editar Alarme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="editAlarmForm">
                <div class="modal-body alarm-modal-body">
                    <input type="hidden" id="editAlarmId" name="alarm_id">
                    <div class="mb-3">
                        <label for="editAlarmTime" class="form-label alarm-label">Novo Horário</label>
                        <input type="time" class="form-control alarm-input" id="editAlarmTime" name="time" required>
                    </div>
                </div>
                <div class="modal-footer alarm-modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-register-alarm">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>



@push('scripts')
<script src="{{ asset('js/feeding-manager.js') }}"></script>
<script src="{{ asset('js/tips-manager.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const babySelector = document.getElementById('baby-selector');
        if (babySelector) {
            babySelector.addEventListener('change', function() {
                const babyId = this.value;
                window.location.href = `{{ route('dashboard') }}?baby_id=${babyId}`;
            });
        }
    });
</script>
@endpush

@endsection