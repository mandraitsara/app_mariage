<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703134140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, civilité_f VARCHAR(255) DEFAULT NULL, nom_f VARCHAR(255) DEFAULT NULL, temoin_f VARCHAR(255) DEFAULT NULL, civilite_temoin_f VARCHAR(255) DEFAULT NULL, parent_f VARCHAR(255) DEFAULT NULL, amie_proche_f VARCHAR(255) DEFAULT NULL, amie_f VARCHAR(255) DEFAULT NULL, parent VARCHAR(255) DEFAULT NULL, civilite_h VARCHAR(255) DEFAULT NULL, nom_h VARCHAR(255) DEFAULT NULL, temoin_h VARCHAR(255) DEFAULT NULL, civilite_temoin_h VARCHAR(255) DEFAULT NULL, garcon_d_honneur VARCHAR(255) DEFAULT NULL, parent_h VARCHAR(255) DEFAULT NULL, ami_h VARCHAR(255) DEFAULT NULL, ami_proche_h VARCHAR(255) DEFAULT NULL, prenom_f VARCHAR(255) DEFAULT NULL, prenom_h VARCHAR(255) DEFAULT NULL, fille_d_honneur VARCHAR(255) DEFAULT NULL, total_invite INT DEFAULT NULL, INDEX IDX_AC74095AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, titre_categorie VARCHAR(255) NOT NULL, soustitre_categorie VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, prestataire_id INT NOT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C53D045FBE3DB2B7 (prestataire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invite (id INT AUTO_INCREMENT NOT NULL, nominvite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestataire (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, contact_id INT NOT NULL, nom_prestataire VARCHAR(255) NOT NULL, type_prestataire VARCHAR(255) NOT NULL, info_prestataire VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_60A26480BCF5E72D (categorie_id), INDEX IDX_60A26480E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_login (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, roles JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AA76ED395 FOREIGN KEY (user_id) REFERENCES user_login (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE prestataire ADD CONSTRAINT FK_60A26480BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE prestataire ADD CONSTRAINT FK_60A26480E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AA76ED395');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBE3DB2B7');
        $this->addSql('ALTER TABLE prestataire DROP FOREIGN KEY FK_60A26480BCF5E72D');
        $this->addSql('ALTER TABLE prestataire DROP FOREIGN KEY FK_60A26480E7A1254A');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE invite');
        $this->addSql('DROP TABLE prestataire');
        $this->addSql('DROP TABLE user_login');
    }
}
