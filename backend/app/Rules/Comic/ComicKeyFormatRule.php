<?php

declare(strict_types=1);

namespace App\Rules\Comic;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Packages\Domain\Comic\ComicKey;

class ComicKeyFormatRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match(ComicKey::REGEX_PATTERN, $value)) {
            $fail('The :attribute must be a valid key.');
        }
    }
}
