@extends('layouts.app')

@section('content')
       

<div style="background-color: #E8C7C8; width: 100%;" class="py-5 px-3 px-md-5">
    <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-between gap-5 gap-lg-5">

        <div class="col-lg-6" style="padding-right: 40px;">
            <h1 class="fw-bold mb-4 display-5 display-md-4" style="color: var(--text-color);">
                Bem-vinda ao <span style="color: #9A434A">MaternArte!</span>
            </h1>
            <p class="mb-4" style="font-size: 24px;">
                Um espaço acolhedor e informativo para mães de primeira viagem.
                Aqui você encontrará apoio, dicas e uma comunidade que entende sua jornada.
            </p>
            <a href="{{ route('register') }}" class="btn-auth btn-register w-100 w-md-auto" style="padding: 14px 32px; font-size: 20px;">Começar Agora</a>
        </div>

            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/mae-bebe.png') }}" 
                alt="Mãe e bebê" 
                class="img-fluid"   
                style="box-shadow: none; max-height: 420px; width: auto;">
            </div>
    </div>

</div>
    <div style="background-color: #FFFFFF;" class="py-5 py-md-5 px-3">
        <div class="container text-center">
            <h2 class="fw-bold mb-5 display-6 display-md-4" style="color: var(--text-color);">Apoiando sua jornada de <span style="color: var(--primary-color);">amamentação</span></h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="info-box h-100">
                        <i class="fas fa-lightbulb"></i>
                        <h5>Dicas</h5>  
                        <p>Obtenha dicas diárias de profissionais para cuidados com seu bebê.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="info-box h-100">
                        <i class="fas fa-clock"></i>
                        <h5>Rotina</h5>
                        <p>Crie e siga uma rotina que irá auxiliar diariamente na amamentação do seu bebê.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="info-box h-100">
                        <i class="fas fa-smile"></i>
                        <h5>Acompanhamento</h5>
                        <p>Informações essenciais sobre gravidez e cuidados com o seu bebê.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
    .info-box {
        border: 2px solid var(--primary-color);
        border-radius: 16px;
        padding: 32px;
        background-color: #ffffff;
        color: var(--text-color);
        transition: transform 0.3s ease;
    }

    .info-box:hover {
        transform: translateY(-4px);
    }

    .info-box i {
        font-size: 32px;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .info-box h5 {
        font-weight: 600;
        font-size: 32px;
        margin-bottom: 10px;
    }

    .info-box p {
        font-size: 20px;
    }

</style>
@endsection
