<h1 class="mb-5">Search for images</h1>
<?php
  if (!empty($_GET['form_error'])) {
    $formErrorCode = (int)$_GET['form_error'];
    $formError = FormError::tryFrom($formErrorCode);
    if ($formError instanceof FormError) {
      include BASEPATH . '/view/form_error.php';
    }
  }
?>
<form method="get" action="/index.php">
  <div class="input-group">
    <input type="text" name="search_text" class="form-control form-control-lg" placeholder="Search text"
           aria-label="Search text"
           aria-describedby="search-button-addon" autofocus>
    <button class="btn btn-outline-secondary" type="submit" id="search-button-addon">Search</button>
  </div>
</form>