<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205070930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit DROP CONSTRAINT fk_1cc16efe7edc5b38');
        $this->addSql('DROP INDEX uniq_1cc16efe7edc5b38');
        $this->addSql('ALTER TABLE credit DROP attestation_id');
        $this->addSql('ALTER TABLE gage_credit ADD attestation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gage_credit ADD CONSTRAINT FK_F4DA49A87EDC5B38 FOREIGN KEY (attestation_id) REFERENCES garantee_attestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F4DA49A87EDC5B38 ON gage_credit (attestation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE credit ADD attestation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT fk_1cc16efe7edc5b38 FOREIGN KEY (attestation_id) REFERENCES garantee_attestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_1cc16efe7edc5b38 ON credit (attestation_id)');
        $this->addSql('ALTER TABLE gage_credit DROP CONSTRAINT FK_F4DA49A87EDC5B38');
        $this->addSql('DROP INDEX UNIQ_F4DA49A87EDC5B38');
        $this->addSql('ALTER TABLE gage_credit DROP attestation_id');
    }
}
