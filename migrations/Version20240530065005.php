<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530065005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity CHANGE civilite_temoin_f civilite_temoin_f VARCHAR(255) DEFAULT NULL, CHANGE parent_f parent_f VARCHAR(255) DEFAULT NULL, CHANGE amie_proche_f amie_proche_f VARCHAR(255) DEFAULT NULL, CHANGE amie_f amie_f VARCHAR(255) DEFAULT NULL, CHANGE parent parent VARCHAR(255) DEFAULT NULL, CHANGE civilite_h civilite_h VARCHAR(255) DEFAULT NULL, CHANGE nom_h nom_h VARCHAR(255) DEFAULT NULL, CHANGE temoin_h temoin_h VARCHAR(255) DEFAULT NULL, CHANGE civilite_temoin_h civilite_temoin_h VARCHAR(255) DEFAULT NULL, CHANGE garcon_d_honneur garcon_d_honneur VARCHAR(255) DEFAULT NULL, CHANGE parent_h parent_h VARCHAR(255) DEFAULT NULL, CHANGE ami_h ami_h VARCHAR(255) DEFAULT NULL, CHANGE ami_proche_h ami_proche_h VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity CHANGE civilite_temoin_f civilite_temoin_f VARCHAR(255) NOT NULL, CHANGE parent_f parent_f VARCHAR(255) NOT NULL, CHANGE amie_proche_f amie_proche_f VARCHAR(255) NOT NULL, CHANGE amie_f amie_f VARCHAR(255) NOT NULL, CHANGE parent parent VARCHAR(255) NOT NULL, CHANGE civilite_h civilite_h VARCHAR(255) NOT NULL, CHANGE nom_h nom_h VARCHAR(255) NOT NULL, CHANGE temoin_h temoin_h VARCHAR(255) NOT NULL, CHANGE civilite_temoin_h civilite_temoin_h VARCHAR(255) NOT NULL, CHANGE garcon_d_honneur garcon_d_honneur VARCHAR(255) NOT NULL, CHANGE parent_h parent_h VARCHAR(255) NOT NULL, CHANGE ami_h ami_h VARCHAR(255) NOT NULL, CHANGE ami_proche_h ami_proche_h VARCHAR(255) NOT NULL');
    }
}
