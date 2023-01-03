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
  <div class="d-flex justify-content-center" style="top: 50%;">
    <div class="align-items-center">
      <div class="col">
        <h1 class='text-center'>Произошла внутренняя ошибка</h1>
      </div>
      <div class="col">
        <h2 class="text-center">Зайдите снова через 15 мин.</h2>
      </div>
    </div>
  </div>
  <div style="min-height: 400px;">

  </div>
    <?php Web::footer(); ?>
