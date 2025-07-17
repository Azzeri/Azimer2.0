<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentManufacturer;

use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Definition\GetEquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Ecotone\Modelling\QueryBus;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that returns details of a single manufacturer
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-manufacturer/{manufacturerId}', methods: ['GET'])]
#[OA\Response(response: 200, description: 'Manufacturer returned')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Tag(name: "Equipment - Manufacturer")]
final readonly class GetEquipmentManufacturerController
{
    /**
     * @param QueryBus $queryBus
     * @param string $manufacturerId
     * @return JsonResponse
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        QueryBus $queryBus,
        string $manufacturerId
    ): JsonResponse {
        return new JsonResponse(
            $queryBus->send(
                new GetEquipmentManufacturer(
                    EquipmentManufacturerId::fromString($manufacturerId)
                )
            )
        );
    }
}
