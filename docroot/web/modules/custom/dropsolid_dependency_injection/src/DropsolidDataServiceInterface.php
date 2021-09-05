<?php

namespace Drupal\dropsolid_dependency_injection;

/**
 * Interface DropsolidDataServiceInterface.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
interface DropsolidDataServiceInterface {

  /**
   * Gets array with photos.
   *
   * @param array $data
   *   Rest response data array.
   * @param array $build
   *   Images render array.
   */
  public function getPhotos(array $data, array &$build);

}
