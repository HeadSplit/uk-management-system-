@extends('layouts.index')
@section('content')

    <!-- Слайдер -->
    <div class="bg-white rounded-2xl shadow p-8">
        <div class="relative w-full overflow-hidden rounded-2xl shadow-lg mb-6">
            <div id="homeSwiper" class="flex transition-transform duration-700 ease-in-out">
                <div class="flex-shrink-0 w-full relative">
                    <img src="{{asset('images/house1.png')}}" alt="Дом 1" class="w-full h-64 object-cover rounded-2xl">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <h2 class="text-3xl text-white font-bold text-center px-4">Ваш комфорт — наша забота</h2>
                    </div>
                </div>
                <div class="flex-shrink-0 w-full relative">
                    <img src="{{asset('images/house2.png')}}" alt="Дом 2" class="w-full h-64 object-cover rounded-2xl">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <h2 class="text-3xl text-white font-bold text-center px-4">Уютные квартиры для вашей семьи</h2>
                    </div>
                </div>
                <div class="flex-shrink-0 w-full relative">
                    <img src="{{asset('images/house3.png')}}" alt="Дом 3" class="w-full h-64 object-cover rounded-2xl">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <h2 class="text-3xl text-white font-bold text-center px-4">Пространство для жизни и отдыха</h2>
                    </div>
                </div>
            </div>

            <!-- Навигация (стрелки) -->
            <button id="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 bg-gray-100/70 hover:bg-gray-200 rounded-full p-2 shadow">❮</button>
            <button id="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 bg-gray-100/70 hover:bg-gray-200 rounded-full p-2 shadow">❯</button>
        </div>

        <script>
            const swiper = document.getElementById('homeSwiper');
            const slides = swiper.children;
            let index = 0;
            const total = slides.length;

            function showSlide(i) {
                swiper.style.transform = `translateX(-${i * 100}%)`;
            }

            function nextSlide() {
                index = (index + 1) % total;
                showSlide(index);
            }

            function prevSlide() {
                index = (index - 1 + total) % total;
                showSlide(index);
            }

            document.getElementById('nextSlide').addEventListener('click', nextSlide);
            document.getElementById('prevSlide').addEventListener('click', prevSlide);

            setInterval(nextSlide, 5000);
        </script>

        <!-- Блок под слайдером -->
        <div class="bg-gray-50 rounded-xl shadow p-6 mt-6 text-center">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Добро пожаловать в УК "Комфорт"</h3>
            <p class="text-gray-600 max-w-2xl mx-auto">
                УК “Комфорт” заботится о вашем доме и квартире. Уют, порядок и надёжность — наша главная цель.
                Мы делаем жизнь жильцов проще и комфортнее каждый день.
            </p>
        </div>

        <!-- Блок "О нас" -->
        <div class="mt-10 bg-gray-50 rounded-xl shadow p-6 max-w-4xl mx-auto text-center">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Немного о компании</h3>
            <p class="text-gray-600 text-lg leading-relaxed">
                УК "Комфорт" работает на рынке недвижимости более 10 лет, обеспечивая жильцам
                надежное и качественное обслуживание домов и квартир. Мы заботимся о комфорте,
                безопасности и уюте каждого жителя, постоянно улучшая наши услуги и внедряя
                современные технологии управления жилыми комплексами.
            </p>
        </div>

    </div>
@endsection
