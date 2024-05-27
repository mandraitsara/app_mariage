<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240524144325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE ajout_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fournisseur_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE prestataire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE prestataire (id INT NOT NULL, nom_prestataire VARCHAR(255) NOT NULL, type_prestataire VARCHAR(255) NOT NULL, info_prestataire VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE ajout');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('ALTER TABLE user_login ADD date_now TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_login ALTER reset_token TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_login ALTER reset_token SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE prestataire_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ajout_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fournisseur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ajout (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE fournisseur (id INT NOT NULL, nom_f VARCHAR(255) NOT NULL, type_f VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE prestataire');
        $this->addSql('ALTER TABLE user_login DROP date_now');
        $this->addSql('ALTER TABLE user_login ALTER reset_token TYPE CHAR(255)');
        $this->addSql('ALTER TABLE user_login ALTER reset_token DROP NOT NULL');
    }
}
