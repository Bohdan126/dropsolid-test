<?php

namespace Drupal\dropsolid_dependency_injection\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\dropsolid_dependency_injection\DropsolidDataServiceInterface;
use Drupal\dropsolid_dependency_injection\DropsolidRestServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RestOutputController.
 *
 * @package Drupal\dropsolid_dependency_injection\Controller
 */
class RestOutputController extends ControllerBase {

  /**
   * Dropsolid service to obtain data.
   *
   * @var \Drupal\dropsolid_dependency_injection\DropsolidDataServiceInterface
   */
  protected $dropData;

  /**
   * Dropsolid service to connect for rest.
   *
   * @var \Drupal\dropsolid_dependency_injection\DropsolidRestServiceInterface
   */
  protected $restConnector;

  /**
   * RestOutputController constructor.
   *
   * @param \Drupal\dropsolid_dependency_injection\DropsolidDataServiceInterface $drop_data_service
   *   Dropsolid service to obtain data.
   * @param \Drupal\dropsolid_dependency_injection\DropsolidRestServiceInterface $rest_service
   *   Dropsolid service to connect for rest.
   */
  public function __construct(DropsolidDataServiceInterface $drop_data_service, DropsolidRestServiceInterface $rest_service) {
    $this->dropData = $drop_data_service;
    $this->restConnector = $rest_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('dropsolid_dependency_injection.data_service'),
      $container->get('dropsolid_dependency_injection.rest_service')
    );
  }

  /**
   * Displays selected photos.
   *
   * @return array
   *   Array with images.
   */
  public function showPhotos() {
    $build = $this->dropData->getDefaultCache();
    $uri = 'https://jsonplaceholder.typicode.com/albums/5/photos';

    if ($data = $this->restConnector->getApiData($uri)) {
      $this->dropData->getPhotos($data, $build);
    }

    return $build;
  }

}
