<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522131945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB65DB09530');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB65DB09530 FOREIGN KEY (Usuarios_idUsuario) REFERENCES usuarios (idUsuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB65DB09530');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB65DB09530 FOREIGN KEY (Usuarios_idUsuario) REFERENCES usuarios (idUsuario) ON DELETE CASCADE');
    }
}
