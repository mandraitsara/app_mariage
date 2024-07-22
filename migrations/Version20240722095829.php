<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240722095829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestataire_tarif DROP FOREIGN KEY FK_59FEBAAE56D12E25');
        $this->addSql('ALTER TABLE prestataire_tarif DROP FOREIGN KEY FK_59FEBAAEBE3DB2B7');
        $this->addSql('DROP INDEX IDX_59FEBAAE56D12E25 ON prestataire_tarif');
        $this->addSql('DROP INDEX IDX_59FEBAAEBE3DB2B7 ON prestataire_tarif');
        $this->addSql('ALTER TABLE prestataire_tarif DROP prestataire_id, DROP presta_type_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77BBC3F045D');
        $this->addSql('ALTER TABLE prestataire_tarif ADD prestataire_id INT DEFAULT NULL, ADD presta_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestataire_tarif ADD CONSTRAINT FK_59FEBAAE56D12E25 FOREIGN KEY (presta_type_id) REFERENCES prestataire_type (id)');
        $this->addSql('ALTER TABLE prestataire_tarif ADD CONSTRAINT FK_59FEBAAEBE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('CREATE INDEX IDX_59FEBAAE56D12E25 ON prestataire_tarif (presta_type_id)');
        $this->addSql('CREATE INDEX IDX_59FEBAAEBE3DB2B7 ON prestataire_tarif (prestataire_id)');
    }
}
