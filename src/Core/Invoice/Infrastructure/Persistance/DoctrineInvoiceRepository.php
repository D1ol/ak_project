<?php

namespace App\Core\Invoice\Infrastructure\Persistance;

use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\Invoice\Domain\Status\InvoiceStatus;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class DoctrineInvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function getInvoicesWithGreaterAmountAndStatus(int $amount, InvoiceStatus $invoiceStatus): array
    {
        $qb = $this->entityManager->createQueryBuilder();


        return $qb
            ->select('i')
            ->from(Invoice::class, 'i')
            ->andWhere($qb->expr()->eq('i.status', ':invoice_status'))
            ->andWhere($qb->expr()->gt('i.amount', ':invoice_amount'))
            ->setParameter(':invoice_amount', $amount)
            ->setParameter(':invoice_status', $invoiceStatus)
            ->getQuery()
            ->getResult();
    }

    public function save(Invoice $invoice): void
    {
        $this->entityManager->persist($invoice);

        $events = $invoice->pullEvents();
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
