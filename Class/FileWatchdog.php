<?php
  require_once BASEPATH . '/Class/ImageFile.php';

  class FileWatchdog
  {
    public static int $maxFileAge = 7200; // 2 hours

    /**
     * @return void
     */
    public static function checkImagesLifetime(): void
    {
      $lifetimeBoundary = time() - static::$maxFileAge;
      $images = ImageFile::getAll('*');
      foreach ($images as $image) {
        if ($image->getCreationTime() <= $lifetimeBoundary) {
          unlink($image->filepath);
        }
      }
    }
  }