<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502141004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE canciones ADD Artista VARCHAR(90) DEFAULT \'NULL\', CHANGE Reproducciones Reproducciones INT DEFAULT NULL, CHANGE Puesto Puesto INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cancionesdia1 ADD Artista VARCHAR(90) DEFAULT \'NULL\', CHANGE Reproducciones Reproducciones INT DEFAULT NULL, CHANGE Puesto Puesto INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE canciones DROP Artista, CHANGE Reproducciones Reproducciones INT NOT NULL, CHANGE Puesto Puesto INT NOT NULL');
        $this->addSql('ALTER TABLE cancionesdia1 DROP Artista, CHANGE Reproducciones Reproducciones INT NOT NULL, CHANGE Puesto Puesto INT NOT NULL');
    }
}
