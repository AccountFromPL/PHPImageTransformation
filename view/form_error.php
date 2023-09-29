<?php
  if (!$formError instanceof FormError) {
    return;
  }
?>
<div class="card border-danger my-3 w-50 mx-auto">
  <div class="card-header border-danger text-danger fw-bold">
    Error
  </div>
  <div class="card-body text-danger">
    <?= $formError->message() ?>
  </div>
</div>