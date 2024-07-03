<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703104702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD date_ceremonie VARCHAR(255) DEFAULT NULL, ADD lieux_ceremonie VARCHAR(255) DEFAULT NULL, DROP civilité_f, DROP temoin_f, DROP civilite_temoin_f, DROP parent_f, DROP amie_proche_f, DROP amie_f, DROP parent, DROP civilite_h, DROP nom_h, DROP temoin_h, DROP civilite_temoin_h, DROP garcon_d_honneur, DROP parent_h, DROP ami_h, DROP ami_proche_h, DROP prenom_f, DROP prenom_h, DROP fille_d_honneur, DROP total_invite, DROP email_filled_honneur, DROP email_garcond_honneur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD civilité_f VARCHAR(255) DEFAULT NULL, ADD temoin_f VARCHAR(255) DEFAULT NULL, ADD civilite_temoin_f VARCHAR(255) DEFAULT NULL, ADD parent_f VARCHAR(255) DEFAULT NULL, ADD amie_proche_f BLOB DEFAULT NULL, ADD amie_f BLOB DEFAULT NULL, ADD parent VARCHAR(255) DEFAULT NULL, ADD civilite_h VARCHAR(255) DEFAULT NULL, ADD nom_h VARCHAR(255) DEFAULT NULL, ADD temoin_h VARCHAR(255) DEFAULT NULL, ADD civilite_temoin_h VARCHAR(255) DEFAULT NULL, ADD garcon_d_honneur VARCHAR(255) DEFAULT NULL, ADD parent_h VARCHAR(255) DEFAULT NULL, ADD ami_h BLOB DEFAULT NULL, ADD ami_proche_h BLOB DEFAULT NULL, ADD prenom_f VARCHAR(255) DEFAULT NULL, ADD prenom_h VARCHAR(255) DEFAULT NULL, ADD fille_d_honneur VARCHAR(255) DEFAULT NULL, ADD total_invite INT DEFAULT NULL, ADD email_filled_honneur VARCHAR(255) DEFAULT NULL, ADD email_garcond_honneur VARCHAR(255) DEFAULT NULL, DROP date_ceremonie, DROP lieux_ceremonie');
    }
}
