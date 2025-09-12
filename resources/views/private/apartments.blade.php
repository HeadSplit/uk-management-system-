@extends('layouts.index')

@section('title', 'Квартиры')

@section('content')
    <div class="flex flex-col space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Квартиры</h2>

        @if($apartments->isEmpty())
            <p class="text-gray-600">Квартир пока нет.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Номер</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Дом</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Жильцы</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($apartments as $apartment)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $apartment->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $apartment->number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $apartment->house->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $apartment->user->count() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
