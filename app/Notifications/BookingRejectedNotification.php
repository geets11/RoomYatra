<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingRejectedNotification extends Notification
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Booking Request Update')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('We regret to inform you that your booking request has been declined.')
                    ->line('**Property:** ' . $this->booking->property->title)
                    ->line('**Check-in:** ' . $this->booking->check_in->format('M d, Y'))
                    ->line('**Reason:** ' . ($this->booking->landlord_message ?: 'No specific reason provided'))
                    ->action('Browse Other Properties', route('website.properties.index'))
                    ->line('Don\'t worry! There are many other great properties available.')
                    ->line('Thank you for using RoomYatra!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'property_title' => $this->booking->property->title,
            'check_in' => $this->booking->check_in->format('M d, Y'),
            'reason' => $this->booking->landlord_message,
            'message' => 'Your booking request for ' . $this->booking->property->title . ' has been declined.',
            'action_url' => route('website.properties.index')
        ];
    }
}
