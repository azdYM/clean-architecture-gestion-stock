<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204114351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garantee_attestation DROP CONSTRAINT fk_dc434aa5c28e8258');
        $this->addSql('DROP INDEX uniq_dc434aa5c28e8258');
        $this->addSql('ALTER TABLE garantee_attestation RENAME COLUMN evaluation_service TO evaluation_service_id');
        $this->addSql('ALTER TABLE garantee_attestation ADD CONSTRAINT FK_DC434AA575BEE14 FOREIGN KEY (evaluation_service_id) REFERENCES evaluation_gage_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC434AA575BEE14 ON garantee_attestation (evaluation_service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE garantee_attestation DROP CONSTRAINT FK_DC434AA575BEE14');
        $this->addSql('DROP INDEX UNIQ_DC434AA575BEE14');
        $this->addSql('ALTER TABLE garantee_attestation RENAME COLUMN evaluation_service_id TO evaluation_service');
        $this->addSql('ALTER TABLE garantee_attestation ADD CONSTRAINT fk_dc434aa5c28e8258 FOREIGN KEY (evaluation_service) REFERENCES evaluation_gage_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_dc434aa5c28e8258 ON garantee_attestation (evaluation_service)');
    }
}
