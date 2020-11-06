<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('defaults')->rules(['array']),

    Rule::make('defaults.guard')->rules(['string']),

    Rule::make('defaults.passwords')->rules(['string']),

    Rule::make('guards')->rules(['array']),

    Rule::make('guards.web')->rules(['array']),

    Rule::make('guards.web.driver')->rules(['string']),

    Rule::make('guards.web.provider')->rules(['string']),

    Rule::make('guards.api')->rules(['array']),

    Rule::make('guards.api.driver')->rules(['string']),

    Rule::make('guards.api.provider')->rules(['string']),

    Rule::make('guards.api.hash')->rules(['bool']),

    Rule::make('providers')->rules(['array']),

    Rule::make('providers.users')->rules(['array']),

    Rule::make('providers.users.driver')->rules(['string', 'in:eloquent,database']),

    Rule::make('providers.users.model')->rules(['string']),

    Rule::make('passwords')->rules(['array']),

    Rule::make('passwords.users')->rules(['array']),

    Rule::make('passwords.users.provider')->rules(['string']),

    Rule::make('passwords.users.table')->rules(['string']),

    Rule::make('passwords.users.expire')->rules(['integer']),

    Rule::make('passwords.users.throttle')->rules(['integer']),

    Rule::make('password_timeout')->rules(['integer']),
];
