<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230808113048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE general_content_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contracts_signatures (contract_id INT NOT NULL, signature_id INT NOT NULL, PRIMARY KEY(contract_id, signature_id))');
        $this->addSql('CREATE INDEX IDX_26A089C02576E0FD ON contracts_signatures (contract_id)');
        $this->addSql('CREATE INDEX IDX_26A089C0ED61183A ON contracts_signatures (signature_id)');
        $this->addSql('CREATE TABLE articles_contracts (contract_id INT NOT NULL, article_id INT NOT NULL, PRIMARY KEY(contract_id, article_id))');
        $this->addSql('CREATE INDEX IDX_F493C4FF2576E0FD ON articles_contracts (contract_id)');
        $this->addSql('CREATE INDEX IDX_F493C4FF7294869C ON articles_contracts (article_id)');
        $this->addSql('CREATE TABLE general_content (id INT NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contracts_credits (credit_id INT NOT NULL, contract_id INT NOT NULL, PRIMARY KEY(credit_id, contract_id))');
        $this->addSql('CREATE INDEX IDX_C42D5A4BCE062FF9 ON contracts_credits (credit_id)');
        $this->addSql('CREATE INDEX IDX_C42D5A4B2576E0FD ON contracts_credits (contract_id)');
        $this->addSql('ALTER TABLE contracts_signatures ADD CONSTRAINT FK_26A089C02576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts_signatures ADD CONSTRAINT FK_26A089C0ED61183A FOREIGN KEY (signature_id) REFERENCES signature (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles_contracts ADD CONSTRAINT FK_F493C4FF2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles_contracts ADD CONSTRAINT FK_F493C4FF7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts_credits ADD CONSTRAINT FK_C42D5A4BCE062FF9 FOREIGN KEY (credit_id) REFERENCES pawn_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts_credits ADD CONSTRAINT FK_C42D5A4B2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts_short_credits DROP CONSTRAINT fk_5fd0e5ce062ff9');
        $this->addSql('ALTER TABLE contracts_short_credits DROP CONSTRAINT fk_5fd0e52576e0fd');
        $this->addSql('ALTER TABLE short_term_credit DROP CONSTRAINT fk_996b204bf396750');
        $this->addSql('DROP TABLE contracts_short_credits');
        $this->addSql('DROP TABLE short_term_credit');
        $this->addSql('ALTER TABLE contract ADD content_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285984A0A3ED FOREIGN KEY (content_id) REFERENCES general_content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E98F285984A0A3ED ON contract (content_id)');
        $this->addSql('ALTER TABLE pawn_credit ADD capital INT NOT NULL');
        $this->addSql('ALTER TABLE pawn_credit ADD id_adbanking_folder INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pawn_credit ADD code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pawn_credit ADD started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE pawn_credit ADD end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE pawn_credit ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE pawn_credit ADD duration INT NOT NULL');
        $this->addSql('ALTER TABLE pawn_credit ADD interest DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F285984A0A3ED');
        $this->addSql('DROP SEQUENCE general_content_id_seq CASCADE');
        $this->addSql('CREATE TABLE contracts_short_credits (credit_id INT NOT NULL, contract_id INT NOT NULL, PRIMARY KEY(credit_id, contract_id))');
        $this->addSql('CREATE INDEX idx_5fd0e52576e0fd ON contracts_short_credits (contract_id)');
        $this->addSql('CREATE INDEX idx_5fd0e5ce062ff9 ON contracts_short_credits (credit_id)');
        $this->addSql('CREATE TABLE short_term_credit (id INT NOT NULL, capital INT NOT NULL, id_adbanking_folder INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, duration INT NOT NULL, interest DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE contracts_short_credits ADD CONSTRAINT fk_5fd0e5ce062ff9 FOREIGN KEY (credit_id) REFERENCES short_term_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts_short_credits ADD CONSTRAINT fk_5fd0e52576e0fd FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE short_term_credit ADD CONSTRAINT fk_996b204bf396750 FOREIGN KEY (id) REFERENCES credit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts_signatures DROP CONSTRAINT FK_26A089C02576E0FD');
        $this->addSql('ALTER TABLE contracts_signatures DROP CONSTRAINT FK_26A089C0ED61183A');
        $this->addSql('ALTER TABLE articles_contracts DROP CONSTRAINT FK_F493C4FF2576E0FD');
        $this->addSql('ALTER TABLE articles_contracts DROP CONSTRAINT FK_F493C4FF7294869C');
        $this->addSql('ALTER TABLE contracts_credits DROP CONSTRAINT FK_C42D5A4BCE062FF9');
        $this->addSql('ALTER TABLE contracts_credits DROP CONSTRAINT FK_C42D5A4B2576E0FD');
        $this->addSql('DROP TABLE contracts_signatures');
        $this->addSql('DROP TABLE articles_contracts');
        $this->addSql('DROP TABLE general_content');
        $this->addSql('DROP TABLE contracts_credits');
        $this->addSql('DROP INDEX IDX_E98F285984A0A3ED');
        $this->addSql('ALTER TABLE contract DROP content_id');
        $this->addSql('ALTER TABLE pawn_credit DROP capital');
        $this->addSql('ALTER TABLE pawn_credit DROP id_adbanking_folder');
        $this->addSql('ALTER TABLE pawn_credit DROP code');
        $this->addSql('ALTER TABLE pawn_credit DROP started_at');
        $this->addSql('ALTER TABLE pawn_credit DROP end_at');
        $this->addSql('ALTER TABLE pawn_credit DROP created_at');
        $this->addSql('ALTER TABLE pawn_credit DROP duration');
        $this->addSql('ALTER TABLE pawn_credit DROP interest');
    }
}
