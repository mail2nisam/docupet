<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213183637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE breed (id INT AUTO_INCREMENT NOT NULL, breed VARCHAR(255) NOT NULL, is_dangerous TINYINT(1) NOT NULL, type_id INT NOT NULL, INDEX IDX_F8AF884FC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dob DATE DEFAULT NULL, approximate_dob TINYINT(1) NOT NULL, cross_breed TINYINT(1) NOT NULL, gender VARCHAR(10) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pet_breed (id INT AUTO_INCREMENT NOT NULL, pet_id INT DEFAULT NULL, breed_id INT DEFAULT NULL, INDEX IDX_55D348EC966F7FB6 (pet_id), INDEX IDX_55D348ECA8B4A30F (breed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pet_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE breed ADD CONSTRAINT FK_F8AF884FC54C8C93 FOREIGN KEY (type_id) REFERENCES pet_type (id)');
        $this->addSql('ALTER TABLE pet_breed ADD CONSTRAINT FK_55D348EC966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id)');
        $this->addSql('ALTER TABLE pet_breed ADD CONSTRAINT FK_55D348ECA8B4A30F FOREIGN KEY (breed_id) REFERENCES breed (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE breed DROP FOREIGN KEY FK_F8AF884FC54C8C93');
        $this->addSql('ALTER TABLE pet_breed DROP FOREIGN KEY FK_55D348EC966F7FB6');
        $this->addSql('ALTER TABLE pet_breed DROP FOREIGN KEY FK_55D348ECA8B4A30F');
        $this->addSql('DROP TABLE breed');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE pet_breed');
        $this->addSql('DROP TABLE pet_type');
        $this->addSql('DROP TABLE user');
    }
}
