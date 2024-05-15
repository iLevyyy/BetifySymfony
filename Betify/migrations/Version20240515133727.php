<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515133727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amistades DROP FOREIGN KEY FK_64F7488B4A76531F');
        $this->addSql('ALTER TABLE amistades DROP FOREIGN KEY FK_64F7488BD394351E');
        $this->addSql('ALTER TABLE amistades ADD CONSTRAINT FK_64F7488B4A76531F FOREIGN KEY (Usuario2_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE amistades ADD CONSTRAINT FK_64F7488BD394351E FOREIGN KEY (Usuario1_idUsuario) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC0386D8D01');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC01C3E945F');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC0386D8D01 FOREIGN KEY (receptor_id) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC01C3E945F FOREIGN KEY (remitente_id) REFERENCES usuarios (idUsuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amistades DROP FOREIGN KEY FK_64F7488BD394351E');
        $this->addSql('ALTER TABLE amistades DROP FOREIGN KEY FK_64F7488B4A76531F');
        $this->addSql('ALTER TABLE amistades ADD CONSTRAINT FK_64F7488BD394351E FOREIGN KEY (Usuario1_idUsuario) REFERENCES usuarios (idUsuario) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amistades ADD CONSTRAINT FK_64F7488B4A76531F FOREIGN KEY (Usuario2_idUsuario) REFERENCES usuarios (idUsuario) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC01C3E945F');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC0386D8D01');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC01C3E945F FOREIGN KEY (remitente_id) REFERENCES usuarios (idUsuario) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC0386D8D01 FOREIGN KEY (receptor_id) REFERENCES usuarios (idUsuario) ON DELETE CASCADE');
    }
}
