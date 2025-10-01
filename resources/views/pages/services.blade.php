@extends('layouts.index')

@section('title', 'Услуги')

@section('content')
    <div class="flex flex-col space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Услуги</h2>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('services.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
                    Добавить услугу
                </a>
            @endif
        </div>

        @if($services->isEmpty())
            <p class="text-gray-600">Услуг пока нет.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Название</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Ед. измерения</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Цена</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($services as $service)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $service->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $service->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $service->unit }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($service->price, 2, '.', ' ') }} ₽</td>
                            <td class="px-6 py-4 text-sm text-center space-x-2">
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('services.edit', $service->id) }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 transition">Редактировать</a>
                                    <form action="{{ route('services.delete', $service->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600 transition">Удалить</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
