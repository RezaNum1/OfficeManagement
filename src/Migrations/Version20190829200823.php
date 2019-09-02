<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829200823 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE jabatan (id INT AUTO_INCREMENT NOT NULL, jabatan VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE karyawan ADD jabatan_id INT NOT NULL');
        $this->addSql('ALTER TABLE karyawan ADD CONSTRAINT FK_7382F2ABA7400487 FOREIGN KEY (jabatan_id) REFERENCES jabatan (id)');
        $this->addSql('CREATE INDEX IDX_7382F2ABA7400487 ON karyawan (jabatan_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE karyawan DROP FOREIGN KEY FK_7382F2ABA7400487');
        $this->addSql('DROP TABLE jabatan');
        $this->addSql('DROP INDEX IDX_7382F2ABA7400487 ON karyawan');
        $this->addSql('ALTER TABLE karyawan DROP jabatan_id');
    }
}
