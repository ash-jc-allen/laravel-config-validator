<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string']),

    Rule::make('connections')->rules(['array']),

    Rule::make('connections.sqlite')->rules(['array']),

    Rule::make('connections.sqlite.driver')->rules(['string']),

    Rule::make('connections.sqlite.url')->rules(['nullable', 'string']),

    Rule::make('connections.sqlite.database')->rules(['string']),

    Rule::make('connections.sqlite.prefix')->rules(['string']),

    Rule::make('connections.sqlite.foreign_key_constraints')->rules(['boolean']),

    Rule::make('connections.sqlite.busy_timeout')->rules(['nullable', 'integer']),

    Rule::make('connections.sqlite.journal_mode')->rules(['nullable', 'string']),

    Rule::make('connections.sqlite.synchronous')->rules(['nullable', 'in:0,1,2,3,OFF,NORMAL,FULL,EXTRA']),

    Rule::make('connections.mysql')->rules(['array']),

    Rule::make('connections.mysql.driver')->rules(['string']),

    Rule::make('connections.mysql.url')->rules(['nullable', 'string']),

    Rule::make('connections.mysql.host')->rules(['string']),

    Rule::make('connections.mysql.port')->rules(['integer']),

    Rule::make('connections.mysql.database')->rules(['string']),

    Rule::make('connections.mysql.username')->rules(['string']),

    Rule::make('connections.mysql.password')->rules(['string']),

    Rule::make('connections.mysql.unix_socket')->rules(['string']),

    Rule::make('connections.mysql.charset')->rules(['string']),

    Rule::make('connections.mysql.collation')->rules(['string']),

    Rule::make('connections.mysql.prefix')->rules(['string']),

    Rule::make('connections.mysql.prefix_indexes')->rules(['boolean']),

    Rule::make('connections.mysql.strict')->rules(['boolean']),

    Rule::make('connections.mysql.engine')->rules(['nullable', 'string']),

    Rule::make('connections.mysql.options')->rules(['array']),

    Rule::make('connections.mariadb')->rules(['array']),

    Rule::make('connections.mariadb.driver')->rules(['string']),

    Rule::make('connections.mariadb.url')->rules(['nullable', 'string']),

    Rule::make('connections.mariadb.host')->rules(['string']),

    Rule::make('connections.mariadb.port')->rules(['integer']),

    Rule::make('connections.mariadb.database')->rules(['string']),

    Rule::make('connections.mariadb.username')->rules(['string']),

    Rule::make('connections.mariadb.password')->rules(['string']),

    Rule::make('connections.mariadb.unix_socket')->rules(['string']),

    Rule::make('connections.mariadb.charset')->rules(['string']),

    Rule::make('connections.mariadb.collation')->rules(['string']),

    Rule::make('connections.mariadb.prefix')->rules(['string']),

    Rule::make('connections.mariadb.prefix_indexes')->rules(['boolean']),

    Rule::make('connections.mariadb.strict')->rules(['boolean']),

    Rule::make('connections.mariadb.engine')->rules(['nullable', 'string']),

    Rule::make('connections.mariadb.options')->rules(['array']),

    Rule::make('connections.pgsql')->rules(['array']),

    Rule::make('connections.pgsql.driver')->rules(['string']),

    Rule::make('connections.pgsql.url')->rules(['nullable', 'string']),

    Rule::make('connections.pgsql.host')->rules(['string']),

    Rule::make('connections.pgsql.port')->rules(['integer']),

    Rule::make('connections.pgsql.database')->rules(['string']),

    Rule::make('connections.pgsql.username')->rules(['string']),

    Rule::make('connections.pgsql.password')->rules(['string']),

    Rule::make('connections.pgsql.charset')->rules(['string']),

    Rule::make('connections.pgsql.prefix')->rules(['string']),

    Rule::make('connections.pgsql.prefix_indexes')->rules(['boolean']),

    Rule::make('connections.pgsql.search_path')->rules(['string']),

    Rule::make('connections.pgsql.sslmode')->rules(['string']),

    Rule::make('connections.sqlsrv')->rules(['array']),

    Rule::make('connections.sqlsrv.driver')->rules(['string']),

    Rule::make('connections.sqlsrv.url')->rules(['nullable', 'string']),

    Rule::make('connections.sqlsrv.host')->rules(['string']),

    Rule::make('connections.sqlsrv.port')->rules(['integer']),

    Rule::make('connections.sqlsrv.database')->rules(['string']),

    Rule::make('connections.sqlsrv.username')->rules(['string']),

    Rule::make('connections.sqlsrv.password')->rules(['string']),

    Rule::make('connections.sqlsrv.charset')->rules(['string']),

    Rule::make('connections.sqlsrv.prefix')->rules(['string']),

    Rule::make('connections.sqlsrv.prefix_indexes')->rules(['boolean']),

    Rule::make('migrations')->rules(['array']),

    Rule::make('migrations.table')->rules(['string']),

    Rule::make('migrations.update_date_on_publish')->rules(['boolean']),

    Rule::make('redis')->rules(['array']),

    Rule::make('redis.client')->rules(['string']),

    Rule::make('redis.options')->rules(['array']),

    Rule::make('redis.options.cluster')->rules(['string']),

    Rule::make('redis.options.prefix')->rules(['string']),

    Rule::make('redis.options.persistent')->rules(['boolean']),

    Rule::make('redis.default')->rules(['array']),

    Rule::make('redis.default.url')->rules(['nullable', 'string']),

    Rule::make('redis.default.host')->rules(['string']),

    Rule::make('redis.default.username')->rules(['nullable', 'string']),

    Rule::make('redis.default.password')->rules(['nullable', 'string']),

    Rule::make('redis.default.port')->rules(['integer']),

    Rule::make('redis.default.database')->rules(['integer']),

    Rule::make('redis.cache')->rules(['array']),

    Rule::make('redis.cache.url')->rules(['nullable', 'string']),

    Rule::make('redis.cache.host')->rules(['string']),

    Rule::make('redis.cache.username')->rules(['nullable', 'string']),

    Rule::make('redis.cache.password')->rules(['nullable', 'string']),

    Rule::make('redis.cache.port')->rules(['integer']),

    Rule::make('redis.cache.database')->rules(['integer']),
];
