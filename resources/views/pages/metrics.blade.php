@extends('layouts.index')

@section('title', 'Передать показатели')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-semibold mb-6">Передать показатели</h2>

        <form action="{{ route('apartments.send-metrics', $apartment->id) }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="period" class="block text-sm font-medium text-gray-700">Период</label>
                <input type="month" name="period" id="period"
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required>
            </div>

            @foreach($services as $service)
                <div>
                    <label for="service_{{ $service->id }}" class="block text-sm font-medium text-gray-700">
                        {{ $service->name }} ({{ $service->unit }})
                    </label>
                    <input type="number" step="0.01" name="services[{{ $service->id }}]" id="service_{{ $service->id }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
                </div>
            @endforeach

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('invoices') }}"
                   class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Отмена</a>
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900 transition">
                    Передать показатели
                </button>
            </div>
        </form>
    </div>
@endsection
