<?php

namespace App\Models;

use App\Events\NewsCreated;
use App\Traits\HasOlderRecords;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;
    use HasOlderRecords;

    /**
     * The event map for the model.
     * 
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => NewsCreated::class
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
