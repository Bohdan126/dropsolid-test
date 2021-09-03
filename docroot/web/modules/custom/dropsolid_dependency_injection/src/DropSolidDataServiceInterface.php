<?php

namespace Drupal\dropsolid_dependency_injection;

/**
 * Interface DropSolidDataServiceInterface.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
interface DropSolidDataServiceInterface {

  /**
   * Gets default cache array.
   *
   * @return array
   */
  public function getDefaultCache();

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
