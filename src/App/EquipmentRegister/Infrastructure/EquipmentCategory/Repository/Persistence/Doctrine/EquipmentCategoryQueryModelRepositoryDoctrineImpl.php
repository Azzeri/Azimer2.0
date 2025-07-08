<?php

namespace App\EquipmentRegister\Infrastructure\EquipmentCategory\Repository\Persistence\Doctrine;

use App\EquipmentRegister\Application\EquipmentCategory\Query\Dto\EquipmentCategoryQueryModel;
use App\EquipmentRegister\Application\EquipmentCategory\Query\Repository\EquipmentCategoryQueryModelRepository;
use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Implementation of {@see EquipmentCategoryQueryModelRepository}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentCategoryQueryModelRepositoryDoctrineImpl implements EquipmentCategoryQueryModelRepository
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
    public function findById(EquipmentCategoryId $id): ?EquipmentCategoryQueryModel
    {
        $category = $this->getBaseQueryBuilder()
            ->where('category.id = :id')
            ->setParameter('id', (string)$id)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);

        if (!$category) {
            return null;
        }

        return $this->mapToDto($category);
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
            ->select('category', 'subcategories', 'parent')
            ->from(EquipmentCategory::class, 'category')
            ->leftJoin('category.subcategories', 'subcategories')
            ->leftJoin('category.parentCategory', 'parent')
            ->orderBy('category.name.name', 'DESC');

        return $queryBuilder;
    }

    /**
     * @param array<string, mixed> $category
     * @return EquipmentCategoryQueryModel
     * @author Mariusz Waloszczyk
     */
    private function mapToDto(mixed $category): EquipmentCategoryQueryModel
    {
        $subcategories = array_map(
            fn(array $sub) => $this->mapToDto($sub),
            $category['subcategories'] ?? []
        );

        $parent = isset($category['parentCategory'])
            ? $this->mapToDto($category['parentCategory'])
            : null;


        return new EquipmentCategoryQueryModel(
            (string)$category['id'],
            (string)$category['name.name'],
            $subcategories,
            $parent
        );
    }
}
