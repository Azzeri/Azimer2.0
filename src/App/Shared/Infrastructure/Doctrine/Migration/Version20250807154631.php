<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250807154631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_maintenance ALTER assigned_to_uuid TYPE UUID');
        $this->addSql('ALTER TABLE equipment_maintenance ALTER assigned_to_uuid DROP NOT NULL');
        $this->addSql('ALTER TABLE equipment_maintenance ALTER performed_by_uuid TYPE UUID');
        $this->addSql('ALTER TABLE equipment_maintenance ALTER performed_by_uuid DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_maintenance ALTER assigned_to_uuid TYPE UUID');
        $this->addSql('ALTER TABLE equipment_maintenance ALTER assigned_to_uuid SET NOT NULL');
        $this->addSql('ALTER TABLE equipment_maintenance ALTER performed_by_uuid TYPE UUID');
        $this->addSql('ALTER TABLE equipment_maintenance ALTER performed_by_uuid SET NOT NULL');
    }
}
