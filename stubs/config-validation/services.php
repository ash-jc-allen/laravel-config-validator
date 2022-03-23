<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('mailgun')->rules(['array']),
    Rule::make('mailgun.domain')->rules(['string', 'nullable']),
    Rule::make('mailgun.secret')->rules(['string', 'nullable']),
    Rule::make('mailgun.endpoint')->rules(['string']),

    Rule::make('postmark')->rules(['array']),
    Rule::make('postmark.token')->rules(['string', 'nullable']),

    Rule::make('ses')->rules(['array']),
    Rule::make('ses.key')->rules(['string', 'nullable']),
    Rule::make('ses.secret')->rules(['string', 'nullable']),
    Rule::make('ses.region')->rules(['string']),
];
