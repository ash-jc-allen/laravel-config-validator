<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('cms')->rules(['array']),
    Rule::make('cms.key')->rules(['string']),
    Rule::make('cms.secret')->rules(['string']),
];
