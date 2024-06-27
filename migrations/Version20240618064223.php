<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618064223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD total_invite INT DEFAULT NULL, CHANGE amie_proche_f amie_proche_f VARCHAR(255) DEFAULT NULL, CHANGE amie_f amie_f VARCHAR(255) DEFAULT NULL, CHANGE ami_h ami_h VARCHAR(255) DEFAULT NULL, CHANGE ami_proche_h ami_proche_h VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP total_invite, CHANGE amie_proche_f amie_proche_f BLOB DEFAULT NULL, CHANGE amie_f amie_f BLOB DEFAULT NULL, CHANGE ami_h ami_h BLOB DEFAULT NULL, CHANGE ami_proche_h ami_proche_h BLOB DEFAULT NULL');
    }
}
