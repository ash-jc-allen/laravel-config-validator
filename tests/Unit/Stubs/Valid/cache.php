<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('default')
        ->rules(['string', 'required', 'in:apc,array,database,file,memcached,redis,dynamodb'])
];
