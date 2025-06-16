<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingApprovedNotification extends Notification
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
                    ->subject('Booking Approved - Your Stay is Confirmed!')
                    ->greeting('Great news, ' . $notifiable->name . '!')
                    ->line('Your booking request has been approved!')
                    ->line('**Property:** ' . $this->booking->property->title)
                    ->line('**Address:** ' . $this->booking->property->address . ', ' . $this->booking->property->city)
                    ->line('**Check-in:** ' . $this->booking->check_in->format('M d, Y'))
                    ->line('**Guests:** ' . $this->booking->guests)
                    ->line('**Host:** ' . $this->booking->property->user->name)
                    ->line('**Host Phone:** ' . $this->booking->property->user->phone)
                    ->action('View Booking Details', route('tenant.bookings.show', $this->booking->id))
                    ->line('Please contact your host if you have any questions about check-in procedures.')
                    ->line('We hope you have a wonderful stay!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'property_title' => $this->booking->property->title,
            'host_name' => $this->booking->property->user->name,
            'check_in' => $this->booking->check_in->format('M d, Y'),
            'guests' => $this->booking->guests,
            'message' => 'Your booking for ' . $this->booking->property->title . ' has been approved!',
            'action_url' => route('tenant.bookings.show', $this->booking->id)
        ];
    }
}
