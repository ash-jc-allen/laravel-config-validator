<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string']),

    Rule::make('connections')->rules(['array']),

    Rule::make('connections.reverb')->rules(['array']),

    Rule::make('connections.reverb.driver')->rules(['string']),

    Rule::make('connections.reverb.key')->rules(['nullable', 'string']),

    Rule::make('connections.reverb.secret')->rules(['nullable', 'string']),

    Rule::make('connections.reverb.app_id')->rules(['nullable', 'string']),

    Rule::make('connections.reverb.options')->rules(['array']),

    Rule::make('connections.reverb.options.host')->rules(['nullable', 'string']),

    Rule::make('connections.reverb.options.port')->rules(['integer']),

    Rule::make('connections.reverb.options.scheme')->rules(['string']),

    Rule::make('connections.reverb.options.useTLS')->rules(['boolean']),

    Rule::make('connections.reverb.client_options')->rules(['array']),

    Rule::make('connections.pusher')->rules(['array']),

    Rule::make('connections.pusher.driver')->rules(['string']),

    Rule::make('connections.pusher.key')->rules(['nullable', 'string']),

    Rule::make('connections.pusher.secret')->rules(['nullable', 'string']),

    Rule::make('connections.pusher.app_id')->rules(['nullable', 'string']),

    Rule::make('connections.pusher.options')->rules(['array']),

    Rule::make('connections.pusher.options.cluster')->rules(['nullable', 'string']),

    Rule::make('connections.pusher.options.host')->rules(['string']),

    Rule::make('connections.pusher.options.port')->rules(['integer']),

    Rule::make('connections.pusher.options.scheme')->rules(['string']),

    Rule::make('connections.pusher.options.encrypted')->rules(['boolean']),

    Rule::make('connections.pusher.options.useTLS')->rules(['boolean']),

    Rule::make('connections.pusher.client_options')->rules(['array']),

    Rule::make('connections.ably')->rules(['array']),

    Rule::make('connections.ably.driver')->rules(['string']),

    Rule::make('connections.ably.key')->rules(['nullable', 'string']),

    Rule::make('connections.mercure')->rules(['array']),

    Rule::make('connections.mercure.driver')->rules(['string']),

    Rule::make('connections.mercure.url')->rules(['nullable', 'string']),

    Rule::make('connections.mercure.public_url')->rules(['nullable', 'string']),

    Rule::make('connections.mercure.secret')->rules(['nullable', 'string']),

    Rule::make('connections.mercure.encryption_key')->rules(['nullable', 'string']),

    Rule::make('connections.mercure.claims')->rules(['array']),

    Rule::make('connections.mercure.claims.iss')->rules(['nullable', 'string']),

    Rule::make('connections.mercure.claims.client_id')->rules(['nullable', 'string']),

    Rule::make('connections.mercure.cookie_name')->rules(['nullable', 'string']),

    Rule::make('connections.mercure.subscribe_expiration')->rules(['integer']),

    Rule::make('connections.log')->rules(['array']),

    Rule::make('connections.log.driver')->rules(['string']),

    Rule::make('connections.null')->rules(['array']),

    Rule::make('connections.null.driver')->rules(['string']),
];
