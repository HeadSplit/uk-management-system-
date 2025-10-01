<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Управляющая компания')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex flex-col font-sans text-gray-800">

<!-- Шапка -->
<header class="bg-white/90 backdrop-blur-md border-b shadow-sm">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <a href="{{route('index')}}">
            <h1 class="text-2xl font-bold tracking-wide text-gray-700">УК "Комфорт"</h1>
        </a>
        <div class="space-x-4 flex items-center">
            <a href="{{ route('index') }}" class="hover:text-gray-600 transition">Главная</a>
            <a href="{{route('about')}}" class="hover:text-gray-600 transition">О компании</a>
            <a href="{{route('contact')}}" class="hover:text-gray-600 transition">Контакты</a>
            @guest()
                <button onclick="openModal('loginModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl shadow hover:bg-gray-300 transition">Вход</button>
                <button onclick="openModal('registerModal')" class="bg-gray-800 text-white px-4 py-2 rounded-xl shadow hover:bg-gray-900 transition">Регистрация</button>
            @endguest
            @auth
                <a href="{{route('personal')}}" class="hover:text-gray-600">Личный кабинет</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
                        Выйти
                    </button>
                </form>

            @endauth
        </div>
    </div>
</header>
<!-- Flash уведомления -->
@if(session('flash_message'))
    <div id="flashMessage" class="fixed top-24 right-6 z-50 w-96 p-4 rounded-lg shadow-md text-white
        {{ session('flash_type') === 'error' ? 'bg-red-500' : 'bg-green-500' }} transition-all duration-500">
        {{ session('flash_message') }}
    </div>
    <script>
        setTimeout(() => {
            const msg = document.getElementById('flashMessage');
            if(msg){
                msg.classList.add('opacity-0', 'translate-y-[-20px]');
                setTimeout(() => msg.remove(), 500);
            }
        }, 4000);
    </script>
@endif
<div class="flex flex-1">
    <!-- Боковое меню -->
    <aside class="w-64 bg-white border-r shadow-sm hidden md:block">
        <nav class="p-6 space-y-3">
            @if(auth()->check() && in_array(auth()->user()->role, ['employee', 'admin']))
                <a href="{{route('users')}}" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">👥 Жильцы</a>
            @endif
            @if(auth()->check())
                    <a href="{{route('apartments')}}" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">🏢 Квартиры</a>
                <a href="{{route('apartments')}}" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">🏢 Квартиры</a>
                <a href="{{route('invoices')}}" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">📑 Счета</a>
                <a href="{{route('requests')}}" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">🛠️ Заявки</a>
                    <a href="{{route('services')}}" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">⚙️ Услуги</a>
            @endif
        </nav>
    </aside>


    <!-- Контент -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>
</div>

<!-- Подвал -->
<footer class="bg-white border-t py-5 mt-auto shadow-sm">
    <div class="container mx-auto text-center text-sm text-gray-500">
        © {{ date('Y') }} УК "Комфорт". Все права защищены.
    </div>
</footer>

<!-- Модалка -->
<div id="modalBackdrop" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center transition-opacity duration-300 z-50">
    <div id="modalContent" class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform scale-90 opacity-0 transition-all duration-300">
    </div>
</div>

<script>
    const modalBackdrop = document.getElementById('modalBackdrop');
    const modalContent = document.getElementById('modalContent');

    function openModal(type) {
        let html = '';
        if (type === 'loginModal') {
            html = `
                <h2 class="text-xl font-bold mb-4 text-gray-700">Вход</h2>
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
            <div>
                <label class="block text-sm text-gray-600">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-gray-300" required>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Пароль</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-gray-300" required>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="remember_me" id="remember" class="mr-2">
                <label for="remember" class="text-sm text-gray-600">Запомнить меня</label>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">Отмена</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900 transition">Войти</button>
            </div>
        </form>
`;
        } else if (type === 'registerModal') {
            html = `
                <h2 class="text-xl font-bold mb-4 text-gray-700">Регистрация</h2>
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
            <div>
                <label class="block text-sm text-gray-600">Имя</label>
                <input type="text" name="name" class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-gray-300" required>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-gray-300" required>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Пароль</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-gray-300" required>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-gray-300" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">Отмена</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900 transition">Зарегистрироваться</button>
            </div>
        </form>
`;
        }
        modalContent.innerHTML = html;
        modalBackdrop.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-90', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function closeModal() {
        modalContent.classList.add('scale-90', 'opacity-0');
        setTimeout(() => {
            modalBackdrop.classList.add('hidden');
        }, 200);
    }

    modalBackdrop.addEventListener('click', (e) => {
        if (e.target === modalBackdrop) closeModal();
    });
</script>

</body>
</html>
