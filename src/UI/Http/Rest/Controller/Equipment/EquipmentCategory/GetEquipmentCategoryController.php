<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\EquipmentCategory;

use App\EquipmentRegister\Application\EquipmentCategory\Service\EquipmentCategoryApiService;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that returns details of a single category
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-category/{categoryId}', methods: ['GET'])]
#[OA\Response(response: 200, description: 'Category returned')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Tag(name: "Equipment - Category")]
final readonly class GetEquipmentCategoryController
{
    /**
     * @param EquipmentCategoryApiService $categoryApiService
     * @param string $categoryId
     * @return JsonResponse
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        EquipmentCategoryApiService $categoryApiService,
        string $categoryId
    ): JsonResponse {
        return new JsonResponse(
            $categoryApiService->findById(
                EquipmentCategoryId::fromString($categoryId)
            )
        );
    }
}
