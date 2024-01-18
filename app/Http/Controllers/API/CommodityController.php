<?php

namespace App\Http\Controllers\API;

use App\Commodity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommodityController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Commodity $commodity)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => $commodity->load('school_operational_assistance', 'commodity_location')
        ], Response::HTTP_OK);
    }
}
