<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\FireBrigadeUnit;

use App\FireBrigadeUnit\Application\Command\AddFireBrigadeUnit\AddFireBrigadeUnitCommand;
use Ecotone\Modelling\CommandBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that adds a new fire brigade unit
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/fire-brigade-unit', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: AddFireBrigadeUnitCommand::class))]
#[OA\Response(response: 201, description: 'Unit created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Fire Brigade Unit")]
final readonly class AddFireBrigadeUnitController
{
    /**
     * @param CommandBus $commandBus
     * @param AddFireBrigadeUnitCommand $command
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        CommandBus $commandBus,
        #[MapRequestPayload] AddFireBrigadeUnitCommand $command
    ): JsonResponse {
        $commandBus->send($command);
        return new JsonResponse(['ok'], 200);
    }
}
