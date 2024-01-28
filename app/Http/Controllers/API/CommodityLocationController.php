<?php

namespace App\Http\Controllers\API;

use App\CommodityLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CommodityLocationController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(CommodityLocation $commodityLocation)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => $commodityLocation
        ], Response::HTTP_OK);
    }
}
