<?php

namespace Drupal\dropsolid_dependency_injection;

use GuzzleHttp\ClientInterface;

/**
 * Class RestConnectorService.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
class RestConnectorService implements RestConnectorServiceInterface {

  /**
   * The HTTP client to fetch the Rest data.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * RestConnectorService constructor.
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
  public function getApiData(string $uri): array {
    try {
      $response = $this->httpClient->request('GET', $uri);
      $data = $response->getBody()->getContents();

      if (!$decoded = json_decode($data)) {
        throw new \Exception('Invalid data returned from API');
      }
    }
    catch (\Exception $e) {
      return [];
    }

    return $decoded;
  }

}
