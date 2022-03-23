<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string']),

    Rule::make('cloud')->rules(['string']),

    Rule::make('disks')->rules(['array']),

    Rule::make('disks.local')->rules(['array']),
    Rule::make('disks.local.driver')->rules(['string']),
    Rule::make('disks.local.root')->rules(['string']),

    Rule::make('disks.public')->rules(['array']),
    Rule::make('disks.public.driver')->rules(['string']),
    Rule::make('disks.public.root')->rules(['string']),
    Rule::make('disks.public.url')->rules(['string']),
    Rule::make('disks.public.visibility')->rules(['string']),

    Rule::make('disks.s3')->rules(['array']),
    Rule::make('disks.s3.driver')->rules(['string']),
    Rule::make('disks.s3.key')->rules(['string', 'nullable']),
    Rule::make('disks.s3.secret')->rules(['string', 'nullable']),
    Rule::make('disks.s3.region')->rules(['string', 'nullable']),
    Rule::make('disks.s3.bucket')->rules(['string', 'nullable']),
    Rule::make('disks.s3.url')->rules(['string', 'nullable']),
    Rule::make('disks.s3.endpoint')->rules(['string', 'nullable']),

    Rule::make('links')->rules(['array']),
];
