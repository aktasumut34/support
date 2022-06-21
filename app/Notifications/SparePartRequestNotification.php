<?php

namespace App\Notifications;

use App\Models\SparePartRequests;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SparePartRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SparePartRequests $sparePartRequest)
    {
        $this->sparePartRequest = $sparePartRequest;
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->sparePartRequest->id,
            'title' => 'Request: #' . $this->sparePartRequest->request_no,
            'status' => $this->sparePartRequest->status,
            'link' => '/admin/spare-part-requests/' . $this->sparePartRequest->id,
            'clink' =>
            '/customer/spare-part-request/' . $this->sparePartRequest->id,
            'sprprt' => 1,
        ];
    }
}
