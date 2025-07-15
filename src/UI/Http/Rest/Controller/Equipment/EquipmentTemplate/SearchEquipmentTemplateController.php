<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentTemplate;

use App\EquipmentRegister\Application\EquipmentTemplate\Service\EquipmentTemplateApiService;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that returns list of templates
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-template', methods: ['GET'])]
#[OA\Response(response: 200, description: 'Templates returned')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Tag(name: "Equipment - Template")]
final readonly class SearchEquipmentTemplateController
{
    /**
     * @param EquipmentTemplateApiService $apiService
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        EquipmentTemplateApiService $apiService,
    ): JsonResponse {
        return new JsonResponse($apiService->search());
    }
}
