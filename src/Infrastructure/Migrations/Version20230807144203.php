<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230807144203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE short_term_folder DROP CONSTRAINT fk_f9f5d537bf396750');
        $this->addSql('ALTER TABLE collateral_garantee DROP CONSTRAINT fk_e73d794d162cb942');
        $this->addSql('DROP SEQUENCE folder_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE short_term_credit_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contract_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE credit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parameter_in_description_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE short_term_folder_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE signature_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, title INT NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contract (id INT NOT NULL, credit_id INT DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E98F2859CE062FF9 ON contract (credit_id)');
        $this->addSql('CREATE TABLE credit (id INT NOT NULL, credit_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parameter_in_description (id INT NOT NULL, article_id INT DEFAULT NULL, position INT NOT NULL, key VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3464ADC37294869C ON parameter_in_description (article_id)');
        $this->addSql('CREATE TABLE contracts_short_credits (credit_id INT NOT NULL, contract_id INT NOT NULL, PRIMARY KEY(credit_id, contract_id))');
        $this->addSql('CREATE INDEX IDX_5FD0E5CE062FF9 ON contracts_short_credits (credit_id)');
        $this->addSql('CREATE INDEX IDX_5FD0E52576E0FD ON contracts_short_credits (contract_id)');
        $this->addSql('CREATE TABLE signature (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859CE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parameter_in_description ADD CONSTRAINT FK_3464ADC37294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts_short_credits ADD CONSTRAINT FK_5FD0E5CE062FF9 FOREIGN KEY (credit_id) REFERENCES short_term_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts_short_credits ADD CONSTRAINT FK_5FD0E52576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE folder DROP CONSTRAINT fk_eca209cdce062ff9');
        $this->addSql('ALTER TABLE folder DROP CONSTRAINT fk_eca209cdb96b5643');
        $this->addSql('DROP TABLE folder');
        $this->addSql('DROP INDEX idx_e73d794d162cb942');
        $this->addSql('ALTER TABLE collateral_garantee RENAME COLUMN folder_id TO credit_id');
        $this->addSql('ALTER TABLE collateral_garantee ADD CONSTRAINT FK_E73D794DCE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E73D794DCE062FF9 ON collateral_garantee (credit_id)');
        $this->addSql('ALTER TABLE pawn_credit DROP CONSTRAINT FK_82BDC6C7BF396750');
        $this->addSql('ALTER TABLE pawn_credit ADD CONSTRAINT FK_82BDC6C7BF396750 FOREIGN KEY (id) REFERENCES credit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE short_term_credit DROP credit_type');
        $this->addSql('ALTER TABLE short_term_credit RENAME COLUMN id_adbanking_fodler TO id_adbanking_folder');
        $this->addSql('ALTER TABLE short_term_credit ADD CONSTRAINT FK_996B204BF396750 FOREIGN KEY (id) REFERENCES credit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE short_term_folder ADD portfolio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE short_term_folder ADD credit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE short_term_folder ADD state VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE short_term_folder ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE short_term_folder ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE short_term_folder ADD CONSTRAINT FK_F9F5D537B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE short_term_folder ADD CONSTRAINT FK_F9F5D537CE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F9F5D537B96B5643 ON short_term_folder (portfolio_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F9F5D537CE062FF9 ON short_term_folder (credit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE collateral_garantee DROP CONSTRAINT FK_E73D794DCE062FF9');
        $this->addSql('ALTER TABLE pawn_credit DROP CONSTRAINT FK_82BDC6C7BF396750');
        $this->addSql('ALTER TABLE short_term_credit DROP CONSTRAINT FK_996B204BF396750');
        $this->addSql('ALTER TABLE short_term_folder DROP CONSTRAINT FK_F9F5D537CE062FF9');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contract_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE credit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parameter_in_description_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE short_term_folder_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE signature_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE folder_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE short_term_credit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE folder (id INT NOT NULL, credit_id INT DEFAULT NULL, portfolio_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, folder_type VARCHAR(255) NOT NULL, state VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_eca209cdb96b5643 ON folder (portfolio_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_eca209cdce062ff9 ON folder (credit_id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT fk_eca209cdce062ff9 FOREIGN KEY (credit_id) REFERENCES short_term_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT fk_eca209cdb96b5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F2859CE062FF9');
        $this->addSql('ALTER TABLE parameter_in_description DROP CONSTRAINT FK_3464ADC37294869C');
        $this->addSql('ALTER TABLE contracts_short_credits DROP CONSTRAINT FK_5FD0E5CE062FF9');
        $this->addSql('ALTER TABLE contracts_short_credits DROP CONSTRAINT FK_5FD0E52576E0FD');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE credit');
        $this->addSql('DROP TABLE parameter_in_description');
        $this->addSql('DROP TABLE contracts_short_credits');
        $this->addSql('DROP TABLE signature');
        $this->addSql('ALTER TABLE short_term_folder DROP CONSTRAINT FK_F9F5D537B96B5643');
        $this->addSql('DROP INDEX IDX_F9F5D537B96B5643');
        $this->addSql('DROP INDEX UNIQ_F9F5D537CE062FF9');
        $this->addSql('ALTER TABLE short_term_folder DROP portfolio_id');
        $this->addSql('ALTER TABLE short_term_folder DROP credit_id');
        $this->addSql('ALTER TABLE short_term_folder DROP state');
        $this->addSql('ALTER TABLE short_term_folder DROP created_at');
        $this->addSql('ALTER TABLE short_term_folder DROP updated_at');
        $this->addSql('ALTER TABLE short_term_folder ADD CONSTRAINT fk_f9f5d537bf396750 FOREIGN KEY (id) REFERENCES folder (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX IDX_E73D794DCE062FF9');
        $this->addSql('ALTER TABLE collateral_garantee RENAME COLUMN credit_id TO folder_id');
        $this->addSql('ALTER TABLE collateral_garantee ADD CONSTRAINT fk_e73d794d162cb942 FOREIGN KEY (folder_id) REFERENCES folder (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e73d794d162cb942 ON collateral_garantee (folder_id)');
        $this->addSql('ALTER TABLE short_term_credit ADD credit_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE short_term_credit RENAME COLUMN id_adbanking_folder TO id_adbanking_fodler');
        $this->addSql('ALTER TABLE pawn_credit DROP CONSTRAINT fk_82bdc6c7bf396750');
        $this->addSql('ALTER TABLE pawn_credit ADD CONSTRAINT fk_82bdc6c7bf396750 FOREIGN KEY (id) REFERENCES short_term_credit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
