<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240715123050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestataire CHANGE budget_prestataire budget_prestataire VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE prestataire_tarif ADD prestataires_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestataire_tarif ADD CONSTRAINT FK_59FEBAAEB2CAA6B8 FOREIGN KEY (prestataires_id) REFERENCES prestataire (id)');
        $this->addSql('CREATE INDEX IDX_59FEBAAEB2CAA6B8 ON prestataire_tarif (prestataires_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77BBC3F045D');
        $this->addSql('ALTER TABLE prestataire CHANGE budget_prestataire budget_prestataire DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE prestataire_tarif DROP FOREIGN KEY FK_59FEBAAEB2CAA6B8');
        $this->addSql('DROP INDEX IDX_59FEBAAEB2CAA6B8 ON prestataire_tarif');
        $this->addSql('ALTER TABLE prestataire_tarif DROP prestataires_id');
    }
}
