<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250819140546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(50) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, deadline, status FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, deadline VARCHAR(255) DEFAULT NULL, status BOOLEAN DEFAULT NULL, description VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO task (id, title, deadline, status) SELECT id, title, deadline, status FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, deadline, status FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, deadline VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO task (id, title, deadline, status) SELECT id, title, deadline, status FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
    }
}