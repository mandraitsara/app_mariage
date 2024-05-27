<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527085129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE ajout_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE categorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE prestataire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categorie (id INT NOT NULL, titre_categorie VARCHAR(255) NOT NULL, soustitre_categorie VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, gerant VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE prestataire (id INT NOT NULL, nom_prestataire VARCHAR(255) NOT NULL, type_prestataire VARCHAR(255) NOT NULL, info_prestataire VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE ajout');
        $this->addSql('ALTER TABLE fournisseur ADD titre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD titre_categ VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD sous_categ VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur DROP nom_f');
        $this->addSql('ALTER TABLE fournisseur DROP type_f');
        $this->addSql('ALTER TABLE fournisseur DROP contact');
        $this->addSql('ALTER TABLE user_login ADD date_now TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_login ALTER reset_token TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_login ALTER reset_token SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categorie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE prestataire_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ajout_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ajout (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE prestataire');
        $this->addSql('ALTER TABLE user_login DROP date_now');
        $this->addSql('ALTER TABLE user_login ALTER reset_token TYPE CHAR(255)');
        $this->addSql('ALTER TABLE user_login ALTER reset_token DROP NOT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD nom_f VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD type_f VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD contact VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur DROP titre');
        $this->addSql('ALTER TABLE fournisseur DROP description');
        $this->addSql('ALTER TABLE fournisseur DROP titre_categ');
        $this->addSql('ALTER TABLE fournisseur DROP sous_categ');
    }
}
