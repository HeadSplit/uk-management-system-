<?php

namespace App\Services;

use App\Models\Apartment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class BillingService
{
    protected array $tariffs = [
        'cold_water' => 30,
        'hot_water' => 60,
        'electricity' => 5,
        'heating' => 25,
        'garbage' => 200,
        'maintenance' => 500,
    ];

    public function createInvoice(int $apartmentId, string $period, array $consumption = []): Invoice
    {
        $apartment = Apartment::findOrFail($apartmentId);

        return DB::transaction(function () use ($apartment, $period, $consumption) {

            $invoice = Invoice::create([
                'apartment_id' => $apartment->id,
                'period' => $period,
                'total_amount' => 0,
                'status' => 'unpaid',
            ]);

            $total = 0;

            $services = [
                'cold_water' => $consumption['cold_water'] ?? 0,
                'hot_water' => $consumption['hot_water'] ?? 0,
                'electricity' => $consumption['electricity'] ?? 0,
                'heating' => $apartment->area ?? 0,
                'garbage' => 1,
                'maintenance' => 1,
            ];

            foreach ($services as $serviceKey => $quantity) {
                $service = Service::where('key', $serviceKey)->first();
                if (!$service) continue;
                $amount = $quantity * $service->tariff;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $service->id,
                    'quantity' => $quantity ?: null,
                    'amount' => $amount,
                ]);

                $total += $amount;
            }

            $invoice->update(['total_amount' => $total]);

            return $invoice;
        });
    }
}
