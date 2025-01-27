<?php

declare(strict_types=1);

namespace App\Shared\CommonUtilities;

/**
 * This class contains common operations for strings
 *
 * @author Mariusz Waloszczyk
 */
final class StringUtils
{
    /**
     * @param string $string
     * @param int $min
     * @param int $max
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public static function isLengthBetween(string $string, int $min, int $max): bool
    {
        return mb_strlen($string) >= $min && mb_strlen($string) <= $max;
    }

    /**
     * @param string $string
     * @param array $exclude
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public static function containsSpecialCharacters(string $string, array $exclude = []): bool
    {
        $escapedExclude = array_map('preg_quote', $exclude);

        $pattern = '/[^a-zA-Z0-9' . implode('', $escapedExclude) . ']/';

        return (bool)preg_match($pattern, $string);
    }
}
