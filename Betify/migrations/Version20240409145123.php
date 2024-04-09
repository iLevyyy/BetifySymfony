<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409145123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE solicitud (id INT AUTO_INCREMENT NOT NULL, remitente_id INT NOT NULL, receptor_id INT NOT NULL, estado VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_96D27CC01C3E945F (remitente_id), UNIQUE INDEX UNIQ_96D27CC0386D8D01 (receptor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC01C3E945F FOREIGN KEY (remitente_id) REFERENCES usuarios (idusuario)');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC0386D8D01 FOREIGN KEY (receptor_id) REFERENCES usuarios (idusuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC01C3E945F');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC0386D8D01');
        $this->addSql('DROP TABLE solicitud');
    }
}
