@extends('layouts.index')

@section('title', 'Квартиры')

@section('content')
    <div class="flex flex-col space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Квартиры</h2>
            @if(auth()->user()->role == 'employee' || auth()->user()->role == 'admin')
                <a href="{{ route('apartments.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
                    Добавить квартиру
                </a>
            @endif
        </div>

        @if($apartments->isEmpty())
            <p class="text-gray-600">Квартир пока нет.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Номер</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Этаж</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Дом</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Жильцы</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Площадь</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($apartments as $apartment)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $apartment->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $apartment->floor }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $apartment->number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $apartment->house->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($apartment->residents)
                                    @foreach($apartment->residentsUsers() as $resident)
                                        <div>{{ $resident->name }} ({{ $resident->email }})</div>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $apartment->area ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <div class="flex flex-wrap justify-center gap-2">
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('apartments.edit', $apartment->id) }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 transition">Редактировать</a>
                                        <form action="{{ route('apartments.delete', $apartment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600 transition">Удалить</button>
                                        </form>
                                    @endif

                                    @if($apartment->user_id || auth()->user()->role == 'admin')
                                        <button class="px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-700 add-resident-btn"
                                                data-apartment-id="{{ $apartment->id }}"
                                                data-residents='@json($apartment->residents ?? [])'>
                                            Добавить жильца
                                        </button>

                                        <a href="{{ route('apartments.send-metrics', $apartment->id) }}" class="px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-700">
                                            Передать показатели
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div id="addResidentModal" style="display:none;" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-xl p-6 w-96 relative">
            <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            <h3 class="text-xl font-semibold mb-4">Добавить жильца</h3>
            <form id="addResidentForm" action="{{ route('apartments.storeResident') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="apartment_id" id="modalApartmentId">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Выберите пользователя</label>
                    <select name="user_id" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-gray-300" required></select>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" id="cancelModal" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Отмена</button>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Добавить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('addResidentModal');
            const modalApartmentId = document.getElementById('modalApartmentId');
            const select = modal.querySelector('select[name="user_id"]');
            const closeModal = document.getElementById('closeModal');
            const cancelModal = document.getElementById('cancelModal');

            const users = @json($users);

            document.querySelectorAll('.add-resident-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const apartmentId = button.dataset.apartmentId;
                    const apartmentResidents = (JSON.parse(button.dataset.residents) || []).map(Number);

                    modalApartmentId.value = apartmentId;
                    select.innerHTML = '';

                    users.forEach(user => {
                        if (!apartmentResidents.includes(user.id)) {
                            const option = document.createElement('option');
                            option.value = user.id;
                            option.textContent = `${user.name} (${user.email})`;
                            select.appendChild(option);
                        }
                    });

                    if (select.options.length === 0) {
                        const option = document.createElement('option');
                        option.textContent = 'Нет доступных пользователей';
                        option.disabled = true;
                        select.appendChild(option);
                    }

                    modal.style.display = 'flex';
                });
            });

            closeModal.addEventListener('click', () => modal.style.display = 'none');
            cancelModal.addEventListener('click', () => modal.style.display = 'none');
            window.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });
        });
    </script>
@endsection
