<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('paths')->rules(['array']),

    Rule::make('allowed_methods')->rules(['array']),

    Rule::make('allowed_origins')->rules(['array']),

    Rule::make('allowed_origins_patterns')->rules(['array']),

    Rule::make('allowed_headers')->rules(['array']),

    Rule::make('max_age')->rules(['integer']),

    Rule::make('supports_credentials')->rules(['bool']),

];
