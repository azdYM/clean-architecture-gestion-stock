<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204145417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit_folder ADD mounting_folder_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE credit_folder ADD CONSTRAINT FK_DD94E8ACE461BA52 FOREIGN KEY (mounting_folder_service_id) REFERENCES mounting_credit_folder_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DD94E8ACE461BA52 ON credit_folder (mounting_folder_service_id)');
        $this->addSql('ALTER TABLE gage_folder DROP CONSTRAINT fk_4b92e9be461ba52');
        $this->addSql('DROP INDEX idx_4b92e9be461ba52');
        $this->addSql('ALTER TABLE gage_folder DROP mounting_folder_service_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE credit_folder DROP CONSTRAINT FK_DD94E8ACE461BA52');
        $this->addSql('DROP INDEX IDX_DD94E8ACE461BA52');
        $this->addSql('ALTER TABLE credit_folder DROP mounting_folder_service_id');
        $this->addSql('ALTER TABLE gage_folder ADD mounting_folder_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gage_folder ADD CONSTRAINT fk_4b92e9be461ba52 FOREIGN KEY (mounting_folder_service_id) REFERENCES mounting_credit_folder_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4b92e9be461ba52 ON gage_folder (mounting_folder_service_id)');
    }
}
