<?php

declare(strict_types=1);

namespace Setono\SyliusQuickOrderPlugin\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\SyliusQuickOrderPlugin\DependencyInjection\SetonoSyliusQuickOrderExtension;

/**
 * See examples of tests and configuration options here: https://github.com/SymfonyTest/SymfonyDependencyInjectionTest
 */
final class SetonoSyliusQuickOrderExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoSyliusQuickOrderExtension(),
        ];
    }

    protected function getMinimalConfiguration(): array
    {
        return [
            'option' => 'option_value',
        ];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameter_has_been_set(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono_sylius_quick_order.option', 'option_value');
    }
}
