@extends('layouts.index')

@section('title', 'Редактировать жильца')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6 space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Редактировать жильца</h2>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Имя</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Роль</label>
                <select id="role" name="role"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Пользователь</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Администратор</option>
                </select>
                @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="house_id" class="block text-sm font-medium text-gray-700">Дом</label>
                <select id="house_id" name="house_id"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">-- Не выбран --</option>
                    @foreach($houses as $house)
                        <option value="{{ $house->id }}"
                            {{ old('house_id', optional($user->apartments->first())->house_id) == $house->id ? 'selected' : '' }}>
                            {{ $house->name }}
                        </option>
                    @endforeach
                </select>
                @error('house_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="apartment_id" class="block text-sm font-medium text-gray-700">Квартира</label>
                <select id="apartment_id" name="apartment_id"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">-- Не выбрана --</option>
                    @foreach($apartments as $apartment)
                        <option value="{{ $apartment->id }}"
                            {{ old('apartment_id', optional($user->apartments->first())->id) == $apartment->id ? 'selected' : '' }}>
                            №{{ $apartment->number }} ({{ $apartment->house->name }})
                        </option>
                    @endforeach
                </select>
                @error('apartment_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('users') }}" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">Отмена</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
