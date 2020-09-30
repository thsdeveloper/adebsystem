<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NovoMembroNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'nexmo'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Bem vindo ao AdebSystem')
            ->greeting('Olá '.$notifiable->name.'. Paz do Senhor!')
            ->line('Seja muito bem vindo ao AdebSystem, o sistema de gerenciamento de membros da ADEB Setor 11 - Riacho Fundo.')
            ->line('Segue abaixo os seus dados de acesso ao sistema.')
            ->line('Login: '.$notifiable->details->cpf)
            ->line('Senha: '.$notifiable->details->cpf)
            ->action('Acessar o sistema', url('/'))
            ->line('Obrigado por se cadastrar, em breve teremos novidades!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }


    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Seja bem vindo ao AdebSystem, os dados de acesso foram enviados para o seu email cadastrado');

    }
}
