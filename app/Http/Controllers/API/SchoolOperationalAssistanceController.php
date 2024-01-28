<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SchoolOperationalAssistance;
use Illuminate\Http\Response;

class SchoolOperationalAssistanceController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(SchoolOperationalAssistance $schoolOperationalAssistance)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => $schoolOperationalAssistance
        ], Response::HTTP_OK);
    }
}
