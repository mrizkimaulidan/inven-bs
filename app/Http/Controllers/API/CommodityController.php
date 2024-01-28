<?php

namespace App\Http\Controllers\API;

use App\Commodity;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShowCommodityResource;
use Illuminate\Http\Response;

class CommodityController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Commodity $commodity)
    {
        $commodity->load('school_operational_assistance:id,name', 'commodity_location:id,name');

        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => new ShowCommodityResource($commodity)
        ], Response::HTTP_OK);
    }
}
