@extends('layouts.index')

@section('title', 'Редактировать квартиру')

@section('content')
    <div class="bg-white rounded-xl shadow p-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6">Редактировать квартиру</h2>

        <form action="{{ route('apartments.update', $apartment->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm text-gray-700 mb-1">Номер квартиры</label>
                <input type="number" name="number" value="{{ $apartment->number }}" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Площадь (м²)</label>
                <input type="number" step="0.01" name="area" value="{{ $apartment->area }}" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Дом</label>
                <select name="house_id" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
                    @foreach($houses as $house)
                        <option value="{{ $house->id }}" {{ $apartment->house_id == $house->id ? 'selected' : '' }}>
                            {{ $house->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('apartments') }}" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">Отмена</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900 transition">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
