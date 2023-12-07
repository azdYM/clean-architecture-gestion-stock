<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206102634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE parameter_in_description_id_seq CASCADE');
        $this->addSql('ALTER TABLE parameter_in_description DROP CONSTRAINT fk_3464adc37294869c');
        $this->addSql('DROP TABLE parameter_in_description');
        $this->addSql('ALTER TABLE article ADD contract_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE general_content ADD contract_type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE parameter_in_description_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE parameter_in_description (id INT NOT NULL, article_id INT DEFAULT NULL, "position" INT NOT NULL, key VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_3464adc37294869c ON parameter_in_description (article_id)');
        $this->addSql('ALTER TABLE parameter_in_description ADD CONSTRAINT fk_3464adc37294869c FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE general_content DROP contract_type');
        $this->addSql('ALTER TABLE article DROP contract_type');
    }
}
