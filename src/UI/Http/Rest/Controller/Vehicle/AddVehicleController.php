<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Vehicle;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Fleet\Domain\Dto\VehicleInputData;
use Ecotone\Modelling\CommandBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that adds a new vehicle
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/vehicle', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: VehicleInputData::class))]
#[OA\Response(response: 200, description: 'Vehicle created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
final readonly class AddVehicleController
{
    /**
     * @param CommandBus $commandBus
     * @param VehicleInputData $vehicleInput
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    #[OA\Tag(name: "Vehicle")]
    public function __invoke(
        CommandBus $commandBus,
        #[MapRequestPayload] VehicleInputData $vehicleInput
    ): JsonResponse {
        $commandBus->send(new AddVehicleCommand($vehicleInput));
        return new JsonResponse(['ok'], 200);
    }
}
