@extends('layouts.index')

@section('title', 'Добавить дом')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6 space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Добавить дом</h2>

        <form action="{{ route('houses.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Название</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Адрес</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" required
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
                @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="entrances" class="block text-sm font-medium text-gray-700 mb-1">Количество подъездов</label>
                <input type="number" id="entrances" name="entrances" value="{{ old('entrances') }}" min="1" required
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
                @error('entrances')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="floors" class="block text-sm font-medium text-gray-700 mb-1">Количество этажей</label>
                <input type="number" id="floors" name="floors" value="{{ old('floors') }}" min="1" required
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
                @error('floors')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('houses') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Отмена</a>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
