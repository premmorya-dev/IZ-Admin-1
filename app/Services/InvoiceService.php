<?php


namespace App\Services;

class InvoiceService extends DocumentService
{
    public function __construct()
    {
        $this->table = 'invoices';
        $this->codeField = 'invoice_code';
        $this->numberField = 'invoice_number';
        $this->dateField = 'invoice_date';
        $this->dueField = 'due_date';
        $this->idField = 'invoice_id';
    }
}
