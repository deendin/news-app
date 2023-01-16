<?php

namespace App\Models;

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

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
