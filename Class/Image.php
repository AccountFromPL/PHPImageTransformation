<?php

  class Image
  {
    private string $imageSizePrefix = '/full/843,/0/default.jpg';

    public int $id;
    public int $score;
    public string $identifier;
    public string $iiifUrl;

    /**
     * @param $_score
     * @param $id
     * @param $image_id
     * @throws Exception
     */
    public function __construct($_score, $id, $image_id)
    {
      $this->id = (int)$id;
      $this->score = (int)$_score;
      $this->identifier = (string)$image_id;
      $this->iiifUrl = ImageFetcher::getIiifBaseUrl($this->id);

      if (empty($this->iiifUrl)) {
        throw new Exception('Iiif URL not found.');
      }
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
      return $this->iiifUrl . '/' . $this->identifier . $this->imageSizePrefix;
    }
  }