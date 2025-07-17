<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250715205144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_property ALTER value_value TYPE VARCHAR(128)');
        $this->addSql('ALTER TABLE equipment_property ALTER value_value DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_property ALTER value_value TYPE VARCHAR(128)');
        $this->addSql('ALTER TABLE equipment_property ALTER value_value SET NOT NULL');
    }
}
