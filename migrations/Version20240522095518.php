<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20240522095518.php
final class Version20240522095518 extends AbstractMigration
========
final class Version20240517071715 extends AbstractMigration
>>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71:migrations/Version20240517071715.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20240522095518.php
        $this->addSql('CREATE TABLE prestataire (id INT AUTO_INCREMENT NOT NULL, nom_prestataire VARCHAR(255) NOT NULL, type_prestataire VARCHAR(255) NOT NULL, info_prestataire VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
========
        $this->addSql('ALTER TABLE user_login CHANGE reset_token reset_token VARCHAR(250) NOT NULL');
>>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71:migrations/Version20240517071715.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20240522095518.php
        $this->addSql('DROP TABLE prestataire');
========
        $this->addSql('ALTER TABLE user_login CHANGE reset_token reset_token VARCHAR(100) NOT NULL');
>>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71:migrations/Version20240517071715.php
    }
}
