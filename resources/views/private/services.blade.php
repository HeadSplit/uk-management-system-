@extends('layouts.index')

@section('title', 'Добавить услугу')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Добавить услугу</h2>

        <form action="{{ route('services.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Название услуги</label>
                <input type="text" name="name" id="name" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            <div>
                <label for="unit" class="block text-sm font-medium text-gray-700">Единица измерения</label>
                <select name="unit" id="unit" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
                    <option value="">Выберите единицу</option>
                    <option value="м³">м³ (кубометр)</option>
                    <option value="кВт·ч">кВт·ч (киловатт-час)</option>
                    <option value="м²">м² (квадратный метр)</option>
                    <option value="шт">шт (штука)</option>
                    <option value="месяц">месяц</option>
                </select>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Цена (₽)</label>
                <input type="number" name="price" id="price" step="0.01" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('services') }}" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Отмена</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900 transition">Создать</button>
            </div>
        </form>
    </div>
@endsection
