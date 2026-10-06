<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('driver')->rules(['string']),

    Rule::make('lifetime')->rules(['integer']),

    Rule::make('expire_on_close')->rules(['boolean']),

    Rule::make('encrypt')->rules(['boolean']),

    Rule::make('files')->rules(['string']),

    Rule::make('connection')->rules(['nullable', 'string']),

    Rule::make('table')->rules(['string']),

    Rule::make('store')->rules(['nullable', 'string']),

    Rule::make('lottery')->rules(['array']),

    Rule::make('cookie')->rules(['string']),

    Rule::make('path')->rules(['string']),

    Rule::make('domain')->rules(['nullable', 'string']),

    Rule::make('secure')->rules(['nullable', 'boolean']),

    Rule::make('http_only')->rules(['boolean']),

    Rule::make('same_site')->rules(['nullable', 'string', 'in:lax,strict,none']),

    Rule::make('partitioned')->rules(['boolean']),

    Rule::make('serialization')->rules(['string', 'in:json,php']),
];
