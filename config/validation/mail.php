<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string', 'in:smtp,sendmail,mailgun,ses,postmark,log,array']),

    Rule::make('mailers')->rules(['array']),

    Rule::make('mailers.smtp')->rules(['array']),
    Rule::make('mailers.smtp.transport')->rules(['string']),
    Rule::make('mailers.smtp.host')->rules(['string']),
    Rule::make('mailers.smtp.port')->rules(['integer']),
    Rule::make('mailers.smtp.encryption')->rules(['string', 'nullable']),
    Rule::make('mailers.smtp.username')->rules(['string', 'nullable']),
    Rule::make('mailers.smtp.password')->rules(['string', 'nullable']),
    Rule::make('mailers.smtp.timeout')->rules(['integer', 'nullable']),
    Rule::make('mailers.smtp.auth_mode')->rules(['string', 'nullable']),

    Rule::make('mailers.ses')->rules(['array']),
    Rule::make('mailers.ses.transport')->rules(['string']),

    Rule::make('mailers.mailgun')->rules(['array']),
    Rule::make('mailers.mailgun.transport')->rules(['string']),

    Rule::make('mailers.postmark')->rules(['array']),
    Rule::make('mailers.postmark.transport')->rules(['string']),

    Rule::make('mailers.sendmail')->rules(['array']),
    Rule::make('mailers.sendmail.transport')->rules(['string']),
    Rule::make('mailers.sendmail.path')->rules(['string']),

    Rule::make('mailers.log')->rules(['array']),
    Rule::make('mailers.log.transport')->rules(['string']),
    Rule::make('mailers.log.channel')->rules(['string', 'nullable']),

    Rule::make('mailers.array')->rules(['array']),
    Rule::make('mailers.array.transport')->rules(['string']),

    Rule::make('from')->rules(['array']),
    Rule::make('from.address')->rules(['email']),
    Rule::make('from.name')->rules(['string']),

    Rule::make('markdown')->rules(['array']),
    Rule::make('markdown.theme')->rules(['string']),
    Rule::make('markdown.paths')->rules(['array']),
];
