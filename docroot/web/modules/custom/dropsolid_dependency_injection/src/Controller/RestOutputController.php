<?php

namespace Drupal\dropsolid_dependency_injection\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\dropsolid_dependency_injection\DropSolidDataServiceInterface;
use Drupal\dropsolid_dependency_injection\RestConnectorServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RestOutputController
 *
 * @package Drupal\dropsolid_dependency_injection\Controller
 */
class RestOutputController extends ControllerBase {

  /**
   * Custom rest request manager.
   *
   * @var \Drupal\dropsolid_dependency_injection\RestConnectorServiceInterface
   */
  protected $restConnector;

  /**
   * Custom service with helping functions.
   *
   * @var \Drupal\dropsolid_dependency_injection\DropSolidDataServiceInterface
   */
  protected $dropData;

  /**
   * RestOutputController constructor.
   *
   * @param \Drupal\dropsolid_dependency_injection\DropSolidDataServiceInterface $drop_data_service
   *   DropSolid service to obtain data.
   * @param \Drupal\dropsolid_dependency_injection\RestConnectorServiceInterface $rest_connector_service
   *   DropSolid service to connect for rest.
   */
  public function __construct(DropSolidDataServiceInterface $drop_data_service, RestConnectorServiceInterface $rest_connector_service) {
    $this->dropData = $drop_data_service;
    $this->restConnector = $rest_connector_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('dropsolid_dependency_injection.data_service'),
      $container->get('dropsolid_dependency_injection.rest_connector')
    );
  }

  /**
   * Displays selected photos by rest request.
   *
   * @return array
   *   Images render array.
   */
  public function showPhotos(): array {
    $build = $this->dropData->getDefaultCache();

    $uri = 'https://jsonplaceholder.typicode.com/albums/5/photos';

    if ($data = $this->restConnector->getApiData($uri)) {
      $this->dropData->getPhotos($data, $build);
    }

    return $build;
  }

}
