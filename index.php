<?php
define('BASEPATH', getcwd());

const  IMG_DIR = 'img';
const IMG_PATH = BASEPATH . '/' . IMG_DIR;
const TMP_PREFIX = 'SEPIA_IMAGES_GALLERY_';

require_once BASEPATH . '/Class/FileWatchdog.php';

if (!empty($_GET['form_error'])) {
  require_once BASEPATH . '/Enum/FormError.php';
}

if (!empty($_GET['search_text'])) {
  require_once BASEPATH . '/Enum/FormError.php';
  include './process_search.php';
}

FileWatchdog::checkImagesLifetime();

?><!DOCTYPE html>
<html class="h-100" lang="en" data-bs-theme="auto">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Beniamin Kowol">
  <title>Search</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body class="d-flex h-100 text-center">
<div class="cover-container d-flex w-100 h-100 mx-auto flex-column">
  <main class="container my-auto w-50">
    <?php
      if (!empty($_GET['search_text'])) {
        include './view/gallery.php';
      } else {
        include './view/form.php';
      }
    ?>
  </main>
</div>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>