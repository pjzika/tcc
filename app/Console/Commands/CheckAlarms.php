<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Alarm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;
use App\Jobs\SendAlarmNotification;

class CheckAlarms extends Command
{
    protected $signature = 'alarms:check';
    protected $description = 'Verifica os alarmes e envia notificações para os que devem disparar agora';

    public function handle()
    {
        $now = Carbon::now();
        $currentTime = $now->format('H:i');
        $currentDay = strtolower($now->format('l')); // dia da semana atual
        
        // Buscar alarmes ativos que devem disparar agora
        $alarms = Alarm::where('is_active', true)
            ->where('time', $currentTime)
            ->where(function($query) use ($currentDay) {
                $query->where('day_of_week', 'all')
                    ->orWhere('day_of_week', $currentDay);
            })
            ->with('baby.user')
            ->get();
        
        $this->info("Verificando alarmes para {$currentTime} - {$currentDay}");
        $this->info("Encontrados " . $alarms->count() . " alarmes ativos");
        
        foreach ($alarms as $alarm) {
            $user = $alarm->baby->user;
            
            // Verificar se o usuário tem subscription para push notification
            if ($user->push_subscription) {
                $this->info("Enviando notificação para usuário {$user->name} - Alarme {$alarm->time}");
                
                // Enviar notificação via job para não bloquear o comando
                SendAlarmNotification::dispatch($user, $alarm);
            } else {
                $this->warn("Usuário {$user->name} não tem subscription para push notification");
            }
        }
        
        $this->info('Verificação de alarmes concluída.');
    }
} 