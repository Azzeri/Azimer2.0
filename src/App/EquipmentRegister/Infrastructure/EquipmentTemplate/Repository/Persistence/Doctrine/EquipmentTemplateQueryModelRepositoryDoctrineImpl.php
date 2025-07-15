<?php

namespace App\EquipmentRegister\Infrastructure\EquipmentTemplate\Repository\Persistence\Doctrine;

use App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto\EquipmentTemplateQueryModel;
use App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto\EquipmentTemplateQueryModelCategory;
use App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto\EquipmentTemplateQueryModelManufacturer;
use App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto\EquipmentTemplateQueryModelProperty;
use App\EquipmentRegister\Application\EquipmentTemplate\Query\Repository\EquipmentTemplateQueryModelRepository;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Implementation of {@see EquipmentTemplateQueryModelRepository}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentTemplateQueryModelRepositoryDoctrineImpl implements
    EquipmentTemplateQueryModelRepository
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
    public function findById(EquipmentTemplateId $id): ?EquipmentTemplateQueryModel
    {
        $template = $this->getBaseQueryBuilder()
            ->where('template.id = :id')
            ->setParameter('id', (string)$id)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);

        if (!$template) {
            return null;
        }

        return $this->mapToDto($template);
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
            ->select('template', 'manufacturer', 'category', 'properties', 'propertiesDefinition')
            ->from(EquipmentTemplate::class, 'template')
            ->leftJoin('template.manufacturer', 'manufacturer')
            ->leftJoin('template.category', 'category')
            ->leftJoin('template.properties', 'properties')
            ->leftJoin('properties.definition', 'propertiesDefinition')
            ->orderBy('template.name.name', 'DESC');

        return $queryBuilder;
    }

    /**
     * @param array<string, mixed> $template
     * @return EquipmentTemplateQueryModel
     * @author Mariusz Waloszczyk
     */
    private function mapToDto(mixed $template): EquipmentTemplateQueryModel
    {
        $category = new EquipmentTemplateQueryModelCategory(
            (string)$template['category']['id'],
            (string)$template['category']['name.name'],
        );
        $manufacturer = new EquipmentTemplateQueryModelManufacturer(
            (string)$template['manufacturer']['id'],
            (string)$template['manufacturer']['name.name'],
        );
        $properties = array_map(
            fn(array $property) => new EquipmentTemplateQueryModelProperty(
                (string)$property['definition']['id'],
                (string)$property['definition']['name.name'],
                ($property['definition']['propertyType'])->value,
                $property['isRequired'],
            ),
            $template['properties']
        );

        return new EquipmentTemplateQueryModel(
            (string)$template['id'],
            (string)$template['name.name'],
            $category,
            $manufacturer,
            $properties,
        );
    }
}
