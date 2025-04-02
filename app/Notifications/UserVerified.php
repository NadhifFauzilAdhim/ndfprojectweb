<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserVerified extends Notification
{
    use Queueable;


    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                        ->subject('🌟 Akun Anda Telah Diverifikasi!')
                        ->greeting('🎉 Hai, ' . $notifiable->name . '!')
                        ->line('**Akun Anda telah berhasil diverifikasi** oleh administrator. Anda sekarang bisa menikmati akses penuh ke semua fitur aplikasi kami!')
                        ->action('Mulai Jelajahi', url('/dashboard'))
                        ->line('
                            Jika Anda menemui kendala atau memiliki pertanyaan,
                            jangan ragu untuk menghubungi tim support kami.
                     ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
