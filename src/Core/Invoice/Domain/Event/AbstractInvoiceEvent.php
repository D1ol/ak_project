<?php

namespace App\Core\Invoice\Domain\Event;

use App\Common\EventManager\EventInterface;
use App\Core\Invoice\Domain\Invoice;

abstract class AbstractInvoiceEvent implements EventInterface
{
    public function __construct(public Invoice $invoice)
    {
    }
}
