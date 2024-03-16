<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Traits\BookingTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @property Builder bookingsQuery
 * @property Builder parkingSpotsQuery
 */
class SearchController extends Controller
{
    use BookingTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function search(Request $request)
    {
        $validated = $this->validate($request, $this->getUpdateValidationRules());

        $bookings = $this->getBookingSlotsForADateRange($validated['start_date'], $validated['end_date']);

//        return response($bookings, 200);
        return response($bookings->map(function(Booking $booking) {
            return [
                'parking_spot_id' => $booking->parking_spot_id,
                'start_date' => $booking->start_date,
                'end_date' => $booking->end_date
            ];
        }), 200);
    }
}