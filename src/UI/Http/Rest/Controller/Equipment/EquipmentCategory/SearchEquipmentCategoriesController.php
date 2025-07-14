<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentCategory;

use App\EquipmentRegister\Application\EquipmentCategory\Service\EquipmentCategoryApiService;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that returns list of categories
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-category', methods: ['GET'])]
#[OA\Response(response: 200, description: 'Categories returned')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Tag(name: "Equipment - Category")]
final readonly class SearchEquipmentCategoriesController
{
    /**
     * @param EquipmentCategoryApiService $categoryApiService
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        EquipmentCategoryApiService $categoryApiService,
    ): JsonResponse {
        return new JsonResponse($categoryApiService->search());
    }
}
