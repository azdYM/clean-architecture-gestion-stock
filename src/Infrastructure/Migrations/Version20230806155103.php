<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806155103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE folder_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE portfolio_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE short_term_credit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE folder (id INT NOT NULL, credit_id INT DEFAULT NULL, portfolio_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, folder_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ECA209CDCE062FF9 ON folder (credit_id)');
        $this->addSql('CREATE INDEX IDX_ECA209CDB96B5643 ON folder (portfolio_id)');
        $this->addSql('CREATE TABLE portfolio (id INT NOT NULL, client_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9ED106219EB6921 ON portfolio (client_id)');
        $this->addSql('CREATE TABLE short_term_credit (id INT NOT NULL, capital INT NOT NULL, id_adbanking_fodler INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, duration INT NOT NULL, interest DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE short_term_folder (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDCE062FF9 FOREIGN KEY (credit_id) REFERENCES short_term_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED106219EB6921 FOREIGN KEY (client_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE short_term_folder ADD CONSTRAINT FK_F9F5D537BF396750 FOREIGN KEY (id) REFERENCES folder (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE collateral_garantee ADD folder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE collateral_garantee ADD CONSTRAINT FK_E73D794D162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E73D794D162CB942 ON collateral_garantee (folder_id)');
        $this->addSql('ALTER TABLE corporate ADD folio INT NOT NULL');
        $this->addSql('ALTER TABLE corporate RENAME COLUMN member_ship_at TO membership_at');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F33D7A29BEA0CC6 ON corporate (folio)');
        $this->addSql('ALTER TABLE individual ADD folio INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8793FC179BEA0CC6 ON individual (folio)');
        $this->addSql('DROP INDEX uniq_34dcd1769bea0cc6');
        $this->addSql('ALTER TABLE person DROP folio');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE collateral_garantee DROP CONSTRAINT FK_E73D794D162CB942');
        $this->addSql('DROP SEQUENCE folder_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE portfolio_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE short_term_credit_id_seq CASCADE');
        $this->addSql('ALTER TABLE folder DROP CONSTRAINT FK_ECA209CDCE062FF9');
        $this->addSql('ALTER TABLE folder DROP CONSTRAINT FK_ECA209CDB96B5643');
        $this->addSql('ALTER TABLE portfolio DROP CONSTRAINT FK_A9ED106219EB6921');
        $this->addSql('ALTER TABLE short_term_folder DROP CONSTRAINT FK_F9F5D537BF396750');
        $this->addSql('DROP TABLE folder');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE short_term_credit');
        $this->addSql('DROP TABLE short_term_folder');
        $this->addSql('ALTER TABLE person ADD folio INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_34dcd1769bea0cc6 ON person (folio)');
        $this->addSql('DROP INDEX UNIQ_1F33D7A29BEA0CC6');
        $this->addSql('ALTER TABLE corporate DROP folio');
        $this->addSql('ALTER TABLE corporate RENAME COLUMN membership_at TO member_ship_at');
        $this->addSql('DROP INDEX UNIQ_8793FC179BEA0CC6');
        $this->addSql('ALTER TABLE individual DROP folio');
        $this->addSql('DROP INDEX IDX_E73D794D162CB942');
        $this->addSql('ALTER TABLE collateral_garantee DROP folder_id');
    }
}
