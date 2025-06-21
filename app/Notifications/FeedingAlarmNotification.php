<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Alarm;

class FeedingAlarmNotification extends Notification
{
    use Queueable;

    protected $alarm;

    /**
     * Create a new notification instance.
     */
    public function __construct(Alarm $alarm)
    {
        $this->alarm = $alarm;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Hora de alimentar o bebê!')
                    ->line("Alarme configurado para: {$this->alarm->time}")
                    ->action('Ver Dashboard', url('/dashboard'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Hora de alimentar o bebê!',
            'body' => "Alarme configurado para: {$this->alarm->time}",
            'alarm_id' => $this->alarm->id,
            'alarm_time' => $this->alarm->time,
            'baby_name' => $this->alarm->baby->name,
            'type' => 'feeding_alarm',
            'sound' => 'alarm.mp3', // Som de alarme
            'icon' => '/images/baby-icon.png', // Ícone do bebê
            'click_action' => '/dashboard', // URL para abrir quando clicar na notificação
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toBroadcast(object $notifiable): array
    {
        return [
            'title' => 'Hora de alimentar o bebê!',
            'body' => "Alarme configurado para: {$this->alarm->time}",
            'alarm_id' => $this->alarm->id,
            'alarm_time' => $this->alarm->time,
            'baby_name' => $this->alarm->baby->name,
            'type' => 'feeding_alarm',
            'sound' => 'alarm.mp3',
            'icon' => '/images/baby-icon.png',
            'click_action' => '/dashboard',
            'timestamp' => now()->toISOString(),
        ];
    }
}
