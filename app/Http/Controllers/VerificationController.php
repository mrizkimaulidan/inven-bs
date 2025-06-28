<?php

namespace App\Http\Controllers;

use App\Commodity;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class VerificationController extends Controller
{
    /**
     * Menampilkan halaman verifikasi barang berdasarkan ID yang terenkripsi.
     *
     * @param  string  $encrypted_id
     * @return \Illuminate\View\View
     */
    public function show($encrypted_id)
    {
        try {
            $decryptedId = Crypt::decryptString($encrypted_id);
            $commodity = Commodity::findOrFail($decryptedId);

            return view('verifications.show', ['commodity' => $commodity]);

        } catch (DecryptException $e) {
            return view('verifications.invalid');
        }
    }
}
