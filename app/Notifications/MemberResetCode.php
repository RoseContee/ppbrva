<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberResetCode extends Notification
{
    use Queueable;

    protected string $code;
    protected int $expiration;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $code, $expiration)
    {
        $this->code = $code;
        $this->expiration = $expiration;
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
            ->subject('Reset Password Notification')
            ->view('mails.member-reset-code', [
                'code' => $this->code,
                'expiration' => $this->expiration,
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
