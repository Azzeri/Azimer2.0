<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\Equipment;

use App\EquipmentRegister\Application\Equipment\Query\Definition\SearchEquipments;
use Ecotone\Modelling\QueryBus;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that returns list of equipments
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment', methods: ['GET'])]
#[OA\Response(response: 200, description: 'Equipments returned')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Tag(name: "Equipment")]
final readonly class SearchEquipmentsController
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
                new SearchEquipments()
            )
        );
    }
}
