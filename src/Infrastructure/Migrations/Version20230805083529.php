<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805083529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE person_supported_id_seq CASCADE');
        $this->addSql('CREATE TABLE corporates_managers (corporate_id INT NOT NULL, manager_id INT NOT NULL, PRIMARY KEY(corporate_id, manager_id))');
        $this->addSql('CREATE INDEX IDX_D86BA980CD147EEF ON corporates_managers (corporate_id)');
        $this->addSql('CREATE INDEX IDX_D86BA980783E3463 ON corporates_managers (manager_id)');
        $this->addSql('CREATE TABLE married_person (married_id INT NOT NULL, spouse_id INT NOT NULL, PRIMARY KEY(married_id, spouse_id))');
        $this->addSql('CREATE INDEX IDX_68E2DDAC4A64FF67 ON married_person (married_id)');
        $this->addSql('CREATE INDEX IDX_68E2DDAC8EEC5B5C ON married_person (spouse_id)');
        $this->addSql('CREATE TABLE locations_persons (person_id INT NOT NULL, location_id INT NOT NULL, PRIMARY KEY(person_id, location_id))');
        $this->addSql('CREATE INDEX IDX_638475FB217BBB47 ON locations_persons (person_id)');
        $this->addSql('CREATE INDEX IDX_638475FB64D218E ON locations_persons (location_id)');
        $this->addSql('CREATE TABLE contacts_persons (person_id INT NOT NULL, contact_id INT NOT NULL, PRIMARY KEY(person_id, contact_id))');
        $this->addSql('CREATE INDEX IDX_28F4CB8E217BBB47 ON contacts_persons (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28F4CB8EE7A1254A ON contacts_persons (contact_id)');
        $this->addSql('ALTER TABLE corporates_managers ADD CONSTRAINT FK_D86BA980CD147EEF FOREIGN KEY (corporate_id) REFERENCES corporate (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE corporates_managers ADD CONSTRAINT FK_D86BA980783E3463 FOREIGN KEY (manager_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE married_person ADD CONSTRAINT FK_68E2DDAC4A64FF67 FOREIGN KEY (married_id) REFERENCES married (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE married_person ADD CONSTRAINT FK_68E2DDAC8EEC5B5C FOREIGN KEY (spouse_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE locations_persons ADD CONSTRAINT FK_638475FB217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE locations_persons ADD CONSTRAINT FK_638475FB64D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contacts_persons ADD CONSTRAINT FK_28F4CB8E217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contacts_persons ADD CONSTRAINT FK_28F4CB8EE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact_person DROP CONSTRAINT fk_a44ee6f7217bbb47');
        $this->addSql('ALTER TABLE contact_person DROP CONSTRAINT fk_a44ee6f7e7a1254a');
        $this->addSql('ALTER TABLE location_person DROP CONSTRAINT fk_7fae5974217bbb47');
        $this->addSql('ALTER TABLE location_person DROP CONSTRAINT fk_7fae597464d218e');
        $this->addSql('ALTER TABLE matrimonial_people_supported DROP CONSTRAINT fk_17cca82b4b93c697');
        $this->addSql('ALTER TABLE matrimonial_people_supported DROP CONSTRAINT fk_17cca82b77304de3');
        $this->addSql('DROP TABLE contact_person');
        $this->addSql('DROP TABLE location_person');
        $this->addSql('DROP TABLE person_supported');
        $this->addSql('DROP TABLE matrimonial_people_supported');
        $this->addSql('ALTER TABLE corporate ADD created_location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE corporate ADD central_location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE corporate ADD CONSTRAINT FK_1F33D7A2A73D36F9 FOREIGN KEY (created_location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE corporate ADD CONSTRAINT FK_1F33D7A220111F93 FOREIGN KEY (central_location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F33D7A2A73D36F9 ON corporate (created_location_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F33D7A220111F93 ON corporate (central_location_id)');
        $this->addSql('ALTER TABLE divorced ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE divorced ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE divorced DROP state');
        $this->addSql('ALTER TABLE married ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE married ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE married DROP state');
        $this->addSql('ALTER TABLE matrimonial_status DROP created_at');
        $this->addSql('ALTER TABLE matrimonial_status DROP updated_at');
        $this->addSql('ALTER TABLE single ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE single ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE single DROP state');
        $this->addSql('ALTER TABLE widower ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE widower ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE widower DROP state');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE person_supported_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contact_person (person_id INT NOT NULL, contact_id INT NOT NULL, PRIMARY KEY(person_id, contact_id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_a44ee6f7e7a1254a ON contact_person (contact_id)');
        $this->addSql('CREATE INDEX idx_a44ee6f7217bbb47 ON contact_person (person_id)');
        $this->addSql('CREATE TABLE location_person (person_id INT NOT NULL, location_id INT NOT NULL, PRIMARY KEY(person_id, location_id))');
        $this->addSql('CREATE INDEX idx_7fae597464d218e ON location_person (location_id)');
        $this->addSql('CREATE INDEX idx_7fae5974217bbb47 ON location_person (person_id)');
        $this->addSql('CREATE TABLE person_supported (id INT NOT NULL, relationship VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE matrimonial_people_supported (matrimonial_status_id INT NOT NULL, people_supported INT NOT NULL, PRIMARY KEY(matrimonial_status_id, people_supported))');
        $this->addSql('CREATE INDEX idx_17cca82b77304de3 ON matrimonial_people_supported (people_supported)');
        $this->addSql('CREATE INDEX idx_17cca82b4b93c697 ON matrimonial_people_supported (matrimonial_status_id)');
        $this->addSql('ALTER TABLE contact_person ADD CONSTRAINT fk_a44ee6f7217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact_person ADD CONSTRAINT fk_a44ee6f7e7a1254a FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE location_person ADD CONSTRAINT fk_7fae5974217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE location_person ADD CONSTRAINT fk_7fae597464d218e FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrimonial_people_supported ADD CONSTRAINT fk_17cca82b4b93c697 FOREIGN KEY (matrimonial_status_id) REFERENCES matrimonial_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrimonial_people_supported ADD CONSTRAINT fk_17cca82b77304de3 FOREIGN KEY (people_supported) REFERENCES person_supported (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE corporates_managers DROP CONSTRAINT FK_D86BA980CD147EEF');
        $this->addSql('ALTER TABLE corporates_managers DROP CONSTRAINT FK_D86BA980783E3463');
        $this->addSql('ALTER TABLE married_person DROP CONSTRAINT FK_68E2DDAC4A64FF67');
        $this->addSql('ALTER TABLE married_person DROP CONSTRAINT FK_68E2DDAC8EEC5B5C');
        $this->addSql('ALTER TABLE locations_persons DROP CONSTRAINT FK_638475FB217BBB47');
        $this->addSql('ALTER TABLE locations_persons DROP CONSTRAINT FK_638475FB64D218E');
        $this->addSql('ALTER TABLE contacts_persons DROP CONSTRAINT FK_28F4CB8E217BBB47');
        $this->addSql('ALTER TABLE contacts_persons DROP CONSTRAINT FK_28F4CB8EE7A1254A');
        $this->addSql('DROP TABLE corporates_managers');
        $this->addSql('DROP TABLE married_person');
        $this->addSql('DROP TABLE locations_persons');
        $this->addSql('DROP TABLE contacts_persons');
        $this->addSql('ALTER TABLE corporate DROP CONSTRAINT FK_1F33D7A2A73D36F9');
        $this->addSql('ALTER TABLE corporate DROP CONSTRAINT FK_1F33D7A220111F93');
        $this->addSql('DROP INDEX UNIQ_1F33D7A2A73D36F9');
        $this->addSql('DROP INDEX UNIQ_1F33D7A220111F93');
        $this->addSql('ALTER TABLE corporate DROP created_location_id');
        $this->addSql('ALTER TABLE corporate DROP central_location_id');
        $this->addSql('ALTER TABLE matrimonial_status ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE matrimonial_status ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE married ADD state VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE married DROP created_at');
        $this->addSql('ALTER TABLE married DROP updated_at');
        $this->addSql('ALTER TABLE divorced ADD state VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE divorced DROP created_at');
        $this->addSql('ALTER TABLE divorced DROP updated_at');
        $this->addSql('ALTER TABLE widower ADD state VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE widower DROP created_at');
        $this->addSql('ALTER TABLE widower DROP updated_at');
        $this->addSql('ALTER TABLE single ADD state VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE single DROP created_at');
        $this->addSql('ALTER TABLE single DROP updated_at');
    }
}
