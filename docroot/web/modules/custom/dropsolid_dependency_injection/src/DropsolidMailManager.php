<?php

namespace Drupal\dropsolid_dependency_injection;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Mail\MailManager;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\StringTranslation\TranslationInterface;

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
