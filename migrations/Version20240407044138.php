<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407044138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emarger (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, utilisateur_id INT NOT NULL, presence TINYINT(1) DEFAULT NULL, alternative VARCHAR(50) DEFAULT NULL, heure_arrive TIME DEFAULT NULL, heure_depart TIME DEFAULT NULL, signature TINYINT(1) DEFAULT NULL, INDEX IDX_7EF5C405613FECDF (session_id), INDEX IDX_7EF5C405FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emarger ADD CONSTRAINT FK_7EF5C405613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE emarger ADD CONSTRAINT FK_7EF5C405FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emarger DROP FOREIGN KEY FK_7EF5C405613FECDF');
        $this->addSql('ALTER TABLE emarger DROP FOREIGN KEY FK_7EF5C405FB88E14F');
        $this->addSql('DROP TABLE emarger');
    }
}
