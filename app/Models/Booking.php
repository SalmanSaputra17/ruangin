<?php

namespace App\Models;

use App\Support\Constant;
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
        'override_at',
        'override_by',
        'override_reason',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'rejected_reason',
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
        'override_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
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
    public function overrideBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'override_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @param $query
     * @param $user
     * @return mixed
     */
    public function scopeVisibleFor($query, $user)
    {
        if ($user->role === Constant::ROLE_USER) {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }
}
