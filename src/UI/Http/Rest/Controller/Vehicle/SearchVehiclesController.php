<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Vehicle;

use App\Fleet\Application\Query\Definition\SearchVehiclesQuery;
use App\Fleet\Domain\Dto\VehicleQueryModel;
use Ecotone\Modelling\QueryBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that searches for vehicles
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[Route('/vehicle', methods: ['GET'])]
#[OA\Response(
    response: 200,
    description: 'Returns the list of vehicles',
    content: new OA\JsonContent(
        type: 'array',
        items: new OA\Items(ref: new Model(type: VehicleQueryModel::class))
    )
)]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
final readonly class SearchVehiclesController
{
    /**
     * @param Request $request
     * @param QueryBus $queryBus
     * @return JsonResponse
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    #[OA\Tag(name: "Vehicle")]
    public function __invoke(
        Request $request,
        QueryBus $queryBus,
    ): JsonResponse {
        $vehicles = $queryBus->send(new SearchVehiclesQuery());
        return new JsonResponse($vehicles, 200);
    }
}
