<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313155248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE CancionesDia2 (idCancion INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', Reproducciones INT NOT NULL, Puesto INT NOT NULL, UNIQUE INDEX idCancion_UNIQUE (idCancion), PRIMARY KEY(idCancion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE CancionesDia3 (idCancion INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', Reproducciones INT NOT NULL, Puesto INT NOT NULL, UNIQUE INDEX idCancion_UNIQUE (idCancion), PRIMARY KEY(idCancion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cancionesdia1 (idCancion INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', Reproducciones INT NOT NULL, Puesto INT NOT NULL, UNIQUE INDEX idCancion_UNIQUE (idCancion), PRIMARY KEY(idCancion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE CancionesDia2');
        $this->addSql('DROP TABLE CancionesDia3');
        $this->addSql('DROP TABLE cancionesdia1');
    }
}
