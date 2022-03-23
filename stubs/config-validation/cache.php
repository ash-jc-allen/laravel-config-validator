<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string', 'in:apc,array,database,file,memcached,redis,dynamodb']),

    Rule::make('stores')->rules(['array']),

    Rule::make('stores.apc')->rules(['array']),
    Rule::make('stores.apc.driver')->rules(['string']),

    Rule::make('stores.array')->rules(['array']),
    Rule::make('stores.array.driver')->rules(['string']),
    Rule::make('stores.array.serialize')->rules(['bool']),

    Rule::make('stores.database')->rules(['array']),
    Rule::make('stores.database.driver')->rules(['string']),
    Rule::make('stores.database.table')->rules(['string']),
    Rule::make('stores.database.connection')->rules(['string', 'nullable']),

    Rule::make('stores.file')->rules(['array']),
    Rule::make('stores.file.driver')->rules(['string']),
    Rule::make('stores.file.path')->rules(['string']),

    Rule::make('stores.memcached')->rules(['array']),
    Rule::make('stores.memcached.driver')->rules(['string']),
    Rule::make('stores.memcached.persistent_id')->rules(['string', 'nullable']),
    Rule::make('stores.memcached.sasl')->rules(['array']),
    Rule::make('stores.memcached.options')->rules(['array']),
    Rule::make('stores.memcached.servers')->rules(['array']),

    Rule::make('stores.redis')->rules(['array']),
    Rule::make('stores.redis.driver')->rules(['string']),
    Rule::make('stores.redis.connection')->rules(['string']),

    Rule::make('stores.dynamodb')->rules(['array']),
    Rule::make('stores.dynamodb.driver')->rules(['string']),
    Rule::make('stores.dynamodb.key')->rules(['string', 'nullable']),
    Rule::make('stores.dynamodb.secret')->rules(['string', 'nullable']),
    Rule::make('stores.dynamodb.region')->rules(['string']),
    Rule::make('stores.dynamodb.table')->rules(['string']),
    Rule::make('stores.dynamodb.endpoint')->rules(['string', 'nullable']),

    Rule::make('prefix')->rules(['string']),
];
