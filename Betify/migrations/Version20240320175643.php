<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320175643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuarios_has_apuestas DROP FOREIGN KEY FK_5AB111005DB09530');
        $this->addSql('ALTER TABLE usuarios_has_apuestas DROP FOREIGN KEY FK_5AB11100A539A20D');
        $this->addSql('DROP TABLE usuarios_has_apuestas');
        $this->addSql('ALTER TABLE apuestas ADD Usuarios_idUsuario INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB65DB09530 FOREIGN KEY (Usuarios_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('CREATE INDEX IDX_AE7EB65DB09530 ON apuestas (Usuarios_idUsuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE usuarios_has_apuestas (Apuestas_idApuesta INT NOT NULL, Usuarios_idUsuario INT NOT NULL, INDEX IDX_5AB111005DB09530 (Usuarios_idUsuario), INDEX IDX_5AB11100A539A20D (Apuestas_idApuesta), PRIMARY KEY(Apuestas_idApuesta, Usuarios_idUsuario)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE usuarios_has_apuestas ADD CONSTRAINT FK_5AB111005DB09530 FOREIGN KEY (Usuarios_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE usuarios_has_apuestas ADD CONSTRAINT FK_5AB11100A539A20D FOREIGN KEY (Apuestas_idApuesta) REFERENCES apuestas (idApuesta)');
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB65DB09530');
        $this->addSql('DROP INDEX IDX_AE7EB65DB09530 ON apuestas');
        $this->addSql('ALTER TABLE apuestas DROP Usuarios_idUsuario');
    }
}
