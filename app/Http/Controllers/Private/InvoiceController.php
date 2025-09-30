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
        $invoice->load('items');
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


    public function downloadPdf(Invoice $invoice): RedirectResponse
    {
        try {
            return $this->pdfService->downloadInvoice($invoice);
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось скачать PDF', 'error');
            return redirect()->back();
        }
    }
}
