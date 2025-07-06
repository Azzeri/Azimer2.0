<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Repository\Persistence\Doctrine;

use App\Fleet\Domain\Vehicle;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of standard Ecotone repository for Vehicle aggregate
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class VehicleDoctrineRepository extends StandardRepositoryDoctrineImpl
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return Vehicle::class;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getIdentifierPropertyName(): string
    {
        return 'plateNumber';
    }
}
