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
        return view('private.invoice.show', compact('invoice'));
    }

    public function createInvoice(int $apartmentId, string $period): RedirectResponse
    {
        try {
            $this->billingService->createInvoice($apartmentId, $period);
            NotificationHelper::flash('Счет успешно создан');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось создать счет', 'error');
        }

        return redirect()->back();
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
