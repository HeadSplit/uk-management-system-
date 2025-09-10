<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Управляющая компания')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Шапка -->
<header class="bg-blue-700 text-white shadow-lg">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <h1 class="text-2xl font-bold">УК "Комфорт"</h1>
        <nav class="space-x-6">
            <a href="{{ route('index') }}" class="hover:text-gray-200">Главная</a>
            <a href="#" class="hover:text-gray-200">О компании</a>
            <a href="#" class="hover:text-gray-200">Контакты</a>
        </nav>
    </div>
</header>

<!-- Контейнер -->
<div class="flex flex-1">
    <!-- Боковое меню -->
    <aside class="w-64 bg-white border-r shadow-md hidden md:block">
        <nav class="p-4 space-y-2">
            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🏠 Дома</a>
            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🏢 Квартиры</a>
            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-100">👥 Жильцы</a>
            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-100">📑 Счета</a>
            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🛠️ Заявки</a>
        </nav>
    </aside>

    <!-- Контент -->
    <main class="flex-1 p-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold mb-4">@yield('title', 'Панель управления')</h2>
            @yield('content')
        </div>
    </main>
</div>

<!-- Подвал -->
<footer class="bg-blue-700 text-white py-4 mt-auto">
    <div class="container mx-auto text-center">
        © {{ date('Y') }} УК "Комфорт". Все права защищены.
    </div>
</footer>

</body>
</html>
