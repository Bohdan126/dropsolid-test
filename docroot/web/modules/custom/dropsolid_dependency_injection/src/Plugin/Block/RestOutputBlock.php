<?php

namespace Drupal\dropsolid_dependency_injection\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\dropsolid_dependency_injection\DropSolidDataServiceInterface;
use Drupal\dropsolid_dependency_injection\DropSolidRestServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'RestOutputBlock' block.
 *
 * @Block(
 *  id = "rest_output_block",
 *  admin_label = @Translation("Rest output block"),
 * )
 */
class RestOutputBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * DropSolid service to obtain data.
   *
   * @var \Drupal\dropsolid_dependency_injection\DropSolidDataServiceInterface
   */
  protected $dropData;

  /**
   * DropSolid service to connect for rest.
   *
   * @var \Drupal\dropsolid_dependency_injection\DropSolidRestServiceInterface
   */
  protected $restConnector;

  /**
   * RestOutputBlock constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\dropsolid_dependency_injection\DropSolidDataServiceInterface $drop_data_service
   *   DropSolid service to obtain data.
   * @param \Drupal\dropsolid_dependency_injection\DropSolidRestServiceInterface $rest_service
   *   DropSolid service to connect for rest.
   */
  public function __construct(array $configuration, string $plugin_id, array $plugin_definition, DropSolidDataServiceInterface $drop_data_service, DropSolidRestServiceInterface $rest_service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dropData = $drop_data_service;
    $this->restConnector = $rest_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('dropsolid_dependency_injection.data_service'),
      $container->get('dropsolid_dependency_injection.rest_service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = $this->dropData->getDefaultCache();
    $album_id = random_int(1, 20);
    $uri = "https://jsonplaceholder.typicode.com/albums/{$album_id}/photos";

    if ($data = $this->restConnector->getApiData($uri)) {
      $this->dropData->getPhotos($data, $build);
    }

    return $build;
  }

}
