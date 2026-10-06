<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string']),

    Rule::make('mailers')->rules(['array']),

    Rule::make('mailers.smtp')->rules(['array']),

    Rule::make('mailers.smtp.transport')->rules(['string']),

    Rule::make('mailers.smtp.scheme')->rules(['nullable', 'string']),

    Rule::make('mailers.smtp.url')->rules(['nullable', 'string']),

    Rule::make('mailers.smtp.host')->rules(['string']),

    Rule::make('mailers.smtp.port')->rules(['integer']),

    Rule::make('mailers.smtp.username')->rules(['nullable', 'string']),

    Rule::make('mailers.smtp.password')->rules(['nullable', 'string']),

    Rule::make('mailers.smtp.timeout')->rules(['nullable', 'numeric']),

    Rule::make('mailers.smtp.local_domain')->rules(['string']),

    Rule::make('mailers.ses')->rules(['array']),

    Rule::make('mailers.ses.transport')->rules(['string']),

    Rule::make('mailers.postmark')->rules(['array']),

    Rule::make('mailers.postmark.transport')->rules(['string']),

    Rule::make('mailers.resend')->rules(['array']),

    Rule::make('mailers.resend.transport')->rules(['string']),

    Rule::make('mailers.sendmail')->rules(['array']),

    Rule::make('mailers.sendmail.transport')->rules(['string']),

    Rule::make('mailers.sendmail.path')->rules(['string']),

    Rule::make('mailers.log')->rules(['array']),

    Rule::make('mailers.log.transport')->rules(['string']),

    Rule::make('mailers.log.channel')->rules(['nullable', 'string']),

    Rule::make('mailers.array')->rules(['array']),

    Rule::make('mailers.array.transport')->rules(['string']),

    Rule::make('mailers.failover')->rules(['array']),

    Rule::make('mailers.failover.transport')->rules(['string']),

    Rule::make('mailers.failover.mailers')->rules(['array']),

    Rule::make('mailers.roundrobin')->rules(['array']),

    Rule::make('mailers.roundrobin.transport')->rules(['string']),

    Rule::make('mailers.roundrobin.mailers')->rules(['array']),

    Rule::make('from')->rules(['array']),

    Rule::make('from.address')->rules(['email']),

    Rule::make('from.name')->rules(['string']),

    Rule::make('markdown')->rules(['array']),

    Rule::make('markdown.theme')->rules(['string']),

    Rule::make('markdown.paths')->rules(['array']),
];
