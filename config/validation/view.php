<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('paths')->rules(['array']),

    Rule::make('compiled')->rules(['string']),
];
