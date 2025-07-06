<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer;

use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;
use App\EquipmentRegister\Infrastructure\EquipmentManufacturer\Repository\Persistence\Doctrine\Type\Identifier\EquipmentManufacturerIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;
use Symfony\Component\Uid\Uuid;

/**
 *
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class EquipmentManufacturer extends AggregateRoot
{
    private function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentManufacturerIdType::NAME, unique: true)]
        private EquipmentManufacturerId $id,
        #[ORM\Embedded(class: EquipmentManufacturerName::class)]
        private EquipmentManufacturerName $name
    ) {
    }

    public static function create(
        EquipmentManufacturerName $name
    ) {
        return new self(
            EquipmentManufacturerId::fromString(Uuid::v4()->toString()),
            $name
        );
    }
}
