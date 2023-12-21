<?php

namespace App\Core\Invoice\Application\EventListener;

use App\Core\Invoice\Domain\Event\InvoiceCreatedEvent;
use App\Core\Invoice\Domain\Notification\NotificationInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendEmailInvoiceCreatedEventSubscriberListener implements EventSubscriberInterface
{
    public function __construct(private readonly NotificationInterface $mailer)
    {
    }

    public function send(InvoiceCreatedEvent $event): void
    {
        $this->mailer->sendEmail(
            $event->invoice->getUser()->getEmail(),
            'Utworzono fakturę',
            'Dla twojego konta została wystawiona faktura'
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            InvoiceCreatedEvent::class => 'send'
        ];
    }
}
