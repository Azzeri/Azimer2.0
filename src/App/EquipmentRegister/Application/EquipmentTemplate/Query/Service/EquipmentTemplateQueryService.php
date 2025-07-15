<?php

namespace App\EquipmentRegister\Application\EquipmentTemplate\Query\Service;

use App\EquipmentRegister\Application\EquipmentTemplate\Query\Definition\GetEquipmentTemplate;
use App\EquipmentRegister\Application\EquipmentTemplate\Query\Definition\SearchEquipmentTemplates;
use App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto\EquipmentTemplateQueryModel;
use App\EquipmentRegister\Application\EquipmentTemplate\Query\Repository\EquipmentTemplateQueryModelRepository;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;
use Ecotone\Modelling\Attribute\QueryHandler;

/**
 * Handlers for equipment template queries
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentTemplateQueryService
{
    /**
     * @param EquipmentTemplateQueryModelRepository $repository
     */
    public function __construct(private EquipmentTemplateQueryModelRepository $repository)
    {
    }

    /**
     * @param GetEquipmentTemplate $query
     * @return QueryItem<EquipmentTemplateQueryModel>|null
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function findOne(GetEquipmentTemplate $query): ?QueryItem
    {
        $template = $this->repository->findById($query->id);
        return $template !== null
            ? QueryItem::create($query->id->toString(), $template)
            : null;
    }

    /**
     * @param SearchEquipmentTemplates $query
     * @return QueryItemCollection<EquipmentTemplateQueryModel>
     * @psalm-suppress UnusedParam
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function search(SearchEquipmentTemplates $query): QueryItemCollection
    {
        $templates = $this->repository->search();
        $items = array_map(
            fn(EquipmentTemplateQueryModel $template) => QueryItem::create(
                $template->id,
                $template
            ),
            $templates
        );
        return QueryItemCollection::create($items);
    }
}
