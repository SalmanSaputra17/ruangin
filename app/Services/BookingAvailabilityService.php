<?php

namespace App\Services;

use App\Exceptions\BusinessRuleException;
use App\Models\Room;
use Carbon\Carbon;

class BookingAvailabilityService
{
    /**
     * @param \App\Models\Room $room
     * @param \Carbon\Carbon   $start
     * @param \Carbon\Carbon   $end
     * @return void
     * @throws \App\Exceptions\BusinessRuleException
     */
    public function ensureAvailability(Room $room, Carbon $start, Carbon $end): void
    {
        $conflict = $room->bookings()->where('status', '!=', 'rejected')->where(function ($query) use ($start, $end) {
            $query->where('start_time', '<', $end)->where('end_time', '>', $start);
        })->exists();

        if ($conflict) {
            throw new BusinessRuleException('The room was already booked at that time.');
        }
    }
}
