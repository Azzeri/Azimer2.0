<?php

namespace App\EquipmentRegister\Infrastructure\Equipment\Repository\Persistence\Doctrine;

use App\EquipmentRegister\Application\Equipment\Query\Dto\EquipmentQueryModel;
use App\EquipmentRegister\Application\Equipment\Query\Dto\EquipmentQueryModelCategory;
use App\EquipmentRegister\Application\Equipment\Query\Dto\EquipmentQueryModelManufacturer;
use App\EquipmentRegister\Application\Equipment\Query\Dto\EquipmentQueryModelProperty;
use App\EquipmentRegister\Application\Equipment\Query\Dto\EquipmentQueryModelUsage;
use App\EquipmentRegister\Application\Equipment\Query\Repository\EquipmentQueryModelRepository;
use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Implementation of {@see EquipmentQueryModelRepository}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentQueryModelRepositoryDoctrineImpl implements EquipmentQueryModelRepository
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
    public function findById(EquipmentId $id): ?EquipmentQueryModel
    {
        $manufacturer = $this->getBaseQueryBuilder()
            ->where('equipment.id = :id')
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
            ->select(
                'equipment',
                'equipmentTemplate',
                'equipmentProperties',
                'templateProperty',
                'templatePropertyDefinition',
                'manufacturer',
                'category'
            )
            ->from(Equipment::class, 'equipment')
            ->leftJoin('equipment.properties', 'equipmentProperties')
            ->leftJoin('equipment.equipmentTemplate', 'equipmentTemplate')
            ->leftJoin('equipmentProperties.templateProperty', 'templateProperty')
            ->leftJoin('templateProperty.definition', 'templatePropertyDefinition')
            ->leftJoin('equipmentTemplate.manufacturer', 'manufacturer')
            ->leftJoin('equipmentTemplate.category', 'category');

        return $queryBuilder;
    }

    /**
     * @param array<string, mixed> $equipment
     * @return EquipmentQueryModel
     * @author Mariusz Waloszczyk
     */
    private function mapToDto(mixed $equipment): EquipmentQueryModel
    {
        $properties = [];
        foreach ($equipment['properties'] as $property) {
            $properties[] = new EquipmentQueryModelProperty(
                $property['id'],
                $property['templateProperty']['definition']['id'],
                $property['templateProperty']['definition']['name.name'],
                $property['templateProperty']['definition']['propertyType']->value,
                $property['templateProperty']['isRequired'],
                $property['value.value'],
            );
        }

        $category = new EquipmentQueryModelCategory(
            $equipment['equipmentTemplate']['category']['id'],
            $equipment['equipmentTemplate']['category']['name.name'],
        );
        $manufacturer = new EquipmentQueryModelManufacturer(
            $equipment['equipmentTemplate']['manufacturer']['id'],
            $equipment['equipmentTemplate']['manufacturer']['name.name'],
        );

        return new EquipmentQueryModel(
            $equipment['id'],
            $equipment['status']->value,
            $equipment['equipmentTemplate']['name.name'],
            $equipment['ownerId.uuid'],
            $manufacturer,
            $category,
            $properties,
            $this->getUsages($equipment['id'])
        );
    }

    /**
     * @param string $equipmentId
     * @return array<int, EquipmentQueryModelUsage>
     * @throws Exception
     * @author Mariusz Waloszczyk
     */
    private function getUsages(string $equipmentId): array
    {
        $query = '
            SELECT
                usage.id as "usageId",
                usingPerson.id as "usingPersonId",
                CONCAT(usingPerson.full_name_first_name, \' \', usingPerson.full_name_last_name) as "usingPersonName",
                usage.usage_period_usage_from as "usedFrom",
                usage.usage_period_usage_to as "usedTo",
                usage.description_body as "description"
            FROM
                equipment_usage usage
            INNER JOIN employee usingPerson ON usingPerson.id = usage.using_person_uuid
            WHERE usage.used_equipment_uuid = :equipmentId
        ';
        $usages = $this->entityManager->getConnection()
            ->fetchAllAssociative(
                $query,
                ['equipmentId' => $equipmentId]
            );

        return array_map(fn(array $item) => new EquipmentQueryModelUsage(...$item), $usages);
    }
}

