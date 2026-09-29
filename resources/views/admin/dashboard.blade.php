<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold">
                        Dashboard Admin
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Selamat datang, {{ auth()->user()->name }}
                    </p>
                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none transition">
                            Kelola Produk (CRUD)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
