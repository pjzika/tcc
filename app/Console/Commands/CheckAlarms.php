<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Alarm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;

class CheckAlarms extends Command
{
    protected $signature = 'alarms:check';
    protected $description = 'Verifica os alarmes e envia notificações para os que estão próximos de disparar';

    public function handle()
    {
        $now = Carbon::now();
        $currentTime = $now->format('H:i');
        $currentDay = strtolower($now->format('l')); // dia da semana atual
        
        // Buscar alarmes ativos que estão próximos de disparar (dentro dos próximos 5 minutos)
        $alarms = Alarm::where('is_active', true)
            ->where(function($query) use ($currentTime, $currentDay) {
                $query->where('day_of_week', 'all')
                    ->orWhere('day_of_week', $currentDay);
            })
            ->get();
        
        $notificationController = new NotificationController();
        
        foreach ($alarms as $alarm) {
            $alarmTime = Carbon::createFromFormat('H:i', $alarm->time);
            $timeDiff = $now->diffInMinutes($alarmTime, false);
            
            // Se o alarme está próximo de disparar (dentro dos próximos 5 minutos)
            if ($timeDiff >= 0 && $timeDiff <= 5) {
                $user = $alarm->baby->user;
                $subscription = json_decode($user->push_subscription, true);
                
                if ($subscription) {
                    $notificationController->sendNotification(new Request([
                        'message' => "Hora da amamentação em {$timeDiff} minutos! ({$alarm->time})"
                    ]));
                }
            }
        }
        
        $this->info('Verificação de alarmes concluída.');
    }
} 