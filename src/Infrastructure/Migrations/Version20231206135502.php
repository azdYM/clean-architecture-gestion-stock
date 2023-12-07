<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206135502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_23a0e66e4ab1941');
        $this->addSql('DROP INDEX uniq_86f0a2b3e4ab1941');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE UNIQUE INDEX uniq_86f0a2b3e4ab1941 ON signature_label (contract_type)');
        $this->addSql('CREATE UNIQUE INDEX uniq_23a0e66e4ab1941 ON article (contract_type)');
    }
}
