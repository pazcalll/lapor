<?php

if (!function_exists('createReferral')) {
    function createReferral() {
        return strtoupper(bin2hex(random_bytes(6)));
    }
}