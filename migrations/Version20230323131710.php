<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230323131710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gmap_localisation (id INT AUTO_INCREMENT NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD gmap_localisation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA6F43BE7 FOREIGN KEY (gmap_localisation_id) REFERENCES gmap_localisation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FA6F43BE7 ON company (gmap_localisation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA6F43BE7');
        $this->addSql('DROP TABLE gmap_localisation');
        $this->addSql('DROP INDEX UNIQ_4FBF094FA6F43BE7 ON company');
        $this->addSql('ALTER TABLE company DROP gmap_localisation_id');
    }
}
