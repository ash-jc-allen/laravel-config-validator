<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('name')->rules(['string']),

    Rule::make('env')->rules(['string']),

    Rule::make('debug')->rules(['bool']),

    Rule::make('url')->rules(['url']),

    Rule::make('asset_url')->rules(['url', 'nullable']),

    Rule::make('timezone')->rules(['string']),

    Rule::make('locale')->rules(['string']),

    Rule::make('faker_locale')->rules(['string']),

    Rule::make('key')->rules(['string']),

    Rule::make('cipher')->rules(['string']),

    Rule::make('providers')->rules(['array']),

    Rule::make('aliases')->rules(['array']),
];
