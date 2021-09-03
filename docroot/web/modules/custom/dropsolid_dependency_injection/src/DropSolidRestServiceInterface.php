<?php

namespace Drupal\dropsolid_dependency_injection;

/**
 * Interface DropSolidRestServiceInterface.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
interface DropSolidRestServiceInterface {

  /**
   * Gets rest data.
   *
   * @param string $uri
   *   Rest request string.
   *
   * @return array
   *   Returns rest data or empty array if no data was received.
   */
  public function getApiData(string $uri);
}
