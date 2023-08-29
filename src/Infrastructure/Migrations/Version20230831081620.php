<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230831081620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation DROP CONSTRAINT fk_326ec63ffab25dd5');
        $this->addSql('DROP INDEX idx_326ec63ffab25dd5');
        $this->addSql('ALTER TABLE attestation RENAME COLUMN target_credit_id TO credit_type_id');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63FFFC8EBBC FOREIGN KEY (credit_type_id) REFERENCES credit_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_326EC63FFFC8EBBC ON attestation (credit_type_id)');
        $this->addSql('DROP INDEX uniq_af939509ea750e8');
        $this->addSql('ALTER TABLE gage_section DROP label');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gage_section ADD label VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_af939509ea750e8 ON gage_section (label)');
        $this->addSql('ALTER TABLE attestation DROP CONSTRAINT FK_326EC63FFFC8EBBC');
        $this->addSql('DROP INDEX IDX_326EC63FFFC8EBBC');
        $this->addSql('ALTER TABLE attestation RENAME COLUMN credit_type_id TO target_credit_id');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT fk_326ec63ffab25dd5 FOREIGN KEY (target_credit_id) REFERENCES gage_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_326ec63ffab25dd5 ON attestation (target_credit_id)');
    }
}
