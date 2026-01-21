<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use App\Support\Constant;

class BookingPolicy
{
    /**
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [Constant::ROLE_ADMIN, Constant::ROLE_USER]);
    }

    /**
     * @param \App\Models\User $user
     * @return bool
     */
    public function approve(User $user): bool
    {
        return $user->role === Constant::ROLE_ADMIN;
    }

    /**
     * @param \App\Models\User $user
     * @return bool
     */
    public function overrideOfficeHours(User $user): bool
    {
        return $user->role === Constant::ROLE_ADMIN;
    }
}
