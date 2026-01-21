@php use Illuminate\Support\Str; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Room List') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("List of rooms available.") }}
                    </p>
                </header>
                @if (session('success'))
                    <x-success-alert>{{ session('success') }}</x-success-alert>
                @endif
                <div
                    class="relative mt-4 overflow-x-auto shadow-xs rounded-lg border border-default">
                    <div class="p-4 flex items-center justify-between gap-4 flex-wrap md:flex-nowrap bg-gray-50">
                        <x-create-button :href="route('rooms.create')">Create Room</x-create-button>
                        <div class="w-full md:w-[240px] lg:w-[280px] relative">
                            <x-search-form :action="route('rooms.index')"/>
                        </div>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <thead class="text-sm text-body bg-gray-50 border-b border-default-medium">
                        <tr>
                            <th scope="col" class="p-4">
                                No.
                            </th>
                            <th scope="col" class="p-4">
                                Name
                            </th>
                            <th scope="col" class="p-4">
                                Location
                            </th>
                            <th scope="col" class="p-4">
                                Capacity
                            </th>
                            <th scope="col" class="p-4">
                                Status
                            </th>
                            <th scope="col" class="w-4 sm:w-8 p-4">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rooms as $room)
                            <tr class="{{ !$loop->last ? 'border-b' : '' }} border-default {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="p-4 align-top">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="p-4 align-top">
                                    <span class="block mb-2 font-extrabold">{{ $room->name }}</span>
                                    <p>{{ Str::limit($room->description, 50) }}</p>
                                </td>
                                <td class="p-4 align-top">
                                    {{ $room->location }}
                                </td>
                                <td class="p-4 align-top">
                                    {{ $room->capacity }} People
                                </td>
                                <td class="p-4 align-top">
                                    {{ $room->is_active ? 'Active' : 'Inactive' }}
                                </td>
                                <td class="p-4 align-top">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('rooms.facilities.index', $room) }}"
                                           class="w-full indigo-btn">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3 21h18M5 21V7l8-4 6 3v15M9 21v-4h6v4"/>
                                            </svg>
                                            Facilities
                                        </a>
                                        <x-edit-button :href="route('rooms.edit', $room)">Edit</x-edit-button>
                                        <x-delete-button :href="route('rooms.destroy', $room)">Delete
                                        </x-delete-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav
                        class="flex items-center justify-between gap-4 flex-wrap md:flex-nowrap p-4 bg-gray-50 border-t border-gray-200"
                        aria-label="Table navigation">
                        <div class="mx-auto md:mx-0">
                            {{ $rooms->links() }}
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
