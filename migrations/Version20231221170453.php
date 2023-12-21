<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231221170453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Extra active field';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD active TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP active');
    }
}
