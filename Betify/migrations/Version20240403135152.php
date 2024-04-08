<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403135152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amistad (id INT AUTO_INCREMENT NOT NULL, usuario1_id INT NOT NULL, usuario2_id INT NOT NULL, INDEX IDX_8CAEA1CEC100AB93 (usuario1_id), INDEX IDX_8CAEA1CED3B5047D (usuario2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amistad ADD CONSTRAINT FK_8CAEA1CEC100AB93 FOREIGN KEY (usuario1_id) REFERENCES usuarios (idusuario)');
        $this->addSql('ALTER TABLE amistad ADD CONSTRAINT FK_8CAEA1CED3B5047D FOREIGN KEY (usuario2_id) REFERENCES usuarios (idusuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amistad DROP FOREIGN KEY FK_8CAEA1CEC100AB93');
        $this->addSql('ALTER TABLE amistad DROP FOREIGN KEY FK_8CAEA1CED3B5047D');
        $this->addSql('DROP TABLE amistad');
    }
}
