<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180405000726 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task CHANGE source source VARCHAR(255) NOT NULL, CHANGE project project VARCHAR(255) NOT NULL, CHANGE title title VARCHAR(255) NOT NULL, CHANGE list list VARCHAR(255) NOT NULL, CHANGE url url VARCHAR(255) NOT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(16384) DEFAULT NULL, CHANGE due_date due_date DATETIME DEFAULT NULL, CHANGE task_id task_id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task CHANGE task_id task_id VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE source source VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE project project VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE title title VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE list list VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE url url VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE status status VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE description description VARCHAR(16384) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE due_date due_date DATETIME DEFAULT \'NULL\'');
    }
}
