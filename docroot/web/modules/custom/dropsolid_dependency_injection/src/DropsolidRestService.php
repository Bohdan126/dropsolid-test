<?php

namespace Drupal\dropsolid_dependency_injection;

use GuzzleHttp\ClientInterface;

/**
 * Class DropsolidRestService.
 *
 * @package Drupal\dropsolid_dependency_injection
 */
class DropsolidRestService implements DropsolidRestServiceInterface {

  /**
   * The HTTP client to fetch the Rest data.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * DropsolidRestService constructor.
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
