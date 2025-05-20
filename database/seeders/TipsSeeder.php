<?php

namespace Database\Seeders;

use App\Models\Tip;
use Illuminate\Database\Seeder;

class TipsSeeder extends Seeder
{
    public function run()
    {
        $tips = [
            // Dicas para 0-6 meses
            [
                'title' => 'Postura Correta',
                'content' => 'Mantenha o bebê com a cabeça alinhada ao corpo e o queixo tocando o seio. Isso ajuda na pega correta e evita dores.',
                'age_range' => '0-6',
                'category' => 'Amamentação'
            ],
            [
                'title' => 'Hidratação',
                'content' => 'Beba bastante água durante a amamentação para manter a produção de leite. Recomenda-se 3-4 litros por dia.',
                'age_range' => '0-6',
                'category' => 'Saúde'
            ],
            [
                'title' => 'Rotina de Sono',
                'content' => 'Estabeleça uma rotina de sono desde cedo. Banho, massagem e música suave ajudam o bebê a relaxar.',
                'age_range' => '0-6',
                'category' => 'Sono'
            ],
            [
                'title' => 'Cólicas',
                'content' => 'Massagens suaves na barriga e movimentos de bicicleta com as perninhas ajudam a aliviar as cólicas.',
                'age_range' => '0-6',
                'category' => 'Saúde'
            ],

            // Dicas para 7-12 meses
            [
                'title' => 'Introdução Alimentar',
                'content' => 'Comece com alimentos pastosos e aumente gradualmente a consistência. Ofereça um alimento novo por vez.',
                'age_range' => '7-12',
                'category' => 'Alimentação'
            ],
            [
                'title' => 'Desenvolvimento Motor',
                'content' => 'Incentive o bebê a engatinhar e se movimentar. Coloque brinquedos a uma distância que ele precise se esforçar para alcançar.',
                'age_range' => '7-12',
                'category' => 'Desenvolvimento'
            ],

            // Dicas para 13-24 meses
            [
                'title' => 'Comunicação',
                'content' => 'Converse muito com seu filho e nomeie objetos e ações. Isso estimula o desenvolvimento da linguagem.',
                'age_range' => '13-24',
                'category' => 'Desenvolvimento'
            ],
            [
                'title' => 'Alimentação Saudável',
                'content' => 'Ofereça uma variedade de alimentos saudáveis e mantenha horários regulares para as refeições.',
                'age_range' => '13-24',
                'category' => 'Alimentação'
            ],

            // Dicas para 25+ meses
            [
                'title' => 'Independência',
                'content' => 'Incentive a independência permitindo que a criança faça pequenas tarefas sozinha, como guardar brinquedos.',
                'age_range' => '25+',
                'category' => 'Desenvolvimento'
            ],
            [
                'title' => 'Limites',
                'content' => 'Estabeleça limites claros e consistentes. Explique as regras de forma simples e positiva.',
                'age_range' => '25+',
                'category' => 'Comportamento'
            ]
        ];

        foreach ($tips as $tip) {
            Tip::create($tip);
        }
    }
} 