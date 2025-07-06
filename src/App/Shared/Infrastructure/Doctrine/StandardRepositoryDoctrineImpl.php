<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use App\Shared\Domain\Repository\StandardRepository;
use App\Shared\DomainUtilities\Domain\IdentifierValueObject;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Ecotone\Modelling\StandardRepository as EcotoneStandardRepository;

/**
 * A generic implementation of two repository interfaces:
 *  - Ecotone for automated aggregate actions
 *  - Domain for clear and readable domain repositories
 *
 * @template T of object
 * @implements StandardRepository<T>
 * @author Mariusz Waloszczyk
 */
abstract readonly class StandardRepositoryDoctrineImpl implements StandardRepository, EcotoneStandardRepository
{
    /**
     * @param EntityManagerInterface $entityManager
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * This method should return the name of the aggregate class managed by the repository
     *
     * @return string
     * @author Mariusz Waloszczyk
     */
    abstract public function getClassName(): string;

    /**
     * This method should return identifier's property name of the aggregate class managed by the repository
     *
     * @return string
     * @author Mariusz Waloszczyk
     */
    abstract public function getIdentifierPropertyName(): string;

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function findById(IdentifierValueObject $id): object
    {
        $model = $this->findBy($this->getClassName(), [$this->getIdentifierPropertyName() => (string)$id]);
        if (null === $model) {
            throw new ResourceNotFoundException();
        }
        return $model;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function persist(object $object): void
    {
        $this->save([], $object, [], null);
    }

    /**
     * @inheritDoc
     * @param mixed[] $identifiers
     * @author Mariusz Waloszczyk
     */
    public function findBy(string $aggregateClassName, array $identifiers): ?object
    {
        return $this->entityManager->getRepository($this->getClassName())
            ->find($identifiers[$this->getIdentifierPropertyName()]);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function save(array $identifiers, object $aggregate, array $metadata, ?int $versionBeforeHandling): void
    {
        $this->entityManager->persist($aggregate);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function canHandle(string $aggregateClassName): bool
    {
        return $aggregateClassName === $this->getClassName();
    }
}
