<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string']),

    Rule::make('stores')->rules(['array']),

    Rule::make('stores.array')->rules(['array']),

    Rule::make('stores.array.driver')->rules(['string']),

    Rule::make('stores.array.serialize')->rules(['boolean']),

    Rule::make('stores.session')->rules(['array']),

    Rule::make('stores.session.driver')->rules(['string']),

    Rule::make('stores.session.key')->rules(['string']),

    Rule::make('stores.database')->rules(['array']),

    Rule::make('stores.database.driver')->rules(['string']),

    Rule::make('stores.database.connection')->rules(['nullable', 'string']),

    Rule::make('stores.database.table')->rules(['string']),

    Rule::make('stores.database.lock_connection')->rules(['nullable', 'string']),

    Rule::make('stores.database.lock_table')->rules(['nullable', 'string']),

    Rule::make('stores.file')->rules(['array']),

    Rule::make('stores.file.driver')->rules(['string']),

    Rule::make('stores.file.path')->rules(['string']),

    Rule::make('stores.file.lock_path')->rules(['string']),

    Rule::make('stores.storage')->rules(['array']),

    Rule::make('stores.storage.driver')->rules(['string']),

    Rule::make('stores.storage.disk')->rules(['nullable', 'string']),

    Rule::make('stores.storage.path')->rules(['string']),

    Rule::make('stores.memcached')->rules(['array']),

    Rule::make('stores.memcached.driver')->rules(['string']),

    Rule::make('stores.memcached.persistent_id')->rules(['nullable', 'string']),

    Rule::make('stores.memcached.sasl')->rules(['array']),

    Rule::make('stores.memcached.options')->rules(['array']),

    Rule::make('stores.memcached.servers')->rules(['array']),

    Rule::make('stores.redis')->rules(['array']),

    Rule::make('stores.redis.driver')->rules(['string']),

    Rule::make('stores.redis.connection')->rules(['string']),

    Rule::make('stores.redis.lock_connection')->rules(['string']),

    Rule::make('stores.dynamodb')->rules(['array']),

    Rule::make('stores.dynamodb.driver')->rules(['string']),

    Rule::make('stores.dynamodb.key')->rules(['nullable', 'string']),

    Rule::make('stores.dynamodb.secret')->rules(['nullable', 'string']),

    Rule::make('stores.dynamodb.region')->rules(['string']),

    Rule::make('stores.dynamodb.table')->rules(['string']),

    Rule::make('stores.dynamodb.endpoint')->rules(['nullable', 'string']),

    Rule::make('stores.octane')->rules(['array']),

    Rule::make('stores.octane.driver')->rules(['string']),

    Rule::make('stores.failover')->rules(['array']),

    Rule::make('stores.failover.driver')->rules(['string']),

    Rule::make('stores.failover.stores')->rules(['array']),

    Rule::make('prefix')->rules(['string']),

    Rule::make('serializable_classes')->rules([
        static function (string $attribute, mixed $value, Closure $fail): void {
            if (! is_bool($value) && ! is_array($value)) {
                $fail('The '.$attribute.' field must be a boolean or an array.');
            }
        },
    ]),
];
