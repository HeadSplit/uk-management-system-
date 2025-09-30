@extends('layouts.index')

@section('title', 'Детали счета')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6 space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Счет #{{ $invoice->id }}</h2>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p><strong>Квартира:</strong> {{ $invoice->apartment->number ?? '-' }}</p>
                <p><strong>Дом:</strong> {{ $invoice->apartment->house->name ?? '-' }}</p>
            </div>
            <div>
                <p><strong>Период:</strong> {{ $invoice->period }}</p>
                <p>
                    <strong>Статус:</strong>
                    @if($invoice->status === 'paid')
                        <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs font-semibold">Оплачен</span>
                    @else
                        <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs font-semibold">Не оплачен</span>
                    @endif
                </p>
            </div>
        </div>

        <h3 class="text-xl font-semibold mt-4 mb-2">Позиции</h3>
        @if($invoice->items->isEmpty())
            <p class="text-gray-500">Нет позиций.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Название</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Количество</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Сумма</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($invoice->items as $item)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->quantity ?? 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($item->amount, 2, '.', ' ') }} ₽</td>
                        </tr>
                    @endforeach
                    <tr class="font-semibold bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-700">Итого</td>
                        <td></td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($invoice->total_amount, 2, '.', ' ') }} ₽</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endif

        <div class="flex justify-end mt-6 space-x-2">
            <a href="{{ route('invoices') }}" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">Назад</a>
            <a href="{{ route('invoices.download', $invoice) }}" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">Скачать PDF</a>
        </div>
    </div>
@endsection
