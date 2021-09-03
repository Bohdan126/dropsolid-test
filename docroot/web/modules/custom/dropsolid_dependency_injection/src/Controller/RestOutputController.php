<?php

namespace Drupal\dropsolid_dependency_injection\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\dropsolid_dependency_injection\DropSolidDataServiceInterface;
use Drupal\dropsolid_dependency_injection\DropSolidRestServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RestOutputController.
 *
 * @package Drupal\dropsolid_dependency_injection\Controller
 */
class RestOutputController extends ControllerBase {

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
   * RestOutputController constructor.
   *
   * @param \Drupal\dropsolid_dependency_injection\DropSolidDataServiceInterface $drop_data_service
   *   DropSolid service to obtain data.
   * @param \Drupal\dropsolid_dependency_injection\DropSolidRestServiceInterface $rest_service
   *   DropSolid service to connect for rest.
   */
  public function __construct(DropSolidDataServiceInterface $drop_data_service, DropSolidRestServiceInterface $rest_service) {
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
