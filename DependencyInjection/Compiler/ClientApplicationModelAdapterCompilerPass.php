<?php
/**
 *  (c) 2019 Общество с ограниченной ответственностью "Экьюрейт Веб". Все права защищены.
 *
 *  Настоящий файл является частью программного продукта, разработанного ООО "Экьюрейт Веб"
 *  (ОГРН 1186658025289, ИНН 6683013910).
 *
 *  Алгоритм и исходные коды программного кода программного продукта являются коммерческой тайной
 *  ООО "Экьюрейт Веб". Любое их использование без согласия ООО "Экьюрейт Веб" рассматривается,
 *  как нарушение его авторских прав.
 *   Ответственность за нарушение авторских прав наступает в соответствии с действующим законодательством РФ.
 */

namespace Accurateweb\ClientApplicationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ClientApplicationModelAdapterCompilerPass implements CompilerPassInterface
{
  /**
   * You can modify the container here before it is dumped to PHP code.
   *
   * @param ContainerBuilder $container
   */
  public function process (ContainerBuilder $container)
  {
    if (!$container->has('aw.client_application.manager'))
    {
      return;
    }

    $definition = $container->findDefinition('aw.client_application.manager');
    $taggedServices = $container->findTaggedServiceIds('aw.client_application.adapter');

    foreach ($taggedServices as $id => $tags)
    {
      foreach ($tags as $attributes)
      {

        $definition->addMethodCall('addModelAdapter', array(
          new Reference($id)
        ));
      }
    }
  }

}