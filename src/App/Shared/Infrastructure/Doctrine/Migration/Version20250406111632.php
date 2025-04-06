<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406111632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resource (name VARCHAR(64) NOT NULL, PRIMARY KEY(name))');
        $this->addSql('CREATE TABLE role (name VARCHAR(64) NOT NULL, PRIMARY KEY(name))');
        $this->addSql('CREATE TABLE role_resource (role_id VARCHAR(64) NOT NULL, resource_id VARCHAR(64) NOT NULL, PRIMARY KEY(role_id, resource_id))');
        $this->addSql('CREATE INDEX IDX_96421227D60322AC ON role_resource (role_id)');
        $this->addSql('CREATE INDEX IDX_9642122789329D25 ON role_resource (resource_id)');
        $this->addSql('CREATE TABLE tenant (email VARCHAR NOT NULL, status VARCHAR(255) NOT NULL, password_hashed VARCHAR(255) NOT NULL, PRIMARY KEY(email))');
        $this->addSql('CREATE TABLE tenant_role (tenant_id VARCHAR NOT NULL, role_id VARCHAR(64) NOT NULL, PRIMARY KEY(tenant_id, role_id))');
        $this->addSql('CREATE INDEX IDX_1D06D0B99033212A ON tenant_role (tenant_id)');
        $this->addSql('CREATE INDEX IDX_1D06D0B9D60322AC ON tenant_role (role_id)');
        $this->addSql('CREATE TABLE vehicle (plate_number VARCHAR(12) NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, name_make VARCHAR(64) NOT NULL, name_model VARCHAR(64) NOT NULL, production_date_year INT NOT NULL, production_date_month INT DEFAULT NULL, assigned_unit_id_uuid UUID NOT NULL, PRIMARY KEY(plate_number))');
        $this->addSql('ALTER TABLE role_resource ADD CONSTRAINT FK_96421227D60322AC FOREIGN KEY (role_id) REFERENCES role (name) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role_resource ADD CONSTRAINT FK_9642122789329D25 FOREIGN KEY (resource_id) REFERENCES resource (name) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tenant_role ADD CONSTRAINT FK_1D06D0B99033212A FOREIGN KEY (tenant_id) REFERENCES tenant (email) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tenant_role ADD CONSTRAINT FK_1D06D0B9D60322AC FOREIGN KEY (role_id) REFERENCES role (name) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role_resource DROP CONSTRAINT FK_96421227D60322AC');
        $this->addSql('ALTER TABLE role_resource DROP CONSTRAINT FK_9642122789329D25');
        $this->addSql('ALTER TABLE tenant_role DROP CONSTRAINT FK_1D06D0B99033212A');
        $this->addSql('ALTER TABLE tenant_role DROP CONSTRAINT FK_1D06D0B9D60322AC');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_resource');
        $this->addSql('DROP TABLE tenant');
        $this->addSql('DROP TABLE tenant_role');
        $this->addSql('DROP TABLE vehicle');
    }
}
