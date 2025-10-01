<?php

namespace App\Http\Controllers\Private;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\BillingService;
use App\Services\PdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    protected BillingService $billingService;
    protected PdfService $pdfService;

    public function __construct(BillingService $billingService, PdfService $pdfService)
    {
        $this->billingService = $billingService;
        $this->pdfService = $pdfService;
    }

    public function index(Request $request): View
    {
        $invoices = Invoice::all();
        return view('private.invoice.index', compact('invoices'));
    }

    public function show(Invoice $invoice): View
    {
        $items = $invoice->load('items.service');
        return view('pages.invoices', compact('invoice'));
    }

    public function createInvoice(Request $request, int $apartmentId): RedirectResponse
    {
        $period = $request->input('period', now()->format('Y-m'));

        $consumption = [
            'cold_water'  => $request->input('cold_water', 0),
            'hot_water'   => $request->input('hot_water', 0),
            'electricity' => $request->input('electricity', 0),
        ];

        try {
            $this->billingService->createInvoice($apartmentId, $period, $consumption);
            NotificationHelper::flash('Счет успешно создан');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось создать счет: ' . $exception->getMessage(), 'error');
        }

        return redirect()->route('invoices');
    }


    public function downloadPdf(Invoice $invoice)
    {
        try {
            return $this->pdfService->downloadInvoice($invoice);
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось скачать PDF', 'error');
            return redirect()->back();
        }
    }

    public function edit(Invoice $invoice): View
    {
        try {
            $invoice->load('items.service', 'apartment.house');
            return view('edit.invoices', compact('invoice'));
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось загрузить счет', 'error');
            return redirect()->route('invoices');
        }
    }

    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $invoice->load('items.service', 'apartment.house');

        try {
            $invoice->update([
                'status' => $request->input('status'),
            ]);

            if ($request->has('items')) {
                foreach ($request->input('items') as $itemId => $itemData) {
                    $invoiceItem = $invoice->items()->find($itemId);
                    if ($invoiceItem) {
                        $invoiceItem->update([
                            'quantity' => $itemData['quantity'],
                            'amount'   => $itemData['quantity'] * ($invoiceItem->service->price ?? 0),
                        ]);
                    }
                }
            }

            NotificationHelper::flash('Счет успешно обновлен');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось обновить счет', 'error');
        }

        return redirect()->route('invoices.show', $invoice);
    }


    public function destroy(Invoice $invoice): RedirectResponse
    {
        try {
            $invoice->delete();
            NotificationHelper::flash('Счет успешно удален');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось удалить счет', 'error');
        }

        return redirect()->route('invoices');
    }

}

