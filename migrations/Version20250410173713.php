<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250410173713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE patient DROP heure_arrivee
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket ADD heure_arrivee TIME NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE patient ADD heure_arrivee TIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket DROP heure_arrivee
        SQL);
    }
}
