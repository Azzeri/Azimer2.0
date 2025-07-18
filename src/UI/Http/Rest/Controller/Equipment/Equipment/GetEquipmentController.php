<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\Equipment;

use App\EquipmentRegister\Application\Equipment\Query\Definition\GetEquipment;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Ecotone\Modelling\QueryBus;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that returns details of a single equipment
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment/{id}', methods: ['GET'])]
#[OA\Response(response: 200, description: 'Equipment returned')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Tag(name: "Equipment")]
final readonly class GetEquipmentController
{
    /**
     * @param QueryBus $queryBus
     * @param string $id
     * @return JsonResponse
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        QueryBus $queryBus,
        string $id
    ): JsonResponse {
        return new JsonResponse(
            $queryBus->send(
                new GetEquipment(
                    EquipmentId::fromString($id)
                )
            )
        );
    }
}
