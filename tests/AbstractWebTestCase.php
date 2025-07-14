<?php

namespace Tests;

use App\Security\Domain\Resource\Resource;
use App\Security\Domain\Resource\ValueObject\ResourceId;
use App\Security\Domain\Role\Role;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\InMemoryUser;

/**
 * Class to configure PEST web tests - from controller to database
 *
 * @author Mariusz Waloszczyk
 */
abstract class AbstractWebTestCase extends WebTestCase
{
    /** @var string Email of user used in feature tests */
    public const string TEST_USER_EMAIL = 'azimertestuser@azimer.com';

    /** @var string Role of user used in feature tests - requested permissions will be assigned to this role */
    public const string TEST_USER_ROLE = 'azimer_test_user_role';

    /** @var KernelBrowser $client Can be used to handle HTTP requests */
    protected KernelBrowser $client;

    /** @var EntityManagerInterface $entityManager Useful to check data in database */
    protected EntityManagerInterface $entityManager;

    /**
     * Kernel must be shut down for Symfony test HTTP client
     *
     * @return void
     * @author Mariusz Waloszczyk
     */
    protected function setUp(): void
    {
        static::ensureKernelShutdown();
        parent::setUp();
        $this->client = self::createClient();
        $this->client->disableReboot();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->service(EntityManagerInterface::class);
        $this->entityManager = $entityManager;
    }

    /**
     * Wrapper to get a service
     *
     * @param string $serviceId
     * @return object|null
     * @author Mariusz Waloszczyk
     */
    protected function service(string $serviceId): ?object
    {
        return self::getContainer()->get($serviceId);
    }

    /**
     * Save the requested entities with option to flush tem
     *
     * @param array<int, object> $entities
     * @param bool $flush
     * @return void
     * @author Mariusz Waloszczyk
     */
    protected function saveEntities(array $entities, bool $flush = true): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
        }
        if ($flush) {
            $this->entityManager->flush();
        }
    }

    /**
     * Retrieve entity from persistence with criteria
     *
     * @param class-string $class
     * @param array<string, mixed> $criteria
     * @return object|null
     * @author Mariusz Waloszczyk
     */
    protected function getEntity(string $class, array $criteria): ?object
    {
        return $this->entityManager->getRepository($class)
            ->findOneBy($criteria);
    }

    /**
     * Send a GET request and return response. Token is generated for the requested permissions.
     *
     * @param string $uri
     * @param array<int, string> $tenantPermissions
     * @return Response
     * @author Mariusz Waloszczyk
     */
    protected function sendGet(string $uri, array $tenantPermissions): Response
    {
        $this->client->request(
            method: 'GET',
            uri: $uri,
            server: [
                'HTTP_Authorization' => $this->getJwtWithPermissions($tenantPermissions)
            ],
        );

        return $this->client->getResponse();
    }

    /**
     * Send a POST request and return response. Token is generated for the requested permissions.
     *
     * @param array|object $payload
     * @param string $uri
     * @param array<int, string> $tenantPermissions
     * @return Response
     * @author Mariusz Waloszczyk
     */
    protected function sendPost(array|object $payload, string $uri, array $tenantPermissions): Response
    {
        $payload = json_encode($payload);
        if ($payload === false) {
            throw new \Exception("Invalid JSON payload");
        }
        $this->client->request(
            method: 'POST',
            uri: $uri,
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => $this->getJwtWithPermissions($tenantPermissions)
            ],
            content: $payload
        );

        return $this->client->getResponse();
    }

    /**
     * Decode client's response to array
     *
     * @return mixed
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    protected function decodeResponse(): mixed
    {
        $responseContent = $this->client->getResponse()
            ->getContent();

        return json_decode($responseContent, true);
    }

    /**
     * Generate JWT token for test user. User will have the requested permissions assigned
     *
     * @param array<int, string> $permissions
     * @return string
     * @author Mariusz Waloszczyk
     */
    protected function getJwtWithPermissions(array $permissions): string
    {
        /** @var Role $role */
        $role = $this->entityManager->getRepository(Role::class)
            ->findOneBy(['name' => self::TEST_USER_ROLE]);
        foreach ($permissions as $permission) {
            $role->assignResource(Resource::create(ResourceId::fromUniqueName($permission)));
        }
        $this->saveEntities([$role]);

        /** @var JWTTokenManagerInterface $jwtManager */
        $jwtManager = $this->service(JWTTokenManagerInterface::class);
        return 'Bearer ' . $jwtManager->create(
                new InMemoryUser(self::TEST_USER_EMAIL, 'Azimer1234#.', [self::TEST_USER_ROLE])
            );
    }
}
