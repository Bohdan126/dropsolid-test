<?php

namespace Drupal\dropsolid_dependency_injection;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Class DropsolidDependencyInjectionServiceProvider.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
class DropsolidDependencyInjectionServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    if ($container->hasDefinition('plugin.manager.mail')) {
      $definition = $container->getDefinition('plugin.manager.mail');
      $definition->setClass('Drupal\dropsolid_dependency_injection\DropsolidMailManager');
    }
  }

}
