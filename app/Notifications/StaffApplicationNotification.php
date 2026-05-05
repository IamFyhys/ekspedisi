<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StaffApplicationNotification extends Notification
{
    use Queueable;

    public $applicant;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $applicant)
    {
        $this->applicant = $applicant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Lamaran Staff Baru — ' . $this->applicant->name . ' (' . str_replace('_', ' ', $this->applicant->role) . ')')
                    ->line('Ada pendaftar baru untuk cabang ' . ($this->applicant->branch->name ?? 'Hub') . '.')
                    ->line('Nama: ' . $this->applicant->name)
                    ->line('Posisi: ' . str_replace('_', ' ', $this->applicant->role))
                    ->line('Email: ' . $this->applicant->email)
                    ->action('Review Lamaran', route('manager.staff.lamaran'))
                    ->line('Mohon segera tinjau data pelamar tersebut.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'applicant_id' => $this->applicant->id,
            'applicant_name' => $this->applicant->name,
            'position' => $this->applicant->role,
            'message' => 'Lamaran staff baru dari ' . $this->applicant->name,
        ];
    }
}
