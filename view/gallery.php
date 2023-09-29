<div class="container text-center my-3">
  <div class="row">
    <?php foreach ($images as $i => $image): ?>
      <div class="col-4" style="height: 250px;">
        <img src="<?= $image->getUrl() ?>" class="d-block h-75 mx-auto" alt="<?= $image->keyword ?>"
             data-bs-target="#carousel" data-bs-slide-to="<?= $i ?>" role="button">
      </div>
    <?php endforeach; ?>
  </div>
</div>
<div id="carousel" class="carousel slide">
  <div class="carousel-indicators">
    <?php for ($i = 0; $i < count($images); $i++): ?>
      <button type="button"
              data-bs-target="#carousel" <?php if (0 === $i): ?> class="active" aria-current="true"<?php endif; ?>
              data-bs-slide-to="<?= $i ?>" aria-label="Slide <?= $i + 1 ?>"></button>
    <?php endfor; ?>

  </div>
  <div class="carousel-inner">
    <?php foreach ($images as $i => $image): ?>
      <div class="carousel-item<?php if (0 === $i): ?> active<?php endif; ?>">
        <img src="<?= $image->getUrl() ?>" class="d-block w-100" alt="<?= $image->keyword ?>">
      </div>
    <?php endforeach; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>