@extends('layouts.index')

@section('title', 'Заявки')

@section('content')
    <div class="flex flex-col space-y-4">
        <h2 class="text-2xl font-semibold text-gray-800">Список заявок</h2>

        @if($requests->isEmpty())
            <p class="text-gray-600">Заявок пока нет.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Жилец</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Квартира</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Статус</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Дата создания</th>
                        @if(auth()->user()->role !== 'resident')
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Действия</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($requests as $request)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $request->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $request->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $request->apartment->number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($request->status) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $request->created_at->format('d.m.Y') }}</td>
                            @if(auth()->user()->role !== 'resident')
                                <td class="px-6 py-4 text-sm text-center space-x-2">
                                    <a href="{{ route('requests.edit', $request->id) }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 transition">Редактировать</a>
                                    <form action="{{ route('request.delete', $request->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600 transition">Удалить</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
