<?php

namespace App\Listeners;

use App\Events\PatientRegistered;
use App\Notifications\NewPatientNotification;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewPatientNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PatientRegistered  $event
     * @return void
     */
    public function handle(PatientRegistered $event)
    {

        Notification::route('mail', $event->patient->email)
                        //->route('sms', $event->patient->mobile)
                        ->notify(new NewPatientNotification($event->patient));
    }
}
