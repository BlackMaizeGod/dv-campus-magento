<?php

declare(strict_types=1);

namespace GeekHub\AskQuestion\Validator;

/**
 * Class Validator
 *
 * @package GeekHub\AskQuestion\Validator
 */
class UaPhone
{
    /**
     * Validate phone number
     *
     * @param $phoneNumber
     *
     * @return bool
     */
    public function isValid(string $phoneNumber): bool
    {
        return $phoneNumber{0} && preg_match('/^38[\d]{10}$/', substr($phoneNumber, 1));
    }
}
