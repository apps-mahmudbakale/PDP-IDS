<?php

namespace App\Enums;

class MemberTitles
{
    public static function all(): array
    {
        return [
            'Mr' => 'Mr',
            'Mrs' => 'Mrs',
            'Miss' => 'Miss',
            'Ms' => 'Ms',
            'Dr' => 'Dr',
            'Prof' => 'Prof',
            'Eng' => 'Eng',
            'Arch' => 'Arch',
            'Senator' => 'Senator',
            'Hon' => 'Hon',
            'SAN' => 'SAN',
            'Chief' => 'Chief',
            'Alhaji' => 'Alhaji',
            'Alh' => 'Alh',
            'Oba' => 'Oba',
            'Emir' => 'Emir',
            'Prince' => 'Prince',
            'Princess' => 'Princess',
        ];
    }
}
