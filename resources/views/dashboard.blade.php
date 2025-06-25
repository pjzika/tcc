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
                <div class="card text-center">
                    <div class="card-header">Bem-vindo(a)!</div>
                    <div class="card-body">
                        <h5 class="card-title">Nenhum bebê registrado</h5>
                        <p class="card-text">Para começar a usar o dashboard, por favor, registre seu primeiro bebê.</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBabyModal">
                            Registrar Bebê
                        </button>
                    </div>
                </div>
            @else
                <div class="card mb-4">
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
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Alarmes</span>
                                <button id="test-alarm-btn" class="btn btn-warning btn-sm ms-2" type="button">
                                    <i class="fas fa-bell"></i> Testar Alarme
                                </button>
                                {{-- Futuro botão de adicionar alarme --}}
                            </div>
                            <div class="card-body">
                                @forelse($alarms as $alarm)
                                    <div class="alarm-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="alarm-time">{{ $alarm->formatted_time }}</span>
                                        <div>
                                            <button class="btn btn-sm btn-outline-secondary me-2 edit-alarm-btn" data-bs-toggle="modal" data-bs-target="#editAlarmModal" data-alarm-id="{{ $alarm->id }}" data-alarm-time="{{ $alarm->time }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <div class="custom-control custom-switch d-inline-block">
                                                <input type="checkbox" class="custom-control-input alarm-toggle" 
                                                    id="alarm-{{ $alarm->id }}" 
                                                    data-alarm-id="{{ $alarm->id }}"
                                                    {{ $alarm->is_active ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="alarm-{{ $alarm->id }}"></label>
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

<!-- Modal Adicionar Bebê -->
<div class="modal fade" id="addBabyModal" tabindex="-1" aria-labelledby="addBabyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBabyModalLabel">Registrar Novo Bebê</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('baby.store') }}">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                  <label for="name" class="form-label">Nome do Bebê</label>
                  <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                  <label for="birth_date" class="form-label">Data de Nascimento</label>
                  <input type="date" class="form-control" id="birth_date" name="birth_date" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Registrar</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar Alarme -->
<div class="modal fade" id="editAlarmModal" tabindex="-1" aria-labelledby="editAlarmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAlarmModalLabel">Editar Alarme</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editAlarmForm">
          <div class="modal-body">
              <input type="hidden" id="editAlarmId" name="alarm_id">
              <div class="mb-3">
                  <label for="editAlarmTime" class="form-label">Novo Horário</label>
                  <input type="time" class="form-control" id="editAlarmTime" name="time" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
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