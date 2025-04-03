<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostDeleted extends Notification
{
    use Queueable;
    protected $deleteReason;
    protected $postTitle;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $deleteReason, string $postTitle)
    {
        $this->deleteReason = $deleteReason;
        $this->postTitle = $postTitle;
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
                    ->subject('Post Deleted Notification ❌')
                    ->greeting('Hello, ' . $notifiable->name . '!')
                    ->line('Your post has been deleted.')
                    ->line('im sorry to inform you that your post has been permanently deleted due to violation of our policies.')
                    ->line('title: ' . $this->postTitle)
                    ->line('reason: ' . $this->deleteReason)
                    ->line('If you believe this is a mistake, please contact support.');
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
