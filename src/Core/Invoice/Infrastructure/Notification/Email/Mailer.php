<?php

namespace App\Core\Invoice\Infrastructure\Notification\Email;

use App\Common\Mailer\SMPTMailer;
use App\Core\Invoice\Domain\Notification\NotificationInterface;

class Mailer implements NotificationInterface
{
    public function __construct(private readonly SMPTMailer $SMPTMailer)
    {
    }


    public function sendEmail(string $recipient, string $subject, string $message): void
    {
        $this->SMPTMailer->send($recipient, $subject, $message);
    }
}
