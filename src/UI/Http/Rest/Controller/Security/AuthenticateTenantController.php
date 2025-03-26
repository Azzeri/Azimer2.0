<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Security;

use App\Security\Application\Command\AuthenticateTenant\AuthenticateTenantCommand;
use App\Security\Application\Command\AuthenticateTenant\AuthenticateTenantCommandHandler;
use App\Shared\CqrsUtilities\Domain\Repository\RuntimeMessageCollectorRepository;
use Ecotone\Modelling\CommandBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/authenticate', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: AuthenticateTenantCommand::class))]
#[OA\Response(response: 201, description: 'Tenant created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Tenant")]
class AuthenticateTenantController extends AbstractController
{
    /**
     * @param AuthenticateTenantCommand $command
     * @param CommandBus $commandBus
     * @param RuntimeMessageCollectorRepository $runtimeMessageCollectorRepository
     * @return JsonResponse
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __invoke(
        #[MapRequestPayload] AuthenticateTenantCommand $command,
        CommandBus $commandBus,
        RuntimeMessageCollectorRepository $runtimeMessageCollectorRepository,
    ): JsonResponse {
        $commandBus->send($command);

        $token = $runtimeMessageCollectorRepository
            ->findByKey(AuthenticateTenantCommandHandler::JWT_TOKEN_MESSAGE_KEY);

        return new JsonResponse(['token' => $token[0]->message()]);
    }
}
