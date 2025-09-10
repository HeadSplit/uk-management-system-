@extends('layouts.index')
@section('content')
    <body class="bg-gray-100">

    <div class="min-h-screen flex flex-col justify-center items-center">
        <h1 class="text-3xl font-bold mb-8">Добро пожаловать в УК</h1>

        <div class="flex space-x-4">
            <button @click="openLogin = true" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Войти</button>
            <button @click="openRegister = true" class="px-6 py-2 bg-green-600 text-white rounded-lg">Регистрация</button>
        </div>
    </div>

    <!-- Контейнер Alpine -->
    <div x-data="{ openLogin: false, openRegister: false }">

        <!-- Модалка входа -->
        <div x-show="openLogin"
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="openLogin = false" class="bg-white p-6 rounded-xl w-96">
                <h2 class="text-xl font-semibold mb-4">Вход</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm">Email</label>
                        <input type="email" name="email" required
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Пароль</label>
                        <input type="password" name="password" required
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="flex items-center mb-3">
                        <input type="checkbox" name="remember_me" id="remember"
                               class="mr-2">
                        <label for="remember">Запомнить меня</label>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Войти</button>
                </form>
            </div>
        </div>

        <!-- Модалка регистрации -->
        <div x-show="openRegister"
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="openRegister = false" class="bg-white p-6 rounded-xl w-96">
                <h2 class="text-xl font-semibold mb-4">Регистрация</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm">Имя</label>
                        <input type="text" name="name" required
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Email</label>
                        <input type="email" name="email" required
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Пароль</label>
                        <input type="password" name="password" required
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
@endsection
