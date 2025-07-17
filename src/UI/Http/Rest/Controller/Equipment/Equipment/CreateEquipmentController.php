<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Equipment\Equipment;

use App\EquipmentRegister\Application\Equipment\Command\CreateEquipment\CreateEquipment;
use App\EquipmentRegister\Application\Equipment\Service\EquipmentApiService;
use App\EquipmentRegister\Domain\Equipment\Dto\EquipmentInputData;
use Ecotone\Modelling\CommandBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that adds a new equipment
 *
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/equipment', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: EquipmentInputData::class))]
#[OA\Response(response: 201, description: 'Equipment created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Equipment")]
final readonly class CreateEquipmentController
{
    /**
     * @param EquipmentInputData $inputData
     * @param CommandBus $commandBus
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        #[MapRequestPayload] EquipmentInputData $inputData,
        CommandBus $commandBus
    ): JsonResponse {
        $commandBus->send(new CreateEquipment($inputData));
        return new JsonResponse(['ok'], Response::HTTP_CREATED);
    }
}
