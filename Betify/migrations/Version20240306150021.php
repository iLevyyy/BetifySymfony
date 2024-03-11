<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306150021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apuestas (idApuesta INT AUTO_INCREMENT NOT NULL, Cuota DOUBLE PRECISION NOT NULL, Cantidad DOUBLE PRECISION NOT NULL, FechaFinal DATETIME NOT NULL, Artistas_idArtista INT DEFAULT NULL, Canciones_idCancion INT DEFAULT NULL, INDEX fk_Apuestas_Canciones1_idx (Canciones_idCancion), INDEX fk_Apuestas_Artistas1_idx (Artistas_idArtista), PRIMARY KEY(idApuesta)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios_has_apuestas (Apuestas_idApuesta INT NOT NULL, Usuarios_idUsuario INT NOT NULL, INDEX IDX_5AB11100A539A20D (Apuestas_idApuesta), INDEX IDX_5AB111005DB09530 (Usuarios_idUsuario), PRIMARY KEY(Apuestas_idApuesta, Usuarios_idUsuario)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artistas (idArtista INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', UNIQUE INDEX Nombre_UNIQUE (Nombre), PRIMARY KEY(idArtista)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE canciones (idCancion INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(45) DEFAULT \'NULL\', UNIQUE INDEX idCancion_UNIQUE (idCancion), PRIMARY KEY(idCancion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (idUsuario INT AUTO_INCREMENT NOT NULL, NombreUsuario VARCHAR(45) NOT NULL, Email VARCHAR(45) NOT NULL, Password VARCHAR(45) DEFAULT \'NULL\', isAdmin TINYINT(1) DEFAULT NULL, UNIQUE INDEX NombreUsuario_UNIQUE (NombreUsuario), UNIQUE INDEX idUsuario_UNIQUE (idUsuario), UNIQUE INDEX Email_UNIQUE (Email), PRIMARY KEY(idUsuario)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB6A0E63DBC FOREIGN KEY (Artistas_idArtista) REFERENCES artistas (idArtista)');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB6896B76DC FOREIGN KEY (Canciones_idCancion) REFERENCES canciones (idCancion)');
        $this->addSql('ALTER TABLE usuarios_has_apuestas ADD CONSTRAINT FK_5AB11100A539A20D FOREIGN KEY (Apuestas_idApuesta) REFERENCES apuestas (idApuesta)');
        $this->addSql('ALTER TABLE usuarios_has_apuestas ADD CONSTRAINT FK_5AB111005DB09530 FOREIGN KEY (Usuarios_idUsuario) REFERENCES usuarios (idUsuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB6A0E63DBC');
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB6896B76DC');
        $this->addSql('ALTER TABLE usuarios_has_apuestas DROP FOREIGN KEY FK_5AB11100A539A20D');
        $this->addSql('ALTER TABLE usuarios_has_apuestas DROP FOREIGN KEY FK_5AB111005DB09530');
        $this->addSql('DROP TABLE apuestas');
        $this->addSql('DROP TABLE usuarios_has_apuestas');
        $this->addSql('DROP TABLE artistas');
        $this->addSql('DROP TABLE canciones');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
