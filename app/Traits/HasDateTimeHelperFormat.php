<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait HasDateTimeHelperFormat
{
    public function usaFormat($date): string
    {
        return Carbon::parse($date)->format('m/d/Y h:i:s');
    }

    public function timestamp($date): int
    {
        return (int) Carbon::parse($date)->timestamp;
    }
}
