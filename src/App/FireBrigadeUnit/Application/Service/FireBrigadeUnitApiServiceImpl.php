<?php

declare(strict_types=1);

namespace App\FireBrigadeUnit\Application\Service;

use App\FireBrigadeUnit\Domain\FireBrigadeUnit;
use App\FireBrigadeUnit\Domain\Repository\FireBrigadeUnitRepository;
use App\FireBrigadeUnit\Domain\ValueObject\FireBrigadeUnitId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Implementation of {@see FireBrigadeUnitApiService}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FireBrigadeUnitApiServiceImpl implements FireBrigadeUnitApiService
{
    /**
     * @param FireBrigadeUnitRepository $fireBrigadeUnitRepository
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private FireBrigadeUnitRepository $fireBrigadeUnitRepository
    ) {
    }

    /**
     * @inheritDoc
     * @throws InvalidDataException|ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function isUnitSuperiorTo(string $unitToCheck, string $unitToCheckAgainst): bool
    {
        /** @var FireBrigadeUnit $unitAggregate */
        $unitAggregate = $this->fireBrigadeUnitRepository->findById(FireBrigadeUnitId::fromString($unitToCheck));

        return $unitAggregate->isSuperiorOf(FireBrigadeUnitId::fromString($unitToCheckAgainst));
    }

    /**
     * @inheritDoc
     * @throws InvalidDataException|ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function isUnitSubservientTo(string $unitToCheck, string $unitToCheckAgainst): bool
    {
        /** @var FireBrigadeUnit $unitAggregate */
        $unitAggregate = $this->fireBrigadeUnitRepository->findById(FireBrigadeUnitId::fromString($unitToCheck));

        return $unitAggregate->isSubservientTo(FireBrigadeUnitId::fromString($unitToCheckAgainst));
    }
}
