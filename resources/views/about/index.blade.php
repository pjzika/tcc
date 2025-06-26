@extends('layouts.app')

@section('content')

<div class="sobre-container">
    <h1 class="sobre-titulo">Sobre Nós</h1>
    <p class="sobre-texto">
        Somos uma equipe dedicada a fornecer soluções inovadoras para nossos clientes.<br>
        Nossa missão é tornar a tecnologia acessível e útil para todos.
    </p>
</div>

<div class="valores-section">
    <h2 class="valores-titulo">Nossos valores</h2>
    <div class="valores-container">
        <div class="valor-box">
            <img src="{{ asset('icons/idea.png') }}" alt="Inovação">
            <span>Inovação constante</span>
        </div>
        <div class="valor-box">
            <img src="{{ asset('icons/user.png') }}" alt="Foco no cliente">
            <span>Foco no cliente</span>
        </div>
        <div class="valor-box">
            <img src="{{ asset('icons/info.png') }}" alt="Informações verídicas">
            <span>Informações verídicas</span>
        </div>
        <div class="valor-box">
            <img src="{{ asset('icons/check.png') }}" alt="Compromisso com a Qualidade">
            <span>Compromisso com a Qualidade</span>
        </div>
    </div>
</div>

<style>
    .sobre-container {
        text-align: center;
        padding: 60px 20px;
        background-color: #fff;
    }

    .sobre-titulo {
        color: #4a1c1c;
        font-weight: 700;
        font-size: clamp(2rem, 5vw, 3rem);
        margin-bottom: 20px;
    }

    .sobre-texto {
        font-size: clamp(1rem, 2.5vw, 1.125rem);
        max-width: 900px;
        margin: 0 auto;
        color: #333;
        line-height: 1.6;
    }

    .valores-section {
        background-color: #E8C7C8;
        padding: 60px 20px;
        text-align: center;
    }

    .valores-titulo {
        font-size: clamp(1.8rem, 5vw, 2.25rem);
        color: #4a0f0f;
        margin-bottom: 40px;
        font-weight: bold;
    }

    .valores-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .valor-box {
        width: calc(50% - 20px); 
        background-color: #f8eaea;
        border-radius: 16px;
        display: flex;
        align-items: center;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    @media (max-width: 768px) {
    .valor-box {
        width: 100%; /* 1 por linha em telas pequenas */
        flex-direction: column;
        text-align: center;
        height: auto;
    }

    .valor-box img {
        margin: 0 0 10px 0;
    }
    }

    .valor-box:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .valor-box img {
        width: 24px;
        height: 24px;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .valor-box span {
        font-size: 1rem;
        color: #000;
        font-weight: 500;
        text-align: left;
    }

    @media (max-width: 480px) {
        .valor-box {
            flex-direction: column;
            text-align: center;
            height: auto;
        }

        .valor-box img {
            margin: 0 0 10px 0;
        }

        .valor-box span {
            font-size: 0.95rem;
        }
    }
</style>

@endsection
