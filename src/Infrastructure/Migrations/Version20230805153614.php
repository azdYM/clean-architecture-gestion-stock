<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805153614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE cash_garantee_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE collateral_garantee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE gold_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE collateral_garantee (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE gold (id INT NOT NULL, collateral_garnatee_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, quantity INT DEFAULT 1 NOT NULL, carrat INT NOT NULL, unit_price INT NOT NULL, weight INT NOT NULL, value INT NOT NULL, description TEXT DEFAULT NULL, validated BOOLEAN DEFAULT false NOT NULL, validated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47A91D5197FE37AF ON gold (collateral_garnatee_id)');
        $this->addSql('ALTER TABLE gold ADD CONSTRAINT FK_47A91D5197FE37AF FOREIGN KEY (collateral_garnatee_id) REFERENCES collateral_garantee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE cash_garantee');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE collateral_garantee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE gold_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE cash_garantee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cash_garantee (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE gold DROP CONSTRAINT FK_47A91D5197FE37AF');
        $this->addSql('DROP TABLE collateral_garantee');
        $this->addSql('DROP TABLE gold');
    }
}
