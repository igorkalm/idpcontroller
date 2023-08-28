<?php
namespace Igorkalm\IDPcontroller\Services;

use Illuminate\Support\Facades\DB;

class QRCodesService {
    
    /**
     * Checks if QR-code is valid
     *
     * @param string $qrcode
     * @return boolean
     */
    public static function findQRcode(string $qrcode = '') {
        if ( DB::table('users')->where('qrcode', $qrcode)->exists() ) {
            return true;
        } else {
            return false;
        }
    }
}