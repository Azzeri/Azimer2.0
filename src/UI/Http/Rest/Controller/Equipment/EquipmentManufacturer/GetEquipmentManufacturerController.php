<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentManufacturer;

use App\EquipmentRegister\Application\EquipmentManufacturer\Service\EquipmentManufacturerApiService;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
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
     * @param EquipmentManufacturerApiService $apiService
     * @param string $manufacturerId
     * @return JsonResponse
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        EquipmentManufacturerApiService $apiService,
        string $manufacturerId
    ): JsonResponse {
        return new JsonResponse(
            $apiService->findById(
                EquipmentManufacturerId::fromString($manufacturerId)
            )
        );
    }
}
