<?php

use AshAllenDesign\ConfigValidator\Services\Rule;
use AshAllenDesign\ConfigValidator\Tests\Unit\Stubs\IsFooBar;

return [
    Rule::make('default')
        ->rules(['string', 'required', 'in:apc,array,database,file,memcached,redis,dynamodb']),

    Rule::make('prefix')
        ->rules([new IsFooBar()]),
];
