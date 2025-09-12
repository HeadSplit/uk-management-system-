@extends('layouts.index')

@section('title', 'Жильцы')

@section('content')
    <div class="flex flex-col space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">Жильцы</h2>
        </div>


        @if($users->isEmpty())
            <p class="text-gray-600">Жильцов пока нет.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Имя</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Роль</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Дом</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Квартира</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($user->role) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->apartments->pluck('number')->join(', ') ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->apartments->pluck('house.name')->join(', ') ?: '-' }} </td>
                            <td class="px-6 py-4 text-sm text-center space-x-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 transition">Редактировать</a>
                                <form action="{{ route('users.delete', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
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
