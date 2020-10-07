<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as Notification;

class ResetPassword extends Notification
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Adebsystem - Redefinição de Senha')
            ->greeting('Olá, tudo bem?')
            ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha de sua conta.')
            ->action('Redefinir Senha', url(config('app.url').'/password/reset/'.$this->token).'?email='.urlencode($notifiable->email))
                ->line('Se você não solicitou uma redefinição de senha, nenhuma ação adicional será necessária.');
    }
}
