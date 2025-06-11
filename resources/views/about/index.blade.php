@extends('layouts.app')

@section('content')

    <div style="text-align: center; padding: 60px 20px; background-color: #fff;">
        <h1 style="color: #4a1c1c; font-weight: 700; font-size: 3rem;">Sobre Nós</h1>
        <p style="font-size: 18px; max-width: 900px; margin: 0 auto; color: #333;">
            Somos uma equipe dedicada a fornecer soluções inovadoras para nossos clientes.<br>
            Nossa missão é tornar a tecnologia acessível e útil para todos.
        </p>
    </div>

    <div class="bg-pink" style="padding: 60px 0;">
        <h2 style="text-align: center; font-size: 36px; color: #4a0f0f; margin-bottom: 40px;">Nossos valores</h2>
        <div class="valores-container" style="display: flex; flex-wrap: wrap; justify-content: center; max-width: 1000px; margin: 0 auto; gap: 30px;">
            <div class="valor-box" style="width: 420px; height: 100px; background-color: #f8eaea; border-radius: 16px; display: flex; align-items: center; padding: 0 25px;">
                <img src="{{ asset('icons/idea.png') }}" alt="Inovação" style="width: 24px; height: 24px; margin-right: 15px;">
                <span style="font-size: 16px; color: #000;">Inovação constante</span>
            </div>
            <div class="valor-box" style="width: 420px; height: 100px; background-color: #f8eaea; border-radius: 16px; display: flex; align-items: center; padding: 0 25px;">
                <img src="{{ asset('icons/user.png') }}" alt="Foco no cliente" style="width: 24px; height: 24px; margin-right: 15px;">
                <span style="font-size: 16px; color: #000;">Foco no cliente</span>
            </div>
            <div class="valor-box" style="width: 420px; height: 100px; background-color: #f8eaea; border-radius: 16px; display: flex; align-items: center; padding: 0 25px;">
                <img src="{{ asset('icons/info.png') }}" alt="Informações verídicas" style="width: 24px; height: 24px; margin-right: 15px;">
                <span style="font-size: 16px; color: #000;">Informações verídicas</span>
            </div>
            <div class="valor-box" style="width: 420px; height: 100px; background-color: #f8eaea; border-radius: 16px; display: flex; align-items: center; padding: 0 25px;">
                <img src="{{ asset('icons/check.png') }}" alt="Compromisso com a Qualidade" style="width: 24px; height: 24px; margin-right: 15px;">
                <span style="font-size: 16px; color: #000;">Compromisso com a Qualidade</span>
            </div>
        </div>
    </div>

    <style>
        .bg-pink {
            background-color: #E8C7C8;
            min-height: 270px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Para a área dos valores — opcional hover ou sombra, se quiser pode adicionar */
        .valor-box {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .valor-box:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>

@endsection
