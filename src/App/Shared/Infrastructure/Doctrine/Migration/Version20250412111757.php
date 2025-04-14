<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250412111757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_equipment_property DROP CONSTRAINT fk_9e815faa517fe9fe');
        $this->addSql('ALTER TABLE equipment_equipment_property DROP CONSTRAINT fk_9e815faa35d0e7cb');
        $this->addSql('DROP TABLE equipment_equipment_property');
        $this->addSql('ALTER TABLE equipment_property ADD equipment_id UUID NOT NULL');
        $this->addSql('ALTER TABLE equipment_property ADD CONSTRAINT FK_BB3198F8517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BB3198F8517FE9FE ON equipment_property (equipment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment_equipment_property (equipment_id UUID NOT NULL, equipment_property_id INT NOT NULL, PRIMARY KEY(equipment_id, equipment_property_id))');
        $this->addSql('CREATE INDEX idx_9e815faa35d0e7cb ON equipment_equipment_property (equipment_property_id)');
        $this->addSql('CREATE INDEX idx_9e815faa517fe9fe ON equipment_equipment_property (equipment_id)');
        $this->addSql('ALTER TABLE equipment_equipment_property ADD CONSTRAINT fk_9e815faa517fe9fe FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE equipment_equipment_property ADD CONSTRAINT fk_9e815faa35d0e7cb FOREIGN KEY (equipment_property_id) REFERENCES equipment_property (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE equipment_property DROP CONSTRAINT FK_BB3198F8517FE9FE');
        $this->addSql('DROP INDEX IDX_BB3198F8517FE9FE');
        $this->addSql('ALTER TABLE equipment_property DROP equipment_id');
    }
}
