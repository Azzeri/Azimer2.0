<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Security;

use App\Security\Domain\Tenant\Dto\TenantQueryModel;
use App\Security\Domain\Tenant\Repository\TenantQueryRepository;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Security\Infrastructure\Tenant\Symfony\AuthenticatedUser\AuthenticatedUserProvider;
use Ecotone\Modelling\QueryBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that searches for tenants
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Route('/tenant', methods: ['GET'])]
#[OA\Response(
    response: 200,
    description: 'Returns the list of tenants',
    content: new OA\JsonContent(
        type: 'array',
        items: new OA\Items(ref: new Model(type: TenantQueryModel::class))
    )
)]
#[OA\Response(response: 404, description: 'Resource not found')]
#[OA\Response(response: 403, description: 'User unauthorized')]
#[OA\Response(response: 401, description: 'User unauthenticated')]
#[OA\Response(response: 422, description: 'Request data is invalid')]
#[OA\Tag(name: "Security")]
final readonly class SearchTenantsController
{
    /**
     * @param QueryBus $queryBus
     * @return JsonResponse
     * @author Mariusz Waloszczyk
     */
    public function __invoke(
        QueryBus $queryBus,
        TenantQueryRepository $tenantQueryRepository,
        AuthenticatedUserProvider $authenticatedUserProvider
    ): JsonResponse {
        $data = [
            $tenantQueryRepository->findByIdentifier(TenantId::fromEmail('admin@example.com')),
        ];
//        var_dump($authenticatedUserProvider->loadUserByIdentifier('string@gmail.com'));

        return new JsonResponse($data, 200);
    }
}
