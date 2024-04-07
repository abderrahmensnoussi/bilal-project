<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405005006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, nom_matiere VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle_classe (id INT AUTO_INCREMENT NOT NULL, nom_salle VARCHAR(30) NOT NULL, adresse LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, salle_id INT NOT NULL, matiere_id INT NOT NULL, promotion_id INT NOT NULL, formateur_id INT NOT NULL, intitule VARCHAR(50) NOT NULL, date_session DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, commentaire LONGTEXT DEFAULT NULL, INDEX IDX_D044D5D4DC304035 (salle_id), INDEX IDX_D044D5D4F46CD258 (matiere_id), INDEX IDX_D044D5D4139DF194 (promotion_id), INDEX IDX_D044D5D4155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4DC304035 FOREIGN KEY (salle_id) REFERENCES salle_classe (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4155D8F51 FOREIGN KEY (formateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4DC304035');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4F46CD258');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4139DF194');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4155D8F51');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE salle_classe');
        $this->addSql('DROP TABLE session');
    }
}
