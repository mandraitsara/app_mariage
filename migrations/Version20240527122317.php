<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527122317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, civilité_f VARCHAR(255) NOT NULL, nom_f VARCHAR(255) NOT NULL, temoin_f VARCHAR(255) NOT NULL, civilite_temoin_f VARCHAR(255) NOT NULL, parent_f VARCHAR(255) NOT NULL, amie_proche_f VARCHAR(255) NOT NULL, amie_f VARCHAR(255) NOT NULL, parent VARCHAR(255) NOT NULL, civilite_h VARCHAR(255) NOT NULL, nom_h VARCHAR(255) NOT NULL, temoin_h VARCHAR(255) NOT NULL, civilite_temoin_h VARCHAR(255) NOT NULL, garcon_d_honneur VARCHAR(255) NOT NULL, parent_h VARCHAR(255) NOT NULL, ami_h VARCHAR(255) NOT NULL, ami_proche_h VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activity');
    }
}
