<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentTemplate;

use App\EquipmentRegister\Application\EquipmentTemplate\Service\EquipmentTemplateApiService;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that returns details of a single template
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-template/{templateId}', methods: ['GET'])]
#[OA\Response(response: 200, description: 'Template returned')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Tag(name: "Equipment - Template")]
final readonly class GetEquipmentTemplateController
{
    /**
     * @param EquipmentTemplateApiService $apiService
     * @param string $templateId
     * @return JsonResponse
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        EquipmentTemplateApiService $apiService,
        string $templateId
    ): JsonResponse {
        return new JsonResponse(
            $apiService->findById(
                EquipmentTemplateId::fromString($templateId)
            )
        );
    }
}
