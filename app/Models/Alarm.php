<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
    use HasFactory;

    protected $fillable = [
        'baby_id',
        'time',
        'day_of_week',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Definindo os dias da semana disponíveis
    public static $daysOfWeek = [
        'all' => 'Todos os dias',
        'mon' => 'Segunda-feira',
        'tue' => 'Terça-feira',
        'wed' => 'Quarta-feira',
        'thu' => 'Quinta-feira',
        'fri' => 'Sexta-feira',
        'sat' => 'Sábado',
        'sun' => 'Domingo'
    ];

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }

    // Método para formatar o horário para exibição
    public function getFormattedTimeAttribute()
    {
        if (!$this->time) {
            return '00:00';
        }
        return \Carbon\Carbon::parse($this->time)->format('H:i');
    }

    // Método para obter o nome do dia da semana
    public function getDayNameAttribute()
    {
        return self::$daysOfWeek[$this->day_of_week] ?? $this->day_of_week;
    }
} 