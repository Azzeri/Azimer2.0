<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;

/**
 * Plain password, usually coming from the client to be checked or hashed
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class PlainPassword extends ValueObject
{
    /**
     * @param string $password
     * @return PlainPassword
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public static function fromString(string $password): PlainPassword
    {
        return new self($password);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function toString(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    private function __construct(
        private string $password,
    ) {
    }
}
