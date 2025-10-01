@extends('layouts.index')

@section('title', 'Редактировать дом')

@section('content')
    <div class="bg-white rounded-xl shadow p-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6">Редактировать дом</h2>

        <form action="{{ route('houses.update', $house->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm text-gray-700 mb-1">Название дома</label>
                <input type="text" name="name" value="{{ old('name', $house->name) }}" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Адрес</label>
                <input type="text" name="address" value="{{ old('address', $house->address) }}" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Количество подъездов</label>
                <input type="number" name="entrances" value="{{ old('entrances', $house->entrances) }}" min="1" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Количество этажей</label>
                <input type="number" name="floors" value="{{ old('floors', $house->floors) }}" min="1" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('houses') }}" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">Отмена</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900 transition">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
