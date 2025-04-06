<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406121905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fire_brigade_unit (id UUID NOT NULL, superior_unit_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7AB0FDC222FBBFF0 ON fire_brigade_unit (superior_unit_id)');
        $this->addSql('ALTER TABLE fire_brigade_unit ADD CONSTRAINT FK_7AB0FDC222FBBFF0 FOREIGN KEY (superior_unit_id) REFERENCES fire_brigade_unit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fire_brigade_unit DROP CONSTRAINT FK_7AB0FDC222FBBFF0');
        $this->addSql('DROP TABLE fire_brigade_unit');
    }
}
