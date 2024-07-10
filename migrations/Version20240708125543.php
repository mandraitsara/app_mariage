<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708125543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget ADD user_login_id INT NOT NULL');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77BBC3F045D FOREIGN KEY (user_login_id) REFERENCES user_login (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_73F2F77BBC3F045D ON budget (user_login_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77BBC3F045D');
        $this->addSql('DROP INDEX UNIQ_73F2F77BBC3F045D ON budget');
        $this->addSql('ALTER TABLE budget DROP user_login_id');
    }
}
