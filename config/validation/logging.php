<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string']),

    Rule::make('channels')->rules(['array']),

    Rule::make('channels.stack')->rules(['array']),
    Rule::make('channels.stack.driver')->rules(['string']),
    Rule::make('channels.stack.channels')->rules(['array']),
    Rule::make('channels.stack.ignore_exceptions')->rules(['bool']),

    Rule::make('channels.single')->rules(['array']),
    Rule::make('channels.single.driver')->rules(['string']),
    Rule::make('channels.single.path')->rules(['string']),
    Rule::make('channels.single.level')->rules(['string']),

    Rule::make('channels.daily')->rules(['array']),
    Rule::make('channels.daily.driver')->rules(['string']),
    Rule::make('channels.daily.path')->rules(['string']),
    Rule::make('channels.daily.level')->rules(['string']),
    Rule::make('channels.daily.days')->rules(['integer']),

    Rule::make('channels.slack')->rules(['array']),
    Rule::make('channels.slack.driver')->rules(['string']),
    Rule::make('channels.slack.url')->rules(['string', 'nullable']),
    Rule::make('channels.slack.username')->rules(['string']),
    Rule::make('channels.slack.emoji')->rules(['string']),
    Rule::make('channels.slack.level')->rules(['string']),

    Rule::make('channels.papertrail')->rules(['array']),
    Rule::make('channels.papertrail.driver')->rules(['string']),
    Rule::make('channels.papertrail.level')->rules(['string']),
    Rule::make('channels.papertrail.handler')->rules(['string']),
    Rule::make('channels.papertrail.handler_with')->rules(['array']),

    Rule::make('channels.stderr')->rules(['array']),
    Rule::make('channels.stderr.driver')->rules(['string']),
    Rule::make('channels.stderr.handler')->rules(['string']),
    Rule::make('channels.stderr.formatter')->rules(['string', 'nullable']),
    Rule::make('channels.stderr.with')->rules(['array']),

    Rule::make('channels.syslog')->rules(['array']),
    Rule::make('channels.syslog.driver')->rules(['string']),
    Rule::make('channels.syslog.level')->rules(['string']),

    Rule::make('channels.errorlog')->rules(['array']),
    Rule::make('channels.errorlog.driver')->rules(['string']),
    Rule::make('channels.errorlog.level')->rules(['string']),

    Rule::make('channels.null')->rules(['array']),
    Rule::make('channels.null.driver')->rules(['string']),
    Rule::make('channels.null.handler')->rules(['string']),

    Rule::make('channels.emergency')->rules(['array']),
    Rule::make('channels.emergency.path')->rules(['string']),
];
