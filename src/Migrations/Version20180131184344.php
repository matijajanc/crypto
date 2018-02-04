<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180131184344 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE cryptocurrency ADD COLUMN title VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__cryptocurrency AS SELECT id, tokens, invested_money FROM cryptocurrency');
        $this->addSql('DROP TABLE cryptocurrency');
        $this->addSql('CREATE TABLE cryptocurrency (id INTEGER NOT NULL, tokens NUMERIC(10, 3) NOT NULL, invested_money NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO cryptocurrency (id, tokens, invested_money) SELECT id, tokens, invested_money FROM __temp__cryptocurrency');
        $this->addSql('DROP TABLE __temp__cryptocurrency');
    }
}
