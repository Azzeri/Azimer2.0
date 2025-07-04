<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentCategory;

use App\EquipmentRegister\Application\EquipmentCategory\Service\EquipmentCategoryApiService;
use App\EquipmentRegister\Domain\EquipmentCategory\Dto\EquipmentCategoryInputData;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that adds a new equipment category
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-category', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: EquipmentCategoryInputData::class))]
#[OA\Response(response: 201, description: 'Category created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Equipment - Category")]
final readonly class CreateEquipmentCategoryController
{
    /**
     * @param EquipmentCategoryApiService $categoryApiService
     * @param EquipmentCategoryInputData $inputData
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        EquipmentCategoryApiService $categoryApiService,
        #[MapRequestPayload] EquipmentCategoryInputData $inputData
    ): JsonResponse {
        $categoryApiService->createCategory($inputData);
        return new JsonResponse(['ok'], 200);
    }
}
