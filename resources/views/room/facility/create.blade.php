<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Add Room's Facilities") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Facilities of ' . $room->name . ' - ' . $room->location) }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Add facilities for " . $room->name . ' - ' . $room->location) }}
                            </p>
                        </header>
                        <form method="post" action="{{ route('rooms.facilities.store', $room) }}"
                              class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="name" :value="__('Name')"/>
                                <x-tom-select name="facility_ids[]" placeholder="Select facilities ..." multiple>
                                    @foreach ($availableFacilities as $facility)
                                        <option value="{{ $facility->id }}"
                                            @selected(in_array($facility->id, old('facility_ids', $selectedFacilities ?? [])))
                                        >
                                            {{ $facility->name }}
                                        </option>
                                    @endforeach
                                </x-tom-select>
                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                                <a href="{{ route('rooms.facilities.index', $room) }}" class="secondary-btn">Cancel</a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
