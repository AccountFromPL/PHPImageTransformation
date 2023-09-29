<?php

  class ImageProcessor
  {
    public Image $Image;

    public GdImage|bool $gdImage;

    public int $imageWidth;
    public int $imageHeight;

    public int $sepiaValue = 40;

    /**
     * @param Image $Image
     * @return void
     * @throws Exception
     */
    public function setImage(Image $Image): void
    {
      $this->Image = $Image;
      if (!$this->checkImageUrl()) {
        throw new Exception('Image URL is not valid.');
      }
      $this->fetchImage();
      $this->getImageDimensions();
    }

    /**
     * @return bool
     */
    private function checkImageUrl(): bool
    {
      if (curl_init($this->Image->getImageUrl()) === false) {
        return false;
      }
      return true;
    }

    /**
     * @return void
     * @throws Exception
     */
    private function fetchImage(): void
    {
      $this->gdImage = imagecreatefromjpeg($this->Image->getImageUrl());
      if (!$this->gdImage) {
        throw new Exception('Error while fetching image.');
      }
    }

    /**
     * @return GdImage|bool
     */
    public function applySepiaFilter(): GdImage|bool
    {
      $this->iteratePixels();
      return $this->gdImage;
    }

    /**
     * @return void
     */
    private function iteratePixels(): void
    {
      for ($pixelPositionX = 0; $pixelPositionX < $this->imageWidth; $pixelPositionX++) {
        for ($pixelPositionY = 0; $pixelPositionY < $this->imageHeight; $pixelPositionY++) {
          $pixel = $this->getPixel($pixelPositionX, $pixelPositionY);
          $pixel = $this->applyGrayscaleToPixel($pixel);
          $pixel = $this->applySepiaToPixel($pixel);
          $this->setPixel($pixel);
        }
      }
    }

    private function setPixel(array $pixel): void
    {
      $colorIdentifier = $this->getColorIdentifier($pixel['color']);
      imagesetpixel($this->gdImage, $pixel['position']['x'], $pixel['position']['y'], $colorIdentifier);
    }

    /**
     * @param int $pixelPositionX
     * @param int $pixelPositionY
     * @return array
     */
    private function getPixel(int $pixelPositionX, int $pixelPositionY): array
    {
      $pixelRGB = $this->getPixelRGB($pixelPositionX, $pixelPositionY);
      $pixelPosition = [
        'x' => $pixelPositionX,
        'y' => $pixelPositionY,
      ];
      return [
        'position' => $pixelPosition,
        'color' => $pixelRGB,
      ];
    }

    /**
     * @param array $pixel
     * @return array
     */
    private function applySepiaToPixel(array $pixel): array
    {
      $pixel['color']['r'] += $this->sepiaValue * 2;
      $pixel['color']['g'] += $this->sepiaValue;
      if (255 < $pixel['color']['r']) {
        $pixel['color']['r'] = 255;
      }
      if (255 < $pixel['color']['g']) {
        $pixel['color']['g'] = 255;
      }
      return $pixel;
    }

    /**
     * @param array $pixel
     * @return array
     */
    private function applyGrayscaleToPixel(array $pixel): array
    {
      $pixel['color']['r'] = ($pixel['color']['r'] + $pixel['color']['g'] + $pixel['color']['b']) / 3;
      $pixel['color']['g'] = ($pixel['color']['r'] + $pixel['color']['g'] + $pixel['color']['b']) / 3;
      $pixel['color']['b'] = ($pixel['color']['r'] + $pixel['color']['g'] + $pixel['color']['b']) / 3;
      return $pixel;
    }

    /**
     * @return void
     */
    private function getImageDimensions(): void
    {
      $this->imageWidth = imagesx($this->gdImage);
      $this->imageHeight = imagesy($this->gdImage);
    }

    /**
     * @param int $pixelPositionX
     * @param int $pixelPositionY
     * @return int[]
     */
    private function getPixelRGB(int $pixelPositionX, int $pixelPositionY): array
    {
      $pixelRGB = imagecolorat($this->gdImage, $pixelPositionX, $pixelPositionY);
      return [
        'r' => ($pixelRGB >> 16) & 0xFF,
        'g' => ($pixelRGB >> 8) & 0xFF,
        'b' => $pixelRGB & 0xFF,
      ];
    }

    /**
     * @param array $rgb
     * @return bool|int
     */
    private function getColorIdentifier(array $rgb): bool|int
    {
      return imagecolorallocate($this->gdImage, $rgb['r'], $rgb['g'], $rgb['b']);
    }
  }