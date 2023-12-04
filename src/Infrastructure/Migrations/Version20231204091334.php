<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204091334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garantee_attestation ADD evaluation_service INT DEFAULT NULL');
        $this->addSql('ALTER TABLE garantee_attestation ADD CONSTRAINT FK_DC434AA5C28E8258 FOREIGN KEY (evaluation_service) REFERENCES evaluation_gage_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC434AA5C28E8258 ON garantee_attestation (evaluation_service)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE garantee_attestation DROP CONSTRAINT FK_DC434AA5C28E8258');
        $this->addSql('DROP INDEX UNIQ_DC434AA5C28E8258');
        $this->addSql('ALTER TABLE garantee_attestation DROP evaluation_service');
    }
}
