<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806193443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE renawal_credit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pawn_credit (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE credits_renawal_credits (credit_id INT NOT NULL, renawal_id INT NOT NULL, PRIMARY KEY(credit_id, renawal_id))');
        $this->addSql('CREATE INDEX IDX_AD3D794ECE062FF9 ON credits_renawal_credits (credit_id)');
        $this->addSql('CREATE INDEX IDX_AD3D794EB5E73BFD ON credits_renawal_credits (renawal_id)');
        $this->addSql('CREATE TABLE renawal_credit (id INT NOT NULL, old_credit_id INT DEFAULT NULL, new_credit_id INT DEFAULT NULL, renawaled_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3908797D8BB26B48 ON renawal_credit (old_credit_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3908797DFC992A96 ON renawal_credit (new_credit_id)');
        $this->addSql('ALTER TABLE pawn_credit ADD CONSTRAINT FK_82BDC6C7BF396750 FOREIGN KEY (id) REFERENCES short_term_credit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE credits_renawal_credits ADD CONSTRAINT FK_AD3D794ECE062FF9 FOREIGN KEY (credit_id) REFERENCES pawn_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE credits_renawal_credits ADD CONSTRAINT FK_AD3D794EB5E73BFD FOREIGN KEY (renawal_id) REFERENCES renawal_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE renawal_credit ADD CONSTRAINT FK_3908797D8BB26B48 FOREIGN KEY (old_credit_id) REFERENCES pawn_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE renawal_credit ADD CONSTRAINT FK_3908797DFC992A96 FOREIGN KEY (new_credit_id) REFERENCES pawn_credit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE folder ADD state VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE short_term_credit ADD credit_type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE renawal_credit_id_seq CASCADE');
        $this->addSql('ALTER TABLE pawn_credit DROP CONSTRAINT FK_82BDC6C7BF396750');
        $this->addSql('ALTER TABLE credits_renawal_credits DROP CONSTRAINT FK_AD3D794ECE062FF9');
        $this->addSql('ALTER TABLE credits_renawal_credits DROP CONSTRAINT FK_AD3D794EB5E73BFD');
        $this->addSql('ALTER TABLE renawal_credit DROP CONSTRAINT FK_3908797D8BB26B48');
        $this->addSql('ALTER TABLE renawal_credit DROP CONSTRAINT FK_3908797DFC992A96');
        $this->addSql('DROP TABLE pawn_credit');
        $this->addSql('DROP TABLE credits_renawal_credits');
        $this->addSql('DROP TABLE renawal_credit');
        $this->addSql('ALTER TABLE folder DROP state');
        $this->addSql('ALTER TABLE short_term_credit DROP credit_type');
    }
}
