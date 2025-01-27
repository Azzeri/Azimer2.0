<?php

declare(strict_types=1);

namespace App\Shared\BusinessRuleUtilities\Domain\ValueObject;

/**
 * Single notification message of a business rule
 *
 * @author Mariusz Waloszczyk
 */
final readonly class BusinessRuleNotification
{
    /**
     * @param string $message
     */
    private function __construct(
        private string $message
    ) {
    }

    /**
     * Return notification's content
     *
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * Create a new notification from a string
     *
     * @param string $message
     * @return self
     * @author Mariusz Waloszczyk
     */
    public static function fromString(string $message): self
    {
        return new self($message);
    }
}
