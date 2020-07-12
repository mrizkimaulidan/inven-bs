<?php

namespace App\Http\Controllers\CommodityLocations\Ajax;

use App\CommodityLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommodityLocationAjaxController extends Controller
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
        $commodity_location = new CommodityLocation();
        $commodity_location->name = $request->name;
        $commodity_location->description = $request->description;
        $commodity_location->save();

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodity_location], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commodity_location = CommodityLocation::findOrFail($id);

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodity_location], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commodity_location = CommodityLocation::findOrFail($id);

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodity_location], 200);
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
        $commodity_location = CommodityLocation::findOrFail($id);
        $commodity_location->name = $request->name;
        $commodity_location->description = $request->description;
        $commodity_location->save();

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodity_location], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CommodityLocation::findOrFail($id)->delete();

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }
}
