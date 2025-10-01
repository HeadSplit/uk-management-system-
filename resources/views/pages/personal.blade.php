@extends('layouts.index')

@section('title', 'Личный кабинет')

@section('content')
    <div class="flex flex-col space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Личный кабинет</h2>
        </div>
    <div class="space-y-8">
        <!-- Приветствие -->
        <div class="bg-gray-50 border rounded-xl p-6 shadow-sm">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Здравствуйте, {{ auth()->user()->name }} 👋</h2>
            <p class="text-gray-600">Здесь вы можете просмотреть свои счета и историю оплат.</p>
        </div>

        <!-- Актуальные счета -->
        <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Актуальные счета</h3>
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm">
                    <th class="border p-3 text-left">#</th>
                    <th class="border p-3 text-left">Период</th>
                    <th class="border p-3 text-left">Сумма</th>
                    <th class="border p-3 text-left">Статус</th>
                    <th class="border p-3 text-left">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($unpaidInvoices as $invoice)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-3">{{ $invoice->id }}</td>
                        <td class="border p-3">{{ ($invoice->getPeriodText($invoice->created_at))}}</td>
                        <td class="border p-3 font-medium">{{ number_format($invoice->total_amount, 2, ',', ' ') }} ₽</td>
                        <td class="border p-3">
                                <span class="px-2 py-1 rounded-lg text-sm
                                    {{ $invoice->status === 'unpaid' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                    {{ $invoice->status === 'unpaid' ? 'Не оплачено' : 'Оплачено' }}
                                </span>
                        </td>
                        <td class="border p-3">
                            <a href="{{ route('invoices.show', $invoice) }}" class="text-gray-700 hover:underline">Просмотр</a>
                            <a href="{{ route('invoices.download', $invoice) }}" class="ml-3 text-gray-700 hover:underline">PDF</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-500">Нет актуальных счетов</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- История оплат -->
        <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">История оплат</h3>
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm">
                    <th class="border p-3 text-left">#</th>
                    <th class="border p-3 text-left">Период</th>
                    <th class="border p-3 text-left">Сумма</th>
                    <th class="border p-3 text-left">Дата оплаты</th>
                </tr>
                </thead>
                <tbody>
                @forelse($paidInvoices as $invoice)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-3">{{ $invoice->id }}</td>
                        <td class="border p-3">{{ ($invoice->getPeriodText($invoice->created_at))}}}</td>
                        <td class="border p-3 font-medium">{{ number_format($invoice->total_amount, 2, ',', ' ') }} ₽</td>
                        <td class="border p-3">{{ $invoice->paid_at?->format('d.m.Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4 text-gray-500">История пуста</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
