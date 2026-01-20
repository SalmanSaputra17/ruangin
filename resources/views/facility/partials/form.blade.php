<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Facilities Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __((isset($facility) ? "Edit" : "Input") . " facility's detail information.") }}
        </p>
    </header>
    <form method="post" action="{{ $action }}" class="mt-6 space-y-6">
        @csrf
        @if (isset($facility))
            @method('patch')
        @endif

        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name', isset($facility) ? $facility->name : '')"
                          required autofocus autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>
        <div>
            <x-input-label for="description" :value="__('Description')"/>
            <textarea id="description" name="description"
                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      required autocomplete="description"
                      rows="5">{{ old('description', isset($facility) ? $facility->description : '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')"/>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <a href="{{ route('facilities.index') }}" class="secondary-btn">Cancel</a>
        </div>
    </form>
</section>
