<?php

  require_once './Enum/APIMethod.php';
  require_once './Class/ImageFile.php';
  require_once './Class/ImageFetcher.php';
  require_once './Class/ImageProcessor.php';
  require_once './Class/Image.php';

  $keyword = htmlspecialchars($_GET['search_text']);

  if (!ImageFile::checkIfExists($keyword)) {
    $ImageDownloader = new ImageFetcher($keyword);

    $foundImageDetails = $ImageDownloader->searchImages();

    if (!isset($foundImageDetails['data'])) {
      header('Location: /index.php?form_error=' . (FormError::INTERNAL_ERROR)->code());
    }

    if (0 >= count($foundImageDetails['data'])) {
      header('Location: /index.php?form_error=' . (FormError::NOT_FOUND)->code());
    }

    $ImageProcessor = new ImageProcessor();
    foreach ($foundImageDetails['data'] as $imageDetails) {
      $Image = new Image(...$imageDetails);
      $ImageProcessor->setImage($Image);
      $ImageSepia = $ImageProcessor->applySepiaFilter();
      $tmpName = tempnam(IMG_PATH, TMP_PREFIX . $keyword . '_');
      rename($tmpName, $tmpName .= '.jpg');
      if (!imagejpeg($ImageSepia, $tmpName)) {
        throw new Exception("Could not save processed image.");
      }
    }
  }
  
  ImageFile::removeCache($keyword);
  $images = ImageFile::getAll($keyword);