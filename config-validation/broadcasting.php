<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string', 'in:pusher,redis,log,null']),

    Rule::make('connections')->rules(['array']),

    Rule::make('connections.pusher')->rules(['array']),

    Rule::make('connections.pusher.driver')->rules(['string']),

    Rule::make('connections.pusher.key')->rules(['string']),

    Rule::make('connections.pusher.secret')->rules(['string']),

    Rule::make('connections.pusher.app_id')->rules(['string']),

    Rule::make('connections.pusher.options')->rules(['array']),

    Rule::make('connections.pusher.options.cluster')->rules(['string']),

    Rule::make('connections.pusher.options.useTLS')->rules(['bool']),

    Rule::make('connections.redis')->rules(['array']),

    Rule::make('connections.redis.driver')->rules(['string']),

    Rule::make('connections.redis.connection')->rules(['string']),

    Rule::make('connections.log')->rules(['array']),

    Rule::make('connections.log.driver')->rules(['string']),

    Rule::make('connections.null')->rules(['array']),

    Rule::make('connections.null.driver')->rules(['string']),
];
