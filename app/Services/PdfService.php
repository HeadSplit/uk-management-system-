<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{

    public function downloadInvoice(Invoice $invoice)
    {
        $invoice->load('items.service');

        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));

        return $pdf->download("invoice_{$invoice->id}.pdf");
    }

}
