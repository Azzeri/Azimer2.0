<?php

declare(strict_types=1);

namespace App\Tests\Shared\CommonUtilities;

/**
 * Class for reflection testing purposes
 *
 * @author Mariusz Waloszczyk
 */
final readonly class SampleClass
{
    public function __construct(
        private string $name,
    ) {
    }

    private function getName(): string
    {
        return $this->name;
    }
}
