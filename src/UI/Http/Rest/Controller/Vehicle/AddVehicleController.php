<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Vehicle;

use App\Fleet\Application\Command\AddVehicleCommand;
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
#[OA\RequestBody(content: new Model(type: AddVehicleCommand::class))]
#[OA\Response(response: 201, description: 'Vehicle created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Vehicle")]
final readonly class AddVehicleController
{
    /**
     * @param CommandBus $commandBus
     * @param AddVehicleCommand $command
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        CommandBus $commandBus,
        #[MapRequestPayload] AddVehicleCommand $command
    ): JsonResponse {
        $commandBus->send($command);
        return new JsonResponse(['ok'], 200);
    }
}
