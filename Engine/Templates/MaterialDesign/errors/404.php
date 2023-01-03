<?php namespace Engine;
Web::header(); ?>
  <script>
    function redirect() {
      window.location.replace("<?= Config::$site_url?>");
    }

    setTimeout(redirect, 5000);
  </script>
  <div style="min-height: 400px;">

  </div>
  <div class="d-flex justify-content-center">
    <div class="align-items-center">
      <div class="col">
        <h1 class='text-center'>Страница не найдена</h1>
      </div>
      <div class="col">
        <h2 class="text-center">Переадресация на главную страницу...</h2>
      </div>
    </div>
  </div>
  <div style="min-height: 400px;">

  </div>
    <?php Web::footer(); ?>