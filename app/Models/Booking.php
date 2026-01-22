<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class Booking extends Model
{
    use softDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
        'is_override',
        'override_reason',
        'approved_by',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'start_time'  => 'datetime',
        'end_time'    => 'datetime',
        'is_override' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
