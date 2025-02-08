<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Persistence\Elastic;

use App\Fleet\Domain\Dto\VehicleQueryModel;
use Elastica\Result;
use FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerInterface;

/**
 * Implementation of {@see ElasticaToModelTransformerInterface} for Vehicle
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class ElasticaToVehicleTransformer implements ElasticaToModelTransformerInterface
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function transform(array $elasticaObjects): array
    {
        $result = [];
        /** @var Result $elasticaObject */
        foreach ($elasticaObjects as $elasticaObject) {
            $result[] = $this->mapElasticaResultToDto($elasticaObject);
        }

        return $result;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function hybridTransform(array $elasticaObjects): array
    {
        $result = [];
        /** @var Result $elasticaObject */
        foreach ($elasticaObjects as $elasticaObject) {
            $result[] = $this->mapElasticaResultToDto($elasticaObject);
        }

        return $result;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getObjectClass(): string
    {
        return VehicleQueryModel::class;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getIdentifierField(): string
    {
        return 'plateNumber';
    }

    /**
     * Maps elastica result to DTO
     *
     * @param Result $object
     * @return VehicleQueryModel
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    private function mapElasticaResultToDto(Result $object): VehicleQueryModel
    {
        return new VehicleQueryModel(
            $object->__get('plateNumber'),
            $object->__get('status'),
            $object->__get('type'),
            $object->__get('make'),
            $object->__get('model'),
            $object->__get('productionYear'),
            $object->__get('assignedUnitId'),
            $object->__get('productionMonth'),
        );
    }
}
