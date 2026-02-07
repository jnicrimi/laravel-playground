<?php

declare(strict_types=1);

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

final class LayerDependencyTest
{
    public function test_domain_does_not_depend_on_outer_layers(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('Packages\Domain'))
            ->shouldNotDependOn()
            ->classes(
                Selector::inNamespace('Packages\UseCase'),
                Selector::inNamespace('Packages\Application'),
                Selector::inNamespace('Packages\Infrastructure'),
                Selector::inNamespace('App'),
            );
    }

    public function test_usecase_does_not_depend_on_outer_layers(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('Packages\UseCase'))
            ->shouldNotDependOn()
            ->classes(
                Selector::inNamespace('Packages\Application'),
                Selector::inNamespace('Packages\Infrastructure'),
                Selector::inNamespace('App'),
            );
    }

    public function test_application_does_not_depend_on_infrastructure(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('Packages\Application'))
            ->shouldNotDependOn()
            ->classes(
                Selector::inNamespace('Packages\Infrastructure'),
                Selector::inNamespace('App'),
            );
    }
}
