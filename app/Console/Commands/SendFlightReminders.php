<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flight;
use App\Models\Passenger;
use App\Notifications\FlightReminderNotification;
use Carbon\Carbon;

class SendFlightReminders extends Command
{
    protected $signature = 'flights:send-reminders';
    protected $description = 'Send reminders to passengers 24 hours before flight departure';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $flights = Flight::whereBetween('departure_time', [
            Carbon::now(), Carbon::now()->addDay()
        ])->get();

        foreach ($flights as $flight) {
            foreach ($flight->passengers as $passenger) {
                $passenger->notify(new FlightReminderNotification($flight));
            }
        }

        $this->info('Reminders sent to passengers for flights departing in 24 hours.');
    }
}
