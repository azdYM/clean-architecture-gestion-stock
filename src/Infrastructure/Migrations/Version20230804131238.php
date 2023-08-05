<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804131238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cash_garantee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cash_garantee (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, telephone VARCHAR(50) DEFAULT NULL, email VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638450FF010 ON contact (telephone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638E7927C74 ON contact (email)');
        $this->addSql('CREATE TABLE location_person (person_id INT NOT NULL, location_id INT NOT NULL, PRIMARY KEY(person_id, location_id))');
        $this->addSql('CREATE INDEX IDX_7FAE5974217BBB47 ON location_person (person_id)');
        $this->addSql('CREATE INDEX IDX_7FAE597464D218E ON location_person (location_id)');
        $this->addSql('CREATE TABLE contact_person (person_id INT NOT NULL, contact_id INT NOT NULL, PRIMARY KEY(person_id, contact_id))');
        $this->addSql('CREATE INDEX IDX_A44EE6F7217BBB47 ON contact_person (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A44EE6F7E7A1254A ON contact_person (contact_id)');
        $this->addSql('ALTER TABLE location_person ADD CONSTRAINT FK_7FAE5974217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE location_person ADD CONSTRAINT FK_7FAE597464D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact_person ADD CONSTRAINT FK_A44EE6F7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact_person ADD CONSTRAINT FK_A44EE6F7E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cash_garantee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('ALTER TABLE location_person DROP CONSTRAINT FK_7FAE5974217BBB47');
        $this->addSql('ALTER TABLE location_person DROP CONSTRAINT FK_7FAE597464D218E');
        $this->addSql('ALTER TABLE contact_person DROP CONSTRAINT FK_A44EE6F7217BBB47');
        $this->addSql('ALTER TABLE contact_person DROP CONSTRAINT FK_A44EE6F7E7A1254A');
        $this->addSql('DROP TABLE cash_garantee');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE location_person');
        $this->addSql('DROP TABLE contact_person');
    }
}
