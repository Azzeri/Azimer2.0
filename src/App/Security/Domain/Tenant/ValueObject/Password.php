<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;

/**
 * Password used to authenticate tenant
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class Password extends ValueObject
{
    /**
     * @param string $password
     * @return Password
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public static function fromHashedString(string $password): Password
    {
        return new self($password, null);
    }

    /**
     * @param string $password
     * @return Password
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public static function fromNonHashedString(string $password): Password
    {
        return new self(null, $password);
    }

    /**
     * @return string|null
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function hashed(): ?string
    {
        return $this->hashed;
    }

    /**
     * @return string|null
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function nonHashed(): ?string
    {
        return $this->nonHashed;
    }

    /**
     * @param string|null $hashed
     * @param string|null $nonHashed
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    private function __construct(
        private ?string $hashed = null,
        private ?string $nonHashed = null,
    ) {
    }
}
