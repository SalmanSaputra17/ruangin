<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Rooms Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __((isset($room) ? "Edit" : "Input") . " room's detail information.") }}
        </p>
    </header>
    <form method="post" action="{{ $action }}" class="mt-6 space-y-6">
        @csrf
        @if (isset($room))
            @method('patch')
        @endif

        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name', isset($room) ? $room->name : '')"
                          required autofocus autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>
        <div>
            <x-input-label for="location" :value="__('Location')"/>
            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                          :value="old('location', isset($room) ? $room->location : '')" required
                          autocomplete="location"/>
            <x-input-error class="mt-2" :messages="$errors->get('location')"/>
        </div>
        <div>
            <x-input-label for="capacity" :value="__('Capacity')"/>
            <x-text-input id="capacity" name="capacity" type="number" class="mt-1 block w-full"
                          :value="old('capacity', isset($room) ? $room->capacity : '')" required
                          autocomplete="capacity"/>
            <x-input-error class="mt-2" :messages="$errors->get('capacity')"/>
        </div>
        <div>
            <x-input-label for="description" :value="__('Description')"/>
            <textarea id="description" name="description"
                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      required autocomplete="description"
                      rows="5">{{ old('description', isset($room) ? $room->description : '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')"/>
        </div>
        <div>
            <x-text-input id="is_active" name="is_active" type="checkbox" value="1"
                          checked="{{ old('is_active', isset($room) ? $room->is_active : '') }}"
                          autocomplete="is_active"/>
            <x-input-label for="is_active" :value="__('Room Active')" class="inline-block"/>
            <x-input-error class="mt-2" :messages="$errors->get('is_active')"/>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <a href="{{ route('rooms.index') }}" class="secondary-btn">Cancel</a>
        </div>
    </form>
</section>
