<?php

namespace Drupal\dropsolid_dependency_injection;

use GuzzleHttp\ClientInterface;

/**
 * Class DropSolidRestService.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
class DropSolidRestService implements DropSolidRestServiceInterface {

  /**
   * The HTTP client to fetch the Rest data.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * DropSolidRestService constructor.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The Guzzle HTTP client.
   */
  public function __construct(ClientInterface $http_client) {
    $this->httpClient = $http_client;
  }

  /**
   * {@inheritDoc}
   */
  public function getApiData(string $uri) {
    try {
      $response = $this->httpClient->request('GET', $uri);
      $data = $response->getBody()->getContents();
      $decoded = json_decode($data);

      if (!$decoded) {
        throw new \Exception('Invalid data returned from API');
      }
    }
    catch (\Exception $e) {
      return [];
    }

    return $decoded;
  }

}
