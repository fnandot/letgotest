<?php

namespace LetShout\Infrastructure\Symfony\Bundle\ApiBundle;

use LetShout\Infrastructure\Symfony\Bundle\ApiBundle\DependencyInjection\CompilerPass\CacheDriverCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class LetShoutApiBundle
 */
class LetShoutApiBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
