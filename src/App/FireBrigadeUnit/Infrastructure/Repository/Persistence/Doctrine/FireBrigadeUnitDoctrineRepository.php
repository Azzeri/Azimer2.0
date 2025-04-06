<?php

declare(strict_types=1);

namespace App\FireBrigadeUnit\Infrastructure\Repository\Persistence\Doctrine;

use App\FireBrigadeUnit\Domain\FireBrigadeUnit;
use App\FireBrigadeUnit\Domain\Repository\FireBrigadeUnitRepository;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see FireBrigadeUnitRepository}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class FireBrigadeUnitDoctrineRepository extends StandardRepositoryDoctrineImpl implements
    FireBrigadeUnitRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return FireBrigadeUnit::class;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getIdentifierPropertyName(): string
    {
        return 'id';
    }
}
