<?php

namespace Acacha\Forge\Notifications;

use Acacha\Forge\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

/**
 * Class ServerPermissionRequested
 *
 * @package Acacha\Forge\Notifications
 */
class ServerPermissionRequested extends Notification
{
    use Queueable;

    /**
     * Server.
     *
     * @var Server
     */
    public $server;

    /**
     * ServerPermissionRequested constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param $notifiable
     * @return mixed
     */
    public function toTelegram($notifiable)
    {
        $user = $this->server->user->name;
        $user_id = $this->server->user->id;
        $user_email = $this->server->user->email;
        $server = $this->server->name;
        $server_id = $this->server->id;
        $server_forge_id = $this->server->forge_id;

        $domain = config('forge.url');

        $url = $domain . '/users/' . $user_id . '/servers/' . $server_id . '/validate?token=' . $this->server->token;

        return TelegramMessage::create()
            ->to(env('TELEGRAM_ACACHA_FORGE_MANAGERS_CHAT_ID'))
            ->content("New  server permission has been requested\n User: $user \n  id: $user_id \n  email: $user_email  \n Server: $server \n  id: $server_forge_id")
            ->button('Accept', $url);
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
