<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230811142819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F33D7A2F45607D0 ON corporate (comericial_registry)');
        $this->addSql('ALTER TABLE employee ADD username VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE employee ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_1F33D7A2F45607D0');
        $this->addSql('ALTER TABLE employee DROP username');
        $this->addSql('ALTER TABLE employee DROP created_at');
    }
}
