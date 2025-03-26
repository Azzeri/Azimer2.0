<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;

/**
 * Token generated when tenant was successfully authenticated.
 * This token will be used to access API
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class AuthenticationToken extends ValueObject
{
    /**
     * @param string $token
     * @return AuthenticationToken
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public static function fromString(string $token): AuthenticationToken
    {
        return new self($token);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function value(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    private function __construct(private string $token)
    {
    }
}
