<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\EquipmentUsage;

use App\EquipmentUsage\Application\Command\RecordEquipmentUsage\RecordEquipmentUsage;
use App\EquipmentUsage\Domain\Dto\EquipmentUsageInputData;
use Ecotone\Modelling\CommandBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller that records a new usage for an equipment
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment-usage', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: EquipmentUsageInputData::class))]
#[OA\Response(response: 201, description: 'Usage recorded')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Equipment - Usage")]
final readonly class RecordEquipmentUsageController
{
    /**
     * @param CommandBus $commandBus
     * @param EquipmentUsageInputData $inputData
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        CommandBus $commandBus,
        #[MapRequestPayload] EquipmentUsageInputData $inputData
    ): JsonResponse {
        $commandBus->send(new RecordEquipmentUsage($inputData));
        return new JsonResponse(['ok'], Response::HTTP_CREATED);
    }
}
