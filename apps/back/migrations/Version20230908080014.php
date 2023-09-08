<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230908080014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Database main for application knp-taste, tables user and courses';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE courses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, video VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_A9A55A4C5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, register_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', video_viewed INT NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courses ADD report_number INT NOT NULL');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, video VARCHAR(180) NOT NULL, report_number INT NOT NULL, UNIQUE INDEX UNIQ_169E6FB95E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE courses');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE user');
    }
}
