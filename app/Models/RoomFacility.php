<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomFacility extends Pivot
{
    use softDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'room_id',
        'facility_id',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'deleted_at',
    ];
}
