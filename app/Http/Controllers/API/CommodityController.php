<?php

namespace App\Http\Controllers\API;

use App\Commodity;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShowCommodityResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CommodityController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Commodity $commodity)
    {
        $commodity->load('commodity_acquisition:id,name', 'commodity_location:id,name');

        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => new ShowCommodityResource($commodity),
        ], Response::HTTP_OK);
    }


    /**
     * Generate QR Code untuk barang tertentu dan kembalikan sebagai data SVG.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateQrCode($id)
    {
        $commodity = Commodity::find($id);
        if (!$commodity) {
            return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan'], Response::HTTP_NOT_FOUND);
        }

        $verificationUrl = url('verify/qrcode/' . Crypt::encryptString($id));

        $svgImage = QrCode::format('svg')->size(250)->margin(1)->generate($verificationUrl);
        $qrCodeDataUri = 'data:image/svg+xml;base64,' . base64_encode($svgImage);
        return response()->json([
            'success'   => true,
            'svg'       => $qrCodeDataUri,
            'filename'  => 'qrcode-' . $commodity->name . '.svg'
        ], Response::HTTP_OK);
    }
}
