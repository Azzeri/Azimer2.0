<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer;

use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;
// phpcs:ignore Generic.Files.LineLength.TooLong
use App\EquipmentRegister\Infrastructure\EquipmentManufacturer\Repository\Persistence\Doctrine\Type\Identifier\EquipmentManufacturerIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;

/**
 * Aggregate representing equipment manufacturers
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class EquipmentManufacturer extends AggregateRoot
{
    /**
     * @param EquipmentManufacturerId $id
     * @param EquipmentManufacturerName $name
     */
    public function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentManufacturerIdType::NAME, unique: true)]
        private EquipmentManufacturerId $id,
        #[ORM\Embedded(class: EquipmentManufacturerName::class)]
        private EquipmentManufacturerName $name
    ) {
    }

    /**
     * @return EquipmentManufacturerId
     * @author Mariusz Waloszczyk
     */
    public function getId(): EquipmentManufacturerId
    {
        return $this->id;
    }
}
