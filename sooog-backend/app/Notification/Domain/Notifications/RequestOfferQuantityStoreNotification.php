<?php

namespace App\Notification\Domain\Notifications;

use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function url;

class RequestOfferQuantityStoreNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RequestOfferQuantity $requestOfferQuantity, $content)
    {
        $this->requestOfferQuantity = $requestOfferQuantity;
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

    public function toArray($notifiable)
    {
        return array_merge($this->content, [
            'model_id' => $this->requestOfferQuantity->id,
            'type' => 'request_offer_quantity'
        ]);
    }

    public function toDatabase($notifiable)
    {
        return array_merge(
            $this->content,
            [
                'model_id' => $this->requestOfferQuantity->id,
                'type' => 'request_offer_quantity'
            ]
        );
    }
}
