<?php

namespace App\Notifications;

use App\Models\Message;
use App\Models\Topic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $message, $topic;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message, Topic $topic)
    {
        $this->message = $message;
        $this->topic = $topic;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->greeting('greeting')
                    ->line('body')
                    ->action('Notification Action', url('/user/login'))
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
            'message_id'=>$this->message->id,
            'author'=>$this->message->author,
            'time'=>$this->message->created_at,
            'topic_title'=>$this->topic->title
        ];
    }
}
