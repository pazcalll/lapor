<?php

namespace App\Helpers;

class Helper {
    public static function createReferral() {
        return strtoupper(bin2hex(random_bytes(6)));
    }
}