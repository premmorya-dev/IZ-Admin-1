<?php


namespace App\Services;

class EstimateService extends DocumentService
{
    public function __construct()
    {
        $this->table = 'estimates';
        $this->codeField = 'estimate_code';
        $this->numberField = 'estimate_number';
        $this->dateField = 'issue_date';
        $this->dueField = 'expiry_date';
        $this->idField = 'estimate_id';
    }
}
