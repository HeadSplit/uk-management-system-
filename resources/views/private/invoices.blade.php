@extends('layouts.index')

@section('title', 'Счета')

@section('content')
    <div class="flex flex-col space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Ваши счета</h2>
        </div>

        @if($invoices->isEmpty())
            <p class="text-gray-600">Счетов пока нет.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Период</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Сумма</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Статус</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($invoices as $invoice)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $invoice->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $invoice->period }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($invoice->amount, 2, '.', ' ') }} ₽</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($invoice->status === 'paid')
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs font-semibold">Оплачен</span>
                                @else
                                    <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs font-semibold">Не оплачен</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 space-x-2">
                                <a href="{{ route('invoices.download', $invoice) }}"
                                   class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
                                    Скачать PDF
                                </a>
                                @if(auth()->user()->role == 'employee' || auth()->user()->role == 'admin')
                                    <a href="{{ route('invoices.delete', $invoice->apartment_id) }}"
                                       class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
                                        Удалить
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
