<?php

/**
 * Handles events from eloquent models that uses the HasUuid trait.
 * 
 */
 namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid as UuidGenerator;

class HasUuidObserver
{
    public function creating(Model $modelInstance)
    {
        $modelInstance->uuid = UuidGenerator::uuid4()->toString();
    }
}