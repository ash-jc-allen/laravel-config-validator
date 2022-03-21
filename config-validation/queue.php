<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string', 'in:sync,database,beanstalkd,sqs,redis,null']),

    Rule::make('connections')->rules(['array']),

    Rule::make('connections.sync')->rules(['array']),
    Rule::make('connections.sync.driver')->rules(['string']),

    Rule::make('connections.database')->rules(['array']),
    Rule::make('connections.database.driver')->rules(['string']),
    Rule::make('connections.database.table')->rules(['string']),
    Rule::make('connections.database.queue')->rules(['string']),
    Rule::make('connections.database.retry_after')->rules(['integer']),

    Rule::make('connections.beanstalkd')->rules(['array']),
    Rule::make('connections.beanstalkd.driver')->rules(['string']),
    Rule::make('connections.beanstalkd.host')->rules(['string']),
    Rule::make('connections.beanstalkd.queue')->rules(['string']),
    Rule::make('connections.beanstalkd.retry_after')->rules(['integer']),
    Rule::make('connections.beanstalkd.block_for')->rules(['integer']),

    Rule::make('connections.sqs')->rules(['array']),
    Rule::make('connections.sqs.driver')->rules(['string']),
    Rule::make('connections.sqs.key')->rules(['string', 'nullable']),
    Rule::make('connections.sqs.secret')->rules(['string', 'nullable']),
    Rule::make('connections.sqs.prefix')->rules(['string']),
    Rule::make('connections.sqs.queue')->rules(['string']),
    Rule::make('connections.sqs.suffix')->rules(['string', 'nullable']),
    Rule::make('connections.sqs.region')->rules(['string']),

    Rule::make('connections.redis')->rules(['array']),
    Rule::make('connections.redis.driver')->rules(['string']),
    Rule::make('connections.redis.connection')->rules(['string']),
    Rule::make('connections.redis.queue')->rules(['string']),
    Rule::make('connections.redis.retry_after')->rules(['integer', 'nullable']),
    Rule::make('connections.redis.block_for')->rules(['integer', 'nullable']),

    Rule::make('failed')->rules(['array']),
    Rule::make('failed.driver')->rules(['string']),
    Rule::make('failed.database')->rules(['string']),
    Rule::make('failed.table')->rules(['string']),
];
