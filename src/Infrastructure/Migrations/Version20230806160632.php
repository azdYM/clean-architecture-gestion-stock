<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806160632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corporate ADD portfolio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE corporate ADD CONSTRAINT FK_1F33D7A2B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F33D7A2B96B5643 ON corporate (portfolio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE corporate DROP CONSTRAINT FK_1F33D7A2B96B5643');
        $this->addSql('DROP INDEX UNIQ_1F33D7A2B96B5643');
        $this->addSql('ALTER TABLE corporate DROP portfolio_id');
    }
}