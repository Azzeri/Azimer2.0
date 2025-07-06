<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250619113320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_category ADD category_name VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE equipment_category DROP name_name');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_368F9DE7D5B80441 ON equipment_category (category_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_368F9DE7D5B80441');
        $this->addSql('ALTER TABLE equipment_category ADD name_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE equipment_category DROP category_name');
    }
}
