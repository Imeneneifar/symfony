<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251021190625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3315CFF918C FOREIGN KEY (author1_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_CBE5A3315CFF918C ON book (author1_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3315CFF918C');
        $this->addSql('DROP INDEX IDX_CBE5A3315CFF918C ON book');
        $this->addSql('DROP INDEX `primary` ON book');
    }
}
