<?php

declare(strict_types=1);

namespace App\Shared\BusinessRuleUtilities\Domain\Exception;

use Throwable;

/**
 * Exception thrown when the business rule was violated
 *
 * @author Mariusz Waloszczyk
 */
final class BusinessRuleViolationException extends \Exception
{
    private int $statusCode;

    /**
     * @param $statusCode
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($statusCode = 422, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     * @author Mariusz Waloszczyk
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
