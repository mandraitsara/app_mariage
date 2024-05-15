<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515133652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE livre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE auteur_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ajout_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fournisseur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_login_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ajout (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE fournisseur (id INT NOT NULL, nom_f VARCHAR(255) NOT NULL, type_f VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_login (id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, test VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE auteur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE ajout_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fournisseur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_login_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE livre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE auteur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE livre (id INT NOT NULL, titre VARCHAR(255) NOT NULL, annee INT DEFAULT NULL, auteur VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN users.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE auteur (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE ajout');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE user_login');
    }
}
