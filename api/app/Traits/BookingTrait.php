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
    public function getCreateValidationRules()
    {
        $rules = $this->getUpdateValidationRules();

        $rules['parking_spot_id'] = 'bail|required|exists:App\Models\ParkingSpot,id';

        return $rules;
    }

    /**
     * @return array
     */
    public function getUpdateValidationRules()
    {
        $now = Carbon::now()->format($this->dateFormat);

        return [
            'start_date' => "bail|required|date_format:$this->dateFormat|before_or_equal:end_date|after_or_equal:$now",
            'end_date' => "bail|required|date_format:$this->dateFormat|after_or_equal:start_date"
        ];
    }

    /**
     * @param $start_date
     * @param $end_date
     * @param $ignore_id
     * @return void
     * @throws BadRequestHttpException
     */
    public function throwIfSlotIsNotAvailable($start_date, $end_date, $ignore_id = null)
    {
        $start_date = Carbon::createFromFormat($this->dateFormat, $start_date);

        $end_date = Carbon::createFromFormat($this->dateFormat, $end_date);

        $bookings = Booking::query();

        $bookings->where('start_date', '>=', Carbon::now()->toDateTimeString());

        $bookings->where(function (Builder $query) use ($start_date, $end_date) {
            $query->where(function (Builder $query) use ($start_date, $end_date) {
                $query->where('start_date', '>', $end_date->toDateTimeString());

                $query->where('end_date', '<', $start_date->toDateTimeString());
            });

            $query->orWhere(function (Builder $query) use ($start_date, $end_date) {
                $query->where('start_date', '<', $end_date->toDateTimeString());

                $query->where('end_date', '>', $start_date->toDateTimeString());
            });
        });

        if ($ignore_id) {
            $bookings->where('id', '!=', $ignore_id);
        }

        if ($bookings->exists()) {
            throw new BadRequestHttpException("Selected slot is not available.");
        }
    }
}