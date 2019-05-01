<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190430181225 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE expedient (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, workgroup VARCHAR(255) NOT NULL, created DATETIME NOT NULL, contrary VARCHAR(255) DEFAULT NULL, opponent VARCHAR(255) NOT NULL, matter VARCHAR(255) NOT NULL, jurisdiction VARCHAR(255) NOT NULL, comments VARCHAR(500) DEFAULT NULL, INDEX IDX_F38F876119EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expedient ADD CONSTRAINT FK_F38F876119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE phone_one phone_one VARCHAR(255) DEFAULT NULL, CHANGE phone_two phone_two VARCHAR(255) DEFAULT NULL, CHANGE additional_info additional_info VARCHAR(500) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE expedient');
        $this->addSql('ALTER TABLE client CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE phone_one phone_one VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE phone_two phone_two VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE additional_info additional_info VARCHAR(500) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
