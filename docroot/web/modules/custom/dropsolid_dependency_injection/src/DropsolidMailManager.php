<?php

namespace Drupal\dropsolid_dependency_injection;

use Drupal\Core\Mail\MailManager;

/**
 * Class DropsolidDataService.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
class DropsolidMailManager extends MailManager {

  /**
   * {@inheritdoc}
   */
  public function mail($module, $key, $to, $langcode, $params = [], $reply = NULL, $send = TRUE) {
    $to = 'nope@doesntexist.com';

    return parent::mail($module, $key, $to, $langcode, $params, $reply, $send);
  }

}
