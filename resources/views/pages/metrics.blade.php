@extends('layouts.index')

@section('title', 'Передать показатели')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-semibold mb-6">Передать показатели</h2>

        <form action="{{ route('apartments.send-metrics', $apartment->id) }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="period" class="block text-sm font-medium text-gray-700">Период</label>
                <input type="month" name="period" id="period" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            <div>
                <label for="cold_water" class="block text-sm font-medium text-gray-700">Холодная вода (м³)</label>
                <input type="number" name="cold_water" id="cold_water" step="0.01" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
            </div>

            <div>
                <label for="hot_water" class="block text-sm font-medium text-gray-700">Горячая вода (м³)</label>
                <input type="number" name="hot_water" id="hot_water" step="0.01" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
            </div>

            <div>
                <label for="electricity" class="block text-sm font-medium text-gray-700">Электричество (кВт·ч)</label>
                <input type="number" name="electricity" id="electricity" step="0.01" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('invoices') }}" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-700 transition">Отмена</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-700 transition">Передать показатели</button>
            </div>
        </form>
    </div>
@endsection
