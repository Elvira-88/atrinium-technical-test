<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913113453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Sentencia añadida a mano para "sortear" el problema de la relación
        // del campo sector_id de la tabla company porque por ahora
        // no existe ningún sector.
        $this->addSql('INSERT INTO sector (id, name) VALUES (1, "Sector por asignar");');

        // Sentencia modificada a mano para "sortear" el problema de la relación
        // del campo sector_id de la tabla company porque por ahora
        // no existe ningún sector.
        // $this->addSql('ALTER TABLE company ADD sector_id INT NOT NULL');
        $this->addSql('ALTER TABLE company ADD sector_id INT');

        $this->addSql('UPDATE company SET sector_id = 1 WHERE 1;');

        // Sentencia añadida a mano para "sortear" el problema de la relación
        // del campo sector_id de la tabla company porque por ahora
        // no existe ningún sector.
        $this->addSql('ALTER TABLE company MODIFY sector_id INT NOT NULL');

        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FDE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('CREATE INDEX IDX_4FBF094FDE95C867 ON company (sector_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FDE95C867');
        $this->addSql('DROP TABLE sector');
        $this->addSql('DROP INDEX IDX_4FBF094FDE95C867 ON company');
        $this->addSql('ALTER TABLE company DROP sector_id');
    }
}
