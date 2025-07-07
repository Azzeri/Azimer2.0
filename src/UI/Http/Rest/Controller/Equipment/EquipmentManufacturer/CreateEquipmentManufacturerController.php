<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentManufacturer;

use App\EquipmentRegister\Application\EquipmentManufacturer\Service\EquipmentManufacturerApiService;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Dto\EquipmentManufacturerInputData;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that adds a new equipment manufacturer
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-manufacturer', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: EquipmentManufacturerInputData::class))]
#[OA\Response(response: 201, description: 'Manufacturer created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Equipment - Manufacturer")]
final readonly class CreateEquipmentManufacturerController
{
    /**
     * @param EquipmentManufacturerApiService $manufacturerApiService
     * @param EquipmentManufacturerInputData $inputData
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        EquipmentManufacturerApiService $manufacturerApiService,
        #[MapRequestPayload] EquipmentManufacturerInputData $inputData
    ): JsonResponse {
        $manufacturerApiService->createManufacturer($inputData);
        return new JsonResponse(['ok'], Response::HTTP_CREATED);
    }
}
