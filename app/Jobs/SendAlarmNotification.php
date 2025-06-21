<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Alarm;
use App\Notifications\FeedingAlarmNotification;
use Illuminate\Support\Facades\Log;

class SendAlarmNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $alarm;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, Alarm $alarm)
    {
        $this->user = $user;
        $this->alarm = $alarm;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Enviando notificação de alarme', [
                'user_id' => $this->user->id,
                'alarm_id' => $this->alarm->id,
                'alarm_time' => $this->alarm->time
            ]);

            // Enviar notificação push
            $this->user->notify(new FeedingAlarmNotification($this->alarm));

            Log::info('Notificação de alarme enviada com sucesso', [
                'user_id' => $this->user->id,
                'alarm_id' => $this->alarm->id
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao enviar notificação de alarme', [
                'user_id' => $this->user->id,
                'alarm_id' => $this->alarm->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
