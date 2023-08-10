<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810114402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE evaluation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, disc VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1E7927C74 ON employee (email)');
        $this->addSql('CREATE TABLE evaluation (id INT NOT NULL, garantee_id INT DEFAULT NULL, evaluator_id INT DEFAULT NULL, sealer_id INT DEFAULT NULL, evaluated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description_evaluator TEXT NOT NULL, sealed BOOLEAN DEFAULT false NOT NULL, sealed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description_sealer TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1323A57561498D2E ON evaluation (garantee_id)');
        $this->addSql('CREATE INDEX IDX_1323A57543575BE2 ON evaluation (evaluator_id)');
        $this->addSql('CREATE INDEX IDX_1323A575EC3F4119 ON evaluation (sealer_id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57561498D2E FOREIGN KEY (garantee_id) REFERENCES collateral_garantee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57543575BE2 FOREIGN KEY (evaluator_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575EC3F4119 FOREIGN KEY (sealer_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE renawal_credit ADD agent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE renawal_credit ADD CONSTRAINT FK_3908797D3414710B FOREIGN KEY (agent_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3908797D3414710B ON renawal_credit (agent_id)');
        $this->addSql('ALTER TABLE short_term_folder ADD agent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE short_term_folder ADD CONSTRAINT FK_F9F5D5373414710B FOREIGN KEY (agent_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F9F5D5373414710B ON short_term_folder (agent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE renawal_credit DROP CONSTRAINT FK_3908797D3414710B');
        $this->addSql('ALTER TABLE short_term_folder DROP CONSTRAINT FK_F9F5D5373414710B');
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE evaluation_id_seq CASCADE');
        $this->addSql('ALTER TABLE evaluation DROP CONSTRAINT FK_1323A57561498D2E');
        $this->addSql('ALTER TABLE evaluation DROP CONSTRAINT FK_1323A57543575BE2');
        $this->addSql('ALTER TABLE evaluation DROP CONSTRAINT FK_1323A575EC3F4119');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP INDEX IDX_3908797D3414710B');
        $this->addSql('ALTER TABLE renawal_credit DROP agent_id');
        $this->addSql('DROP INDEX IDX_F9F5D5373414710B');
        $this->addSql('ALTER TABLE short_term_folder DROP agent_id');
    }
}
