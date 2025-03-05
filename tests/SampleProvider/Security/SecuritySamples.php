<?php

declare(strict_types=1);

namespace Tests\SampleProvider\Security;

use Symfony\Component\Uid\Uuid;

use function Pest\Faker\fake;

/**
 * Generates sample security data
 *
 * @author Mariusz Waloszczyk
 */
final readonly class SecuritySamples
{
    /**
     * @param string[] $permissions
     * @return array<string, string|array<int,string>>
     * @author Mariusz Waloszczyk
     */
    public static function apiUser(array $permissions): array
    {
        return [
            'id' => fake()->numerify("####"),
            'fireBrigadeUnitId' => Uuid::v4()->toString(),
            'permissions' => $permissions
        ];
    }
}
