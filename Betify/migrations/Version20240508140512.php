<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240508140512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apuestas DROP FOREIGN KEY FK_AE7EB6A0E63DBC');
        $this->addSql('DROP INDEX fk_Apuestas_Artistas1_idx ON apuestas');
        $this->addSql('ALTER TABLE apuestas DROP Artistas_idArtista');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apuestas ADD Artistas_idArtista INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apuestas ADD CONSTRAINT FK_AE7EB6A0E63DBC FOREIGN KEY (Artistas_idArtista) REFERENCES artistas (idArtista)');
        $this->addSql('CREATE INDEX fk_Apuestas_Artistas1_idx ON apuestas (Artistas_idArtista)');
    }
}
