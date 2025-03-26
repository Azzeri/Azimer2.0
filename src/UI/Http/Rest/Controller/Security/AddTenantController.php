<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Security;

use App\Security\Application\Tenant\Command\AddTenant\AddTenantCommand;
use Ecotone\Modelling\CommandBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller to create a new Tenant
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[Route('/tenant', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: AddTenantCommand::class))]
#[OA\Response(response: 201, description: 'Tenant created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Tenant")]
class AddTenantController extends AbstractController
{
    /**
     * @param CommandBus $commandBus
     * @param AddTenantCommand $command
     * @return JsonResponse
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __invoke(
        CommandBus $commandBus,
        #[MapRequestPayload] AddTenantCommand $command
    ): JsonResponse {
        $commandBus->send($command);

        return new JsonResponse(['ok']);
    }
}
