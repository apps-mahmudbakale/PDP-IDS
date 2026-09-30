<?php

namespace App\Http\Controllers\Concerns;

trait ValidatesMemberFields
{
    /**
     * Validation rules for a member's code.
     *
     * Codes are conventionally "STF-<CATEGORY>-001", which is 11 characters,
     * so a 10-character limit rejected a valid code. The limit keeps
     * headroom for four-digit sequences and longer category prefixes.
     *
     * Defined once so the rule cannot drift between controllers.
     */
    protected function pscodeRules(): string
    {
        return 'nullable|string|max:20';
    }
}
