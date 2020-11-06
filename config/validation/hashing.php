<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('driver')->rules(['string', 'in:bcrypt,argon,argon2id']),

    Rule::make('bcrypt')->rules(['array']),
    Rule::make('bcrypt.rounds')->rules(['integer']),

    Rule::make('argon')->rules(['array']),
    Rule::make('argon.memory')->rules(['integer']),
    Rule::make('argon.threads')->rules(['integer']),
    Rule::make('argon.time')->rules(['integer']),
];
