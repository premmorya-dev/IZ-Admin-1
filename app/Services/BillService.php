<?php

namespace App\Services;

class BillService extends DocumentService
{
    public function __construct()
    {
        $this->table = 'bills';
        $this->codeField = 'bill_code';
        $this->numberField = 'bill_number';
        $this->dateField = 'bill_date';
        $this->dueField = 'due_date';
        $this->idField = 'bill_id';

        // party config for vendors
        $this->partyTable = 'vendors';
        $this->partyKey = 'vendor_id';
        $this->partyAlias = 'vendor';
    }
}
