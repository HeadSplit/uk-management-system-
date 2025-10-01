@extends('layouts.index')

@section('title', 'Редактирование заявки')

@section('content')
    <div class="max-w-4xl mx-auto flex flex-col space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Заявка #{{ $requestModel->id }}</h2>

        <div class="bg-white rounded-xl shadow p-6 space-y-4">
            <p><strong>Жилец:</strong> {{ $requestModel->user?->name }}</p>
            <p><strong>Дом:</strong> {{ $requestModel->apartment->house->name ?? '-' }}</p>
            <p><strong>Квартира:</strong> {{ $requestModel->apartment->number ?? '-' }}</p>

            <form action="{{ route('requests.update', $requestModel->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                    <select name="status" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300">
                        <option value="new" @if($requestModel->status == 'new') selected @endif>Новая</option>
                        <option value="in_progress" @if($requestModel->status == 'in_progress') selected @endif>В работе</option>
                        <option value="done" @if($requestModel->status == 'done') selected @endif>Выполнена</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('requests') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Отмена</a>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Сохранить</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow p-6 space-y-4">
            <h3 class="text-xl font-semibold mb-2">Комментарии</h3>

            @php
                $roles = ['resident' => 'Пользователь', 'employee' => 'Работник', 'admin' => 'Админ'];
            @endphp

            <div id="commentsList" class="space-y-2">
                @foreach($requestModel->comments as $comment)
                    <div class="border rounded-lg p-3 bg-gray-50">
                        <p class="text-sm text-gray-700">
                            {{ $comment->user?->name }} ({{ $roles[$comment->user?->role] ?? $comment->user?->role }})
                            <span class="text-gray-400 text-xs">({{ $comment->created_at->format('d.m.Y H:i') }})</span>
                        </p>
                        <p class="text-gray-800">{{ $comment->text }}</p>
                    </div>
                @endforeach
            </div>

            <form id="addCommentForm" class="space-y-2">
                @csrf
                <input type="hidden" name="request_id" value="{{ $requestModel->id }}">
                <textarea name="text" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" placeholder="Напишите комментарий..." required></textarea>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Добавить комментарий</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('addCommentForm');
            const commentsList = document.getElementById('commentsList');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);

                fetch("{{ route('comments.store') }}", {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': form.querySelector('[name=_token]').value},
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            const roles = {'resident':'Пользователь','employee':'Работник','admin':'Админ'};
                            const commentDiv = document.createElement('div');
                            commentDiv.classList.add('border', 'rounded-lg', 'p-3', 'bg-gray-50');
                            commentDiv.innerHTML = `
                    <p class="text-sm text-gray-700">
                        ${data.comment.user_name} (${roles[data.comment.user_role] || data.comment.user_role})
                        <span class="text-gray-400 text-xs">(${data.comment.created_at})</span>
                    </p>
                    <p class="text-gray-800">${data.comment.text}</p>
                `;
                            commentsList.appendChild(commentDiv);
                            form.reset();
                        }
                    });
            });
        });
    </script>
@endsection
