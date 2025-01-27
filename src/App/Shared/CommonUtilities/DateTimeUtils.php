<?php

declare(strict_types=1);

namespace App\Shared\CommonUtilities;

use Carbon\Month;

/**
 * This class contains common operations for date and time
 *
 * @author Mariusz Waloszczyk
 */
final class DateTimeUtils
{
    /**
     * @param int $month
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public static function isValidMonth(int $month): bool
    {
        return Month::tryFrom($month) !== null;
    }
}
