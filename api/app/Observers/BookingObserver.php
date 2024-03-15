<?php

namespace App\Observers;

use App\Models\Booking;

class BookingObserver
{
    /**
     * Handle the Booking "creating", "updating" event.
     *
     * @param Booking $booking
     * @return void
     */
    public function saving(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "created" event.
     *
     * @param Booking $booking
     * @return void
     */
    public function created(Booking $booking)
    {
        /** TODO: send a notification */
    }

    /**
     * Handle the Booking "updating" event.
     *
     * @param Booking $booking
     * @return void
     */
    public function updated(Booking $booking)
    {
        /** TODO: send a notification */
    }

    /**
     * Handle the Booking "deleted" event.
     *
     * @param Booking $booking
     * @return void
     */
    public function deleted(Booking $booking)
    {
        /** TODO: send a notification */
    }
}