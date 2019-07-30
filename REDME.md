# Dependency injection helpers library


### Features:

#### 1. Sorting of tagged services

Class `Aeliot\DependencyInjection\Helper\PrioritySorter` helps to sort tagged services to inject them in appropriate order.
It accepts: 
1. associated array of services ID obtained from `Symfony\Component\DependencyInjection\ContainerBuilder::findTaggedServiceIds()` (required).
1. order: `true` - ascending, `false` - descending order (optional). Default `true`.
1. priority attribute name (optional). Can be used for custom ordering tag properties. Default `priority`.

**Example of usage:**

```php
<?php

namespace App\DependencyInjection\Compiler;

use Aeliot\DependencyInjection\Helper\PrioritySorter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MyCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('my_service_id')) {
            return;
        }

        $definition = $container->getDefinition('my_service_id');

        $taggedServiceIds = $container->findTaggedServiceIds('my_tag_name');
        $taggedServiceIds = PrioritySorter::sort($taggedServiceIds);
        foreach ($taggedServiceIds as $serviceId => $taggs) {
            $definition->addMethodCall('add', [new Reference($serviceId)]);
        }
    }
}
```
