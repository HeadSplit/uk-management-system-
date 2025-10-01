@extends('layouts.index')

@section('title', 'Создать заявку')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Создать заявку</h2>

        <form action="{{ route('requests.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="apartment_id" class="block text-sm font-medium text-gray-700">Квартира</label>
                <select name="apartment_id" id="apartment_id" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
                    @foreach($apartments as $apartment)
                        <option value="{{ $apartment->id }}">
                            {{ $apartment->number }} - {{ $apartment->house->name ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                <textarea name="description" id="description" rows="4" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required></textarea>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('requests') }}" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Отмена</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-700 transition">Создать</button>
            </div>
        </form>
    </div>
@endsection
