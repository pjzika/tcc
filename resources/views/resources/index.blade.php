@extends('layouts.app')

@section('content')
    <div class="text-center py-5 bg-white">
        <h1 style="color: #4a1c1c; font-weight: 700; font-size: 3rem;">Recursos</h1>
        <p class="mt-3" style="font-size: 1.1rem;">
           Esta seção disponibiliza recursos e instruções que facilitam o uso do sistema </br>
           e apoiam sua experiência de navegação.
        </p>
    </div>

    <div class="bg-pink d-flex justify-content-center align-items-center">
        <div class="d-flex flex-column flex-md-row gap-4 justify-content-center align-items-center">
            <a href="#" class="d-block text-center text-decoration-none p-4 resource-btm"
               style="background-color: #f7eded; border-radius: 16px; width: 300px; font-size: 20px; font-weight: 500; color: black;">
                Documentação
            </a>
            <a href="#" class="d-block text-center text-decoration-none p-4 resource-btm"
               style="background-color: #f7eded; border-radius: 16px; width: 300px; font-size: 20px; font-weight: 500; color: black;">
                Suporte
            </a>
        </div>
    </div>

    <style>
        .bg-pink {
            background-color: #E8C7C8;
            min-height: 270px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .resource-btm {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .resource-btm:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
