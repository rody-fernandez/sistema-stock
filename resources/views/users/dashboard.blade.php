<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Panel de usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold">{{ __('Hola, :name', ['name' => auth()->user()->name]) }}</h1>
                    <p class="mt-2 text-sm text-gray-600">{{ __('Aquí encontrarás un resumen de tus actividades y notificaciones importantes.') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
