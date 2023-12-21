<?php

namespace App\Core\Invoice\Application\DTO;

class InvoiceDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly int $amount
    ) {}
}
