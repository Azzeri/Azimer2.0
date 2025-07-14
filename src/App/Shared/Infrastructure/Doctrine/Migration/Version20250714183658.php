<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250714183658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment_template_property_definition (id VARCHAR NOT NULL, property_type VARCHAR(255) NOT NULL, name_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE equipment_template_equipment_template_property DROP CONSTRAINT fk_485944d96498fb9f');
        $this->addSql('ALTER TABLE equipment_template_equipment_template_property DROP CONSTRAINT fk_485944d9d2e64afd');
        $this->addSql('DROP TABLE equipment_template_equipment_template_property');
        $this->addSql('ALTER TABLE equipment_template_property ADD template_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE equipment_template_property ADD definition_id VARCHAR DEFAULT NULL');
        $this->addSql('ALTER TABLE equipment_template_property DROP property_type');
        $this->addSql('ALTER TABLE equipment_template_property DROP name');
        $this->addSql('ALTER TABLE equipment_template_property RENAME COLUMN can_be_null TO is_required');
        $this->addSql('ALTER TABLE equipment_template_property ALTER is_required TYPE BOOLEAN');
        $this->addSql('ALTER TABLE equipment_template_property ADD CONSTRAINT FK_BB1DE1F5DA0FB8 FOREIGN KEY (template_id) REFERENCES equipment_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE equipment_template_property ADD CONSTRAINT FK_BB1DE1FD11EA911 FOREIGN KEY (definition_id) REFERENCES equipment_template_property_definition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BB1DE1F5DA0FB8 ON equipment_template_property (template_id)');
        $this->addSql('CREATE INDEX IDX_BB1DE1FD11EA911 ON equipment_template_property (definition_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment_template_equipment_template_property (equipment_template_id UUID NOT NULL, equipment_template_property_id INT NOT NULL, PRIMARY KEY(equipment_template_id, equipment_template_property_id))');
        $this->addSql('CREATE INDEX idx_485944d9d2e64afd ON equipment_template_equipment_template_property (equipment_template_property_id)');
        $this->addSql('CREATE INDEX idx_485944d96498fb9f ON equipment_template_equipment_template_property (equipment_template_id)');
        $this->addSql('ALTER TABLE equipment_template_equipment_template_property ADD CONSTRAINT fk_485944d96498fb9f FOREIGN KEY (equipment_template_id) REFERENCES equipment_template (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE equipment_template_equipment_template_property ADD CONSTRAINT fk_485944d9d2e64afd FOREIGN KEY (equipment_template_property_id) REFERENCES equipment_template_property (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE equipment_template_property_definition');
        $this->addSql('ALTER TABLE equipment_template_property DROP CONSTRAINT FK_BB1DE1F5DA0FB8');
        $this->addSql('ALTER TABLE equipment_template_property DROP CONSTRAINT FK_BB1DE1FD11EA911');
        $this->addSql('DROP INDEX IDX_BB1DE1F5DA0FB8');
        $this->addSql('DROP INDEX IDX_BB1DE1FD11EA911');
        $this->addSql('ALTER TABLE equipment_template_property ADD property_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE equipment_template_property ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE equipment_template_property DROP template_id');
        $this->addSql('ALTER TABLE equipment_template_property DROP definition_id');
        $this->addSql('ALTER TABLE equipment_template_property RENAME COLUMN is_required TO can_be_null');
        $this->addSql('ALTER TABLE equipment_template_property ALTER can_be_null TYPE BOOLEAN');
    }
}
