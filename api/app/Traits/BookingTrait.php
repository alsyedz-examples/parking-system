<?php

namespace App\Traits;

use App\Models\Booking;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @property Builder bookingsQuery
 */
Trait BookingTrait
{
    protected $dateFormat = DateTime::ISO8601;

    /**
     * @return array
     */
    public function getValidationRules()
    {
        return [
            'start_date' => "bail|required|date_format:$this->dateFormat|before_or_equal:end_date",
            'end_date' => "bail|required|date_format:$this->dateFormat|after_or_equal:start_date",
            'parking_spot_id' => 'bail|required|exists:App\Models\ParkingSpot,id'
        ];
    }

    /**
     * @param $start_date
     * @param $end_date
     * @return void
     * @throws BadRequestHttpException
     */
    public function throwIfSlotIsNotAvailable($start_date, $end_date)
    {
        $start_date = Carbon::createFromFormat($this->dateFormat, $start_date);

        $end_date = Carbon::createFromFormat($this->dateFormat, $end_date);

        $bookings = Booking::query()
            ->where(function (Builder $query) use ($start_date, $end_date) {
                $query->where('start_date', '>', $end_date->toDateTimeString());

                $query->where('end_date', '<', $start_date->toDateTimeString());
            })
            ->orWhere(function (Builder $query) use ($start_date, $end_date) {
                $query->where('start_date', '<', $end_date->toDateTimeString());

                $query->where('end_date', '>', $start_date->toDateTimeString());
            });

        if ($bookings->exists()) {
            throw new BadRequestHttpException('asdgsadgsagd');
        }
    }
}