<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Persistence\Doctrine\Repository;

use App\Fleet\Domain\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Ecotone\Modelling\Attribute\Repository;
use Ecotone\Modelling\StandardRepository;

/**
 * Doctrine implementation of standard Ecotone repository for Vehicle aggregate
 *
 * @author Mariusz Waloszczyk
 * TODO - try to implement better level of abstraction
 */
#[Repository]
final readonly class VehicleDoctrineRepository implements StandardRepository
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function canHandle(string $aggregateClassName): bool
    {
        return $aggregateClassName === Vehicle::class;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    /** @phpstan-ignore-next-line */
    public function findBy(string $aggregateClassName, array $identifiers): ?object
    {
        return $this->entityManager->getRepository(Vehicle::class)
            ->find($identifiers['plateNumber']);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    /** @phpstan-ignore-next-line */
    public function save(array $identifiers, object $aggregate, array $metadata, ?int $versionBeforeHandling): void
    {
        $this->entityManager->persist($aggregate);
        $this->entityManager->flush();
    }
}
