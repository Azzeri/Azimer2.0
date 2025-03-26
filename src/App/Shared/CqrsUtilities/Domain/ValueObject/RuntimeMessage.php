<?php

declare(strict_types=1);

namespace App\Shared\CqrsUtilities\Domain\ValueObject;

/**
 * Value object representing a runtime message
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class RuntimeMessage
{
    /**
     * Initialize a message
     *
     * @param string $key
     * @param string $value
     * @return static
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public static function fromKeyAndValue(string $key, string $value): self
    {
        return new self($key, $value);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function message(): string
    {
        return $this->value;
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @param string $value
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    private function __construct(private string $key, private string $value)
    {
    }
}
