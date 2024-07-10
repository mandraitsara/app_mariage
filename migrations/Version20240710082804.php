<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710082804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, user_login_id INT NOT NULL, montant_total INT NOT NULL, montant_restant INT NOT NULL, UNIQUE INDEX UNIQ_73F2F77BBC3F045D (user_login_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, prestataire_id INT NOT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C53D045FBE3DB2B7 (prestataire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presta (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, contact VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77BBC3F045D FOREIGN KEY (user_login_id) REFERENCES user_login (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE prestataire ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77BBC3F045D');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBE3DB2B7');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE presta');
        $this->addSql('ALTER TABLE prestataire DROP image_name, DROP updated_at');
    }
}
