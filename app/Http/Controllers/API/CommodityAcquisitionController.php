<?php

namespace App\Http\Controllers\API;

use App\CommodityAcquisition;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommodityAcquisitionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(CommodityAcquisition $commodityAcquisition)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => $commodityAcquisition,
        ], Response::HTTP_OK);
    }
}
