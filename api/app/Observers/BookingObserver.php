<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\Rate;
use Carbon\Carbon;

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
        $start_date = Carbon::create($booking->start_date);

        $end_date = Carbon::create($booking->end_date);

        $total_minutes = $end_date->diffInMinutes($start_date);

        $rate = Rate::query()->where('day', '=', $start_date->dayName)->first();

        $booking->price = $total_minutes * $rate->price;
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