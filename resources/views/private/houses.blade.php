@extends('layouts.index')

@section('title', 'Дома')

@section('content')
    <div class="flex flex-col space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Дома</h2>

        @if($houses->isEmpty())
            <p class="text-gray-600">Домов пока нет.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Название</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Адрес</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Квартир</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($houses as $house)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $house->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $house->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $house->address }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $house->apartments->count() }}</td>
                            <td class="px-6 py-4 text-sm text-center space-x-2">
                                <a href="{{ route('houses.edit', $house->id) }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 transition">Редактировать</a>
                                <form action="{{ route('houses.delete', $house->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600 transition">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
