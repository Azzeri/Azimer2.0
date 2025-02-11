<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Persistence\Elastic;

use App\Fleet\Domain\Enum\VehicleStatus;
use App\Fleet\Domain\Enum\VehicleType;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Fleet\Domain\ValueObject\VehicleName;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Fleet\Domain\ValueObject\VehicleProductionDate;
use App\Fleet\Domain\Vehicle;
use App\Shared\CommonUtilities\ReflectionUtils;
use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use ReflectionException;

/**
 * Implementation of {@see ModelToElasticaTransformerInterface} for Vehicle
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehicleToElasticaTransformer implements ModelToElasticaTransformerInterface
{
    /**
     * @inheritDoc
     * @throws ReflectionException
     * @author Mariusz Waloszczyk
     */
    public function transform(object $object, array $fields): Document
    {
        if (!$object instanceof Vehicle) {
            throw new \InvalidArgumentException('Expected instance of Vehicle');
        }

        /** @var VehiclePlateNumber $plateNumber */
        $plateNumber = ReflectionUtils::getReflectionPropertyValue($object, 'plateNumber');

        /** @var VehicleType $type */
        $type = ReflectionUtils::getReflectionPropertyValue($object, 'type');

        /** @var VehicleName $name */
        $name = ReflectionUtils::getReflectionPropertyValue($object, 'name');

        /** @var VehicleStatus $status */
        $status = ReflectionUtils::getReflectionPropertyValue($object, 'status');

        /** @var VehicleProductionDate $productionDate */
        $productionDate = ReflectionUtils::getReflectionPropertyValue($object, 'productionDate');

        /** @var AssignedUnitId $assignedUnitId */
        $assignedUnitId = ReflectionUtils::getReflectionPropertyValue($object, 'assignedUnitId');

        return new Document(
            (string)$plateNumber,
            [
                'plateNumber' => (string)$plateNumber,
                'status' => $status->value,
                'make' => $name->make(),
                'model' => $name->model(),
                'type' => $type->value,
                'productionYear' => $productionDate->year(),
                'productionMonth' => $productionDate->month(),
                'assignedUnitId' => (string)$assignedUnitId
            ]
        );
    }
}
