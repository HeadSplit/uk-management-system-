@extends('layouts.index')

@section('title', 'Контакты')

@section('content')
    <div class="flex flex-col space-y-8">
        <h2 class="text-2xl font-semibold text-gray-800">Контакты</h2>

        <div class="bg-white rounded-xl shadow p-6 space-y-4">
            <p>Если у вас есть вопросы или предложения, вы можете связаться с нами напрямую:</p>

            <a href="https://t.me/Cat_Semyon" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 240 240">
                    <path d="M120,0C53.73,0,0,53.73,0,120s53.73,120,120,120s120-53.73,120-120S186.27,0,120,0z M175.17,78.61l-18.14,85.73 c-1.37,6.15-4.93,7.72-9.97,4.81l-27.55-20.29l-13.3,12.78c-1.46,1.46-2.69,2.69-5.5,2.69l1.97-27.79l50.61-45.71 c2.2-1.97-0.48-3.08-3.39-1.11l-62.63,39.45l-27-8.44c-5.83-1.82-5.95-5.83,1.22-8.64L168.13,76.1 C173.16,75.06,176.33,76.1,175.17,78.61z"/>
                </svg>
                @Cat_Semyon
            </a>
        </div>
    </div>
@endsection
