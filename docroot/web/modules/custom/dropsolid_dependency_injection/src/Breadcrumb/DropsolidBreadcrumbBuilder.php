<?php

namespace Drupal\dropsolid_dependency_injection\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Routing\RouteProviderInterface;
use Drupal\Core\Url;

/**
 * Provides a breadcrumb for Dropsolid Dependency Injection Exercise.
 */
class DropsolidBreadcrumbBuilder implements BreadcrumbBuilderInterface {

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
   */
  public function applies(RouteMatchInterface $route) {
    $route_name = $route->getRouteName();

    // Apply new breadcrumb only for
    // Dropsolid Dependency Injection Exercise Photos controller.
    if ($route_name != 'dropsolid_dependency_injection.rest_output_controller_showPhotos') {
      return FALSE;
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $full_path = explode('/', substr($route_match->getRouteObject()->getPath(), 1));
    $current_link = '';
    $breadcrumb->addLink(Link::createFromRoute('Home', '<front>'));

    foreach ($full_path as $path) {
      $current_link .= '/' . $path;

      // Check if link has route.
      $route = $this->routeProvider->getRoutesByPattern($current_link)->count();
      $default_link = !empty($route) ? NULL : '/';

      // Add new breadcrumb element.
      $breadcrumb->addLink(Link::fromTextAndUrl(ucfirst($path), Url::fromUserInput($default_link ?? $current_link)));
    }

    // Add route cache context.
    $breadcrumb->addCacheContexts(['route']);

    return $breadcrumb;
  }

}
