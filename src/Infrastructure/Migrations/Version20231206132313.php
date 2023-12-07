<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206132313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles_gage_contracts DROP CONSTRAINT fk_be6045b42576e0fd');
        $this->addSql('ALTER TABLE articles_gage_contracts DROP CONSTRAINT fk_be6045b47294869c');
        $this->addSql('ALTER TABLE gage_contracts_signature_labels DROP CONSTRAINT fk_a0d3294e2576e0fd');
        $this->addSql('ALTER TABLE gage_contracts_signature_labels DROP CONSTRAINT fk_a0d3294e80d5a988');
        $this->addSql('ALTER TABLE articles_death_solidarirty_contracts DROP CONSTRAINT fk_576712792576e0fd');
        $this->addSql('ALTER TABLE articles_death_solidarirty_contracts DROP CONSTRAINT fk_576712797294869c');
        $this->addSql('ALTER TABLE death_solidarity_contracts_signature_labels DROP CONSTRAINT fk_8547867d2576e0fd');
        $this->addSql('ALTER TABLE death_solidarity_contracts_signature_labels DROP CONSTRAINT fk_8547867d80d5a988');
        $this->addSql('DROP TABLE articles_gage_contracts');
        $this->addSql('DROP TABLE gage_contracts_signature_labels');
        $this->addSql('DROP TABLE articles_death_solidarirty_contracts');
        $this->addSql('DROP TABLE death_solidarity_contracts_signature_labels');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT fk_e98f285984a0a3ed');
        $this->addSql('DROP INDEX idx_e98f285984a0a3ed');
        $this->addSql('ALTER TABLE contract ADD articles JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE contract ADD labels_for_signautre JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE contract ADD content VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE contract DROP content_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE articles_gage_contracts (contract_id INT NOT NULL, article_id INT NOT NULL, PRIMARY KEY(contract_id, article_id))');
        $this->addSql('CREATE INDEX idx_be6045b47294869c ON articles_gage_contracts (article_id)');
        $this->addSql('CREATE INDEX idx_be6045b42576e0fd ON articles_gage_contracts (contract_id)');
        $this->addSql('CREATE TABLE gage_contracts_signature_labels (contract_id INT NOT NULL, signature_label_id INT NOT NULL, PRIMARY KEY(contract_id, signature_label_id))');
        $this->addSql('CREATE INDEX idx_a0d3294e80d5a988 ON gage_contracts_signature_labels (signature_label_id)');
        $this->addSql('CREATE INDEX idx_a0d3294e2576e0fd ON gage_contracts_signature_labels (contract_id)');
        $this->addSql('CREATE TABLE articles_death_solidarirty_contracts (contract_id INT NOT NULL, article_id INT NOT NULL, PRIMARY KEY(contract_id, article_id))');
        $this->addSql('CREATE INDEX idx_576712797294869c ON articles_death_solidarirty_contracts (article_id)');
        $this->addSql('CREATE INDEX idx_576712792576e0fd ON articles_death_solidarirty_contracts (contract_id)');
        $this->addSql('CREATE TABLE death_solidarity_contracts_signature_labels (contract_id INT NOT NULL, signature_label_id INT NOT NULL, PRIMARY KEY(contract_id, signature_label_id))');
        $this->addSql('CREATE INDEX idx_8547867d80d5a988 ON death_solidarity_contracts_signature_labels (signature_label_id)');
        $this->addSql('CREATE INDEX idx_8547867d2576e0fd ON death_solidarity_contracts_signature_labels (contract_id)');
        $this->addSql('ALTER TABLE articles_gage_contracts ADD CONSTRAINT fk_be6045b42576e0fd FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles_gage_contracts ADD CONSTRAINT fk_be6045b47294869c FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gage_contracts_signature_labels ADD CONSTRAINT fk_a0d3294e2576e0fd FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gage_contracts_signature_labels ADD CONSTRAINT fk_a0d3294e80d5a988 FOREIGN KEY (signature_label_id) REFERENCES signature_label (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles_death_solidarirty_contracts ADD CONSTRAINT fk_576712792576e0fd FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles_death_solidarirty_contracts ADD CONSTRAINT fk_576712797294869c FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE death_solidarity_contracts_signature_labels ADD CONSTRAINT fk_8547867d2576e0fd FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE death_solidarity_contracts_signature_labels ADD CONSTRAINT fk_8547867d80d5a988 FOREIGN KEY (signature_label_id) REFERENCES signature_label (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD content_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contract DROP articles');
        $this->addSql('ALTER TABLE contract DROP labels_for_signautre');
        $this->addSql('ALTER TABLE contract DROP content');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT fk_e98f285984a0a3ed FOREIGN KEY (content_id) REFERENCES general_content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e98f285984a0a3ed ON contract (content_id)');
    }
}
