<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static whereNotIn(string $string, \Illuminate\Support\Collection $pluck)
 */
class Facility extends Model
{
    use softDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'room_facility', 'facility_id', 'room_id');
    }
}
