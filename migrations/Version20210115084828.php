<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210115084828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, age INT NOT NULL, parti VARCHAR(255) DEFAULT NULL, wiki VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, nb_vote INT DEFAULT NULL, UNIQUE INDEX UNIQ_6AB5B471989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON DEFAULT NULL, password VARCHAR(255) NOT NULL, codepostal INT NOT NULL, datenaissance INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE villes_france_free (ville_id INT UNSIGNED AUTO_INCREMENT NOT NULL, ville_departement VARCHAR(3) DEFAULT NULL, ville_slug VARCHAR(255) DEFAULT NULL, ville_nom VARCHAR(45) DEFAULT NULL, ville_nom_simple VARCHAR(45) DEFAULT NULL, ville_nom_reel VARCHAR(45) DEFAULT NULL, ville_nom_soundex VARCHAR(20) DEFAULT NULL, ville_nom_metaphone VARCHAR(22) DEFAULT NULL, ville_code_postal VARCHAR(255) DEFAULT NULL, ville_commune VARCHAR(3) DEFAULT NULL, ville_code_commune VARCHAR(5) NOT NULL, ville_arrondissement SMALLINT UNSIGNED DEFAULT NULL, ville_canton VARCHAR(4) DEFAULT NULL, ville_amdi SMALLINT UNSIGNED DEFAULT NULL, ville_population_2010 INT UNSIGNED DEFAULT NULL, ville_population_1999 INT UNSIGNED DEFAULT NULL, ville_population_2012 INT UNSIGNED DEFAULT NULL COMMENT \'approximatif\', ville_densite_2010 INT DEFAULT NULL, ville_surface DOUBLE PRECISION DEFAULT NULL, ville_longitude_deg DOUBLE PRECISION DEFAULT NULL, ville_latitude_deg DOUBLE PRECISION DEFAULT NULL, ville_longitude_grd VARCHAR(9) DEFAULT NULL, ville_latitude_grd VARCHAR(8) DEFAULT NULL, ville_longitude_dms VARCHAR(9) DEFAULT NULL, ville_latitude_dms VARCHAR(8) DEFAULT NULL, ville_zmin INT DEFAULT NULL, ville_zmax INT DEFAULT NULL, INDEX ville_nom (ville_nom), INDEX ville_nom_metaphone (ville_nom_metaphone), INDEX ville_longitude_latitude_deg (ville_longitude_deg, ville_latitude_deg), INDEX ville_nom_reel (ville_nom_reel), INDEX ville_population_2010 (ville_population_2010), INDEX ville_departement (ville_departement), INDEX ville_nom_simple (ville_nom_simple), INDEX ville_nom_soundex (ville_nom_soundex), INDEX ville_code_postal (ville_code_postal), UNIQUE INDEX ville_code_commune_2 (ville_code_commune), UNIQUE INDEX ville_slug (ville_slug), PRIMARY KEY(ville_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_5A108564A76ED395 (user_id), INDEX IDX_5A1085648D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085648D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085648D0EB82');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE villes_france_free');
        $this->addSql('DROP TABLE vote');
    }
}
