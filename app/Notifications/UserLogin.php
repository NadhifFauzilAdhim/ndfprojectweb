<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserLogin extends Notification
{
    use Queueable;

    protected $ipAddress;
    protected $loginTime;
    protected $browser;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $ipAddress, string $loginTime, string $browser)
    {
        $this->ipAddress = $ipAddress;
        $this->loginTime = $loginTime;
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
                    ->subject('New Login Detected ⚠️')
                    ->greeting('Hello, ' . $notifiable->name . '!')
                    ->line('We detected a new login to your account.')
                    ->line('**IP Address:** ' . $this->ipAddress)
                    ->line('**Login Time:** ' . $this->loginTime)
                    ->line('**Browser:** ' . $this->browser)
                    ->line('If this was not you, please change your password immediately.');
    }   

    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->subject('⚠️ Login Baru Terdeteksi - ' . config('app.name'))
    //         ->greeting('Halo ' . $notifiable->name . '!')
    //         ->markdown('emails.user_login', [ // Gunakan template custom
    //             'ipAddress' => $this->ipAddress,
    //             'loginTime' => $this->loginTime,
    //             'user' => $notifiable
    //         ])
    //         ->action('Ubah Password', route('password.request'))
    //         ->salutation("Salam,\nTim " . config('app.name'));
    // }

    

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ip_address' => $this->ipAddress,
            'login_time' => $this->loginTime,
        ];
    }
}
