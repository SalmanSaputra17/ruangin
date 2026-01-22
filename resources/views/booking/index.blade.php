@php use App\Support\Constant;use Illuminate\Support\Str; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Booking List') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("List of all bookings.") }}
                    </p>
                </header>
                @if (session('success'))
                    <x-success-alert>{{ session('success') }}</x-success-alert>
                @endif
                <div
                    class="relative mt-4 overflow-x-auto shadow-xs rounded-lg border border-default">
                    <div class="p-4 flex items-center justify-between gap-4 flex-wrap md:flex-nowrap bg-gray-50">
                        <x-create-button :href="route('bookings.create')">Book a Room</x-create-button>
                        <div class="w-full md:w-[240px] lg:w-[280px] relative">
                            <x-search-form :action="route('bookings.index')"/>
                        </div>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <thead class="text-sm text-body bg-gray-50 border-b border-default-medium">
                        <tr>
                            <th scope="col" class="p-4">
                                No.
                            </th>
                            @if(auth()->user()->role === Constant::ROLE_ADMIN)
                                <th scope="col" class="p-4">
                                    User
                                </th>
                            @endif
                            <th scope="col" class="p-4">
                                Room
                            </th>
                            <th scope="col" class="p-4">
                                Title
                            </th>
                            <th scope="col" class="p-4">
                                Datetime
                            </th>
                            <th scope="col" class="p-4">
                                Status
                            </th>
                            <th scope="col" class="p-4">
                                Information
                            </th>
                            @if(auth()->user()->role === Constant::ROLE_ADMIN)
                                <th scope="col" class="p-4">
                                    Action
                                </th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                            <tr class="{{ !$loop->last ? 'border-b' : '' }} border-default {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="p-4 align-top">
                                    {{ $loop->iteration }}
                                </td>
                                @if(auth()->user()->role === Constant::ROLE_ADMIN)
                                    <td class="p-4 align-top">
                                        {{ $booking->user->name }}
                                    </td>
                                @endif
                                <td class="p-4 align-top">
                                    {{ $booking->room->name }}
                                </td>
                                <td class="p-4 align-top">
                                    <span class="block mb-2 font-extrabold">{{ $booking->title }}</span>
                                    <p>{{ Str::limit($booking->description, 50) }}</p>
                                </td>
                                <td class="p-4 align-top">
                                    {{ $booking->start_time->format('d M Y H:i') }}
                                    - {{ $booking->end_time->format('d M Y H:i') }}
                                </td>
                                <td class="p-4 align-top">
                                    <span class="text-sm font-bold uppercase
                                        @if($booking->status === Constant::BOOKING_APPROVED) text-green-700
                                        @elseif($booking->status === Constant::BOOKING_REJECTED) text-red-700
                                        @elseif($booking->status === Constant::BOOKING_PENDING) text-yellow-700
                                        @else text-gray-600 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="p-4 align-top">
                                    @if($booking->is_override)
                                        <p class="text-xs">
                                            <span class="block font-extrabold">Override By:</span>
                                            {{ $booking->overrideBy ? $booking->overrideBy->name : '-' }}
                                            <span class="block mt-1 font-extrabold">Override At:</span>
                                            {{ $booking->override_at ?: '-' }}
                                            <span class="block mt-1 font-extrabold">Reason:</span>
                                            {{ $booking->override_reason ?: '-' }}
                                        </p>
                                    @elseif($booking->status == Constant::BOOKING_PENDING)
                                        <p class="text-xs">Waiting for Admin Approval.</p>
                                    @elseif($booking->status == Constant::BOOKING_APPROVED)
                                        <p class="text-xs">
                                            <span class="block font-extrabold">Approved By:</span>
                                            {{ $booking->approvedBy ? $booking->approvedBy->name : '-' }}
                                            <span class="block mt-1 font-extrabold">Approved At:</span>
                                            {{ $booking->approved_at ?: '-' }}
                                        </p>
                                    @elseif($booking->status == Constant::BOOKING_REJECTED)
                                        <p class="text-xs">
                                            <span class="block font-extrabold">Rejected By:</span>
                                            {{ $booking->rejectedBy ? $booking->rejectedBy->name : '-' }}
                                            <span class="block mt-1 font-extrabold">Rejected At:</span>
                                            {{ $booking->rejected_at ?: '-' }}
                                        </p>
                                    @else
                                        <span class="text-xs text-gray-500 italic">No Info</span>
                                    @endif
                                </td>
                                @if(auth()->user()->role === Constant::ROLE_ADMIN)
                                    <td class="p-4 align-top">
                                        @if($booking->status === Constant::BOOKING_PENDING)
                                            <div class="flex flex-col gap-2">
                                                <form action="{{ route('bookings.approve', $booking) }}" method="POST"
                                                      class="block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="w-full emerald-btn"
                                                            onclick="return confirm('Are you sure you want to approve this booking?');">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('bookings.reject', $booking) }}" method="POST"
                                                      class="block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="w-full red-btn"
                                                            onclick="return confirm('Are you sure you want to reject this booking?');">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-500 italic">No Action</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav
                        class="flex items-center justify-between gap-4 flex-wrap md:flex-nowrap p-4 bg-gray-50 border-t border-gray-200"
                        aria-label="Table navigation">
                        <div class="mx-auto md:mx-0">
                            {{ $bookings->links() }}
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
