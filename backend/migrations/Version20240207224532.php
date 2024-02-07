<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207224532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pet_breed (id INT AUTO_INCREMENT NOT NULL, breed VARCHAR(255) NOT NULL, is_dangerous TINYINT(1) NOT NULL, type_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_55D348ECC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pet_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pet_breed ADD CONSTRAINT FK_55D348ECC54C8C93 FOREIGN KEY (type_id) REFERENCES pet_type (id)');
        $this->addSql('ALTER TABLE pet ADD name VARCHAR(255) NOT NULL, ADD dob DATE DEFAULT NULL, ADD is_approximate TINYINT(1) NOT NULL, ADD gender VARCHAR(10) NOT NULL, ADD type_id INT NOT NULL, ADD breed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85C54C8C93 FOREIGN KEY (type_id) REFERENCES pet_type (id)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85A8B4A30F FOREIGN KEY (breed_id) REFERENCES pet_breed (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4529B85C54C8C93 ON pet (type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4529B85A8B4A30F ON pet (breed_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pet_breed DROP FOREIGN KEY FK_55D348ECC54C8C93');
        $this->addSql('DROP TABLE pet_breed');
        $this->addSql('DROP TABLE pet_type');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B85C54C8C93');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B85A8B4A30F');
        $this->addSql('DROP INDEX UNIQ_E4529B85C54C8C93 ON pet');
        $this->addSql('DROP INDEX UNIQ_E4529B85A8B4A30F ON pet');
        $this->addSql('ALTER TABLE pet DROP name, DROP dob, DROP is_approximate, DROP gender, DROP type_id, DROP breed_id');
    }
}
