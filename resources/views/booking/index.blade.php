@php use Illuminate\Support\Str; @endphp
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
                            <th scope="col" class="p-4">
                                Room
                            </th>
                            <th scope="col" class="p-4">
                                Title
                            </th>
                            <th scope="col" class="p-4">
                                Start Time
                            </th>
                            <th scope="col" class="p-4">
                                End Time
                            </th>
                            <th scope="col" class="p-4">
                                Status
                            </th>
                            <th scope="col" class="p-4">
                                Information
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                            <tr class="{{ !$loop->last ? 'border-b' : '' }} border-default {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="p-4 align-top">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="p-4 align-top">
                                    {{ $booking->room->name }}
                                </td>
                                <td class="p-4 align-top">
                                    <span class="block mb-2 font-extrabold">{{ $booking->title }}</span>
                                    <p>{{ Str::limit($booking->description, 50) }}</p>
                                </td>
                                <td class="p-4 align-top">
                                    {{ $booking->start_time }}
                                </td>
                                <td class="p-4 align-top">
                                    {{ $booking->end_time }}
                                </td>
                                <td class="p-4 align-top">
                                    {{ ucfirst($booking->status) }}
                                </td>
                                <td class="p-4 align-top">
                                    @if($booking->is_override)
                                        <span class="block mb-2 text-yellow-800">Override By Admin</span>
                                        <p>{{ $booking->override_reason }}</p>
                                    @else
                                        <span class="text-xs text-gray-500 italic">No Info</span>
                                    @endif
                                </td>
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
