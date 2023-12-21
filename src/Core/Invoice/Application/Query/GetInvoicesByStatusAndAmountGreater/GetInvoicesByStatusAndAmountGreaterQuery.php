<?php

namespace App\Core\Invoice\Application\Query\GetInvoicesByStatusAndAmountGreater;

class GetInvoicesByStatusAndAmountGreaterQuery
{
    public function __construct(public readonly int $amount)
    {
    }
}
