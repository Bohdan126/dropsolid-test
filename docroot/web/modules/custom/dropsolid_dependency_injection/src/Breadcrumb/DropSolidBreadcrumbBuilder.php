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
class DropSolidBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  /**
   * The route provider service.
   *
   * @var \Drupal\Core\Routing\RouteProviderInterface
   */
  protected $routeProvider;

  /**
   * The DropSolidBreadcrumbBuilder constructor.
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
    $full_route = $route_match->getRouteObject()->getPath();
    $full_route = explode('/', substr($full_route, 1));
    $link = '';

    $breadcrumb->addLink(Link::createFromRoute('Home', '<front>'));

    foreach ($full_route as $element) {
      $empty_link = NULL;
      $link .= '/' . $element;
      $is_route = $this->routeProvider->getRoutesByPattern($link)->count();

      // Reset breadcrumb element url if route is not defined.
      if (empty($is_route)) {
        $empty_link = '/';
      }
      // Create breadcrumb element.
      $breadcrumb->addLink(Link::fromTextAndUrl(ucfirst($element), Url::fromUserInput($empty_link ?? $link)));
    }

    // Add route cache context.
    $breadcrumb->addCacheContexts(['route']);

    return $breadcrumb;
  }

}
