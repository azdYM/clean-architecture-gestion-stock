<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804144201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE relation_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE person_supported_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE matrimonial_people_supported (matrimonial_status_id INT NOT NULL, people_supported INT NOT NULL, PRIMARY KEY(matrimonial_status_id, people_supported))');
        $this->addSql('CREATE INDEX IDX_17CCA82B4B93C697 ON matrimonial_people_supported (matrimonial_status_id)');
        $this->addSql('CREATE INDEX IDX_17CCA82B77304DE3 ON matrimonial_people_supported (people_supported)');
        $this->addSql('CREATE TABLE person_supported (id INT NOT NULL, relationship VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE matrimonial_people_supported ADD CONSTRAINT FK_17CCA82B4B93C697 FOREIGN KEY (matrimonial_status_id) REFERENCES matrimonial_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrimonial_people_supported ADD CONSTRAINT FK_17CCA82B77304DE3 FOREIGN KEY (people_supported) REFERENCES person_supported (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE relation');
        $this->addSql('ALTER TABLE divorced ADD matrimonial_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE divorced ADD state VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE divorced ADD CONSTRAINT FK_304651934B93C697 FOREIGN KEY (matrimonial_status_id) REFERENCES matrimonial_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_304651934B93C697 ON divorced (matrimonial_status_id)');
        $this->addSql('ALTER TABLE individual ADD birth_location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE individual ADD matrimonial_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC17A0C0BE62 FOREIGN KEY (birth_location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC174B93C697 FOREIGN KEY (matrimonial_status_id) REFERENCES matrimonial_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8793FC17A0C0BE62 ON individual (birth_location_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8793FC174B93C697 ON individual (matrimonial_status_id)');
        $this->addSql('ALTER TABLE married ADD matrimonial_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE married ADD state VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE married ADD CONSTRAINT FK_E3D23F104B93C697 FOREIGN KEY (matrimonial_status_id) REFERENCES matrimonial_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E3D23F104B93C697 ON married (matrimonial_status_id)');
        $this->addSql('ALTER TABLE single ADD matrimonial_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE single ADD state VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE single ADD CONSTRAINT FK_CAA727194B93C697 FOREIGN KEY (matrimonial_status_id) REFERENCES matrimonial_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CAA727194B93C697 ON single (matrimonial_status_id)');
        $this->addSql('ALTER TABLE widower ADD matrimonial_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE widower ADD state VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE widower ADD CONSTRAINT FK_6390A8B64B93C697 FOREIGN KEY (matrimonial_status_id) REFERENCES matrimonial_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6390A8B64B93C697 ON widower (matrimonial_status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE person_supported_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE relation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE relation (id INT NOT NULL, relationship VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE matrimonial_people_supported DROP CONSTRAINT FK_17CCA82B4B93C697');
        $this->addSql('ALTER TABLE matrimonial_people_supported DROP CONSTRAINT FK_17CCA82B77304DE3');
        $this->addSql('DROP TABLE matrimonial_people_supported');
        $this->addSql('DROP TABLE person_supported');
        $this->addSql('ALTER TABLE divorced DROP CONSTRAINT FK_304651934B93C697');
        $this->addSql('DROP INDEX IDX_304651934B93C697');
        $this->addSql('ALTER TABLE divorced DROP matrimonial_status_id');
        $this->addSql('ALTER TABLE divorced DROP state');
        $this->addSql('ALTER TABLE married DROP CONSTRAINT FK_E3D23F104B93C697');
        $this->addSql('DROP INDEX IDX_E3D23F104B93C697');
        $this->addSql('ALTER TABLE married DROP matrimonial_status_id');
        $this->addSql('ALTER TABLE married DROP state');
        $this->addSql('ALTER TABLE single DROP CONSTRAINT FK_CAA727194B93C697');
        $this->addSql('DROP INDEX IDX_CAA727194B93C697');
        $this->addSql('ALTER TABLE single DROP matrimonial_status_id');
        $this->addSql('ALTER TABLE single DROP state');
        $this->addSql('ALTER TABLE widower DROP CONSTRAINT FK_6390A8B64B93C697');
        $this->addSql('DROP INDEX IDX_6390A8B64B93C697');
        $this->addSql('ALTER TABLE widower DROP matrimonial_status_id');
        $this->addSql('ALTER TABLE widower DROP state');
        $this->addSql('ALTER TABLE individual DROP CONSTRAINT FK_8793FC17A0C0BE62');
        $this->addSql('ALTER TABLE individual DROP CONSTRAINT FK_8793FC174B93C697');
        $this->addSql('DROP INDEX UNIQ_8793FC17A0C0BE62');
        $this->addSql('DROP INDEX UNIQ_8793FC174B93C697');
        $this->addSql('ALTER TABLE individual DROP birth_location_id');
        $this->addSql('ALTER TABLE individual DROP matrimonial_status_id');
    }
}
