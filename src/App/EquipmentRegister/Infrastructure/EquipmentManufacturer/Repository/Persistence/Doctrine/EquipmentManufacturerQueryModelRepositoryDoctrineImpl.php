<?php

namespace App\EquipmentRegister\Infrastructure\EquipmentManufacturer\Repository\Persistence\Doctrine;

use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Dto\EquipmentManufacturerQueryModel;
use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Repository\EquipmentManufacturerQueryModelRepository;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Implementation of {@see EquipmentManufacturerQueryModelRepository}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManufacturerQueryModelRepositoryDoctrineImpl implements
    EquipmentManufacturerQueryModelRepository
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
    public function findById(EquipmentManufacturerId $id): ?EquipmentManufacturerQueryModel
    {
        $manufacturer = $this->getBaseQueryBuilder()
            ->where('manufacturer.id = :id')
            ->setParameter('id', (string)$id)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);

        if (!$manufacturer) {
            return null;
        }

        return $this->mapToDto($manufacturer);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function search(): array
    {
        $result = $this->getBaseQueryBuilder()
            ->getQuery()
            ->getArrayResult();

        return array_map(fn(array $item) => $this->mapToDto($item), $result);
    }

    /**
     * @return QueryBuilder
     * @author Mariusz Waloszczyk
     */
    private function getBaseQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('manufacturer')
            ->from(EquipmentManufacturer::class, 'manufacturer')
            ->orderBy('manufacturer.name.name', 'DESC');

        return $queryBuilder;
    }

    /**
     * @param array<string, mixed> $manufacturer
     * @return EquipmentManufacturerQueryModel
     * @author Mariusz Waloszczyk
     */
    private function mapToDto(mixed $manufacturer): EquipmentManufacturerQueryModel
    {
        return new EquipmentManufacturerQueryModel(
            (string)$manufacturer['id'],
            (string)$manufacturer['name.name'],
        );
    }
}
