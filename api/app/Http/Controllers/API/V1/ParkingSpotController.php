<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ParkingSpot;
use Illuminate\Http\Response;

class ParkingSpotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->parkingSpotQuery = ParkingSpot::query();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response($this->parkingSpotQuery->paginate(request()->get('length', 15)),200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        return response($this->parkingSpotQuery->findOrFail($id),200);
    }
}