<?php

namespace App\Services;

use App\Models\Apartment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
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
                'total' => 0,
            ]);

            $total = 0;

            $charges = [];

            $cold = ($consumption['cold_water'] ?? 0) * $this->tariffs['cold_water'];
            $hot = ($consumption['hot_water'] ?? 0) * $this->tariffs['hot_water'];
            $charges[] = ['name' => 'Холодная вода', 'amount' => $cold];
            $charges[] = ['name' => 'Горячая вода', 'amount' => $hot];

            $elec = ($consumption['electricity'] ?? 0) * $this->tariffs['electricity'];
            $charges[] = ['name' => 'Электричество', 'amount' => $elec];

            $heating = ($apartment->area ?? 50) * $this->tariffs['heating'];
            $charges[] = ['name' => 'Отопление', 'amount' => $heating];

            $charges[] = ['name' => 'Вывоз мусора', 'amount' => $this->tariffs['garbage']];
            $charges[] = ['name' => 'Содержание квартиры', 'amount' => $this->tariffs['maintenance']];

            foreach ($charges as $charge) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'name' => $charge['name'],
                    'amount' => $charge['amount'],
                ]);
                $total += $charge['amount'];
            }

            $invoice->update(['total' => $total]);

            return $invoice;
        });
    }
}
