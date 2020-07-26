<?php

namespace App\Http\Controllers\Commodities\Ajax;

use App\Commodity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommodityAjaxController extends Controller
{
    public function store(Request $request)
    {
        $commodities = new Commodity();
        $commodities->school_operational_assistance_id = $request->school_operational_assistance_id;
        $commodities->commodity_location_id = $request->commodity_location_id;
        $commodities->item_code = $request->item_code;
        $commodities->name = $request->name;
        $commodities->brand = $request->brand;
        $commodities->material = $request->material;
        $commodities->year_of_purchase = $request->year_of_purchase;
        $commodities->condition = $request->condition;
        $commodities->quantity = $request->quantity;
        $commodities->price = $request->price;
        $commodities->price_per_item = $request->price_per_item;
        $commodities->note = $request->note;
        $commodities->save();

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodities], 200);
    }

    public function show($id)
    {
        $commodity = Commodity::findOrFail($id);

        $data = [
            'school_operational_assistance_id' => $commodity->school_operational_assistance->name,
            'commodity_location_id' => $commodity->commodity_location->name,
            'item_code' => $commodity->item_code,
            'name' => $commodity->name,
            'brand' => $commodity->brand,
            'material' => $commodity->material,
            // $commodity->date_of_purchase
            'year_of_purchase' => $commodity->year_of_purchase,
            'condition' => $commodity->condition,
            'quantity' => $commodity->quantity,
            'price' => $commodity->indonesian_currency($commodity->price),
            'price_per_item' => $commodity->indonesian_currency($commodity->price_per_item),
            'note' => $commodity->note,
        ];

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $data], 200);
    }

    public function edit($id)
    {
        $commodity = Commodity::findOrFail($id);

        $data = [
            'school_operational_assistance_id' => $commodity->school_operational_assistance_id,
            'commodity_location_id' => $commodity->commodity_location_id,
            'item_code' => $commodity->item_code,
            'name' => $commodity->name,
            'brand' => $commodity->brand,
            'material' => $commodity->material,
            'year_of_purchase' => $commodity->year_of_purchase,
            'condition' => $commodity->condition,
            'quantity' => $commodity->quantity,
            'price' => $commodity->price,
            'price_per_item' => $commodity->price_per_item,
            'note' => $commodity->note,
        ];

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $commodities = Commodity::findOrFail($id);

        $commodities->school_operational_assistance_id = $request->school_operational_assistance_id;
        $commodities->commodity_location_id = $request->commodity_location_id;
        $commodities->item_code = $request->item_code;
        $commodities->name = $request->name;
        $commodities->brand = $request->brand;
        $commodities->material = $request->material;
        $commodities->year_of_purchase = $request->year_of_purchase;
        $commodities->condition = $request->condition;
        $commodities->quantity = $request->quantity;
        $commodities->price = $request->price;
        $commodities->price_per_item = $request->price_per_item;
        $commodities->note = $request->note;
        $commodities->save();

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }

    public function destroy($id)
    {
        Commodity::findOrFail($id)->delete();

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }
}
