<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\OutgoingLetter;

class VerificationController extends Controller
{
    public function show(string $code)
    {
        $letter = OutgoingLetter::query()
            ->where('verification_code', $code)
            ->first();

        return view('surat.verify', [
            'title' => 'Verifikasi Surat',
            'letter' => $letter,
            'code' => $code,
        ]);
    }
}
