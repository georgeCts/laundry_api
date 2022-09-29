<?php

namespace App\Services;

use Carbon\Carbon;

class Utils
{
    /**
     * Validates if the local hour is between a specific bussiness hour range
     * @return Boolean
     */
    static function isBusinessHours()
    {
        $isValid = false;
        $startTime = "09:00:00";
        $endTime = "19:00:00";
        $actualTime = Carbon::now()->format("H:i:s");

        if ($actualTime >= $startTime && $actualTime < $endTime)
            $isValid = true;

        return $isValid;
    }
}
