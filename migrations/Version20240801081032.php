<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801081032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD lieux_de_reception VARCHAR(255) DEFAULT NULL, ADD photo_reception VARCHAR(255) DEFAULT NULL, ADD photo_ceremonie VARCHAR(255) DEFAULT NULL, ADD photo_principale VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP lieux_de_reception, DROP photo_reception, DROP photo_ceremonie, DROP photo_principale');
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77BBC3F045D');
    }
}
