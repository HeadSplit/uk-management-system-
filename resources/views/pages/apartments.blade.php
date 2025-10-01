@extends('layouts.index')

@section('title', 'Добавить квартиру')

@section('content')
    <div class="bg-white rounded-xl shadow p-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6">Добавить квартиру</h2>

        <form action="{{ route('apartments.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm text-gray-700 mb-1">Номер квартиры</label>
                <input type="number" name="number" value="{{ old('number') }}" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
                @error('number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Дом</label>
                <select name="house_id" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
                    <option value="" disabled selected>Выберите дом</option>
                    @foreach($houses as $house)
                        <option value="{{ $house->id }}" @selected(old('house_id') == $house->id)>
                            {{ $house->name }} ({{ $house->address }})
                        </option>
                    @endforeach
                </select>
                @error('house_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Владелец квартиры</label>
                <select name="user_id" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
                    <option value="" selected>Не назначен</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Площадь (м²)</label>
                <input type="number" step="0.01" name="area" value="{{ old('area') }}" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
                @error('area')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Подъезд</label>
                <input type="number" name="entrance" value="{{ old('entrance') }}" min="1" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
                @error('entrance')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Этаж</label>
                <input type="number" name="floor" value="{{ old('floor') }}" min="1" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
                @error('floor')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('apartments') }}" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">Отмена</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900 transition">Создать</button>
            </div>
        </form>
    </div>
@endsection
