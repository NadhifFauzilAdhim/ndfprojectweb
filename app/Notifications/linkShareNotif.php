<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class linkShareNotif extends Notification
{
    use Queueable;
    protected $LinkTitle;
    protected $linkUrl;
    protected $sharedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $LinkTitle, string $linkUrl, string $sharedBy)   
    {
        $this->LinkTitle = $LinkTitle;
        $this->linkUrl = $linkUrl;
        $this->sharedBy = $sharedBy;
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
            ->subject('🌟 New Link Shared with You!')
            ->view('emails.link-shared', [
                'notifiable' => $notifiable,
                'linkTitle' => $this->LinkTitle,
                'linkUrl' => $this->linkUrl,
                'dashboardUrl' => config('app.url') . '/dashboard',
                'sharedBy' => $this->sharedBy,
                'sharedAt' => now()->format('F j, Y \a\t g:i a'),
                'appUrl' => config('app.url'),
                'appName' => config('app.name')
            ]);
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
