<?php

use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodParameterRector;
use Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php81\Rector\ClassMethod\NewInInitializerRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withPhpSets(php82: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        instanceOf: true,
        earlyReturn: true,
    )
    ->withSkip([
        ClassPropertyAssignToConstructorPromotionRector::class,
        NewInInitializerRector::class,
        RemoveUnusedPublicMethodParameterRector::class,
        RemoveUnusedConstructorParamRector::class,
        ExplicitBoolCompareRector::class,
        ReturnEarlyIfVariableRector::class,
    ]);
