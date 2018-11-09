<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20181106015842 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE agents ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agents ADD CONSTRAINT FK_9596AB6EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9596AB6EA76ED395 ON agents (user_id)');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT fk_1483a5e93414710b');
        $this->addSql('DROP INDEX uniq_1483a5e93414710b');
        $this->addSql('ALTER TABLE users DROP agent_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE agents DROP CONSTRAINT FK_9596AB6EA76ED395');
        $this->addSql('DROP INDEX UNIQ_9596AB6EA76ED395');
        $this->addSql('ALTER TABLE agents DROP user_id');
        $this->addSql('ALTER TABLE users ADD agent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT fk_1483a5e93414710b FOREIGN KEY (agent_id) REFERENCES agents (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e93414710b ON users (agent_id)');
    }
}
