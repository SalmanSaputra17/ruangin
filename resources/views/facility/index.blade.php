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
                        <x-create-button :href="route('facilities.create')">Create Facility</x-create-button>
                        <div class="w-full md:w-[240px] lg:w-[280px] relative">
                            <x-search-form :action="route('facilities.index')"/>
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
                                        <x-edit-button :href="route('facilities.edit', $facility)">Edit</x-edit-button>
                                        <x-delete-button :href="route('facilities.destroy', $facility)">Delete</x-delete-button>
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
