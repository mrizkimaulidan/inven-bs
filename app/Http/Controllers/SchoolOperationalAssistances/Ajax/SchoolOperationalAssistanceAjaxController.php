<?php

namespace App\Http\Controllers\SchoolOperationalAssistances\Ajax;

use App\Http\Controllers\Controller;
use App\SchoolOperationalAssistance;
use Illuminate\Http\Request;

class SchoolOperationalAssistanceAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $school_operational_assistances = new SchoolOperationalAssistance();
        $school_operational_assistances->name = $request->name;
        $school_operational_assistances->description = $request->description;
        $school_operational_assistances->save();

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $school_operational_assistances], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $school_operational_assistance = SchoolOperationalAssistance::findOrFail($id);

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $school_operational_assistance], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school_operational_assistance = SchoolOperationalAssistance::findOrFail($id);

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $school_operational_assistance], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $school_operational_assistance = SchoolOperationalAssistance::findOrFail($id);
        $school_operational_assistance->name = $request->name;
        $school_operational_assistance->description = $request->description;
        $school_operational_assistance->save();

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $school_operational_assistance], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SchoolOperationalAssistance::findOrFail($id)->delete();

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }
}
