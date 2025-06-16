<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingRequestNotification extends Notification
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
                    ->subject('New Booking Request for Your Property')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('You have received a new booking request for your property.')
                    ->line('**Property:** ' . $this->booking->property->title)
                    ->line('**Guest:** ' . $this->booking->user->name)
                    ->line('**Check-in:** ' . $this->booking->check_in->format('M d, Y'))
                    ->line('**Guests:** ' . $this->booking->guests)
                    ->line('**Message:** ' . ($this->booking->message ?: 'No special message'))
                    ->action('View Booking Request', route('landlord.bookings.show', $this->booking->id))
                    ->line('Please review and respond to this booking request as soon as possible.')
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
            'guest_name' => $this->booking->user->name,
            'check_in' => $this->booking->check_in->format('M d, Y'),
            'guests' => $this->booking->guests,
            'message' => 'New booking request for ' . $this->booking->property->title,
            'action_url' => route('landlord.bookings.show', $this->booking->id)
        ];
    }
}
