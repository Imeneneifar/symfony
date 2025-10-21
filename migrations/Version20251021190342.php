<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251021190342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book CHANGE author1_id author INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331BDAFD8C8 FOREIGN KEY (author) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_CBE5A331BDAFD8C8 ON book (author)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331BDAFD8C8');
        $this->addSql('DROP INDEX IDX_CBE5A331BDAFD8C8 ON book');
        $this->addSql('ALTER TABLE book CHANGE author author1_id INT NOT NULL');
    }
}
