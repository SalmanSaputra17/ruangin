<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessRuleException;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use App\Services\BookingAvailabilityService;
use App\Services\OfficeHourService;
use App\Support\Constant;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request): Factory|View
    {
        $query = Booking::with(['room', 'user'])->visibleFor($request->user());

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $query->orderByDesc('start_time');

        $bookings = $query->paginate(10)->withQueryString();

        return view('booking.index', compact('bookings'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(): Factory|View
    {
        $rooms = Room::orderBy('name')->where('is_active', true)->get();

        return view('booking.create', compact('rooms'));
    }

    /**
     * @param \App\Http\Requests\Booking\StoreBookingRequest $request
     * @param \App\Services\OfficeHourService                $officeHourService
     * @param \App\Services\BookingAvailabilityService       $bookingAvailabilityService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreBookingRequest $request, OfficeHourService $officeHourService, BookingAvailabilityService $bookingAvailabilityService): RedirectResponse
    {
        $this->authorize('create', Booking::class);

        try {
            DB::transaction(function () use ($request, $officeHourService, $bookingAvailabilityService) {
                $room = Room::findOrFail($request->room_id);
                $user = $request->user();

                $start = now()->parse($request->start_time);
                $end = now()->parse($request->end_time);

                $isOverride = (bool) $request->is_override;

                // Validate office hour
                $officeHourService->validate($start, $end, $isOverride, $user->role === Constant::ROLE_ADMIN);

                // Validate booking conflict
                $bookingAvailabilityService->ensureAvailability($room, $start, $end);

                // Validate override reason
                if ($isOverride && $user->role === Constant::ROLE_ADMIN && ! $request->override_reason) {
                    return back()->with('error', 'Override reason is mandatory.')->withInput();
                }

                return Booking::create([
                    'room_id'         => $room->id,
                    'user_id'         => $user->id,
                    'start_time'      => $start,
                    'end_time'        => $end,
                    'title'           => $request->title,
                    'description'     => $request->description,
                    'status'          => $user->role === Constant::ROLE_ADMIN ? 'approved' : 'pending',
                    'is_override'     => $isOverride,
                    'override_reason' => $request->override_reason,
                    'approved_by'     => $user->role === Constant::ROLE_ADMIN ? $user->id : null,
                ]);
            });
        } catch (BusinessRuleException $businessRuleException) {
            return back()->withErrors($businessRuleException->getMessage())->withInput();
        }

        return redirect()->route('bookings.index')->with('success', 'Booking successfully created.');
    }
}
