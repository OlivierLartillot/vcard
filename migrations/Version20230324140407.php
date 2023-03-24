<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324140407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA6F43BE7');
        $this->addSql('DROP INDEX UNIQ_4FBF094FA6F43BE7 ON company');
        $this->addSql('ALTER TABLE company DROP gmap_localisation_id');
        $this->addSql('ALTER TABLE gmap_localisation ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gmap_localisation ADD CONSTRAINT FK_51C5D2CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51C5D2CCA76ED395 ON gmap_localisation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD gmap_localisation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA6F43BE7 FOREIGN KEY (gmap_localisation_id) REFERENCES gmap_localisation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FA6F43BE7 ON company (gmap_localisation_id)');
        $this->addSql('ALTER TABLE gmap_localisation DROP FOREIGN KEY FK_51C5D2CCA76ED395');
        $this->addSql('DROP INDEX UNIQ_51C5D2CCA76ED395 ON gmap_localisation');
        $this->addSql('ALTER TABLE gmap_localisation DROP user_id');
    }
}
