<?php

namespace App\Traits;

use App\Observers\HasUuidObserver;

trait HasUuid
{
    protected static function bootHasUuid()
    {
        static::observe(HasUuidObserver::class);
    }
}