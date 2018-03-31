<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180331151931 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP site_name, CHANGE status status VARCHAR(100) DEFAULT NULL, CHANGE description description VARCHAR(100) DEFAULT NULL, CHANGE due_date due_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task ADD site_name VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE status status VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE description description VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE due_date due_date DATETIME NOT NULL');
    }
}
