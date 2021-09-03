<?php

namespace Drupal\dropsolid_dependency_injection;

/**
 * Class DropSolidDataService.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
class DropSolidDataService implements DropSolidDataServiceInterface {

  /**
   * {@inheritDoc}
   */
  public function getDefaultCache() {
    return [
      '#cache' => [
        'max-age' => 60,
        'contexts' => ['url'],
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function getPhotos(array $data, array &$build) {
    foreach ($data as $item) {
      $build['rest_output_block']['photos'][] = [
        '#theme' => 'image',
        '#uri' => $item->thumbnailUrl,
        '#alt' => $item->title,
        '#title' => $item->title,
      ];
    }
  }

}
