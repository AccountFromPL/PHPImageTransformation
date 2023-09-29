<?php

  class ImageFetcher
  {
    private string $keyword;
    public string $apiBaseUrl = 'https://api.artic.edu/api/v1';

    /**
     * @param string $keyword
     */
    public function __construct(string $keyword = '')
    {
      $this->keyword = $keyword;
    }

    /**
     * @param int $imageId
     * @return string|null
     */
    public static function getIiifBaseUrl(int $imageId): string|null
    {
      $instance = new static;
      $params = [
        'fields' => 'iiif_url',
      ];
      $apiResponse = $instance->makeAPIRequest(method: APIMethod::ARTWORK, params: $params, urlSuffix: $imageId);
      if (!empty($apiResponse['config']['iiif_url'])) {
        return $apiResponse['config']['iiif_url'];
      }
      return null;
    }

    /**
     * @return array|string
     */
    public function searchImages(): array|string
    {
      $params = [
        'q' => $this->keyword,
        'query' => [
          'term' => [
            'is_public_domain' => true,
          ]
        ],
        'limit' => 6,
        'fields' => implode(',', ['id', 'image_id']),
      ];
      return $this->makeAPIRequest(APIMethod::SEARCH, $params);
    }

    /**
     * @param array|null $params
     * @return string
     */
    public function getAPIParams(array|null $params): string
    {
      if (is_array($params) && !empty($params)) {
        return '?' . http_build_query(['params' => json_encode($params)]);
      }
      return '';
    }

    /**
     * @param APIMethod $method
     * @param array|null $params
     * @param string $urlSuffix
     * @param bool $returnAsArray
     * @return string|array
     */
    public function makeAPIRequest(APIMethod $method, array|null $params = null, string $urlSuffix = '', bool $returnAsArray = true): string|array
    {
      $ch = curl_init();

      $url = $this->apiBaseUrl . $method->endpoint() . $urlSuffix . $this->getAPIParams($params);

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $result = curl_exec($ch);

      return $returnAsArray ? json_decode($result, true) : $result;
    }
  }