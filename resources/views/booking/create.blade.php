@php
    use App\Support\Constant;

    $today = now()->format('Y-m-d');
    $startHour = auth()->user()->role === Constant::ROLE_ADMIN ? '06:00' : '08:00';
    $endHour = auth()->user()->role === Constant::ROLE_ADMIN ? '23:00' : '18:00';
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book a Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Booking Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Input booking's detail information.") }}
                            </p>
                        </header>
                        @if ($errors->any())
                            <div class="my-4 rounded-lg bg-red-50 p-4 text-sm text-red-700">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('bookings.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="room-id" :value="__('Room')"/>
                                <select id="room-id" name="room_id" autofocus required
                                        class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select room ...</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}" @selected($room->id == old('room_id'))>
                                            {{ $room->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('room_id')"/>
                            </div>
                            <div>
                                <x-input-label for="title" :value="__('Title')"/>
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                              :value="old('title')" required autocomplete="title"/>
                                <x-input-error class="mt-2" :messages="$errors->get('title')"/>
                            </div>
                            <div>
                                <x-input-label for="description" :value="__('Description')"/>
                                <textarea id="description" name="description"
                                          class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                          autocomplete="description" rows="5">{{ old('description') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')"/>
                            </div>
                            <div>
                                <x-input-label for="start-time" :value="__('Start Time')"/>
                                <input type="datetime-local"
                                       id="start-time"
                                       name="start_time"
                                       value="{{ old('start_time') }}"
                                       min="{{ $today }}T{{ $startHour }}"
                                       max="{{ $today }}T{{ $endHour }}"
                                       step="900"
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <span class="block my-2 text-xs text-yellow-800">
                                    Office Hour: {{ config('office.start') }} – {{ config('office.end') }}
                                </span>
                                <x-input-error class="mt-2" :messages="$errors->get('start_time')"/>
                            </div>
                            <div>
                                <x-input-label for="end-time" :value="__('End Time')"/>
                                <input type="datetime-local"
                                       id="end-time"
                                       name="end_time"
                                       value="{{ old('end_time') }}"
                                       min="{{ $today }}T{{ $startHour }}"
                                       max="{{ $today }}T{{ $endHour }}"
                                       step="900"
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <span class="block my-2 text-xs text-yellow-800">
                                    Office Hour: {{ config('office.start') }} – {{ config('office.end') }}
                                </span>
                                <x-input-error class="mt-2" :messages="$errors->get('end_time')"/>
                            </div>
                            @if(auth()->user()->role === Constant::ROLE_ADMIN)
                                <div class="border-t pt-4">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox"
                                               name="is_override"
                                               value="1"
                                               {{ old('is_override') ? 'checked' : '' }}
                                               class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">
                                                Override office hour
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Use if the meeting is held outside normal working hours.
                                            </p>
                                        </div>
                                        <x-input-error class="mt-2" :messages="$errors->get('is_override')"/>
                                    </div>

                                    <div id="override-reason-wrapper" class="mt-3 hidden">
                                        <x-input-label for="override-reason" :value="__('Override Reason')"/>
                                        <textarea id="override-reason" name="override_reason" rows="5"
                                                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                  placeholder="Example: Board of directors meeting until evening">{{ old('override_reason') }}</textarea>
                                        <x-input-error class="mt-2" :messages="$errors->get('override_reason')"/>
                                    </div>
                                </div>
                            @endif
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                                <a href="{{ route('bookings.index') }}" class="secondary-btn">Cancel</a>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.querySelector('[name="is_override"]').addEventListener('change', function () {
        document.getElementById('override-reason-wrapper')
            .classList.toggle('hidden', !this.checked);
    });
</script>
