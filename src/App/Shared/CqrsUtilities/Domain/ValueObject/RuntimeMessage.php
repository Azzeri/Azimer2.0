<?php

declare(strict_types=1);

namespace App\Shared\CqrsUtilities\Domain\ValueObject;

/**
 * Value object representing a runtime message
 *
 * @author Mariusz Waloszczyk
 */
final readonly class RuntimeMessage
{
    /**
     * Initialize a message
     *
     * @param string $key
     * @param string $value
     * @return static
     * @author Mariusz Waloszczyk
     */
    public static function fromKeyAndValue(string $key, string $value): self
    {
        return new self($key, $value);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function message(): string
    {
        return $this->value;
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @param string $value
     * @author Mariusz Waloszczyk
     */
    private function __construct(private string $key, private string $value)
    {
    }
}
