<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403135610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amistades (id INT AUTO_INCREMENT NOT NULL, Usuario1_idUsuario INT NOT NULL, Usuario2_idUsuario INT NOT NULL, INDEX IDX_64F7488BD394351E (Usuario1_idUsuario), INDEX IDX_64F7488B4A76531F (Usuario2_idUsuario), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amistades ADD CONSTRAINT FK_64F7488BD394351E FOREIGN KEY (Usuario1_idUsuario) REFERENCES usuarios (idusuario)');
        $this->addSql('ALTER TABLE amistades ADD CONSTRAINT FK_64F7488B4A76531F FOREIGN KEY (Usuario2_idUsuario) REFERENCES usuarios (idusuario)');
        $this->addSql('ALTER TABLE amistad DROP FOREIGN KEY FK_8CAEA1CE4A76531F');
        $this->addSql('ALTER TABLE amistad DROP FOREIGN KEY FK_8CAEA1CED394351E');
        $this->addSql('DROP TABLE amistad');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amistad (id INT AUTO_INCREMENT NOT NULL, Usuario1_idUsuario INT NOT NULL, Usuario2_idUsuario INT NOT NULL, INDEX IDX_8CAEA1CED394351E (Usuario1_idUsuario), INDEX IDX_8CAEA1CE4A76531F (Usuario2_idUsuario), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE amistad ADD CONSTRAINT FK_8CAEA1CE4A76531F FOREIGN KEY (Usuario2_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE amistad ADD CONSTRAINT FK_8CAEA1CED394351E FOREIGN KEY (Usuario1_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE amistades DROP FOREIGN KEY FK_64F7488BD394351E');
        $this->addSql('ALTER TABLE amistades DROP FOREIGN KEY FK_64F7488B4A76531F');
        $this->addSql('DROP TABLE amistades');
    }
}
