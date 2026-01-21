<?php

namespace App\Services;

use App\Exceptions\BusinessRuleException;
use Carbon\Carbon;

class OfficeHourService
{
    /**
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param bool           $isOverride
     * @param bool           $isAdmin
     * @return void
     * @throws \App\Exceptions\BusinessRuleException
     */
    public function validate(Carbon $start, Carbon $end, bool $isOverride, bool $isAdmin): void
    {
        if ($start->toDateString() !== $end->toDateString()) {
            throw new BusinessRuleException('Bookings cannot cross days.');
        }

        $officeStart = Carbon::parse($start->format('Y-m-d') . ' ' . config('office.start'));
        $officeEnd = Carbon::parse($start->format('Y-m-d') . ' ' . config('office.end'));

        if ($start < $officeStart || $end > $officeEnd) {
            if ( ! $isAdmin || ! $isOverride) {
                throw new BusinessRuleException('Bookings outside of business hours are not permitted.');
            }
        }
    }
}
