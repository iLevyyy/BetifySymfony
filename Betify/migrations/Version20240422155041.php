<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422155041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC01C3E945F');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC0386D8D01');
        $this->addSql('DROP INDEX uniq_96d27cc01c3e945f ON solicitud');
        $this->addSql('CREATE INDEX IDX_96D27CC01C3E945F ON solicitud (remitente_id)');
        $this->addSql('DROP INDEX uniq_96d27cc0386d8d01 ON solicitud');
        $this->addSql('CREATE INDEX IDX_96D27CC0386D8D01 ON solicitud (receptor_id)');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC01C3E945F FOREIGN KEY (remitente_id) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC0386D8D01 FOREIGN KEY (receptor_id) REFERENCES usuarios (idUsuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC01C3E945F');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC0386D8D01');
        $this->addSql('DROP INDEX idx_96d27cc01c3e945f ON solicitud');
        $this->addSql('CREATE INDEX UNIQ_96D27CC01C3E945F ON solicitud (remitente_id)');
        $this->addSql('DROP INDEX idx_96d27cc0386d8d01 ON solicitud');
        $this->addSql('CREATE INDEX UNIQ_96D27CC0386D8D01 ON solicitud (receptor_id)');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC01C3E945F FOREIGN KEY (remitente_id) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC0386D8D01 FOREIGN KEY (receptor_id) REFERENCES usuarios (idUsuario)');
    }
}
