<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolOperationalAssistanceRequest;
use App\Http\Requests\UpdateSchoolOperationalAssistanceRequest;
use App\SchoolOperationalAssistance;

class SchoolOperationalAssistanceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SchoolOperationalAssistance::class, 'school_operational_assistance');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $school_operational_assistances = SchoolOperationalAssistance::orderBy('name', 'ASC')->get();

        return view('school-operational-assistances.index', compact('school_operational_assistances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolOperationalAssistanceRequest $request)
    {
        SchoolOperationalAssistance::create($request->validated());

        return to_route('bantuan-dana-operasional.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolOperationalAssistanceRequest $request, SchoolOperationalAssistance $schoolOperationalAssistance)
    {
        $schoolOperationalAssistance->update($request->validated());

        return to_route('bantuan-dana-operasional.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolOperationalAssistance $schoolOperationalAssistance)
    {
        if ($schoolOperationalAssistance->commodities->isNotEmpty()) {
            return to_route('bantuan-dana-operasional.index')
                ->with('error', 'BOS tidak dapat dihapus karena masih terkait dengan data komoditas!');
        }

        $schoolOperationalAssistance->delete();

        return to_route('bantuan-dana-operasional.index')->with('success', 'Data berhasil dihapus!');
    }
}
