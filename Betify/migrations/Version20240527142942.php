<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527142942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE CancionesWeek (idCancion INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', Reproducciones INT NOT NULL, Puesto INT NOT NULL, UNIQUE INDEX idCancion_UNIQUE (idCancion), PRIMARY KEY(idCancion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amistades (id INT AUTO_INCREMENT NOT NULL, Usuario1_idUsuario INT NOT NULL, Usuario2_idUsuario INT NOT NULL, INDEX IDX_64F7488BD394351E (Usuario1_idUsuario), INDEX IDX_64F7488B4A76531F (Usuario2_idUsuario), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apuestas (idApuesta INT AUTO_INCREMENT NOT NULL, Cuota DOUBLE PRECISION NOT NULL, Cantidad DOUBLE PRECISION NOT NULL, Prediccion VARCHAR(45) DEFAULT \'NULL\', Tipo VARCHAR(45) DEFAULT \'NULL\', FechaFinal DATETIME NOT NULL, Canciones_idCancion INT DEFAULT NULL, Usuarios_idUsuario INT DEFAULT NULL, INDEX IDX_AE7EB65DB09530 (Usuarios_idUsuario), INDEX fk_Apuestas_Canciones1_idx (Canciones_idCancion), PRIMARY KEY(idApuesta)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artistas (idArtista INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', UNIQUE INDEX Nombre_UNIQUE (Nombre), PRIMARY KEY(idArtista)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cancionesauxiliar (idCancion INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', Reproducciones INT DEFAULT NULL, Puesto INT DEFAULT NULL, Artista VARCHAR(90) DEFAULT \'NULL\', UNIQUE INDEX idCancion_UNIQUE (idCancion), PRIMARY KEY(idCancion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cancionesdia1 (idCancion INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', Reproducciones INT DEFAULT NULL, Puesto INT DEFAULT NULL, Artista VARCHAR(90) DEFAULT \'NULL\', UNIQUE INDEX idCancion_UNIQUE (idCancion), PRIMARY KEY(idCancion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cancionesdia2 (idCancion INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', Reproducciones INT NOT NULL, Puesto INT NOT NULL, UNIQUE INDEX idCancion_UNIQUE (idCancion), PRIMARY KEY(idCancion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cancionesdia3 (idCancion INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', Reproducciones INT NOT NULL, Puesto INT NOT NULL, UNIQUE INDEX idCancion_UNIQUE (idCancion), PRIMARY KEY(idCancion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solicitud (id INT AUTO_INCREMENT NOT NULL, remitente_id INT NOT NULL, receptor_id INT NOT NULL, estado VARCHAR(255) NOT NULL, INDEX IDX_96D27CC01C3E945F (remitente_id), INDEX IDX_96D27CC0386D8D01 (receptor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (idUsuario INT AUTO_INCREMENT NOT NULL, NombreUsuario VARCHAR(45) NOT NULL, Email VARCHAR(45) NOT NULL, Creditos INT DEFAULT 0 NOT NULL, Password VARCHAR(45) DEFAULT \'NULL\', isAdmin TINYINT(1) DEFAULT NULL, UNIQUE INDEX NombreUsuario_UNIQUE (NombreUsuario), UNIQUE INDEX idUsuario_UNIQUE (idUsuario), UNIQUE INDEX Email_UNIQUE (Email), PRIMARY KEY(idUsuario)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amistades ADD CONSTRAINT FK_64F7488BD394351E FOREIGN KEY (Usuario1_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE amistades ADD CONSTRAINT FK_64F7488B4A76531F FOREIGN KEY (Usuario2_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB6896B76DC FOREIGN KEY (Canciones_idCancion) REFERENCES canciones (idCancion)');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB65DB09530 FOREIGN KEY (Usuarios_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC01C3E945F FOREIGN KEY (remitente_id) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC0386D8D01 FOREIGN KEY (receptor_id) REFERENCES usuarios (idUsuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amistades DROP FOREIGN KEY FK_64F7488BD394351E');
        $this->addSql('ALTER TABLE amistades DROP FOREIGN KEY FK_64F7488B4A76531F');
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB6896B76DC');
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB65DB09530');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC01C3E945F');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC0386D8D01');
        $this->addSql('DROP TABLE CancionesWeek');
        $this->addSql('DROP TABLE amistades');
        $this->addSql('DROP TABLE apuestas');
        $this->addSql('DROP TABLE artistas');
        $this->addSql('DROP TABLE cancionesauxiliar');
        $this->addSql('DROP TABLE cancionesdia1');
        $this->addSql('DROP TABLE cancionesdia2');
        $this->addSql('DROP TABLE cancionesdia3');
        $this->addSql('DROP TABLE solicitud');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
