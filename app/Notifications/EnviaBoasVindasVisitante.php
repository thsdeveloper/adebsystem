<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EnviaBoasVindasVisitante extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if(app()->environment('production') || $notifiable->telefone != null){
            return ['mail', 'nexmo'];
        }
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
        return (new MailMessage)
            ->subject('Bem vindo ao AdebSystem')
            ->greeting('Olá '. $notifiable->nome.'!')
            ->line('Sou o Pastor Wilson Donizete, pastor da ADEB Riacho Fundo e queremos agradecer pela sua visita!')
            ->line('Ficamos tão felizes por ter cultuado conosco uma vez, que queremos que volte mais vezes.')
            ->line('Que nesses dias você seja grandemente abençoado. Que o Senhor Jesus te fortaleça e te capacite a avançar na obra que Ele tem a realizar em sua vida.')
            ->line('Nosso cultos são:')
            ->line('Terça-feira: Culto de Oração e Ensino às 19:30h')
            ->line('Quinta-feira: Culto da Vitória às 20h.')
            ->line('Domingo:')
            ->line('Escola Dominical às 9h')
            ->line('Culto de Celebração às 18h')
            ->line('Em nossa igreja você nunca estará sozinho, temos departamentos específicos para estimular o crescimento na fé específico para cada faixa etária.')
            ->action('Acesse nosso canal no Youtube', url('https://www.youtube.com/channel/UCCkSBfP-6i52hQ_GR-0Zz2Q'));
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

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Oi '.$notifiable->nome.', obrigado pela sua visita! A ADEB Riacho Fundo preparou uma surpresa para vc. ACESSE: https://www.youtube.com/channel/UCCkSBfP-6i52hQ_GR-0Zz2Q');

    }
}
