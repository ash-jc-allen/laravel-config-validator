<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('name')->rules(['string']),

    Rule::make('env')->rules(['string']),

    Rule::make('debug')->rules(['boolean']),

    Rule::make('url')->rules(['url']),

    Rule::make('frontend_url')->rules(['url']),

    Rule::make('asset_url')->rules(['nullable', 'url']),

    Rule::make('timezone')->rules(['timezone']),

    Rule::make('locale')->rules(['string']),

    Rule::make('fallback_locale')->rules(['string']),

    Rule::make('faker_locale')->rules(['string']),

    Rule::make('cipher')->rules(['string']),

    Rule::make('key')->rules(['nullable', 'string']),

    Rule::make('previous_keys')->rules(['array']),

    Rule::make('maintenance')->rules(['array']),

    Rule::make('maintenance.driver')->rules(['string']),

    Rule::make('maintenance.store')->rules(['string']),

    Rule::make('providers')->rules(['array']),

    Rule::make('aliases')->rules(['array']),
];
