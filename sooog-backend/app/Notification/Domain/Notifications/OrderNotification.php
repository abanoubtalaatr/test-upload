<?php

namespace App\Notification\Domain\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Order\Domain\Models\Order;
use App\Notification\Domain\Models\Notification as Notif;

class OrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order, $content=[])
    {
        $this->order = $order;
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //mail, database
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
        $order_type = $this->order->type == 'stores' ? 'order' : 'service_order';
        return array_merge($this->content, [
            'model_id' => $this->order->id,
            'type' => $order_type,
            'total' => $this->order->total,
            'status' => optional($this->order->status)->key,
        ]);
    }

    public function toDatabase($notifiable)
    {
        $order_type = $this->order->type == 'stores' ? 'order' : 'service_order';
        return array_merge(
            $this->content,
                [
                'model_id' => $this->order->id,
                'type' => $order_type,
                'total' => $this->order->total,
                'status' => optional($this->order->status)->key
            ]
        );
    }
}
