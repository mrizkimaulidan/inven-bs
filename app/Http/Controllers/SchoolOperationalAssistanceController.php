<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolOperationalAssistanceRequest;
use App\Http\Requests\UpdateSchoolOperationalAssistanceRequest;
use App\SchoolOperationalAssistance;
use Illuminate\Http\Request;

class SchoolOperationalAssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $school_operational_assistances = SchoolOperationalAssistance::orderBy('name', 'ASC')->get();

        return view('school-operational-assistances.index', compact('school_operational_assistances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        $schoolOperationalAssistance->delete();

        return to_route('bantuan-dana-operasional.index')->with('success', 'Data berhasil dihapus!');
    }
}
