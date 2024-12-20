<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241220160632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review ADD publisher_id INT NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C640C86FCE FOREIGN KEY (publisher_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_794381C640C86FCE ON review (publisher_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C640C86FCE');
        $this->addSql('DROP INDEX IDX_794381C640C86FCE ON review');
        $this->addSql('ALTER TABLE review DROP publisher_id');
    }
}