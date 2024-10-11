<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Flight;

class FlightReminderNotification extends Notification
{
    use Queueable;

    public $flight;

    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Flight Reminder: ' . $this->flight->flight_number)
            ->line('Dear ' . $notifiable->name . ',')
            ->line('This is a reminder for your upcoming flight: ' . $this->flight->flight_number)
            ->line('Departure: ' . $this->flight->departure_time)
            ->line('We look forward to having you on board.')
            ->line('Thank you for flying with us!');
    }
}
