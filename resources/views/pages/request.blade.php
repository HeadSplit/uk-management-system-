@extends('layouts.index')

@section('title', 'Просмотр заявки')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Заявка #{{ $request->id }}</h2>

        <div class="space-y-2">
            <p><strong>Жилец:</strong> {{ $request->user->name }}</p>
            <p><strong>Квартира:</strong> {{ $request->apartment->number }} - {{ $request->apartment->house->name ?? '-' }}</p>
            <p><strong>Статус:</strong> {{ ucfirst($request->status) }}</p>
            <p><strong>Описание:</strong> {{ $request->description }}</p>
            <p><strong>Дата создания:</strong> {{ $request->created_at->format('d.m.Y H:i') }}</p>
        </div>

        <hr>

        <h3 class="text-xl font-semibold mb-2">Комментарии</h3>
        @php
            $roles = [
                'resident' => 'Пользователь',
                'employee' => 'Работник',
                'admin' => 'Админ'
            ];
        @endphp
        <div id="comments" class="space-y-2">
            @foreach($request->comments as $comment)
                <div class="border rounded-lg p-3 bg-gray-50">
                    <p class="text-sm text-gray-700">
                        {{ $comment->user?->name }} ({{ $roles[$comment->user?->role] ?? $comment->user?->role }})
                        <span class="text-gray-400 text-xs">({{ $comment->created_at->format('d.m.Y H:i') }})</span>
                    </p>
                    <p class="text-gray-800">{{ $comment->text }}</p>
                </div>
            @endforeach
        </div>

        <form id="commentForm" class="space-y-2">
            @csrf
            <input type="hidden" name="request_id" value="{{ $request->id }}">
            <textarea name="text" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" placeholder="Введите комментарий" required></textarea>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">Добавить комментарий</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('commentForm');
            const commentsDiv = document.getElementById('comments');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const token = document.querySelector('input[name="_token"]').value;

                fetch("{{ route('comments.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            const div = document.createElement('div');
                            div.classList.add('border', 'rounded-lg', 'p-3', 'bg-gray-50');
                            div.innerHTML = `<p class="text-sm text-gray-700">${data.comment.user_name} <span class="text-gray-400 text-xs">(${data.comment.created_at})</span></p>
                                 <p class="text-gray-800">${data.comment.text}</p>`;
                            commentsDiv.appendChild(div);
                            form.reset();
                        } else {
                            alert('Ошибка при добавлении комментария');
                        }
                    })
                    .catch(() => {
                        alert('Ошибка при добавлении комментария');
                    });
            });
        });
    </script>
@endsection
