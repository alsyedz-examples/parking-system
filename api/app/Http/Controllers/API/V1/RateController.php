<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;

/**
 * @property Builder ratesQuery
 */
class RateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->ratesQuery = Rate::query();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response($this->ratesQuery->paginate(request()->get('length', 15)), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        return response($this->ratesQuery->findOrFail($id), 200);
    }
}