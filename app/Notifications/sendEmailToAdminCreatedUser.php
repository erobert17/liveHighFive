<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use DB;

class sendEmailToAdminCreatedUser extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;
    protected $userEmail;
    protected $userPass;
    /**
     * Create a new notification instance.
     *
     * SendActivationEmail constructor.
     * @param $token
     */
    public function __construct($token, $userEmail, $userPass)
    {
        $this->token = $token;
        $this->userEmail = $userEmail;
        $this->userPass = $userPass;

        $this->onQueue('social');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /*
        $userEmail = 'userEamil@gmamil.com';
        $userPass = 'userPass';
        $message = new MailMessage;
        $message->subject(trans('emails.adminCreatedUserSubject'))
            ->line(trans('emails.adminCreatedUserMessage'))
            ->line('Login Email: '. $userEmail)
            ->line('Password: '. $userPass)
            ->action(trans('emails.adminCreatedUserButton'), route('home', ['token' => $this->token]))

        return ($message);
        */
        #$userEmail = $user->email;
        #$userPass = $user->password;
        $message = new MailMessage;
        $message->subject(trans('emails.adminCreatedUserSubject'))
            ->line(trans(' '))
            ->line(trans('emails.adminCreatedUserMessage'))
            ->line(trans('Email: '. $this->userEmail))
            ->line(trans('Password: '. $this->userPass))
            ->line(trans('emails.adminCreatedUserSecurity'))
            ->line(trans('Login at www.growyourleads.com/login'))
            ->line(trans('emails.activationThanks'));

        return ($message);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
