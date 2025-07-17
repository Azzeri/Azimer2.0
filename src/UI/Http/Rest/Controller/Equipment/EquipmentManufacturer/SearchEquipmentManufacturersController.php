<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentManufacturer;

use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Definition\SearchEquipmentManufacturers;
use Ecotone\Modelling\QueryBus;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that returns list of manufacturers
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-manufacturer', methods: ['GET'])]
#[OA\Response(response: 200, description: 'Manufacturers returned')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Tag(name: "Equipment - Manufacturer")]
final readonly class SearchEquipmentManufacturersController
{
    /**
     * @param QueryBus $queryBus
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        QueryBus $queryBus,
    ): JsonResponse {
        return new JsonResponse(
            $queryBus->send(
                new SearchEquipmentManufacturers()
            )
        );
    }
}
