<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240715062754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestataire ADD prestataire_tarif_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestataire ADD CONSTRAINT FK_60A26480F1882C2A FOREIGN KEY (prestataire_tarif_id) REFERENCES prestataire_tarif (id)');
        $this->addSql('CREATE INDEX IDX_60A26480F1882C2A ON prestataire (prestataire_tarif_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77BBC3F045D');
        $this->addSql('ALTER TABLE prestataire DROP FOREIGN KEY FK_60A26480F1882C2A');
        $this->addSql('DROP INDEX IDX_60A26480F1882C2A ON prestataire');
        $this->addSql('ALTER TABLE prestataire DROP prestataire_tarif_id');
    }
}
