<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206103954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66E4AB1941 ON article (contract_type)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FE59DDDE4AB1941 ON general_content (contract_type)');
        $this->addSql('ALTER TABLE signature_label ADD contract_type VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_86F0A2B3E4AB1941 ON signature_label (contract_type)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_23A0E66E4AB1941');
        $this->addSql('DROP INDEX UNIQ_86F0A2B3E4AB1941');
        $this->addSql('ALTER TABLE signature_label DROP contract_type');
        $this->addSql('DROP INDEX UNIQ_8FE59DDDE4AB1941');
    }
}
