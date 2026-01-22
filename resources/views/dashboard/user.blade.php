@php use App\Support\Constant; @endphp
{{-- QUICK ACTION --}}
<div class="flex justify-between items-center">
    <h3 class="text-lg font-semibold text-gray-800">
        My Booking Today
    </h3>

    <a href="{{ route('rooms.index') }}" class="primary-btn">
        Book a Room
    </a>
</div>

{{-- TODAY --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h4 class="font-semibold text-gray-700 mb-3">Today</h4>

    <ul class="space-y-3">
        @forelse($todayBookings as $booking)
            <li class="p-3 rounded-lg bg-gray-50 flex justify-between">
                <div>
                    <p class="font-medium">{{ $booking->title }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $booking->room->name }} •
                        {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}
                    </p>
                </div>
                <span class="px-2 text-sm font-bold uppercase
                    @if($booking->status === Constant::BOOKING_APPROVED) text-green-700
                    @elseif($booking->status === Constant::BOOKING_REJECTED) text-red-700
                    @elseif($booking->status === Constant::BOOKING_PENDING) text-yellow-700
                    @else text-gray-600 @endif">
                    {{ ucfirst($booking->status) }}
                </span>
            </li>
        @empty
            <p class="text-gray-500 text-sm">There is no booking for today.</p>
        @endforelse
    </ul>
</div>

{{-- UPCOMING --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h4 class="font-semibold text-gray-700 mb-3">
        Upcoming Bookings
    </h4>

    <ul class="space-y-3">
        @forelse($upcomingBookings as $booking)
            <li class="p-3 rounded-lg bg-gray-50 flex justify-between">
                <div>
                    <p class="font-medium">{{ $booking->title }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $booking->room->name }} •
                        {{ $booking->start_time->format('d M Y H:i') }}
                    </p>
                </div>
                <span class="px-2 text-sm font-bold uppercase
                    @if($booking->status === Constant::BOOKING_APPROVED) text-green-700
                    @elseif($booking->status === Constant::BOOKING_REJECTED) text-red-700
                    @elseif($booking->status === Constant::BOOKING_PENDING) text-yellow-700
                    @else text-gray-600 @endif">
                    {{ ucfirst($booking->status) }}
                </span>
            </li>
        @empty
            <p class="text-gray-500 text-sm">
                There is no upcoming booking.
            </p>
        @endforelse
    </ul>
</div>
