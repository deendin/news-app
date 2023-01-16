<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait HasOlderRecords
{
    /**
     * Returns the models older records based on a specified number of days.
     * 
     * @param $noOfDays
     * @return Illuminate\Database\Eloquent\Collection|null
     * 
     */
    public static function olderRecords(string $noOfDays) : Collection
    {
        return self::whereDate('created_at', '<=', now()->subDays($noOfDays)->setTime(0, 0, 0)
                    ->toDateTimeString())
                    ->get();
    }
}