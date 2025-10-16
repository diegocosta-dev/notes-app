<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{
    public static function decriptHash($hash)
    {
        try {
			$decryptedHash = Crypt::decrypt($hash);
			return $decryptedHash;
    	} catch (DecryptException $e) {
			return redirect()->route('home');
		}
    }
}