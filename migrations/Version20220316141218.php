<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316141218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, biography LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, game_id INT NOT NULL, date DATETIME NOT NULL, rate INT DEFAULT NULL, feedback VARCHAR(255) DEFAULT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526CE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE component (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_49FEA157C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE component_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, video VARCHAR(255) DEFAULT NULL, rules VARCHAR(255) DEFAULT NULL, player_min INT NOT NULL, player_max INT NOT NULL, age_min INT NOT NULL, duration INT NOT NULL, year_out INT NOT NULL, editor VARCHAR(100) DEFAULT NULL, distributor VARCHAR(100) DEFAULT NULL, illustrator VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_category (game_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_AD08E6E7E48FD905 (game_id), INDEX IDX_AD08E6E712469DE2 (category_id), PRIMARY KEY(game_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_content (id INT AUTO_INCREMENT NOT NULL, component_id INT DEFAULT NULL, type_id INT NOT NULL, quantity INT NOT NULL, name VARCHAR(50) NOT NULL, material VARCHAR(50) NOT NULL, picture VARCHAR(255) NOT NULL, color VARCHAR(50) NOT NULL, INDEX IDX_6B074F86E2ABAFFF (component_id), INDEX IDX_6B074F86C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, about LONGTEXT DEFAULT NULL, visibility VARCHAR(30) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, address_number INT DEFAULT NULL, city VARCHAR(80) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_game (user_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_59AA7D45A76ED395 (user_id), INDEX IDX_59AA7D45E48FD905 (game_id), PRIMARY KEY(user_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_F7129A803AD8644E (user_source), INDEX IDX_F7129A80233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE component ADD CONSTRAINT FK_49FEA157C54C8C93 FOREIGN KEY (type_id) REFERENCES component_type (id)');
        $this->addSql('ALTER TABLE game_category ADD CONSTRAINT FK_AD08E6E7E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_category ADD CONSTRAINT FK_AD08E6E712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_content ADD CONSTRAINT FK_6B074F86E2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id)');
        $this->addSql('ALTER TABLE game_content ADD CONSTRAINT FK_6B074F86C54C8C93 FOREIGN KEY (type_id) REFERENCES component_type (id)');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_category DROP FOREIGN KEY FK_AD08E6E712469DE2');
        $this->addSql('ALTER TABLE game_content DROP FOREIGN KEY FK_6B074F86E2ABAFFF');
        $this->addSql('ALTER TABLE component DROP FOREIGN KEY FK_49FEA157C54C8C93');
        $this->addSql('ALTER TABLE game_content DROP FOREIGN KEY FK_6B074F86C54C8C93');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CE48FD905');
        $this->addSql('ALTER TABLE game_category DROP FOREIGN KEY FK_AD08E6E7E48FD905');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45E48FD905');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45A76ED395');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80233D34C1');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE component');
        $this->addSql('DROP TABLE component_type');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_category');
        $this->addSql('DROP TABLE game_content');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_game');
        $this->addSql('DROP TABLE user_user');
    }
}
