@php use App\Support\Constant; @endphp
{{-- STAT CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <x-dashboard.stat title="Total Rooms" :value="$stats['rooms']"/>
    <x-dashboard.stat title="Total Facilities" :value="$stats['facilities']"/>
    <x-dashboard.stat title="Today Booking" :value="$stats['today']"/>
    <x-dashboard.stat title="Pending Approval" :value="$stats['pending']"/>
</div>

{{-- TODAY BOOKINGS --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        Today Bookings
    </h3>

    <table class="min-w-full text-sm">
        <thead class="border-b">
        <tr class="text-left text-gray-500">
            <th class="py-2">Hour</th>
            <th>Room</th>
            <th>User</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody class="divide-y">
        @forelse($todayBookings as $booking)
            <tr>
                <td class="py-2">
                    {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}
                </td>
                <td>{{ $booking->room->name }}</td>
                <td>{{ $booking->user->name }}</td>
                <td>
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($booking->status === Constant::BOOKING_APPROVED) bg-green-100 text-green-700
                        @elseif($booking->status === Constant::BOOKING_REJECTED) bg-red-100 text-red-700
                        @elseif($booking->status === Constant::BOOKING_PENDING) bg-yellow-100 text-yellow-700
                        @else bg-gray-200 text-gray-600 @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="py-4 text-center text-gray-500">
                    There is no booking for today.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
