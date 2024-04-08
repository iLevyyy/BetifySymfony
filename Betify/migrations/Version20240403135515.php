<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403135515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amistad DROP FOREIGN KEY FK_8CAEA1CEC100AB93');
        $this->addSql('ALTER TABLE amistad DROP FOREIGN KEY FK_8CAEA1CED3B5047D');
        $this->addSql('DROP INDEX IDX_8CAEA1CEC100AB93 ON amistad');
        $this->addSql('DROP INDEX IDX_8CAEA1CED3B5047D ON amistad');
        $this->addSql('ALTER TABLE amistad ADD Usuario1_idUsuario INT NOT NULL, ADD Usuario2_idUsuario INT NOT NULL, DROP usuario1_id, DROP usuario2_id');
        $this->addSql('ALTER TABLE amistad ADD CONSTRAINT FK_8CAEA1CED394351E FOREIGN KEY (Usuario1_idUsuario) REFERENCES usuarios (idusuario)');
        $this->addSql('ALTER TABLE amistad ADD CONSTRAINT FK_8CAEA1CE4A76531F FOREIGN KEY (Usuario2_idUsuario) REFERENCES usuarios (idusuario)');
        $this->addSql('CREATE INDEX IDX_8CAEA1CED394351E ON amistad (Usuario1_idUsuario)');
        $this->addSql('CREATE INDEX IDX_8CAEA1CE4A76531F ON amistad (Usuario2_idUsuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amistad DROP FOREIGN KEY FK_8CAEA1CED394351E');
        $this->addSql('ALTER TABLE amistad DROP FOREIGN KEY FK_8CAEA1CE4A76531F');
        $this->addSql('DROP INDEX IDX_8CAEA1CED394351E ON amistad');
        $this->addSql('DROP INDEX IDX_8CAEA1CE4A76531F ON amistad');
        $this->addSql('ALTER TABLE amistad ADD usuario1_id INT NOT NULL, ADD usuario2_id INT NOT NULL, DROP Usuario1_idUsuario, DROP Usuario2_idUsuario');
        $this->addSql('ALTER TABLE amistad ADD CONSTRAINT FK_8CAEA1CEC100AB93 FOREIGN KEY (usuario1_id) REFERENCES usuarios (idUsuario)');
        $this->addSql('ALTER TABLE amistad ADD CONSTRAINT FK_8CAEA1CED3B5047D FOREIGN KEY (usuario2_id) REFERENCES usuarios (idUsuario)');
        $this->addSql('CREATE INDEX IDX_8CAEA1CEC100AB93 ON amistad (usuario1_id)');
        $this->addSql('CREATE INDEX IDX_8CAEA1CED3B5047D ON amistad (usuario2_id)');
    }
}
