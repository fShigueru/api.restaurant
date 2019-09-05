<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190815233144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE variation_meal ADD meal_id INT NOT NULL');
        $this->addSql('ALTER TABLE variation_meal ADD CONSTRAINT FK_E5A42882639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
        $this->addSql('CREATE INDEX IDX_E5A42882639666D6 ON variation_meal (meal_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE variation_meal DROP FOREIGN KEY FK_E5A42882639666D6');
        $this->addSql('DROP INDEX IDX_E5A42882639666D6 ON variation_meal');
        $this->addSql('ALTER TABLE variation_meal DROP meal_id');
    }
}
