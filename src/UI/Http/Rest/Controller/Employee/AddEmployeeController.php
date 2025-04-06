<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Employee;

use App\Employee\Application\Command\AddEmployee\AddEmployeeCommand;
use Ecotone\Modelling\CommandBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that adds a new employee
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/employee', methods: ['POST'])]
#[OA\RequestBody(content: new Model(type: AddEmployeeCommand::class))]
#[OA\Response(response: 201, description: 'Employee created')]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Employee")]
final readonly class AddEmployeeController
{
    /**
     * @param CommandBus $commandBus
     * @param AddEmployeeCommand $command
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        CommandBus $commandBus,
        #[MapRequestPayload] AddEmployeeCommand $command
    ): JsonResponse {
        $commandBus->send($command);
        return new JsonResponse(['ok'], 200);
    }
}
