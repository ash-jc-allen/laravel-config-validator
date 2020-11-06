<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string']),

    Rule::make('connections')->rules(['array']),

    Rule::make('connections.sqlite')->rules(['array']),
    Rule::make('connections.sqlite.driver')->rules(['string']),
    Rule::make('connections.sqlite.url')->rules(['string', 'nullable']),
    Rule::make('connections.sqlite.database')->rules(['string']),
    Rule::make('connections.sqlite.prefix')->rules(['string']),
    Rule::make('connections.sqlite.foreign_key_constraints')->rules(['bool']),

    Rule::make('connections.mysql')->rules(['array']),
    Rule::make('connections.mysql.driver')->rules(['string']),
    Rule::make('connections.mysql.url')->rules(['string', 'nullable']),
    Rule::make('connections.mysql.host')->rules(['string']),
    Rule::make('connections.mysql.port')->rules(['string']),
    Rule::make('connections.mysql.database')->rules(['string']),
    Rule::make('connections.mysql.username')->rules(['string']),
    Rule::make('connections.mysql.password')->rules(['string']),
    Rule::make('connections.mysql.unix_socket')->rules(['string']),
    Rule::make('connections.mysql.charset')->rules(['string']),
    Rule::make('connections.mysql.collation')->rules(['string']),
    Rule::make('connections.mysql.prefix')->rules(['string']),
    Rule::make('connections.mysql.prefix_indexes')->rules(['bool']),
    Rule::make('connections.mysql.strict')->rules(['bool']),
    Rule::make('connections.mysql.engine')->rules(['string', 'nullable']),
    Rule::make('connections.mysql.options')->rules(['array']),

    Rule::make('connections.pgsql')->rules(['array']),
    Rule::make('connections.pgsql.driver')->rules(['string']),
    Rule::make('connections.pgsql.url')->rules(['string', 'nullable']),
    Rule::make('connections.pgsql.host')->rules(['string']),
    Rule::make('connections.pgsql.port')->rules(['string']),
    Rule::make('connections.pgsql.database')->rules(['string']),
    Rule::make('connections.pgsql.username')->rules(['string']),
    Rule::make('connections.pgsql.password')->rules(['string']),
    Rule::make('connections.pgsql.charset')->rules(['string']),
    Rule::make('connections.pgsql.prefix')->rules(['string']),
    Rule::make('connections.pgsql.prefix_indexes')->rules(['bool']),
    Rule::make('connections.pgsql.schema')->rules(['string']),
    Rule::make('connections.pgsql.sslmode')->rules(['string']),

    Rule::make('connections.sqlsrv')->rules(['array']),
    Rule::make('connections.sqlsrv.driver')->rules(['string']),
    Rule::make('connections.sqlsrv.url')->rules(['string', 'nullable']),
    Rule::make('connections.sqlsrv.host')->rules(['string']),
    Rule::make('connections.sqlsrv.port')->rules(['string']),
    Rule::make('connections.sqlsrv.database')->rules(['string']),
    Rule::make('connections.sqlsrv.username')->rules(['string']),
    Rule::make('connections.sqlsrv.password')->rules(['string']),
    Rule::make('connections.sqlsrv.charset')->rules(['string']),
    Rule::make('connections.sqlsrv.prefix')->rules(['string']),
    Rule::make('connections.sqlsrv.prefix_indexes')->rules(['bool']),

    Rule::make('migrations')->rules(['string']),

    Rule::make('redis')->rules(['array']),

    Rule::make('redis.client')->rules(['string']),

    Rule::make('redis.options')->rules(['array']),
    Rule::make('redis.options.cluster')->rules(['string']),
    Rule::make('redis.options.prefix')->rules(['string']),

    Rule::make('redis.default')->rules(['array']),
    Rule::make('redis.default.url')->rules(['string', 'nullable']),
    Rule::make('redis.default.host')->rules(['string']),
    Rule::make('redis.default.password')->rules(['string', 'nullable']),
    Rule::make('redis.default.port')->rules(['string']),
    Rule::make('redis.default.database')->rules(['alpha_dash']),

    Rule::make('redis.cache')->rules(['array']),
    Rule::make('redis.cache.url')->rules(['string', 'nullable']),
    Rule::make('redis.cache.host')->rules(['string']),
    Rule::make('redis.cache.password')->rules(['string', 'nullable']),
    Rule::make('redis.cache.port')->rules(['string']),
    Rule::make('redis.cache.database')->rules(['alpha_dash']),
];
