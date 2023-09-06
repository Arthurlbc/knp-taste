<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230905083639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Database main for application knp-taste, tables user and courses';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, video VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_A9A55A4C5E237E06 (name), UNIQUE INDEX UNIQ_A9A55A4C7CC7DA2C (video), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user DROP is_verified, DROP register_at, DROP video_viewed');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, ADD register_at DATETIME NOT NULL, ADD video_viewed INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE courses');
        $this->addSql('DROP TABLE user');
    }
}
