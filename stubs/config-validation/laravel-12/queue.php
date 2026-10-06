<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string']),

    Rule::make('connections')->rules(['array']),

    Rule::make('connections.sync')->rules(['array']),

    Rule::make('connections.sync.driver')->rules(['string']),

    Rule::make('connections.database')->rules(['array']),

    Rule::make('connections.database.driver')->rules(['string']),

    Rule::make('connections.database.connection')->rules(['nullable', 'string']),

    Rule::make('connections.database.table')->rules(['string']),

    Rule::make('connections.database.queue')->rules(['string']),

    Rule::make('connections.database.retry_after')->rules(['integer']),

    Rule::make('connections.database.after_commit')->rules(['boolean']),

    Rule::make('connections.beanstalkd')->rules(['array']),

    Rule::make('connections.beanstalkd.driver')->rules(['string']),

    Rule::make('connections.beanstalkd.host')->rules(['string']),

    Rule::make('connections.beanstalkd.queue')->rules(['string']),

    Rule::make('connections.beanstalkd.retry_after')->rules(['integer']),

    Rule::make('connections.beanstalkd.block_for')->rules(['integer']),

    Rule::make('connections.beanstalkd.after_commit')->rules(['boolean']),

    Rule::make('connections.sqs')->rules(['array']),

    Rule::make('connections.sqs.driver')->rules(['string']),

    Rule::make('connections.sqs.key')->rules(['nullable', 'string']),

    Rule::make('connections.sqs.secret')->rules(['nullable', 'string']),

    Rule::make('connections.sqs.prefix')->rules(['string']),

    Rule::make('connections.sqs.queue')->rules(['string']),

    Rule::make('connections.sqs.suffix')->rules(['nullable', 'string']),

    Rule::make('connections.sqs.region')->rules(['string']),

    Rule::make('connections.sqs.after_commit')->rules(['boolean']),

    Rule::make('connections.redis')->rules(['array']),

    Rule::make('connections.redis.driver')->rules(['string']),

    Rule::make('connections.redis.connection')->rules(['string']),

    Rule::make('connections.redis.queue')->rules(['string']),

    Rule::make('connections.redis.retry_after')->rules(['integer']),

    Rule::make('connections.redis.block_for')->rules(['nullable', 'integer']),

    Rule::make('connections.redis.after_commit')->rules(['boolean']),

    Rule::make('connections.deferred')->rules(['array']),

    Rule::make('connections.deferred.driver')->rules(['string']),

    Rule::make('connections.failover')->rules(['array']),

    Rule::make('connections.failover.driver')->rules(['string']),

    Rule::make('connections.failover.connections')->rules(['array']),

    Rule::make('connections.background')->rules(['array']),

    Rule::make('connections.background.driver')->rules(['string']),

    Rule::make('batching')->rules(['array']),

    Rule::make('batching.database')->rules(['string']),

    Rule::make('batching.table')->rules(['string']),

    Rule::make('failed')->rules(['array']),

    Rule::make('failed.driver')->rules(['string']),

    Rule::make('failed.database')->rules(['string']),

    Rule::make('failed.table')->rules(['string']),
];
