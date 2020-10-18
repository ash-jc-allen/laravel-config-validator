<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('host')
        ->rules(['string'])
        ->messages(['string' => 'This is a custom message.']),

    Rule::make('port')
        ->rules(['integer']),

    Rule::make('from.address')
        ->rules(['email', 'required']),

    Rule::make('from.to')
        ->rules(['string', 'required']),
];
