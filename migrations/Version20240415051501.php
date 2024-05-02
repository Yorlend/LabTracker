<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415051501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, solution_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, data DATETIME NOT NULL, INDEX IDX_9474526C55857BD0 (solution_id_id), INDEX IDX_9474526C9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, lab_id_id INT DEFAULT NULL, solution_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8C9F36101888489F (lab_id_id), INDEX IDX_8C9F361055857BD0 (solution_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, teacher_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6DC044C52EBB220A (teacher_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lab (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lab_group (lab_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_A0C920D628913D5 (lab_id), INDEX IDX_A0C920DFE54D947 (group_id), PRIMARY KEY(lab_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solution (id INT AUTO_INCREMENT NOT NULL, lab_id_id INT NOT NULL, user_id_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, state SMALLINT NOT NULL, INDEX IDX_9F3329DB1888489F (lab_id_id), INDEX IDX_9F3329DB9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_belongs_id INT DEFAULT NULL, user_name VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role SMALLINT NOT NULL, INDEX IDX_8D93D64984D7E1E3 (user_belongs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group (id INT AUTO_INCREMENT NOT NULL, group_id_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8F02BF9D2F68B530 (group_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C55857BD0 FOREIGN KEY (solution_id_id) REFERENCES solution (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36101888489F FOREIGN KEY (lab_id_id) REFERENCES lab (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361055857BD0 FOREIGN KEY (solution_id_id) REFERENCES solution (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C52EBB220A FOREIGN KEY (teacher_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lab_group ADD CONSTRAINT FK_A0C920D628913D5 FOREIGN KEY (lab_id) REFERENCES lab (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lab_group ADD CONSTRAINT FK_A0C920DFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DB1888489F FOREIGN KEY (lab_id_id) REFERENCES lab (id)');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DB9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64984D7E1E3 FOREIGN KEY (user_belongs_id) REFERENCES user_group (id)');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9D2F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C55857BD0');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36101888489F');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361055857BD0');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C52EBB220A');
        $this->addSql('ALTER TABLE lab_group DROP FOREIGN KEY FK_A0C920D628913D5');
        $this->addSql('ALTER TABLE lab_group DROP FOREIGN KEY FK_A0C920DFE54D947');
        $this->addSql('ALTER TABLE solution DROP FOREIGN KEY FK_9F3329DB1888489F');
        $this->addSql('ALTER TABLE solution DROP FOREIGN KEY FK_9F3329DB9D86650F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64984D7E1E3');
        $this->addSql('ALTER TABLE user_group DROP FOREIGN KEY FK_8F02BF9D2F68B530');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE lab');
        $this->addSql('DROP TABLE lab_group');
        $this->addSql('DROP TABLE solution');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_group');
    }
}
