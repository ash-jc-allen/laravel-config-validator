<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('postmark')->rules(['array']),

    Rule::make('postmark.key')->rules(['nullable', 'string']),

    Rule::make('resend')->rules(['array']),

    Rule::make('resend.key')->rules(['nullable', 'string']),

    Rule::make('ses')->rules(['array']),

    Rule::make('ses.key')->rules(['nullable', 'string']),

    Rule::make('ses.secret')->rules(['nullable', 'string']),

    Rule::make('ses.region')->rules(['string']),

    Rule::make('slack')->rules(['array']),

    Rule::make('slack.notifications')->rules(['array']),

    Rule::make('slack.notifications.bot_user_oauth_token')->rules(['nullable', 'string']),

    Rule::make('slack.notifications.channel')->rules(['nullable', 'string']),
];
