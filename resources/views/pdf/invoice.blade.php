<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Счет #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827; /* почти чёрный */
            background: #fff;
            line-height: 1.6;
            padding: 30px;
        }

        .company {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 35px;
            letter-spacing: 0.5px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header div {
            margin-bottom: 6px;
            font-size: 12px;
        }

        .status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid #d1d5db;
        }
        .status.paid {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }
        .status.unpaid {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }

        th {
            text-align: left;
            padding: 8px 0;
            font-weight: 600;
            border-bottom: 1px solid #d1d5db;
        }

        td {
            padding: 6px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .summary {
            margin-top: 25px;
            font-size: 14px;
            font-weight: bold;
            text-align: right;
            padding-top: 10px;
            border-top: 1px solid #d1d5db;
        }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="company">
    Управляющая компания «Комфорт»
</div>

<div class="header">
    <div><strong>Счет №:</strong> {{ $invoice->id }}</div>
    <div><strong>Квартира:</strong> {{ $invoice->apartment->number ?? '-' }}</div>
    <div><strong>Дом:</strong> {{ $invoice->apartment->house->name ?? '-' }}</div>
    <div><strong>Период:</strong> {{ $invoice->getPeriodText($invoice->created_at) }}</div>
    <div>
        <strong>Статус:</strong>
        <span class="status {{ $invoice->status === 'paid' ? 'paid' : 'unpaid' }}">
            {{ $invoice->status === 'paid' ? 'Оплачен' : 'Не оплачен' }}
        </span>
    </div>
</div>

@if($invoice->items->isEmpty())
    <p>Нет позиций.</p>
@else
    <table>
        <thead>
        <tr>
            <th class="text-center">№</th>
            <th>Услуга</th>
            <th class="text-center">Ед. изм.</th>
            <th class="text-center">Объем</th>
            <th class="text-right">Тариф (₽)</th>
            <th class="text-right">Сумма (₽)</th>
        </tr>
        </thead>
        <tbody>
        @php $total = 0; @endphp
        @foreach($invoice->items as $index => $item)
            @php
                $amount = $item->quantity * $item->service->price;
                $total += $amount;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->service->name ?? '-' }}</td>
                <td class="text-center">{{ $item->service->unit ?? '-' }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->service->price, 4, '.', ' ') }}</td>
                <td class="text-right">{{ number_format($amount, 2, '.', ' ') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="summary">
        Итого: {{ number_format($total, 2, '.', ' ') }} ₽
    </div>
@endif

<div class="footer">
    Этот счет сформирован автоматически системой «Комфорт».
    Для оплаты используйте реквизиты, указанные в личном кабинете.
</div>
</body>
</html>
