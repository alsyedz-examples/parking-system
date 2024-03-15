<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\booking;
use App\Traits\BookingTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @property Builder bookingsQuery
 */
class BookingController extends Controller
{
    use BookingTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->bookingsQuery = booking::query();

        $this->bookingsQuery->orderBy('start_date');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response($this->bookingsQuery->paginate(request()->get('length', 15)), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->getCreateValidationRules());

        $this->throwIfSlotIsNotAvailable($validated['start_date'], $validated['end_date']);

        return response($this->bookingsQuery->create($validated), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        return response($this->bookingsQuery->findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $booking = $this->bookingsQuery->findOrFail($id);

        $validated = $this->validate($request, $this->getUpdateValidationRules());

        $this->throwIfSlotIsNotAvailable($validated['start_date'], $validated['end_date'], $booking->id);

        $booking->update($validated);

        return response($booking, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $booking = $this->bookingsQuery->findOrFail($id);

        return response([
            'deleted' => $booking->delete()
        ], 200);
    }
}