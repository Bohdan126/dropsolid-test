<?php

namespace Drupal\dropsolid_dependency_injection;

/**
 * Class DropsolidDataService.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
class DropsolidDataService implements DropsolidDataServiceInterface {

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
