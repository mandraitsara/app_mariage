<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20240523074010.php
final class Version20240523074010 extends AbstractMigration
========
final class Version20240516153447 extends AbstractMigration
>>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71:migrations/Version20240516153447.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20240523074010.php
        $this->addSql('ALTER TABLE user_login CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL');
========
        $this->addSql('ALTER TABLE user_login ADD reset_token VARCHAR(100) NOT NULL');
>>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71:migrations/Version20240516153447.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20240523074010.php
        $this->addSql('ALTER TABLE user_login CHANGE reset_token reset_token VARCHAR(255) NOT NULL');
========
        $this->addSql('ALTER TABLE user_login DROP reset_token');
>>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71:migrations/Version20240516153447.php
    }
}
