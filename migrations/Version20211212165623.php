<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211212165623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, leader_id_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6DC044C5EFE6DECF (leader_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_project (id INT AUTO_INCREMENT NOT NULL, id_group INT NOT NULL, id_project INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, manager_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_init DATE NOT NULL, deadline DATE NOT NULL, date_fin DATE DEFAULT NULL, INDEX IDX_2FB3D0EE569B5E6D (manager_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_group (id INT AUTO_INCREMENT NOT NULL, id_project_id INT NOT NULL, id_group_id INT NOT NULL, INDEX IDX_7E954D5BB3E79F4B (id_project_id), INDEX IDX_7E954D5BAE8F35D2 (id_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, group_id_id INT NOT NULL, project_id_id INT NOT NULL, user_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, done TINYINT(1) NOT NULL, date_init DATE NOT NULL, deadline DATE NOT NULL, date_fin DATE DEFAULT NULL, INDEX IDX_527EDB252F68B530 (group_id_id), INDEX IDX_527EDB256C1197C9 (project_id_id), INDEX IDX_527EDB259D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, group_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(180) DEFAULT NULL, password2 VARCHAR(180) DEFAULT NULL, encpassword VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649EC595A10 (password2), INDEX IDX_8D93D6492F68B530 (group_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5EFE6DECF FOREIGN KEY (leader_id_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE569B5E6D FOREIGN KEY (manager_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project_group ADD CONSTRAINT FK_7E954D5BB3E79F4B FOREIGN KEY (id_project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_group ADD CONSTRAINT FK_7E954D5BAE8F35D2 FOREIGN KEY (id_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB252F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB259D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_group DROP FOREIGN KEY FK_7E954D5BAE8F35D2');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB252F68B530');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492F68B530');
        $this->addSql('ALTER TABLE project_group DROP FOREIGN KEY FK_7E954D5BB3E79F4B');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB256C1197C9');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5EFE6DECF');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE569B5E6D');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB259D86650F');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_project');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_group');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE user');
    }
}
