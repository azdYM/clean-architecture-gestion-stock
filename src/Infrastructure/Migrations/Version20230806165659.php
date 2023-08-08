<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806165659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corporate DROP CONSTRAINT fk_1f33d7a2b96b5643');
        $this->addSql('DROP INDEX uniq_1f33d7a2b96b5643');
        $this->addSql('ALTER TABLE corporate DROP portfolio_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE corporate ADD portfolio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE corporate ADD CONSTRAINT fk_1f33d7a2b96b5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_1f33d7a2b96b5643 ON corporate (portfolio_id)');
    }
}
