<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131141710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apuestas CHANGE idApuesta idApuesta INT AUTO_INCREMENT NOT NULL, CHANGE Cuota Cuota DOUBLE PRECISION DEFAULT NULL, CHANGE Cantidad Cantidad DOUBLE PRECISION DEFAULT NULL, CHANGE FechaFinal FechaFinal DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB6A0E63DBC FOREIGN KEY (Artistas_idArtista) REFERENCES artistas (idArtista)');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB6896B76DC FOREIGN KEY (Canciones_idCancion) REFERENCES canciones (idCancion)');
        $this->addSql('ALTER TABLE artistas CHANGE Nombre Nombre VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE canciones CHANGE Nombre Nombre VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE canciones_has_artistas ADD CONSTRAINT FK_585ACC64896B76DC FOREIGN KEY (Canciones_idCancion) REFERENCES canciones (idCancion)');
        $this->addSql('ALTER TABLE canciones_has_artistas ADD CONSTRAINT FK_585ACC64A0E63DBC FOREIGN KEY (Artistas_idArtista) REFERENCES artistas (idArtista)');
        $this->addSql('ALTER TABLE usuarios CHANGE NombreUsuario NombreUsuario VARCHAR(45) DEFAULT NULL, CHANGE Email Email VARCHAR(45) DEFAULT NULL, CHANGE Password Password VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE usuarios_has_apuestas ADD CONSTRAINT FK_5AB111005DB09530 FOREIGN KEY (Usuarios_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE usuarios_has_apuestas ADD CONSTRAINT FK_5AB11100A539A20D FOREIGN KEY (Apuestas_idApuesta) REFERENCES apuestas (idApuesta)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB6A0E63DBC');
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB6896B76DC');
        $this->addSql('ALTER TABLE apuestas CHANGE idApuesta idApuesta INT NOT NULL, CHANGE Cuota Cuota DOUBLE PRECISION DEFAULT NULL, CHANGE Cantidad Cantidad DOUBLE PRECISION DEFAULT NULL, CHANGE FechaFinal FechaFinal DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE artistas CHANGE Nombre Nombre VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE canciones CHANGE Nombre Nombre VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE canciones_has_artistas DROP FOREIGN KEY FK_585ACC64896B76DC');
        $this->addSql('ALTER TABLE canciones_has_artistas DROP FOREIGN KEY FK_585ACC64A0E63DBC');
        $this->addSql('ALTER TABLE usuarios CHANGE NombreUsuario NombreUsuario VARCHAR(45) DEFAULT NULL, CHANGE Email Email VARCHAR(45) DEFAULT NULL, CHANGE Password Password VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE usuarios_has_apuestas DROP FOREIGN KEY FK_5AB111005DB09530');
        $this->addSql('ALTER TABLE usuarios_has_apuestas DROP FOREIGN KEY FK_5AB11100A539A20D');
    }
}
