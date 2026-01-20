@php use Illuminate\Support\Str; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Facilities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Facility List') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("List of facilities available.") }}
                    </p>
                </header>
                @if (session('success'))
                    <x-success-alert>{{ session('success') }}</x-success-alert>
                @endif
                <div
                    class="relative mt-4 overflow-x-auto shadow-xs rounded-lg border border-default">
                    <div class="p-4 flex items-center justify-between gap-4 flex-wrap md:flex-nowrap bg-gray-50">
                        <a href="{{ route('facilities.create') }}" class="primary-btn">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            &nbsp;Create Facility
                        </a>
                        <div class="w-full md:w-[240px] lg:w-[280px] relative">
                            <form method="get" action="{{ route('facilities.index') }}">
                                <label for="input-group-1" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                  d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="text" id="input-group-1" name="search" value="{{ request('search') }}"
                                           class="block w-full ps-9 pe-3 py-2 bg-white border border-gray-200 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400"
                                           placeholder="Search facility name...">
                                </div>
                            </form>
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
                                Description
                            </th>
                            <th scope="col" class="p-4">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($facilities as $facility)
                            <tr class="{{ !$loop->last ? 'border-b' : '' }} border-default {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="p-4 align-top">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="p-4 align-top">
                                    {{ $facility->name }}
                                </td>
                                <td class="p-4 align-top">
                                    {{ $facility->description }}
                                </td>
                                <td class="p-4 align-top">
                                    <div class="inline-flex gap-2">
                                        <a href="{{ route('facilities.edit', $facility) }}" class="yellow-btn">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.12 2.12 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <form method="post" action="{{ route('facilities.destroy', $facility) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="red-btn"
                                                    onclick="return confirm('Are you sure want to delete this room?');">
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="2">
                                                    <path d="M3 6h18"/>
                                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                                                    <path d="M10 11v6"/>
                                                    <path d="M14 11v6"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav
                        class="flex items-center justify-between gap-4 flex-wrap md:flex-nowrap p-4 bg-gray-50 border-t border-gray-200"
                        aria-label="Table navigation">
                        <span class="text-sm text-gray-600 w-full md:w-auto text-center md:text-left">
                            Showing
                            <span class="font-semibold text-gray-900">
                                {{ $facilities->firstItem() }}–{{ $facilities->lastItem() }}
                            </span>
                            of
                            <span class="font-semibold text-gray-900">
                                {{ $facilities->total() }}
                            </span>
                        </span>
                        <div class="mx-auto md:mx-0">
                            {{ $facilities->links() }}
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
