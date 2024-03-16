<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\Rate;
use Illuminate\Support\Facades\Log;

class BookingObserver
{
    /**
     * Handle the Booking "creating" & "updating" event.
     *
     * @param Booking $booking
     * @return void
     */
    public function saving(Booking $booking)
    {
        $rates = Rate::query()->pluck('price', 'day');

        $price = 0;

        foreach (getMinutesPerDay($booking->start_date, $booking->end_date) as $day => $minutes) {
            $price = $minutes * $rates[$day];

            Log::debug("$day => $price");
        }

        $booking->price = $price;
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