<?php

namespace Drupal\dropsolid_dependency_injection\Breadcrumb;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Routing\RouteProviderInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Url;

/**
 * Provides a breadcrumb for Dropsolid Dependency Injection Exercise.
 */
class DropsolidBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  use StringTranslationTrait;

  /**
   * The route provider service.
   *
   * @var \Drupal\Core\Routing\RouteProviderInterface
   */
  protected $routeProvider;

  /**
   * The DropsolidBreadcrumbBuilder constructor.
   *
   * @param \Drupal\Core\Routing\RouteProviderInterface $route_provider
   *   The route provider service.
   */
  public function __construct(RouteProviderInterface $route_provider) {
    $this->routeProvider = $route_provider;
  }

  /**
   * {@inheritdoc}
   *
   *  Apply new breadcrumb only for
   *  Dropsolid Dependency Injection Exercise Photos controller.
   */
  public function applies(RouteMatchInterface $route) {
    return $route->getRouteName() === 'dropsolid_dependency_injection.rest_output_controller_showPhotos';
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $full_path = explode('/', substr($route_match->getRouteObject()->getPath(), 1));
    $current_link = '';
    $breadcrumb->addLink(Link::createFromRoute($this->t('Home'), '<front>'));

    foreach ($full_path as $path) {
      $current_link .= '/' . $path;

      // Check if link has route.
      $route = $this->routeProvider->getRoutesByPattern($current_link)->count();
      $link = !empty($route) ? Url::fromUserInput($current_link) : Url::fromRoute('<nolink>');

      // Add new breadcrumb element.
      $breadcrumb->addLink(Link::fromTextAndUrl(Unicode::ucfirst($path), $link));
    }

    // Add route cache context.
    $breadcrumb->addCacheContexts(['route']);

    return $breadcrumb;
  }

}
