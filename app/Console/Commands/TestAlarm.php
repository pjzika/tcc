<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Alarm;
use App\Models\User;
use App\Jobs\SendAlarmNotification;

class TestAlarm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alarm:test {--user-id=1} {--alarm-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa o sistema de alarmes enviando uma notificação';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user-id');
        $alarmId = $this->option('alarm-id');

        // Buscar usuário
        $user = User::find($userId);
        if (!$user) {
            $this->error("Usuário com ID {$userId} não encontrado.");
            return 1;
        }

        // Buscar alarme
        if ($alarmId) {
            $alarm = Alarm::where('id', $alarmId)
                ->whereHas('baby', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->first();
        } else {
            $alarm = $user->babies->first()->alarms->first();
        }

        if (!$alarm) {
            $this->error("Alarme não encontrado para o usuário.");
            return 1;
        }

        $this->info("Enviando notificação de teste...");
        $this->info("Usuário: {$user->name}");
        $this->info("Alarme: {$alarm->time}");
        $this->info("Bebê: {$alarm->baby->name}");

        // Enviar notificação
        SendAlarmNotification::dispatch($user, $alarm);

        $this->info("Notificação enviada com sucesso!");
        $this->info("Verifique o dashboard para ver a notificação.");

        return 0;
    }
}
