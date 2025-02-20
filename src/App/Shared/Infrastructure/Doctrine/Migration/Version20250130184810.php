<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130184810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicle (plate_number VARCHAR(12) NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, name_make VARCHAR(64) NOT NULL, name_model VARCHAR(64) NOT NULL, production_date_year INT NOT NULL, production_date_month INT DEFAULT NULL, assigned_unit_id_uuid UUID NOT NULL, PRIMARY KEY(plate_number))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vehicle');
    }
}
