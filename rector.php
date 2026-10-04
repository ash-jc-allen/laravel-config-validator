<?php

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodParameterRector;
use Rector\DeadCode\Rector\MethodCall\RemoveNullArgOnNullDefaultParamRector;
use Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\SafeDeclareStrictTypesRector;

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
        RemoveUnusedPublicMethodParameterRector::class,
        RemoveUnusedConstructorParamRector::class,
        ReturnEarlyIfVariableRector::class,
        SafeDeclareStrictTypesRector::class,
        RemoveNullArgOnNullDefaultParamRector::class,
    ]);
