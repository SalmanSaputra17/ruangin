@php use App\Support\Constant; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($role === Constant::ROLE_ADMIN)
                @include('dashboard.admin')
            @else
                @include('dashboard.user')
            @endif
        </div>
    </div>
</x-app-layout>
