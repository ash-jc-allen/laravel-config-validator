<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('paths')->rules(['string']),

    Rule::make('compiled')->rules(['string']),
];
