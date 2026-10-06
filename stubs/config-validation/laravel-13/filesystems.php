<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')->rules(['string']),

    Rule::make('disks')->rules(['array']),

    Rule::make('disks.local')->rules(['array']),

    Rule::make('disks.local.driver')->rules(['string']),

    Rule::make('disks.local.root')->rules(['string']),

    Rule::make('disks.local.serve')->rules(['boolean']),

    Rule::make('disks.local.throw')->rules(['boolean']),

    Rule::make('disks.local.report')->rules(['boolean']),

    Rule::make('disks.public')->rules(['array']),

    Rule::make('disks.public.driver')->rules(['string']),

    Rule::make('disks.public.root')->rules(['string']),

    Rule::make('disks.public.url')->rules(['string']),

    Rule::make('disks.public.visibility')->rules(['string']),

    Rule::make('disks.public.throw')->rules(['boolean']),

    Rule::make('disks.public.report')->rules(['boolean']),

    Rule::make('disks.s3')->rules(['array']),

    Rule::make('disks.s3.driver')->rules(['string']),

    Rule::make('disks.s3.key')->rules(['nullable', 'string']),

    Rule::make('disks.s3.secret')->rules(['nullable', 'string']),

    Rule::make('disks.s3.region')->rules(['nullable', 'string']),

    Rule::make('disks.s3.bucket')->rules(['nullable', 'string']),

    Rule::make('disks.s3.url')->rules(['nullable', 'string']),

    Rule::make('disks.s3.endpoint')->rules(['nullable', 'string']),

    Rule::make('disks.s3.use_path_style_endpoint')->rules(['boolean']),

    Rule::make('disks.s3.throw')->rules(['boolean']),

    Rule::make('disks.s3.report')->rules(['boolean']),

    Rule::make('links')->rules(['array']),
];
