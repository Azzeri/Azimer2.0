<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentTemplate;

use App\EquipmentRegister\Application\EquipmentTemplate\Service\EquipmentTemplateApiService;
use App\EquipmentRegister\Domain\EquipmentTemplate\Dto\EquipmentTemplateInputData;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that adds a new equipment template
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-template', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: EquipmentTemplateInputData::class))]
#[OA\Response(response: 201, description: 'Template created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Equipment - Template")]
final readonly class CreateEquipmentTemplateController
{
    /**
     * @param EquipmentTemplateApiService $apiService
     * @param EquipmentTemplateInputData $inputData
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        EquipmentTemplateApiService $apiService,
        #[MapRequestPayload] EquipmentTemplateInputData $inputData
    ): JsonResponse {
        $apiService->createTemplate($inputData);
        return new JsonResponse(['ok'], Response::HTTP_CREATED);
    }
}
